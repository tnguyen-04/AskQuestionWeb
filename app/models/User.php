<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
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
                p.id ASC;
            ";
        $posts = selectRows($listUserPost);
        return $posts;
    }
}
