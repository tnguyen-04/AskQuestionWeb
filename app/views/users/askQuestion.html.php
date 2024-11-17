<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$module = new Module();
$modules = $module->getModules();
$success = getFlashData("success");
$error = getFlashData("error");
?>
<div class="container d-flex justify-content-center" style=" position: relative;margin: 140px 185px 100px;">
    <div>
        <?= !empty($success) && $success !== "" ? "<div class='alert alert-success'>$success</div>" : null ?>
        <?= !empty($error) && $error !== "" ? "<div class='alert-danger'>$error</div>" : null ?>
        <form enctype="multipart/form-data" method="POST" action="?module=Post&action=postQuestion" class="p-5 border border-secondary" style="max-width:498px; border-radius: 15px;">
            <div class="d-flex justify-content-between mb-3">
                <p><strong><?= $username ?></strong></p>
                <input class="btn btn-primary" type="submit" value="Post">
            </div>

            <textarea class="contentPost" name="contentAskQuestion" rows="1" cols="50" placeholder="Type your question here" required style="resize: none; overflow: hidden; width: 100%; border: none; border-bottom: 1px solid rgb(108, 117, 125)"></textarea>

            <input type="hidden" name="user_id" value="<?= $userId ?>">
            <div class="imagePreview" style="position: relative;margin-top: 20px; display: flex; flex-wrap: wrap; "></div>
            <input type="file" class="choosePicture" id="choosePicture" name="choosePicture[]" style="display:none;" multiple>


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
                    <option selected>Select a language</option>
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

<script>
    document.querySelector('.choosePicture').addEventListener('change', function(e) {
        const files = e.target.files;
        //preview
        const preview = document.querySelector('.imagePreview');

        preview.innerHTML = '';

        const fileCount = files.length;
        const maxPreview = 4;

        for (let i = 0; i < Math.min(fileCount, maxPreview); i++) {
            const file = files[i];
            if (file.size <= 3 * 1024 * 1024) { //3MB
                const reader = new FileReader();

                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.objectFit = 'cover';

                    if (fileCount === 1) {
                        img.style.width = '400px';
                        img.style.height = '400px';
                    } else if (fileCount === 2) {
                        img.style.width = '400px';
                        img.style.height = '200px';
                    } else if (fileCount === 3) {
                        if (i === 0) {
                            img.style.width = '400px';
                            img.style.height = '200px';
                        } else {
                            img.style.width = '200px';
                            img.style.height = '150px';
                        }
                    } else if (fileCount >= 4) {
                        if (i === 0) {
                            img.style.width = '450px';
                            img.style.height = '225px';
                        } else {
                            img.style.width = '133px';
                            img.style.height = '150px';
                        }

                        if (i === 3 && fileCount > maxPreview) {
                            const overlayContainer = document.createElement('div');
                            overlayContainer.style.position = 'relative';
                            overlayContainer.style.width = img.style.width;
                            overlayContainer.style.height = img.style.height;

                            const overlay = document.createElement('div');
                            overlay.classList.add('overFiveImages');
                            overlay.textContent = `+${fileCount - maxPreview}`; //the number of images


                            overlayContainer.appendChild(img);
                            overlayContainer.appendChild(overlay);
                            preview.appendChild(overlayContainer);
                            return;
                        }
                    }

                    preview.appendChild(img);

                };

                reader.readAsDataURL(file);
            } else {
                alert('File must be smaller than 4MB.');
            }
        }


        // carousel
        const prevButton = document.querySelector('.carouselPrev');
        const backgroundCarousel = document.querySelector('.background-carousel')
        const carouselImages = document.querySelector('.carouselImages')
        const closeCarousel = document.querySelector('.closeCarousel');
        const nextButton = document.querySelector('.carouselNext');
        const carousel = document.querySelector('.carouselImages');
        let totalImages = 0

        for (let i = 0; i < fileCount; i++) {
            const file = files[i];
            if (file.size <= 3 * 1024 * 1024) { //3MB
                const reader = new FileReader();

                reader.onload = function(event) {

                    const imgCarousel = document.createElement('img');
                    imgCarousel.src = event.target.result;
                    imgCarousel.style.objectFit = 'container';

                    carouselImages.appendChild(imgCarousel);
                };

                reader.readAsDataURL(file);
            } else {
                alert('File must be smaller than 4MB.');
            }
        }

        totalImages = fileCount;
        console.log("Số ảnh hiện tại:", totalImages);
        let currentIndex = 0;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentIndex * 500}px)`;
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