<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
?>

<div class="container d-flex justify-content-center " style="margin: 140px 185px 100px;">
    <form class="p-5 border border-secondary" style="max-width:498px; border-radius: 15px;">
        <div class="d-flex justify-content-between mb-3">
            <p><strong>Author's name</strong></p>
            <input class="btn btn-primary" type="submit" name="" id="" value="Post">
        </div>

        <textarea class="contentPost" rows="1" cols="50" placeholder="Type your question here" style="resize: none; overflow: hidden; width: 100%; border: none;border-bottom: 1px solid rgb(108, 117, 125)"></textarea>

        <div class="">
            <select class="form-select my-3">
                <option selected>Select a language</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
                <option value="5">Five</option>
                <option value="6">Six</option>
                <option value="7">Seven</option>
                <option value="8">Eight</option>
                <option value="9">Nine</option>
                <option value="10">Ten</option>
            </select>


            <label for="choosePicture">
                <i class="fa-regular fa-image"></i> Choose picture
            </label>
            <input type="file" id="choosePicture" style="display:none;" multiple>


        </div>
        <div id="imagePreview" style="margin-top: 20px;"></div>
    </form>

    <!-- Container to display selected images -->


</div>