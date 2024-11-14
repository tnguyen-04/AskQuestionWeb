<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
function sendMailToAdmin($to, $subject, $emailContent)
{


    if (sendEmail($to, $subject, $emailContent)) {

        return true;
    } else {

        return false;
    }
}
