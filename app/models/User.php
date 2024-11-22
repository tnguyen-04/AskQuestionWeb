<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

use Cloudinary\Api\Admin\AdminApi;

class User
{
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $users = selectRows($sql);
        return $users;
    }
    public function editUserName()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userName = $_POST['updateNewName'];
            $userID = $_POST['user_id'];

            $data = [
                'username' => $userName
            ];

            $update = updateData("users", $data, "id = $userID");
            return $update;
        }
    }
    public function showUserPosts()
    {


        $userID = $_GET['userId'];
        $listUserPost = "SELECT 
                p.id AS post_id,
                p.user_id,
                u.username,
                p.module_id,
                p.created_at,
                m.moduleName,
                p.content,
                ul.upload
            FROM 
                posts p
            LEFT JOIN 
                users u ON p.user_id = u.id
            LEFT JOIN 
                modules m ON p.module_id = m.id
            LEFT JOIN 
                uploads ul ON ul.post_id = p.id
            WHERE 
                p.user_id = $userID
            ORDER BY 
                p.id DESC;
            ";
        $posts = selectRows($listUserPost);
        return $posts;
    }
    public function deleteSpecificUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $response = [];
            $userID = $_POST['user_id'];
            $userData = "SELECT 
                u.id AS user_id,
                u.username,
                p.id AS post_id,
                ul.upload AS post_image
            FROM 
                users u
            LEFT JOIN 
                posts p ON u.id = p.user_id
            LEFT JOIN 
                uploads ul ON p.id = ul.post_id
            WHERE 
                u.id = $userID;
            ";
            $deleteRelatedPosts = selectRows($userData);

            if (empty($deleteRelatedPosts)) {
                $response['error'] = "no data ";
                return $response;
            }
            foreach ($deleteRelatedPosts as $deleteRelatedPost) {
                $imageUrls = !empty($deleteRelatedPost['post_image']) ? explode(',', $deleteRelatedPost['post_image']) : [];

                $publicIds = [];
                if ($imageUrls != []) {
                    foreach ($imageUrls as $url) {
                        preg_match('/\/v(\d+)\/(.*?)\.(jpg|jpeg|png|gif)/', $url, $matches);
                        if (isset($matches[2])) {
                            $publicIds[] = $matches[2];
                        }
                    }

                    if (empty($publicIds)) {
                        $response['error'] = "No valid public_ids found for deletion.";
                        return $response;
                    }

                    try {
                        $adminApi = new AdminApi();
                        $result = $adminApi->deleteAssets($publicIds);
                    } catch (Exception $e) {
                        $response['error'] = "Error deleting images: " . $e->getMessage();
                        return $response;
                    }
                }
            }
            $deleteNow = deleteData("users", "id = $userID");
            if (!$deleteNow) {
                $response['error'] = "CANNOT DELETE IN DATABASE";
                return $response;
            }
        }
        $response['success'] = " Deleted successfully";
        return $response;
    }
}
