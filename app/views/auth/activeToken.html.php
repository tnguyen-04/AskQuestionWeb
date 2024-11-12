<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
layout("header", "Active Account");
?>

<div class="bgCustom" style="min-width: 100vw; min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form class="formCustom p-4 border rounded shadow" style="max-width: 400px; width: 100%;" method="POST">
            <h1 class="text-center">Activate your account</h1>
            <?php
            $activeAccount = new Authentication();
            $active = $activeAccount->activeAccount();
            $msg = "Check your email to complete sign-in!";

            if ($active) {
                echo "<div class='alert' role='alert' style='background-color: " .
                    ($msg === "Check your email to complete sign-in!" ? '#28a745' : '#f01435b3') .
                    "; color: white;'>Registered successfully</div>";
            }
            ?>
            <a class="btn btn-primary btn-block mb-4 text-center w-100" href="?module=Auth&action=login" style="color: white; text-decoration: none;">Sign in</a>
        </form>
    </div>
</div>


<?php
layout("footer");
?>