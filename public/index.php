<?php
session_start();

require_once '../config/config.php';
require_once '../config/databaseConnection.php';

require_once '../phpmailer/Exception.php';
require_once '../phpmailer/PHPMailer.php';
require_once '../phpmailer/SMTP.php';

require_once '../config/commonFunctions.php';
require_once '../config/databaseFunctions.php';

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
