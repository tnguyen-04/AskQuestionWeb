<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
layout("header", "Create New Password");
?>
<div class="bgCustom " style="min-width: 100vw;min-height:100vh">
    <div class=" container d-flex justify-content-center align-items-center vh-100">
        <form method="post" class="formCustom p-4 border rounded shadow" style="max-width: 400px; width: 100%;">
            <h1 class="text-center mb-4">New Password</h1>

            <div class="form-outline mb-3">
                <label class="form-label" for="createPassword">Create Password</label>
                <input type="password" id="createPassword" name="createPassword" class="form-control" required />
            </div>

            <div class="form-outline mb-4">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block w-100 mb-3">Submit</button>

            <div class="text-center">
                <a href="?module=Auth&action=login">Sign in</a>
            </div>
        </form>
    </div>
</div>

<?php
layout("footer");
?>