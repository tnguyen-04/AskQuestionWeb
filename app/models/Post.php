<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}


use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;

class Post
{
    public function createPost()
    {
        global $conn;
        $error = ['success' => null, 'error' => null];

        if ($_POST['modules'] == "" ||  $_POST['contentAskQuestion'] == "") {
            $error['error'] = "Module or Content is required";
            return $error;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = [
                'user_id' => $_POST['user_id'],
                'module_id' => $_POST['modules'],
                'content' => $_POST['contentAskQuestion']
            ];

            insertData('posts', $post_data);
            // Lấy ID của bài viết vừa tạo
            $post_id = $conn->lastInsertId();

            if (!empty($_FILES['choosePicture']['name'][0])) {
                $upload_urls = []; // Mảng chứa các URL ảnh

                foreach ($_FILES['choosePicture']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['choosePicture']['error'][$key] != UPLOAD_ERR_OK) {
                        $error['error'] = "Failed to upload file to server";
                        return $error;
                    }

                    if (is_uploaded_file($tmp_name)) {
                        try {
                            // Upload ảnh lên Cloudinary
                            $uploaded_image = (new UploadApi())->upload($tmp_name, [
                                'folder' => 'askQuestionUpload'
                            ]);
                            $image_url = $uploaded_image['secure_url'];

                            $upload_urls[] = $image_url;
                        } catch (Exception $e) {
                            $error['error'] = "Failed to upload file: " . $e->getMessage();
                            return $error;
                        }
                    } else {
                        $error['error'] = "Invalid file.";
                        return $error;
                    }
                }

                $concatenated_urls = implode(',', $upload_urls);

                $upload_data = [
                    'post_id' => $post_id,
                    'user_id' => $_POST['user_id'],
                    'upload' => $concatenated_urls
                ];

                insertData('uploads', $upload_data);

                $error['success'] = "Posted successfully";
            }
        } else {
            $error['error'] = "Invalid method.";
        }

        return $error;
    }


    public function getAllPosts()
    {
        $sql = "SELECT 
            users.username,
            users.id as user_id,
            modules.moduleName,
            modules.id as module_id,
            posts.content,
            posts.id,
            posts.created_at,
            uploads.upload
        FROM 
            posts
        JOIN 
            users ON posts.user_id = users.id
        JOIN 
            modules ON posts.module_id = modules.id
        LEFT JOIN 
            uploads ON posts.id = uploads.post_id
        GROUP BY 
            posts.id
        ORDER BY 
            posts.created_at DESC;
        
        
        ";
        $data = selectRows($sql);
        return $data;
    }


    public function deleteSpecificPost()
    {
        $response = ['success' => null, 'error' => null];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
                $response['error'] = "Post ID is missing.";
                return $response;
            }

            $post_id = $_POST['post_id'];

            // Lấy danh sách các hình ảnh cần xóa từ database
            $uploadData = selectOneRow("SELECT upload FROM uploads WHERE post_id = $post_id");

            if (empty($uploadData) || empty($uploadData['upload'])) {
                $response['error'] = "No images found for the given post ID.";
                return $response;
            }

            // Tách danh sách URL ảnh từ chuỗi
            $imageUrls = explode(',', $uploadData['upload']);
            $publicIds = [];

            foreach ($imageUrls as $url) {
                // Tách public_id từ URL
                preg_match('/\/v(\d+)\/(.*?)\.(jpg|jpeg|png|gif)/', $url, $matches);
                if (isset($matches[2])) {
                    $publicIds[] = $matches[2];
                }
            }

            // Kiểm tra xem có public_id nào không
            if (empty($publicIds)) {
                $response['error'] = "No valid public_ids found for deletion.";
                return $response;
            }

            try {
                // Sử dụng AdminApi để xóa ảnh
                $adminApi = new AdminApi();
                $result = $adminApi->deleteAssets($publicIds); // Chuyển mảng public_ids vào

                // Kiểm tra kết quả xóa
                foreach ($publicIds as $publicId) {
                    if (isset($result['deleted'][$publicId]) && $result['deleted'][$publicId] === 'deleted') {
                        echo "Đã xóa ảnh: " . $publicId . "\n";
                    } else {
                        echo "Không thể xóa ảnh: " . $publicId . "\n";
                    }
                }
            } catch (Exception $e) {
                $response['error'] = "Error deleting images: " . $e->getMessage();
                return $response;
            }

            // Delete the post and image data from the database
            deleteData("posts", "id = $post_id");
            deleteData("uploads", "post_id = $post_id");

            $response['success'] = "Post deleted successfully.";
            return $response;
        } else {
            $response['error'] = "Invalid request method.";
            return $response;
        }
    }

    public function updateSpecificPost()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = [
                'module_id' => $_POST['modules'],
                'content' => $_POST['editContent']
            ];
            $post_id = $_POST['post_id'];

            updateData('posts', $post_data, "id = '$post_id'");


            // delete old images =====================================
            // Retrieve the list of images to delete from the database
            $uploadData = selectOneRow("SELECT upload FROM uploads WHERE post_id = $post_id");

            if (empty($uploadData) || empty($uploadData['upload'])) {
                return;
            }

            $imageUrls = explode(',', $uploadData['upload']);
            $publicIds = [];

            foreach ($imageUrls as $url) {
                preg_match('/\/v(\d+)\/(.*?)\.(jpg|jpeg|png|gif)/', $url, $matches);
                if (isset($matches[2])) {
                    $publicIds[] = $matches[2];
                }
            }

            if (empty($publicIds)) {
                return;
            }

            try {
                $adminApi = new AdminApi();
                $result = $adminApi->deleteAssets($publicIds);

                foreach ($publicIds as $publicId) {
                    if (isset($result['deleted'][$publicId]) && $result['deleted'][$publicId] === 'deleted') {
                        echo "Đã xóa ảnh: " . $publicId . "\n";
                    } else {
                        echo "Không thể xóa ảnh: " . $publicId . "\n";
                    }
                }
            } catch (Exception $e) {
                return;
            }


            // upload new images ====================================
            if (!empty($_FILES['choosePicture']['name'][0])) {
                $upload_urls = [];

                foreach ($_FILES['choosePicture']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['choosePicture']['error'][$key] != UPLOAD_ERR_OK) {
                        return;
                    }

                    if (is_uploaded_file($tmp_name)) {
                        try {
                            // Upload ảnh lên Cloudinary
                            $uploaded_image = (new UploadApi())->upload($tmp_name, [
                                'folder' => 'askQuestionUpload'
                            ]);
                            $image_url = $uploaded_image['secure_url'];

                            $upload_urls[] = $image_url;
                        } catch (Exception $e) {
                            return;
                        }
                    } else {

                        return;
                    }
                }

                $concatenated_urls = implode(',', $upload_urls);

                $upload_data = [
                    'upload' => $concatenated_urls
                ];

                updateData('uploads', $upload_data, "post_id = '$post_id'");
            } else {

                return;
            }
        }
        return;
    }
}
