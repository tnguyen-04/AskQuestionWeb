<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class PostController
{

    public function postQuestion()
    { //To get userID
        require_once __DIR__ . '/../models/Post.php';
        header("location: ?module=User&action=askQuestion");
        setFlashData("success", $error["success"]);
        setFlashData("error", $error["error"]);
    }
}
