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
        $userList = new User();
        $allUsers = $userList->getAllUsers();
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
