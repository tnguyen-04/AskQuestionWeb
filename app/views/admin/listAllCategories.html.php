<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$getModule = new Module();
$modules = $getModule->getModules();
?>
<div class="container-fluid p-0" style="margin-top: 120px;">
    <table class="mx-auto my-0 table table-bordered table-striped text-center w-auto">
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
                    <td><?= $module['name'] ?></td>
                    <td><i class="fa fa-edit text-primary" style="cursor: pointer;"></i></td>
                    <td><i class="fa fa-trash text-danger" style="cursor: pointer;"></i></td>
                <?php endforeach; ?>
                </tr>
        </tbody>

    </table>
</div>