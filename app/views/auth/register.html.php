<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
layout("header", "Register");
if (isPostMethod()) {
    $authentication = new Authentication();
    $result = $authentication->register();
    $error = $result['errors'];
    $userInputArr = $result["userInputArr"];
    if (empty($error)) {
        $activeToken = sha1(uniqid() . time());

        $data = [
            "username" => $userInputArr['username'],
            "email" => $userInputArr['email'],
            "password" => password_hash($userInputArr['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'role' => '2'
        ];

        $insert = insertData("users", $data);
        if ($insert) {
            $content = "<div style='text-align: center;'>
                <h1 style='color:#ffc107; margin:0 auto 30px'>Hello {$userInputArr['username']}</h1>
                <p style='margin:0 auto 30px'>We want to verify your account email, so click the button below to activate your account.</p>
                <div style='display: inline-block; text-align: center;'>
                    <a href='http://localhost/phpExercises/coursework/public/?module=Auth&action=activeToken&activeToken=$activeToken' style='display: inline-block; padding: 15px 30px; background-color: black; color: white; text-decoration: none; font-weight: bold; border-radius: 5px;'>Click here</a>
                </div>
            </div>";
            $subject = "Active your accounts";
            sendEmail($userInputArr['email'], $subject, $content);
            setFlashData("msg", "Check your email to complete sign-in!");
            setFlashData("validData", $userInputArr);
        }
        // header("location:?module=Auth&action=login");   
    } else {
        setFlashData("msg", "Please, check your data again");
        setFlashData("errors", $error);
    }
}

$msg = getFlashData("msg");
$error = getFlashData("errors");
$validData = getFlashData("validData");
?>
<div class="bgCustom " style="min-width: 100vw;min-height:100vh">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form class="formCustom p-4 border rounded shadow" style="max-width: 400px; width: 100%;" method="POST">
            <h1 class="text-center mb-4">Register</h1>

            <?php if (!empty($msg)): ?>
                <div class="alert" role="alert" style="background-color: <?= $msg === "Check your email to complete sign-in!" ? '#28a745' : '#f01435b3' ?>; color: white;">
                    <?= $msg; ?>
                </div>
            <?php endif; ?>

            <!-- Username  -->
            <div class="form-outline mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?= isset($validData['username']) ? $validData['username'] : '' ?>" required />

                <?php echo errorInput($error, "username"); ?>

            </div>
            <!-- email -->
            <div class="form-outline mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?= isset($validData['email']) ? $validData['email'] : '' ?>" required />
                <?php errorInput($error, "email") ?>
            </div>
            <!-- create password -->
            <div class="form-outline mb-3">
                <label class="form-label" for="createPassword">Create Password</label>
                <input type="password" name="password" class="form-control" required />
                <?php errorInput($error, "password") ?>
            </div>
            <!-- confirm password -->
            <div class="form-outline mb-4">
                <label class="form-label" for="confirmPassword">Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control" required />
                <?php errorInput($error, "confirmPassword") ?>
            </div>
            <!-- submit -->
            <button type="submit" class="btn btn-primary btn-block w-100 mb-3">Register</button>

            <!-- login -->
            <div class="text-center">
                <a href="?module=Auth&action=login">Sign in</a>
            </div>
        </form>
    </div>
</div>


<?php
layout("footer");
?>