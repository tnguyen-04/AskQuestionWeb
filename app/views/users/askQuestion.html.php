<?php

if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

$module = new Module();
$modules = $module->getModules();
?>

<div class="container d-flex justify-content-center" style="margin: 140px 185px 100px;">
    <form class="p-5 border border-secondary" style="max-width:498px; border-radius: 15px;">
        <div class="d-flex justify-content-between mb-3">
            <p><strong><?= $username ?></strong></p>
            <input class="btn btn-primary" type="submit" name="" id="" value="Post">
        </div>

        <textarea class="contentPost" rows="1" cols="50" placeholder="Type your question here" style="resize: none; overflow: hidden; width: 100%; border: none; border-bottom: 1px solid rgb(108, 117, 125)"></textarea>

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
    </form>
</div>