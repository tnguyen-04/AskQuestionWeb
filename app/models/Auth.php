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

        // Nếu có dữ liệu, tiếp tục xử lý đăng nhập
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
}
