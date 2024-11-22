<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}
class Authentication
{
    function register()
    {
        $userInputArr = filterUserInput();

        $errors =  validateUserInput($userInputArr);

        return [
            'errors' => $errors,
            'userInputArr' => $userInputArr
        ];
    }

    function activeAccount()
    {
        $token = filterUserInput()["activeToken"];
        if (!empty($token)) {
            $checkToken = selectOneRow("SELECT id from users WHERE activeToken = '$token'");
            $userID = $checkToken["id"];
            if (!empty($checkToken)) {
                $data = [
                    'activeToken' => null,
                    'status' => 1
                ];
                $update = updateData("users", $data, "id = $userID");
                if ($update) {
                    return true;
                } else {
                    return false;
                }
            } else {
                deleteData("users", "id = $checkToken");
                echo "Your account can't be activated, try again!";
            }
        } else {
            echo "Link does not exist or has expired.";
        }
    }

    function login()
    {
        $email = filterUserInput()['email'];
        $inputPassword = filterUserInput()['password'];

        $data = selectOneRow("SELECT id, password FROM users WHERE email = '$email'");

        if (!$data) {
            setFlashData("error", "Email or password is not correct");
            return false;
        }

        $password = $data['password'];
        $user_id = $data['id'];
        if (password_verify($inputPassword, $password)) {
            $loginToken = sha1(uniqid() . time());
            setSession("loginToken", $loginToken);
            $insertData = [
                'user_id' => $user_id,
                'loginToken' => $loginToken
            ];
            insertData("sessions", $insertData);
            return true;
        } else {
            setFlashData("error", "Email or password is not correct");
            return false;
        }
    }

    function forgotPassword()
    {
        $email = filterUserInput()['email'];
        $checkEmail = selectOneRow("SELECT id, username, email from users WHERE email = '$email'");
        if (!empty($checkEmail)) {
            $content = "<div style='text-align: center;'>
                            <h1 style='color:#ffc107; margin:0 auto 30px'>Hello {$checkEmail['username']}</h1>
                            <p style='margin:0 auto 30px'>Do you want to change your password, so click the button below to activate your account.</p>
                            <div style='display: inline-block; text-align: center;'>
                                <a href='http://localhost/phpExercises/coursework/public/?module=Auth&action=createNewPassword&id={$checkEmail['id']}' style='display: inline-block; padding: 15px 30px; background-color: black; color: white; text-decoration: none; font-weight: bold; border-radius: 5px;'>Click here</a>
                            </div>
                        </div>";
            $subject = "Change the password";
            sendEmail($email, $subject, $content);
            setFlashData("success", "Check your email to change your password!");
            return true;
        } else {
            setFlashData("error", "This email is not existed, please try again!");
            return false;
        }
    }

    function updateNewPassword()
    {

        $userInputArr = filterUserInput();
        $errors =  validateUserInput($userInputArr);
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (empty($errors)) {
            $data = [
                'password' => password_hash($userInputArr['password'], PASSWORD_DEFAULT),
            ];

            $update = updateData("users", $data, "id = $id");
            if ($update) {

                return true;
            } else {
                return "cant update";
            }
        } else {
            setFlashData("error", $errors);
            return false;
        }
    }

    function checkAccount()
    {
        if (!empty(getSession("loginToken"))) {
            $loginToken = getSession("loginToken");
            $sql = "SELECT users.id, users.role
                   FROM users
                   INNER JOIN sessions ON users.id = sessions.user_id
                   WHERE sessions.loginToken = '$loginToken'";
            $checkToken = selectOneRow($sql);

            if ($checkToken) {
                if ($checkToken['role'] === 1) {
                    header("location: ?module=Admin&action=user");
                    exit();
                } elseif ($checkToken['role'] === 2) {
                    header("location: ?module=User&action=home");
                    exit();
                }
            } else {
                deleteSession("loginToken");
                header("location: ?module=Auth&action=login");
                exit();
            }
        } else {
            header("location: ?module=Auth&action=login");
            exit();
        }
    }
    function checkLogin()
    {
        if (getSession("loginToken")) {
            $loginToken = getSession("loginToken");
            $sql = "SELECT users.id, users.username, users.email,users.role
                FROM users
                INNER JOIN sessions ON users.id = sessions.user_id
                WHERE sessions.loginToken = '$loginToken' ";
            $checkToken = selectOneRow($sql);

            if (!$checkToken) {
                header("location: ?module=Auth&action=login");
            } else {
                return $checkToken;
            }
        } else {
            header("location: ?module=Auth&action=login");
        }
    }

    function logout()
    {
        if (getSession("loginToken")) {
            $loginToken = getSession("loginToken");
            deleteData("sessions", "loginToken = '$loginToken'");
            deleteSession("loginToken");
            deleteSession();
            setcookie(session_name(), '', time() - 3600, '/');
            header("location:?module=Auth&action=login");
        }
    }
}
