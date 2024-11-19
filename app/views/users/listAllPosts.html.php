<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$getModule = new Module();
$modules = $getModule->getModules();

?>


<div class="content" style="width: 420px;padding-top: 100px; margin: 0px auto 60px;">


    <?php foreach ($postDatas as $postData): ?>
        <div class="border border-1 border-secondary overflow-hidden mb-5" style="background-color: #fff;">
            <!-- information -->
            <div class="d-flex justify-content-between align-item-center mt-3">
                <div class="ms-3 d-flex">
                    <h5><?= $postData['username'] ?></h5>
                    <span class="ms-2"> <?= $postData['moduleName'] ?> </span>
                </div>

                <!-- buttons -->
                <div class="me-3">
                    <?php if ($userId == $postData['user_id']): ?>
                        <button type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit post" style="all:unset">
                            <i data-editPost-id="<?= $postData['id'] ?>" class="editPost fa-solid fa-user-pen me-2"></i>
                        </button>
                        <button type="button" update data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete post" style="all:unset">
                            <i data-deletetPost-id="<?= $postData['id'] ?>" class="deletePost fa-regular fa-trash-can"></i>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
            <!-- Time -->
            <div class="ms-3" style="font-size: 10px;color: #6f7071;"><?= $postData['created_at'] ?> <i class="fa-solid fa-earth-americas ms-1"></i></div>

            <!-- content -->
            <div class="ContentPost mx-3">
                <p class="text-content">
                    <?= $postData['content'] ?>
                </p>
            </div>
            <!-- Images -->
            <div class="postImageContainer d-flex" data-post-id="<?= $postData['id'] ?>" style="flex-wrap: wrap;">
                <?php
                $images = explode(',', $postData['upload']);
                $postImages = $images;
                if (!empty($images) && $images[0] !== '') {
                    foreach ($images as $image): ?>
                        <img class="imgOfPost"
                            src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Post image"
                            style="object-fit: cover;">
                <?php endforeach;
                }
                ?>
            </div>


            <!-- carousel images -->
            <div class="background-carousel" id="carousel-<?= $postData['id'] ?>" style="display: none;">
                <div class="closeCarousel"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                <div class="wrapperCarousel">
                    <div class="carouselPrev"> &#10094;</div>
                    <div class="carouselContainer">
                        <div class="carouselImages">
                            <?php
                            $images2 = explode(',', $postData['upload']);
                            if (!empty($images2) && $images2[0] !== '') {
                                foreach ($images2 as $image): ?>
                                    <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                                        alt="Post image"
                                        style="object-fit: contain;">
                            <?php endforeach;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="carouselNext">&#10095;</div>
                </div>
            </div>


            <!-- comment -->
            <!-- <div class="textarea-container" style="position: relative; width: 100%; display: flex; align-items: center;">
                <textarea class="commentPost d-block" placeholder="Comment here..." rows="1" style="resize: none; overflow: hidden; width: 100%; border: none;border-top: 1px solid rgb(108, 117, 125)"></textarea>
                <i class="fa-regular fa-paper-plane" style="position: absolute; right: 10px; bottom: 10px; cursor: pointer;"></i>
            </div> -->
        </div>

        <!-- edit -->
        <div class="editPost-<?= $postData['id'] ?> popUpFormEdit" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">
            <form class="p-3 border border-secondary" style="position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;max-width:420px; border-radius: 15px;">
                <div class="d-flex justify-content-between mb-3">
                    <h5><?= $postData['username'] ?></h5>

                </div>
                <!-- content -->
                <textarea id="editContent" cols="50" placeholder="Type your question here" style="resize: none; border:none; border-bottom: 1px solid rgb(108, 117, 125);"> <?= $postData['content'] ?></textarea>

                <div class="">
                    <select name="modules" class="form-select my-3">
                        <option selected>Select a language</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, "UTF-8"); ?>">
                                <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="choosePicture">
                        <i class="fa-regular fa-image"></i> Choose picture
                    </label>
                    <input type="file" id="choosePicture" style="display:none;" multiple>

                </div>
                <!-- preview -->
                <div id="imagePreview" style="margin-top: 20px;"></div>
                <!-- carousel images -->
                <div class="background-carousel" style="display: none;">
                    <div class="closeCarousel"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                    <div class="wrapperCarousel">
                        <div class="carouselPrev"> &#10094;</div>
                        <div class="carouselContainer">
                            <div class="carouselImages">

                            </div>
                        </div>
                        <div class="carouselNext">&#10095;</div>
                    </div>
                </div>
                <!-- buttons -->
                <div class="d-flex justify-content-end gap-3 me-3">
                    <button type="button" class="cancelEdit btn btn-secondary">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            </form>
        </div>
        <!-- delete Post -->
        <div class="popUpFormDelete-<?= $postData['id'] ?> modal-type" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9; opacity: 0; visibility: hidden;">
            <form action="" method="POST" class="border border-dark rounded py-2" style="width: 380px; position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;">
                <div>
                    <input type="hidden" name="<?= $postData['id'] ?>">
                    <div class="popUpHeader d-flex align-items-center justify-content-between">
                        <h5 class="modal-title ms-4">Do you want to delete the post</h5>
                        <button type="button" class="popUpClose me-4" style="all: unset; scale: 1.5; cursor: pointer;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <hr>
                    <div class="popUpBody ms-4">
                        <p>This post will be deleted permanently.<?= $postData['content'] ?></p>
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

<?php
seeMore("text-content", "ContentPost");

confirmForm("logoutForm", "Log out", "Do you want to log out?", "Log out", "?module=Auth&action=logout");
handleLogoutConfirmForm();
?>
<script>
    const carouselImages = document.querySelector('.carouselImages');
    const deletePosts = document.querySelectorAll('.deletePost');

    deletePosts.forEach(deletePost => {
        deletePost.addEventListener('click', () => {
            const deleteNow = deletePost.getAttribute('data-deletetPost-id');
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


    document.addEventListener('DOMContentLoaded', () => {
        const postImageContainers = document.querySelectorAll('.postImageContainer');
        const carousels = document.querySelectorAll('.background-carousel');

        //handle carousel
        carousels.forEach(carousel => {
            const carouselImages = carousel.querySelector('.carouselImages');
            const numberOfImage = carouselImages.querySelectorAll('img');

            const deletePosts = carousel.querySelector('.deletePost');
            const popUpFormDelete = carousel.querySelector('.popUpFormDelete');

            const closeButton = carousel.querySelector('.closeCarousel');
            const prevButton = carousel.querySelector('.carouselPrev');
            const nextButton = carousel.querySelector('.carouselNext');

            const totalImages = numberOfImage.length
            let currentIndex = 0

            //button of carousel
            function updateCarousel() {
                carouselImages.style.transform = `translateX(-${currentIndex * 500}px)`;
            }
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
                updateCarousel();
            });
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
                updateCarousel();
            });
            closeButton.addEventListener('click', function() {
                carousel.style.display = 'none';
                document.body.style.overflowY = 'auto';
            });
        });


        postImageContainers.forEach(postImageContainer => {
            postImageContainer.addEventListener('click', function() {
                // Lấy ID từ data-post-id
                const postId = postImageContainer.getAttribute('data-post-id');
                const carousel = document.querySelector(`#carousel-${postId}`);

                if (carousel) {
                    carousel.style.display = 'flex';
                    document.body.style.overflowY = 'hidden';
                    document.body.style.width = '100%';
                }
            });

            const imgOfPost = postImageContainer.querySelectorAll('.imgOfPost');


            const numberOfImg = imgOfPost.length;
            const maxDisplay = 4;

            if (numberOfImg === 1) {
                imgOfPost[0].style.width = '418px';
                imgOfPost[0].style.height = '400px';
            } else if (numberOfImg === 2) {
                imgOfPost[0].style.width = '209px';
                imgOfPost[0].style.height = '400px';
                imgOfPost[1].style.width = '209px';
                imgOfPost[1].style.height = '400px';
            } else if (numberOfImg === 3) {
                imgOfPost[0].style.width = '418px';
                imgOfPost[0].style.height = '200px';
                imgOfPost[1].style.width = '209px';
                imgOfPost[1].style.height = '200px';
                imgOfPost[2].style.width = '209px';
                imgOfPost[2].style.height = '200px';
            } else if (numberOfImg >= 4) {
                imgOfPost[0].style.width = '418px';
                imgOfPost[0].style.height = '200px';
                imgOfPost[1].style.width = '139px';
                imgOfPost[1].style.height = '200px';
                imgOfPost[2].style.width = '139px';
                imgOfPost[2].style.height = '200px';
                imgOfPost[3].style.width = '140px';
                imgOfPost[3].style.height = '200px';

                // Tạo container và overlay nếu có trên 4 ảnh
                const container = document.createElement('div');
                container.style.position = 'relative';
                container.style.width = '140px';
                container.style.height = '200px';

                // Đảm bảo ảnh thứ 4 được thêm vào container
                container.appendChild(imgOfPost[3]);

                // Kiểm tra nếu có nhiều hơn 4 ảnh, tạo lớp phủ
                if (numberOfImg > maxDisplay) {
                    const overlay = document.createElement('div');
                    overlay.classList.add('overFiveImages');
                    overlay.textContent = `+${numberOfImg - maxDisplay}`;
                    container.appendChild(overlay);

                    // Ẩn các ảnh thừa
                    for (let i = maxDisplay; i < numberOfImg; i++) {
                        imgOfPost[i].style.display = 'none';
                    }
                }

                // Đảm bảo container được thêm vào postImageContainer
                postImageContainer.appendChild(container);

                // Đảm bảo các ảnh sau ảnh thứ 4 được ẩn hoặc hiển thị tùy theo điều kiện
                for (let i = maxDisplay; i < numberOfImg; i++) {
                    imgOfPost[i].style.display = 'none';
                }
            }
        });
    });





    // ==============================================================================

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