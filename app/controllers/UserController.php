<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class UserController
{
    public function home()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/Module.php';
        require_once __DIR__ . '/../models/Post.php';
        $post = new Post();
        $postDatas = $post->getAllPosts();
        $title = "home";
        ob_start();
        require __DIR__ . '/../views/users/home.html.php';
        require_once __DIR__ . '/../views/users/listAllPosts.html.php';
        $output = ob_get_clean();
        require __DIR__ . '/../views/users/home.html.php';
    }
    public function askQuestion()
    {
        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/Module.php';
        $title = "Ask question";
        ob_start();
        require_once __DIR__ . '/../views/users/home.html.php';
        require __DIR__ . '/../views/users/askQuestion.html.php';
        $output = ob_get_clean();
        require __DIR__ . '/../views/users/home.html.php';
    }
    public function sendMailToAdmin()
    {

        require_once __DIR__ . '/../models/Auth.php';
        require_once __DIR__ . '/../models/Contact.php';
        header("location: ?module=User&action=home");
        require __DIR__ . '/../views/users/home.html.php';

        $subject = "This email from $username user";
        $emailContent = filterUserInput()["emailContent"];

        //$email from  require __DIR__ . '/../views/users/home.html.php';
        $sendMail = sendMailToAdmin($email, $subject, $emailContent);

        if ($sendMail) {
            setFlashData("success", "Email has sent successfully");
        } else {
            setFlashData("error", "Can not send the email, please try again!");
        }
    }
}
