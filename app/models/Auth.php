<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class Authentication
{
    function register()
    {


        $userInputArr = filterUserInput();

        $errors =  validateUserInput($userInputArr);

        return $errors;
    }
}
