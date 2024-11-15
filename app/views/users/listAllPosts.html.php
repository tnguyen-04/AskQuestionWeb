<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$getModule = new Module();
$modules = $getModule->getModules();
?>

<div class="content" style="width: 420px; margin: 100px auto 60px;">
    <div class="border border-1 border-secondary overflow-hidden mb-4">
        <!-- information -->
        <div class="d-flex justify-content-between mt-3">
            <p class="ms-3"><strong><?= $username ?></strong></p>
            <div class="me-3">
                <button type="button" data-bs-toggle="tooltip" data-bs-placement="center bottom" title="Edit post" style="all:unset">
                    <i class="editPost fa-solid fa-user-pen me-2"></i>
                </button>
                <button type="button" update data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete post" style="all:unset">
                    <i class="deletePost fa-regular fa-trash-can"></i>
                </button>

            </div>
        </div>


        <!-- content -->
        <div class="ContentPost mx-3">
            <p class="text-content">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur nesciunt commodi accusantium. Culpa alias, pariatur sit quod dicta temporibus ducimus deleniti rem eum qui earum cupiditate doloribus blanditiis, possimus facilis nesciunt quam excepturi? Magni non laboriosam facilis. Soluta esse accusantium deleniti optio molestias aut illo corrupti quam nostrum nisi laborum corporis tenetur modi ab nobis alias libero dolores, veritatis culpa!
            </p>
        </div>
        <!-- images -->
        <div>
            <img class="d-block" src="<?= BASE_URL ?>/images/bgLogin.jpg" alt="" style="width: 420px; height: 400px;">
        </div>

        <!-- comment -->
        <div class="textarea-container" style="position: relative; width: 100%; display: flex; align-items: center;">
            <textarea class="commentPost d-block" placeholder="Comment here..." rows="1" style="resize: none; overflow: hidden; width: 100%; border: none;border-top: 1px solid rgb(108, 117, 125)"></textarea>
            <i class="fa-regular fa-paper-plane" style="position: absolute; right: 10px; bottom: 10px; cursor: pointer;"></i>
        </div>
    </div>
    <div class="border border-1 border-secondary overflow-hidden mb-4">
        <!-- information -->
        <div class="d-flex justify-content-between mt-3">
            <p class="ms-3"><strong><?= $username ?></strong></p>
            <div class="me-3">
                <button type="button" data-bs-toggle="tooltip" data-bs-placement="center bottom" title="Edit post" style="all:unset">
                    <i class="editPost fa-solid fa-user-pen me-2"></i>
                </button>
                <button type="button" update data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete post" style="all:unset">
                    <i class="deletePost fa-regular fa-trash-can"></i>
                </button>

            </div>
        </div>


        <!-- content -->
        <div class="ContentPost mx-3">
            <p class="text-content">
                SGWEGFWEGF Ừ FWEFIU WIUEF WGIU
            </p>
        </div>
        <!-- images -->
        <div>
            <img class="d-block" src="<?= BASE_URL ?>/images/bgLogin.jpg" alt="" style="width: 420px; height: 400px;">
        </div>

        <!-- comment -->
        <div class="textarea-container" style="position: relative; width: 100%; display: flex; align-items: center;">
            <textarea class="commentPost d-block" placeholder="Comment here..." rows="1" style="resize: none; overflow: hidden; width: 100%; border: none;border-top: 1px solid rgb(108, 117, 125)"></textarea>
            <i class="fa-regular fa-paper-plane" style="position: absolute; right: 10px; bottom: 10px; cursor: pointer;"></i>
        </div>
    </div>



    <!-- email -->
    <div class="emailAdmin position-fixed border border-2 border-dark rounded-circle d-flex justify-content-center align-items-center" style="bottom: 30px; right: 30px; height: 40px; width: 40px;">
        <i class="fa-regular fa-envelope fa-bounce fa-lg"></i>
    </div>
    <?php
    $success = getFlashData("success");
    $error = getFlashData("error");
    ?>
    <div class="emailAdminDisplay position-fixed " style="z-index:11;bottom:30px; right:30px; display:none">
        <label class="mb-2" for="sendEmail"><strong>Send email to admin
            </strong> </label>

        <div>
            <form method="POST" action="?module=User&action=sendMailToAdmin" class="d-flex align-item-end  ">

                <span class="me-3">
                    <textarea class="emailContent  border border-dark rounded p-4 d-flex" name="emailContent" rows="3" cols="35" placeholder="type your comment" style="resize: none; overflow: hidden; width: 100%; border: none;border-top: 1px solid rgb(108, 117, 125)" required></textarea>
                    <?= !empty($success) ? "<div class='text-success'>$success</div>" : null ?>
                    <?= !empty($error) ? "<div class='text-danger'>$error</div>" : null ?>
                </span>
                <input class="btn btn-primary align-self-end " type="submit" value="Send mail">

            </form>
        </div>
    </div>


    <!-- edit -->
    <div class="popUpFormEdit" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">
        <form class="p-3 border border-secondary" style="position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;max-width:420px; border-radius: 15px;">
            <div class="d-flex justify-content-between mb-3">
                <p><strong>Author's name</strong></p>

            </div>
            <textarea id="editContent" cols="50" placeholder="Type your question here" style="resize: none; border:none; border-bottom: 1px solid rgb(108, 117, 125);"></textarea>

            <div class="">
                <select name="modules" class="form-select my-3">
                    <option selected>Select a language</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, "UTF-8"); ?>">
                            <?= htmlspecialchars($module['name'], ENT_QUOTES, "UTF-8"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="choosePicture">
                    <i class="fa-regular fa-image"></i> Choose picture
                </label>
                <input type="file" id="choosePicture" style="display:none;" multiple>

            </div>
            <div id="imagePreview" style="margin-top: 20px;"></div>
            <div class="d-flex justify-content-end gap-3 me-3">
                <button type="button" class="cancelEdit btn btn-secondary">Cancel</button>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>
    <!-- pagination -->
    <nav class="d-flex justify-content-center" style="z-index: 10;">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</div>

<?php seeMore("text-content", "ContentPost");
?>
<script>
    let editPost = document.querySelectorAll('.editPost');
    let emailAdmin = document.querySelector('.emailAdmin');
    let emailAdminDisplay = document.querySelector('.emailAdminDisplay');

    let popUpFormEdit = document.querySelector('.popUpFormEdit')
    let cancelEdit = document.querySelectorAll('.cancelEdit');


    emailAdmin.addEventListener("click", (event) => {
        emailAdmin.style.visibility = "hidden";
        emailAdminDisplay.style.display = "block";
        event.stopPropagation();
    });

    emailAdminDisplay.addEventListener("click", (event) => {
        event.stopPropagation();
    });

    document.body.addEventListener("click", () => {
        if (emailAdminDisplay.style.display === "block") {
            emailAdminDisplay.style.display = "none";
            emailAdmin.style.visibility = "visible";
        }
    });


    editPost.forEach(post => {
        post.addEventListener("click", () => {
            popUpFormEdit.style.opacity = "1";
            popUpFormEdit.style.visibility = "visible";
            popUpFormEdit.style.transition = ".25s";
            document.body.style.overflowY = "scroll";
            document.body.style.width = "100%";
        });
    });



    cancelEdit.forEach(button => {
        button.addEventListener("click", () => {
            popUpFormEdit.style.opacity = "0"
            popUpFormEdit.style.visibility = "hidden"
            document.body.style.overflow = "auto"

        });
    });
</script>