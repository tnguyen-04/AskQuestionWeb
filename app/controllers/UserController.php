<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class UserController
{
    public function home()
    {
        ob_start();
        require_once __DIR__ . '/../views/users/listAllPosts.html.php';
        $output = ob_get_clean();
        $title = "home";
        require_once __DIR__ . '/../views/users/home.html.php';
    }
    public function askQuestion()
    {
        ob_start();
        require_once __DIR__ . '/../views/users/askQuestion.html.php';
        $output = ob_get_clean();
        $title = "Ask question";

        require_once __DIR__ . '/../views/users/home.html.php';
    }
}
