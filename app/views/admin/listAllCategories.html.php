<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
$module = new Module();
$modules = $module->getModules();
?>
<div class="container-fluid d-flex flex-column  align-items-center p-0" style="margin: 120px 0;">
    <div class="d-flex flex-column align-items-start"> <!-- Căn trái các phần tử -->
        <div class="addModule btn btn-success mb-3">
            Add new module
            <i class="fa-solid fa-plus"></i>
        </div>
        <table class="table table-bordered table-striped text-center w-auto">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Module name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 0 ?>
                <?php foreach ($modules as $module): ?>
                    <tr>
                        <td><?= $count += 1 ?></td>
                        <td><?= $module['moduleName'] ?></td>
                        <td><i class="editModule fa fa-edit text-primary"></i></td>
                        <td><i class="deleteModule fa fa-trash text-danger"></i></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>