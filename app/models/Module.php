<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class Module
{
    function getModules()
    {
        return selectRows("SELECT id,moduleName FROM modules");
    }
}
