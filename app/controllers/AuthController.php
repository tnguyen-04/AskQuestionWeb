<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class AuthController
{

    public function login()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../views/auth/login.html.php';
    }
    public function register()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../views/auth/register.html.php';
    }
    public function activeToken()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../views/auth/activeToken.html.php';
    }
    public function forgotPassword()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../views/auth/forgotPassword.html.php';
    }
    public function createNewPassword()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../views/auth/createNewPassword.html.php';
    }
    public function logout()
    {
        require_once __DIR__ . '/../models/Auth.php';
        $auth = new Authentication();
        $auth->logout();
    }
}
