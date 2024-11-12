<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
layout("header", "Forgot Password");
?>
<div class="bgCustom " style="min-width: 100vw;min-height:100vh">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form class="formCustom p-4 border rounded shadow" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Enter Your Email</h2>
            <input type="hidden" name="module" value="Auth">
            <input type="hidden" name="action" value="createNewPassword">
            <!-- email -->
            <div class="form-outline mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" class="form-control" required />
            </div>

            <!-- submit -->
            <button type="submit" class="btn btn-primary btn-block w-100">Submit</button>
            <!-- sign in -->
            <div class="text-center mt-3">
                <a href="?module=Auth&action=login">Sign in</a>
            </div>
        </form>
    </div>
</div>
<?php
layout("footer");
?>