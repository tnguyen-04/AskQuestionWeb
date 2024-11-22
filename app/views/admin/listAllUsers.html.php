<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
?>
<div class="container-fluid p-0" style="margin-top: 120px;">
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
                    <td><i data-delete-name="<?= $user['id'] ?>" class="deleteName deleteButton fa fa-trash text-danger"></i></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <?php foreach ($allUsers as $user): ?>
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
        <?php endforeach; ?>
    </table>
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
</script>