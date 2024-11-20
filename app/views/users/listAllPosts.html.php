<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$getModule = new Module();
$modules = $getModule->getModules();
$successDeletePost = getFlashData("successDeletePost");
$errorDeletePost = getFlashData("errorDeletePost");



?>


<div class="content" style="width: 420px;padding-top: 100px; margin: 0px auto 60px;">
    <?= !empty($successDeletePost) && $successDeletePost !== "" ? "<div class='alert alert-success'>$successDeletePost</div>" : null ?>
    <?= !empty($errorDeletePost) && $errorDeletePost !== "" ? "<div class='alert alert-danger'>$errorDeletePost</div>" : null ?>



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
                            <i data-deletePost-id="<?= $postData['id'] ?>" class="deletePost fa-regular fa-trash-can"></i>
                        </button>
                    <?php endif; ?>
                </div>

            </div>
            <!-- Time -->
            <div class="ms-3" style="font-size: 10px;color: #6f7071;"><?= $postData['created_at'] ?> <i class="fa-solid fa-earth-americas ms-1"></i></div>

            <!-- content -->
            <div class="ContentPost mx-3">
                <p class="text-content" style="overflow-wrap: break-word">
                    <?= $postData['content'] ?>
                </p>
            </div>

            <!-- Images -->
            <div class="postImageContainer d-flex" data-post-id="<?= $postData['id'] ?>" style="flex-wrap: wrap;">
                <?php
                $images = explode(',', $postData['upload']);
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
        <div class="popUpFormEdit-<?= $postData['id'] ?>  container-fluid d-flex justify-content-center align-items-center" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9;opacity: 0; visibility: hidden">
            <form method="POST" action="?module=Post&action=updatePost" enctype="multipart/form-data" class="p-3 border border-secondary" style="box-sizing:content-box ;margin-top:80px;max-width: 420px; background-color: #fff; border-radius: 15px;">
                <div class="d-flex justify-content-between mb-3">
                    <h5><?= $postData['username'] ?></h5>
                </div>
                <!-- postID -->
                <input type="hidden" name="post_id" value="<?= $postData['id'] ?>">
                <!-- content -->
                <textarea name="editContent" id="px-3 editContent" cols="50" placeholder="Type your question here" style="resize: none; border:none; border-bottom: 1px solid rgb(108, 117, 125);"> <?= $postData['content'] ?></textarea>
                <!-- preview -->
                <div class="imagePreview" style="position: relative;margin-top: 20px; display: flex; flex-wrap: wrap;  overflow: hidden;"></div>

                <!-- carousel -->
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

                <!-- buttons picture and modules -->
                <div class="d-flex justify-content-between align-items-center">
                    <label for="choosePicture" style="flex:1">
                        <i class="fa-regular fa-image"></i>Choose new picture
                    </label>
                    <!-- modules -->
                    <select style="flex:1" name="modules" class="form-select my-3 me-2">
                        <option value="<?= $postData['module_id'] ?>" selected><?= $postData['moduleName'] ?></option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, "UTF-8"); ?>">
                                <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- choose new picture -->
                    <input type="file" class="choosePicture" id="choosePicture" name="choosePicture[]" style="display:none;" multiple>

                </div>

                <!-- buttons -->
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="cancelEdit btn btn-secondary">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            </form>
        </div>
        <!-- delete Post -->
        <div class="popUpFormDelete-<?= $postData['id'] ?> modal-type" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9; opacity: 0; visibility: hidden;">
            <form action="?module=Post&action=deletePost" method="POST" class="border border-dark rounded py-2" style="width: 380px; position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;">
                <div>
                    <input type="hidden" name="post_id" value="<?= $postData['id'] ?>">
                    <div class="popUpHeader d-flex align-items-center justify-content-between">
                        <h5 class="modal-title ms-4">Do you want to delete the post</h5>
                        <button type="button" class="popUpClose me-4" style="all: unset; scale: 1.5; cursor: pointer;">
                            <span>&times;</span>
                        </button>
                    </div>
                    <hr>

                    <div class="popUpBody ms-4">
                        <p>This post will be deleted permanently.</p>
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
            const deleteNow = deletePost.getAttribute('data-deletePost-id');
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

    const editPosts = document.querySelectorAll('.editPost');
    editPosts.forEach(editPost => {
        document.querySelector('.choosePicture').addEventListener('change', function(e) {
            const files = e.target.files;
            const preview = document.querySelector('.imagePreview');
            const carouselImages = document.querySelector('.carouselImages');

            const imageArray = [];

            preview.innerHTML = '';
            carouselImages.innerHTML = '';

            const fileCount = files.length;
            const maxPreview = 4;

            for (let i = 0; i < fileCount; i++) {
                const file = files[i];

                if (file.size <= 3 * 1024 * 1024) { // 3MB
                    imageArray.push(file);
                } else {
                    alert('File must be smaller than 4MB.');
                }
            }

            imageArray.slice(0, maxPreview).forEach((file, index) => {
                const img = document.createElement('img');
                const objectURL = URL.createObjectURL(file);
                img.src = objectURL;

                if (imageArray.length === 1) {
                    img.style.width = '420px';
                    img.style.height = '400px';
                } else if (imageArray.length === 2) {
                    img.style.width = '420px';
                    img.style.height = '200px';
                } else if (imageArray.length === 3) {
                    if (index === 0) {
                        img.style.width = '420px';
                        img.style.height = '200px';
                    } else {
                        img.style.width = '210px';
                        img.style.height = '150px';
                    }
                } else if (imageArray.length >= 4) {
                    if (index === 0) {
                        img.style.width = '420px';
                        img.style.height = '200px';
                    } else {
                        img.style.width = '140px';
                        img.style.height = '150px';
                    }
                }

                // Thêm lớp phủ cho ảnh thứ 4
                if (index === 3 && imageArray.length > maxPreview) {
                    const overlayContainer = document.createElement('div');
                    overlayContainer.style.position = 'relative';
                    overlayContainer.style.width = img.style.width;
                    overlayContainer.style.height = img.style.height;

                    const overlay = document.createElement('div');
                    overlay.classList.add('overFiveImages');
                    overlay.textContent = `+${imageArray.length - maxPreview}`;

                    overlayContainer.appendChild(img);
                    overlayContainer.appendChild(overlay);
                    preview.appendChild(overlayContainer);
                    return;
                }

                preview.appendChild(img);
            });


            imageArray.forEach((file) => {
                const imgCarousel = document.createElement('img');
                const objectURL = URL.createObjectURL(file);
                imgCarousel.src = objectURL;
                carouselImages.appendChild(imgCarousel);
            });

            const prevButton = document.querySelector('.carouselPrev');
            const backgroundCarousel = document.querySelector('.background-carousel');
            const closeCarousel = document.querySelector('.closeCarousel');
            const nextButton = document.querySelector('.carouselNext');

            let totalImages = imageArray.length;
            let currentIndex = 0;

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

            preview.addEventListener('click', () => {
                backgroundCarousel.style.display = 'flex';
                document.body.style.overflowY = 'hidden';
                document.body.style.width = '100%';
            });

            closeCarousel.addEventListener("click", () => {
                backgroundCarousel.style.display = "none";
                document.body.style.overflowY = 'auto';
            });

        })

        editPost.addEventListener('click', () => {
            const editNow = editPost.getAttribute('data-editPost-id');
            const popUpFormEdit = document.querySelector(`.popUpFormEdit-${editNow}`);
            let closeDelete = popUpFormEdit.querySelectorAll('.cancelEdit');

            popUpFormEdit.style.opacity = '1';
            popUpFormEdit.style.visibility = 'visible';
            popUpFormEdit.style.transition = '.25s';
            document.body.style.overflowY = 'scroll';
            document.body.style.width = '100%';

            closeDelete.forEach(button => {
                button.addEventListener('click', () => {
                    popUpFormEdit.style.opacity = '0';
                    popUpFormEdit.style.visibility = 'hidden';
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

        //post images
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


    let emailAdmin = document.querySelector('.emailAdmin');
    let emailAdminDisplay = document.querySelector('.emailAdminDisplay');

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
</script>