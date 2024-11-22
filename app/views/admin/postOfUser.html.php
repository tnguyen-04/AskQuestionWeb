<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
$userList = new User();
$userPosts = $userList->showUserPosts();

?>
<div class="content" style="width: 420px;padding-top: 100px; margin: 0px auto 60px;">
    <?php foreach ($userPosts as $userPost): ?>
        <div class="border border-1 border-secondary overflow-hidden mb-5" style="background-color: #fff;">
            <!-- information -->
            <div class="d-flex justify-content-between align-item-center mt-3">
                <div class="ms-3 d-flex">
                    <h5><?= $userPost['username'] ?></h5>
                    <span class="ms-2"> <?= $userPost['moduleName'] ?> </span>
                </div>

                <!-- buttons -->
                <div class="me-3">
                    <button type="button" update data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete post" style="all:unset">
                        <i data-deletePost-id="<?= $userPost['post_id'] ?>" class="deletePost fa-regular fa-trash-can"></i>
                    </button>
                </div>

            </div>
            <!-- Time -->
            <div class="ms-3" style="font-size: 10px;color: #6f7071;"><?= $userPost['created_at'] ?> <i class="fa-solid fa-earth-americas ms-1"></i></div>

            <!-- content -->
            <div class="ContentPost mx-3">
                <p class="text-content" style="overflow-wrap: break-word">
                    <?= $userPost['content'] ?>
                </p>
            </div>

            <!-- Images -->
            <div class="postImageContainer d-flex" data-post-id="<?= $userPost['post_id'] ?>" style="flex-wrap: wrap;cursor: pointer;">
                <?php
                $images = explode(',', $userPost['upload']);
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
            <div class="background-carousel" id="carousel-<?= $userPost['post_id'] ?>" style="display: none;">
                <div class="closeCarousel"><i class="fa-solid fa-xmark fa-2xl"></i></div>
                <div class="wrapperCarousel">
                    <div class="carouselPrev"> &#10094;</div>
                    <div class="carouselContainer">
                        <div class="carouselImages">
                            <?php
                            $images2 = explode(',', $userPost['upload']);
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

            <!-- delete Post -->
            <div class="popUpFormDelete-<?= $userPost['post_id'] ?> modal-type" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9; opacity: 0; visibility: hidden;">
                <form action="?module=Post&action=deletePost" method="POST" class="border border-dark rounded py-2" style="width: 380px; position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;">
                    <div>
                        <input type="hidden" name="post_id" value="<?= $userPost['post_id'] ?>">
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
        </div>
    <?php endforeach; ?>

</div>
<script>
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

    // show image in home page
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
</script>