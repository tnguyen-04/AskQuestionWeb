<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$module = new Module();
$modules = $module->getModules();
$successAddModule = getFlashData('successAddModule');
$errorAddModule = getFlashData('errorAddModule');

?>
<div class="container-fluid d-flex flex-column  align-items-center p-0" style="margin: 120px 0;">
    <div class="d-flex flex-column align-items-start">
        <?= !empty($successAddModule) && $successAddModule !== "" ? "<div class='alert alert-success'>$successAddModule</div>" : null ?>
        <?= !empty($errorAddModule) && $errorAddModule !== "" ? "<div class='alert alert-danger'>$errorAddModule</div>" : null ?>
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
                        <td><i data-edit-module="<?= $module['id'] ?>" class="editModule editButton fa fa-edit text-primary"></i></td>
                        <td><i data-delete-module="<?= $module['id'] ?>" class="deleteModule deleteButton fa fa-trash text-danger"></i></td>
                    </tr>


                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- edit and delete MODULE -->
    <?php foreach ($modules as $module): ?>


        <!-- edit Module -->
        <div class="editModuleForm-<?= $module['id'] ?> container-fluid d-flex justify-content-center align-items-center" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">
            <div class="rounded p-3 " style="box-sizing: content-box;width: 300px;height: 120px;background-color: #fff;">
                <h4>Update module</h4>
                <form method="POST" action="?module=Admin&action=editModule">
                    <input class="mb-3" name="updateNewModule" type="text" value="<?= $module['moduleName'] ?>" placeholder="type new module" style="width: 300px;">
                    <input name="module_id" type="hidden" value="<?= $module['id'] ?>">
                    <div class="d-flex justify-content-end">
                        <input type="button" class="cancelEditModule btn btn-secondary me-3" value="cancel">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>

        <!-- delete module -->
        <div class="popUpDelete-<?= $module['id'] ?> container-fluid d-flex justify-content-center align-items-center " style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 10; opacity: 0; visibility: hidden;">
            <form action="?module=Admin&action=deleteModule" method="POST" class="border border-dark rounded py-2" style="width: 350px;  background-color: #fff;">
                <!--module ID  -->
                <input type="hidden" name="module_id" value="<?= $module['id'] ?>">
                <div class="popUpHeader d-flex align-items-start justify-content-between">
                    <h5 class="modal-title ms-4">Do you want to delete this module?</h5>
                    <button type="button" class="popUpClose me-4" style="all: unset; scale: 1.5; cursor: pointer;">
                        <span>&times;</span>
                    </button>
                </div>
                <hr>
                <div class="popUpBody ms-4">
                    <p>This module will be deleted permanently.<?= $module['id'] ?></p>
                </div>
                <hr>
                <div class="popUpFooter d-flex justify-content-end align-items-center gap-3 me-3">
                    <button type="button" class="popUpCancel btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger" value="Submit">Delete</button>
                </div>
            </form>
        </div>

    <?php endforeach; ?>
    <!-- add Module -->
    <div class="addForm container-fluid d-flex justify-content-center align-items-center" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">

        <div class="rounded p-3 " style="box-sizing: content-box;width: 300px;height: 120px;background-color: #fff;">
            <h4>Add module </h4>
            <form method="POST" action="?module=Admin&action=addModule">
                <input class="mb-3" name="addNewModule" type="text" placeholder="type new module" style="width: 300px;">
                <div class="d-flex justify-content-end">
                    <input type="button" class="cancelAddModule btn btn-secondary me-3" value="cancel">
                    <input type="submit" class="btn btn-primary" value="Add">
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    // add module
    const addModule = document.querySelector('.addModule')
    const addForm = document.querySelector('.addForm')
    const cancelAddModules = document.querySelectorAll('.cancelAddModule')

    addModule.addEventListener("click", () => {
        addForm.style.visibility = "visible";
        addForm.style.opacity = "1";
        addForm.style.transition = ".25s";

    })
    cancelAddModules.forEach(cancelAddModule => {
        cancelAddModule.addEventListener("click", () => {
            addForm.style.visibility = "hidden";
            addForm.style.opacity = "0";

        })
    })

    //edit module
    const editModules = document.querySelectorAll('.editModule')
    editModules.forEach(editModule => {
        editModule.addEventListener("click", () => {
            const editID = editModule.getAttribute('data-edit-module');
            const editModuleForm = document.querySelector(`.editModuleForm-${editID}`)
            editModuleForm.style.visibility = "visible";
            editModuleForm.style.opacity = "1";
            editModuleForm.style.transition = ".25s";

            let closeEditModules = document.querySelectorAll('.cancelEditModule');
            closeEditModules.forEach(button => {
                button.addEventListener('click', () => {
                    editModuleForm.style.opacity = '0';
                    editModuleForm.style.visibility = 'hidden';
                    document.body.style.overflow = 'auto';
                });
            });
        })
    })

    //delete module
    const deleteModules = document.querySelectorAll('.deleteModule');


    deleteModules.forEach(deleteModule => {
        deleteModule.addEventListener('click', () => {
            const deleteNow = deleteModule.getAttribute('data-delete-module');
            const popUpFormDelete = document.querySelector(`.popUpDelete-${deleteNow}`);
            let closeDelete = document.querySelectorAll('.popUpClose, .popUpCancel');


            popUpFormDelete.style.opacity = '1';
            popUpFormDelete.style.visibility = 'visible';
            popUpFormDelete.style.transition = '.25s';
            document.body.style.overflowY = 'scroll';
            document.body.style.width = '100%';



            closeDelete.forEach(button => {
                button.addEventListener('click', () => {
                    popUpFormDelete.style.opacity = '0';
                    popUpFormDelete.style.visibility = 'hidden';
                    document.body.style.overflow = 'auto';
                });
            });

        });
    })
</script>