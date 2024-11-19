<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}


use Cloudinary\Api\Upload\UploadApi;

class Post
{
    public function createPost()
    {
        global $conn;
        $error = ['success' => null, 'error' => null];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = [
                'user_id' => $_POST['user_id'],
                'module_id' => $_POST['modules'],
                'content' => $_POST['contentAskQuestion']
            ];

            insertData('posts', $post_data);

            $post_id = $conn->lastInsertId();

            if (!empty($_FILES['choosePicture']['name'][0])) {
                $upload_urls = [];

                foreach ($_FILES['choosePicture']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['choosePicture']['error'][$key] != UPLOAD_ERR_OK) {
                        $error['error'] = "Failed to upload file to server";
                        return $error;
                    }

                    if (is_uploaded_file($tmp_name)) {
                        try {
                            $uploaded_image = (new UploadApi())->upload($tmp_name, [
                                'folder' => 'askQuestionUpload'
                            ]);
                            $image_url = $uploaded_image['secure_url'];

                            $upload_data = [
                                'post_id' => $post_id,
                                'user_id' => $_POST['user_id'],
                                'upload' => $image_url
                            ];

                            insertData('uploads', $upload_data);

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
                $error['success'] = "Posted successfully";
            } else {
                $error['error'] = "No file uploaded";
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
            posts.content,
            posts.id,
            posts.created_at,
            GROUP_CONCAT(uploads.upload SEPARATOR ', ') AS upload
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
}
