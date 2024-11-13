<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class UserController
{
    public function home()
    {
        require_once __DIR__ . '/../models/Auth.php';
        ob_start();
        require_once __DIR__ . '/../views/users/listAllPosts.html.php';
        $output = ob_get_clean();
        $title = "home";
        require_once __DIR__ . '/../views/users/home.html.php';
    }
    public function askQuestion()
    {
        require_once __DIR__ . '/../models/Auth.php';
        ob_start();
        require_once __DIR__ . '/../views/users/askQuestion.html.php';
        $output = ob_get_clean();
        $title = "Ask question";
        require_once __DIR__ . '/../views/users/home.html.php';
    }
    public function sendMailToAdmin()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/Contact.php';
        $sendMail = sendMailToAdmin();

        if ($sendMail) {
            setFlashData("success", "Email has sent successfully");
        } else {
            setFlashData("error", "Can not send the email, please try again!");
        }
        header("location: ?module=User&action=home");
    }
}
