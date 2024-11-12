<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
layout("header", "Login");
?>
<div class="bgCustom " style="min-width: 100vw;min-height:100vh">
    <div class=" container d-flex justify-content-center align-items-center vh-100">
        <form class="formCustom p-4 border rounded shadow" style="max-width: 400px;width:100%" method="POST">
            <h1 class="text-center">Login</h1>

            <!-- Email  -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Email</label>
                <input type="email" name="email" class="form-control" />
            </div>

            <!-- Password  -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Password</label>
                <input type="password" name="password" class="form-control" />
            </div>

            <!-- Forgot password  -->
            <div class="d-flex justify-content-end mb-4">
                <a href="?module=Auth&action=forgotPassword">Forgot password?</a>
            </div>

            <input type="submit" class="btn btn-primary btn-block mb-4 text-center w-100" value="Sign in">

            <!-- Register  -->
            <div class="text-center">
                <p>Not a member? <a href="?module=Auth&action=register">Register</a></p>
            </div>
        </form>
    </div>
</div>
<?php
layout("footer");
?>