<?php
// time of session
$cookieLifetime = 30 * 24 * 60 * 60; // 30 days

session_set_cookie_params([
    'lifetime' => $cookieLifetime,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);


require '../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

session_start();


Configuration::instance('cloudinary://271486631826341:kL7rCZKr-COH6LadScToW4TNBUM@dipxjgwt3?secure=true');

require '../config/config.php';
require '../config/databaseConnection.php';

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

require '../config/commonFunctions.php';
require '../config/databaseFunctions.php';

$module = _MODULE;
$action = _ACTION;


if (!empty($_GET["action"])) {
    if (is_string($_GET["action"])) {
        $action = $_GET["action"];
    }
}
if (!empty($_GET["module"])) {
    if (is_string($_GET["module"])) {
        $module = $_GET["module"];
    }
}

$controllerPath = "../app/controllers/" . $module . "Controller.php";

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controllerClass = $module . "Controller";
    $controller = new $controllerClass();

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Action '$action' not found in controller '$controllerClass'.";
    }
} else {
    echo "Controller file '$controllerPath' not found.";
}
