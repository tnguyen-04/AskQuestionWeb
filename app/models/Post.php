<?php
// Kiểm tra quyền truy cập
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

// Sử dụng API Cloudinary
use Cloudinary\Api\Upload\UploadApi;

global $conn;

// Kiểm tra phương thức gửi là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $error = [];
    $post_data = [
        'user_id' => $_POST['user_id'],
        'module_id' => $_POST['modules'],
        'content' => $_POST['contentAskQuestion']
    ];


    $post_result = insertData('posts', $post_data);
    $post_id = $conn->lastInsertId();

    if (!empty($_FILES['choosePicture']['name'][0])) {
        $upload_urls = [];

        // Duyệt qua các file được tải lên
        foreach ($_FILES['choosePicture']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['choosePicture']['error'][$key] != UPLOAD_ERR_OK) {
                return $error['error'] = "Failed to upload file to server";
            }

            if (is_uploaded_file($tmp_name)) {
                try {
                    // Upload ảnh lên Cloudinary
                    $uploaded_image = (new UploadApi())->upload($tmp_name, [
                        'folder' => 'askQuestionUpload'
                    ]);

                    // Lấy URL ảnh sau khi upload thành công
                    $image_url = $uploaded_image['secure_url'];

                    // Lưu thông tin ảnh vào cơ sở dữ liệu
                    $upload_data = [
                        'post_id' => $post_id,
                        'user_id' => $_POST['user_id'],
                        'upload' => $image_url
                    ];

                    // Chèn thông tin ảnh vào bảng uploads
                    insertData('uploads', $upload_data);

                    // Lưu URL ảnh vào mảng để kiểm tra
                    $upload_urls[] = $image_url;
                } catch (Exception $e) {
                    return $error['error'] = "Failed to upload file: ";
                }
            } else {
                return $error['error'] = "Invalid file: ";
            }
        }
        $error['success'] = "Posted successfully";
    } else {
        return $error['error'] = "No file is uploaded";
    }
} else {
    return $error['error'] = "The method is invalid";
}
