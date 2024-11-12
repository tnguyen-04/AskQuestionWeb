<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class AdminController
{
    public function user()
    {
        ob_start();
        require_once __DIR__ . '/../views/admin/listAllUsers.html.php';
        $output = ob_get_clean();
        require_once __DIR__ . '/../views/admin/dashboard.html.php';
    }
    public function category()
    {
        ob_start();
        require_once __DIR__ . '/../views/admin/listAllCategories.html.php';
        $output = ob_get_clean();
        require_once __DIR__ . '/../views/admin/dashboard.html.php';
    }
}
