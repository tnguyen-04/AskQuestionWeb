<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
$userList = new User();
$allUsers = $userList->getAllUsers();
$successDeletePost = getFlashData("successDeletePost");
$errorDeletePost = getFlashData("errorDeletePost");
?>
<div class="container-fluid p-0" style="margin-top: 120px;">
    <?= !empty($successDeletePost) && $successDeletePost !== "" ? "<div class='alert alert-success mx-auto my-3' style='width: 300px'>$successDeletePost</div>" : null ?>
    <?= !empty($errorDeletePost) && $errorDeletePost !== "" ? "<div class='alert alert-danger'mx-auto my-3' style='width: 300px'>$errorDeletePost</div>" : null ?>
    <table class="mx-auto my-0 table table-bordered table-striped text-center w-auto">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0 ?>
            <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td><?= $count += 1 ?></td>
                    <td><a href="?module=Admin&action=showUserPost&userId=<?= $user['id'] ?>"><?= $user['username'] ?></a></td>
                    <td><?= $user['email'] ?></td>
                    <td><i data-edit-name="<?= $user['id'] ?>" class="editName editButton fa fa-edit text-primary"></i></td>
                    <td>
                        <i data-delete-name="<?= $user['id'] ?>" class="deleteName deleteButton fa fa-trash text-danger"
                            <?= $user['role'] === 1 ? 'style="pointer-events: none; opacity: 0.5;"' : '' ?>></i>
                    </td>


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php foreach ($allUsers as $user): ?>
        <!-- EDIT -->
        <div class="editUserForm-<?= $user['id'] ?> container-fluid d-flex justify-content-center align-items-center" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">
            <div class="rounded p-3 " style="box-sizing: content-box;width: 300px;height: 120px;background-color: #fff;">
                <h4>Update Name</h4>
                <form method="POST" action="?module=Admin&action=editName">
                    <input class="mb-3" name="updateNewName" type="text" value="<?= $user['username'] ?>" placeholder="type new name" style="width: 300px;">
                    <input name="user_id" type="hidden" value="<?= $user['id'] ?>">
                    <div class="d-flex justify-content-end">
                        <input type="button" class="cancelEditName btn btn-secondary me-3" value="cancel">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
        <!-- DELETE -->
        <div class="popUpFormDelete-<?= $user['id'] ?> modal-type" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9; opacity: 0; visibility: hidden;">
            <form action="?module=Admin&action=deleteUser" method="POST" class="border border-dark rounded py-2" style="width: 380px; position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;">
                <div>
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <div class="popUpHeader d-flex align-items-center justify-content-between">
                        <h5 class="modal-title ms-4">Do you want to delete this user</h5>
                        <button type="button" class="popUpClose me-4" style="all: unset; scale: 1.5; cursor: pointer;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <hr>

                    <div class="popUpBody ms-4">
                        <p>This user will be deleted permanently.<?= $user['username'] ?></p>
                    </div>

                    <hr>
                    <div class="popUpFooter d-flex justify-content-end align-items-center gap-3 me-3">
                        <button type="button" class="popUpCancel btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-danger" value="Submit">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<script>
    //edit module
    const editNames = document.querySelectorAll('.editName')
    editNames.forEach(editName => {
        editName.addEventListener("click", () => {
            const editID = editName.getAttribute('data-edit-name');
            const editUserForm = document.querySelector(`.editUserForm-${editID}`)
            editUserForm.style.visibility = "visible";
            editUserForm.style.opacity = "1";
            editUserForm.style.transition = ".25s";

            let cancelEditNames = document.querySelectorAll('.cancelEditName');
            cancelEditNames.forEach(button => {
                button.addEventListener('click', () => {
                    editUserForm.style.opacity = '0';
                    editUserForm.style.visibility = 'hidden';
                    editUserForm.body.style.overflow = 'auto';
                });
            });
        })
    })
    //delete
    const deleteNames = document.querySelectorAll('.deleteName');
    deleteNames.forEach(deleteName => {
        deleteName.addEventListener('click', () => {
            const deleteNow = deleteName.getAttribute('data-delete-name');
            const popUpFormDelete = document.querySelector(`.popUpFormDelete-${deleteNow}`);
            let closeDelete = popUpFormDelete.querySelectorAll('.popUpClose, .popUpCancel');


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