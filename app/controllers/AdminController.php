<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class AdminController
{
    public function user()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/User.php';
        ob_start();
        require_once __DIR__ . '/../views/admin/listAllUsers.html.php';
        $output = ob_get_clean();
        require_once __DIR__ . '/../views/admin/dashboard.html.php';
    }
    public function editName()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/User.php';
        $userList = new User();
        $allUsers = $userList->editUserName();
        header("location: ?module=Admin&action=user");
    }
    public function deletePostOfUser()
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = new Post();
        $error = $post->deleteSpecificPost();
        $userID = $_POST['user_id'];
        header("location:?module=Admin&action=showUserPost&userId=$userID");
        if (isset($error['success'])) {
            setFlashData("successDeletePost", $error['success']);
        }

        if (isset($error['error'])) {
            setFlashData("errorDeletePost", $error['error']);
        }
    }
    public function deleteUser()
    {
        require_once __DIR__ . '/../models/User.php';
        $user = new User();
        $response = $user->deleteSpecificUser();
        header("location:?module=Admin&action=user");
        if (isset($response['success'])) {
            setFlashData("successDeletePost", $response['success']);
        }

        if (isset($response['error'])) {
            setFlashData("errorDeletePost", $response['error']);
        }
    }

    public function showUserPost()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/User.php';
        ob_start();
        require_once __DIR__ . '/../views/admin/postOfUser.html.php';
        $output = ob_get_clean();
        require_once __DIR__ . '/../views/admin/dashboard.html.php';
    }
    public function category()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/Module.php';
        ob_start();
        require_once __DIR__ . '/../views/admin/listAllCategories.html.php';
        $output = ob_get_clean();
        require_once __DIR__ . '/../views/admin/dashboard.html.php';
    }
    public function addModule()
    {
        require_once __DIR__ . '/../models/Module.php';
        $addModule = new Module();
        $response = $addModule->addNewModule();
        header("location: ?module=Admin&action=category");
        if (isset($response['success'])) {
            setFlashData("successAddModule", $response['success']);
        }

        if (isset($response['error'])) {
            setFlashData("errorAddModule", $response['error']);
        }
    }
    public function editModule()
    {
        require_once __DIR__ . '/../models/Module.php';
        $addModule = new Module();
        $response = $addModule->editNewModule();
        header("location: ?module=Admin&action=category");
        if (isset($response['success'])) {
            setFlashData("successAddModule", $response['success']);
        }

        if (isset($response['error'])) {
            setFlashData("errorAddModule", $response['error']);
        }
    }
    public function deleteModule()
    {
        require_once __DIR__ . '/../models/Module.php';
        $addModule = new Module();
        $response = $addModule->deleteAModule();
        header("location: ?module=Admin&action=category");
        if (isset($response['success'])) {
            setFlashData("successAddModule", $response['success']);
        }

        if (isset($response['error'])) {
            setFlashData("errorAddModule", $response['error']);
        }
    }
}
