<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

use Cloudinary\Api\Admin\AdminApi;

class Module
{
    public function getModules()
    {
        return selectRows("SELECT id,moduleName FROM modules");
    }
    public function addNewModule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = [];
            $newModule = $_POST['addNewModule'];
            $data = [
                'moduleName' => $newModule
            ];
            $insert = insertData("modules", $data);
            if (!$insert) {
                $response['error'] = "failed to add $newModule";
            }
        }
        $response['success'] = "$newModule added successfully";
        return $response;
    }
    public function editNewModule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = [];
            $newModule = $_POST['updateNewModule'];
            $moduleID = $_POST['module_id'];
            $data = [
                'moduleName' => $newModule
            ];
            $update = updateData("modules", $data, "id = $moduleID");

            if (!$update) {
                $response['error'] = "failed to update $newModule";
            }
        }
        $response['success'] = "$newModule updated successfully";
        return $response;
    }
    public function deleteAModule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = [];
            $moduleID = $_POST['module_id'];
            $sql = "SELECT 
                p.id AS post_id,
                p.user_id,
                p.module_id,
                p.content,
                u.username,
                m.moduleName,
                ul.upload 
            FROM 
                modules AS m
            LEFT JOIN 
                posts AS p ON p.module_id = m.id
            LEFT JOIN 
                users AS u ON p.user_id = u.id
            LEFT JOIN 
                uploads AS ul ON ul.post_id = p.id
            WHERE 
                m.id = $moduleID;
            ";
            $deleteRelatedPosts = selectRows($sql);

            if (empty($deleteRelatedPosts)) {
                $response['error'] = "no images  $moduleID ";
                return $response;
            }
            foreach ($deleteRelatedPosts as $deleteRelatedPost) {
                $imageUrls = !empty($deleteRelatedPost['upload']) ? explode(',', $deleteRelatedPost['upload']) : [];

                $publicIds = [];
                if ($imageUrls != []) {
                    foreach ($imageUrls as $url) {
                        preg_match('/\/v(\d+)\/(.*?)\.(jpg|jpeg|png|gif)/', $url, $matches);
                        if (isset($matches[2])) {
                            $publicIds[] = $matches[2];
                        }
                    }

                    if (empty($publicIds)) {
                        $response['error'] = "No valid public_ids found for deletion.";
                        return $response;
                    }

                    try {
                        $adminApi = new AdminApi();
                        $result = $adminApi->deleteAssets($publicIds);
                    } catch (Exception $e) {
                        $response['error'] = "Error deleting images: " . $e->getMessage();
                        return $response;
                    }
                }
            }
            $deleteNow = deleteData("modules", "id = $moduleID");
            if (!$deleteNow) {
                $response['error'] = "CANNOT DELETE IN DATABASE";
                return $response;
            }
        }
        $response['success'] = " Deleted successfully";
        return $response;
    }
}
