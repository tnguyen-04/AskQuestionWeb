<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class User
{
    function getModules()
    {
        return selectRows("SELECT id,name FROM modules");
    }
}
