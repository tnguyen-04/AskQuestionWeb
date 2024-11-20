<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$module = new Module();
$modules = $module->getModules();
$successPost = getFlashData("successPost");
$errorPost = getFlashData("errorPost");

?>
<div class="container-fluid d-flex justify-content-center" style="margin-top: 120px;">
    <div>
        <?= !empty($successPost) && $successPost !== "" ? "<div class='alert alert-success'>$successPost</div>" : null ?>
        <?= !empty($errorPost) && $errorPost !== "" ? "<div class='alert alert-danger'>$errorPost</div>" : null ?>
        <form enctype="multipart/form-data" method="POST" action="?module=Post&action=postQuestion" class="p-5 border border-secondary" style="max-width:498px; border-radius: 15px;">
            <div class="d-flex justify-content-between mb-3">
                <p><strong><?= $username ?></strong></p>
                <input class="btn btn-primary" type="submit" value="Post">
            </div>

            <textarea class="contentPost" name="contentAskQuestion" rows="1" cols="50" placeholder="Type your question here" required style="resize: none; overflow: hidden; width: 100%; border: none; border-bottom: 1px solid rgb(108, 117, 125)"></textarea>

            <input type="hidden" name="user_id" value="<?= $userId ?>">
            <div class="imagePreview" style="position: relative;margin-top: 20px; display: flex; flex-wrap: wrap;  overflow: hidden;"></div>
            <input type="file" class="choosePicture" id="choosePicture" name="choosePicture[]" style="display:none;" multiple>

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


            <div class="d-flex justify-content-between align-items-center" style="margin-top: 10px;">
                <!-- picture -->
                <label for="choosePicture" style="flex: 1; ">
                    <i class="fa-regular fa-image"></i> Choose picture
                </label>
                <!-- modules -->

                <select name="modules" class="form-select my-3" style="flex: 1;" required>
                    <option value="" selected>Select a language</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, "UTF-8"); ?>">
                            <?= htmlspecialchars($module['moduleName'], ENT_QUOTES, "UTF-8"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


        </form>
    </div>
</div>


<?php
confirmForm("logoutForm", "Log out", "Do you want to log out?", "Log out", "?module=Auth&action=logout");
handleLogoutConfirmForm();
?>
<script>
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
                img.style.width = '400px';
                img.style.height = '400px';
            } else if (imageArray.length === 2) {
                img.style.width = '400px';
                img.style.height = '200px';
            } else if (imageArray.length === 3) {
                if (index === 0) {
                    img.style.width = '400px';
                    img.style.height = '200px';
                } else {
                    img.style.width = '200px';
                    img.style.height = '150px';
                }
            } else if (imageArray.length >= 4) {
                if (index === 0) {
                    img.style.width = '450px';
                    img.style.height = '225px';
                } else {
                    img.style.width = '133px';
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
    });
</script>