<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class UserAuth
{
    function checkLogin()
    {
        if (getSession("loginToken")) {
            $loginToken = getSession("loginToken");
            $checkToken = selectOneRow("SELECT user_id FROM sessions WHERE loginToken = $loginToken");
            if ($checkToken) {
                return true;
            } else {
                header("location: ?module=Auth&action=login");
            }
        }
    }
}
