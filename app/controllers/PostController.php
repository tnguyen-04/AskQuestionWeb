<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class PostController
{
    public function postQuestion()
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = new Post();
        $error = $post->createPost();

        header("location: ?module=User&action=askQuestion");
        if (isset($error['success'])) {
            setFlashData("successPost", $error['success']);
        }

        if (isset($error['error'])) {
            setFlashData("errorPost", $error['error']);
        }
    }

    public function deletePost()
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = new Post();
        $error = $post->deleteSpecificPost();

        header("location: ?module=User&action=home");
        if (isset($error['success'])) {
            setFlashData("successDeletePost", $error['success']);
        }

        if (isset($error['error'])) {
            setFlashData("errorDeletePost", $error['error']);
        }
    }
    public function updatePost()
    {
        require_once __DIR__ . '/../models/Post.php';
        $post = new Post();
        $error = $post->updateSpecificPost();
        header("location: ?module=User&action=home");
    }
}
