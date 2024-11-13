<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
function sendMailToAdmin()
{

    $loginToken = getSession("loginToken");
    $sql = "SELECT users.username, users.email
                    FROM users
                    INNER JOIN sessions ON users.id = sessions.user_id
                    WHERE sessions.loginToken = '$loginToken' ";
    $data = selectOneRow($sql);
    if (!$data) {
        setFlashData("error", "Can not get data, please try again!");
        return false;
    }
    $subject = "This email from {$data['username']}";
    $emailContent = filterUserInput()["emailContent"];

    $to = $data["email"];
    if (sendEmail($to, $subject, $emailContent)) {

        return true;
    } else {

        return false;
    }
}
