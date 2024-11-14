
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layout($layout, $newTitle = null)
{
    if ($layout == "header") {
        if ($newTitle) {
            $title = $newTitle;
            require_once "../layouts/$layout.html.php";
        }
    }
    return require_once "../layouts/$layout.html.php";
}
function seeMore($textContent, $boxContentByClass)
{
    echo "<script>
       document.addEventListener('DOMContentLoaded', function() {

           let contents = document.querySelectorAll('.' + '$textContent');
           let boxContents = document.querySelectorAll('.' + '$boxContentByClass'); // Sửa đây
       
           contents.forEach(content => {
       
               let fullText = content.innerText;
               let previewText = fullText.substring(0, 100);
               let restOfText = fullText.substring(100);
       
               content.innerHTML = previewText +
                   '<span id=\"dots\">...</span>' +
                   '<span class=\"more-content\" style=\"display: none;\">' + restOfText + '</span>' +
                   '<span id=\"moreLink\" class=\"more-link\" style=\"color: #1895ef; cursor: pointer; word-break: break-word;\"> See more</span>';
       
               boxContents.forEach(boxContent => {
                   let moreLink = boxContent.querySelector('#moreLink'); // Sửa đây
                   if (moreLink) {  
                       boxContent.addEventListener('click', function() {
                           console.log('clicked');
                           let moreContent = content.querySelector('.more-content');
                           let dots = document.getElementById('dots');
       
                           if (moreContent.style.display === 'none') {
                               moreContent.style.display = 'inline';
                               dots.style.display = 'none';
                               moreLink.style.display = 'none';
                           } else {
                               moreContent.style.display = 'none';
                               dots.style.display = 'inline';
                               moreLink.style.display = 'inline';
                           }
                       });
                   }
               });
           });
       });
    </script>";
}
function autoResizeTextArea($textareaClass)
{
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('." . $textareaClass . "');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    textarea.style.height = 'auto'; 
                    textarea.style.height = textarea.scrollHeight + 'px'; 
                });
            }
        });
    </script>";
}
function confirmForm($type, $title, $content, $buttonValue, $redirect)
{
    echo "
    <div class=\"$type popUpFormDelete\" style=\"position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.5); z-index: 9; opacity: 0; visibility: hidden;\">
        <form class=\"border border-dark rounded py-2\" style=\"width: 380px; position: absolute; z-index: 10; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;\" action=\"$redirect\" method=\"POST\">
            <div>
                <div class=\"popUpHeader d-flex align-items-center justify-content-between\">
                    <h5 class=\"modal-title ms-4\">$title</h5>
                    <button type=\"button\" class=\"popUpClose me-4\" style=\"all: unset; scale: 1.5; cursor: pointer;\">
                        <span>&times;</span>
                    </button>
                </div>
                <hr>
                <div class=\"popUpBody ms-4\">
                    <p>$content</p>
                </div>
                <hr>
                <div class=\"popUpFooter d-flex justify-content-end align-items-center gap-3 me-3\">
                    <button type=\"button\" class=\"popUpCancel btn btn-secondary\">Cancel</button>
                    <button type=\"submit\" class=\"btn btn-danger\" value=\"$buttonValue\">$buttonValue</button>
                </div>
            </div>
        </form>
    </div>
    ";
}

function handleDeleteConfirmForm()
{
    echo "
    <script>
        let deletePost = document.querySelectorAll('.deletePost');
        let popUpFormDelete = document.querySelector('.deleteConfirm');
        let closeDelete = document.querySelectorAll('.popUpClose, .popUpCancel');
     

        deletePost.forEach(post => {
            post.addEventListener('click', () => {
                popUpFormDelete.style.opacity = '1';
                popUpFormDelete.style.visibility = 'visible';
                popUpFormDelete.style.transition = '.25s';
                document.body.style.overflowY = 'scroll';
                document.body.style.width = '100%';
            });
        });

        closeDelete.forEach(button => {
            button.addEventListener('click', () => {
                popUpFormDelete.style.opacity = '0';
                popUpFormDelete.style.visibility = 'hidden';
                document.body.style.overflow = 'auto';
            });
        });

    </script>
    ";
}
function handleLogoutConfirmForm()
{
    echo "
    <script>
            let logoutButtons = document.querySelectorAll('.logout');
            let popUpFormLogout = document.querySelector('.logoutForm');
            let closeButtons = document.querySelectorAll('.popUpClose, .popUpCancel');
         
            // Show confirmation form on 'Log Out' button click
            logoutButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    popUpFormLogout.style.opacity = '1';
                    popUpFormLogout.style.visibility = 'visible';
                    popUpFormLogout.style.transition = 'opacity 0.25s ease';
                    document.body.style.overflowY = 'scroll';
                    document.body.style.width = '100%';
                });
            });

            // Hide confirmation form on close button click
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    popUpFormLogout.style.opacity = '0';
                    popUpFormLogout.style.visibility = 'hidden';
                    document.body.style.overflow = 'auto';
                });
            });
    </script>
    ";
}




function setSession($key, $value)
{
    return $_SESSION[$key] = $value;
}
function getSession($key = "")
{
    if (empty($key)) {
        return $_SESSION;
    } else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }
}
function deleteSession($key = "")
{
    if (empty($key)) {
        session_destroy();
        return true;
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    }
}
function setFlashData($key, $value)
{
    $key = "flash_$key";
    return setSession($key, $value);
}
function getFlashData($key)
{
    $key = "flash_$key";
    $newKey = getSession($key);
    deleteSession($key);
    return $newKey;
}


function isPostMethod()
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
}
function isGetMethod()
{
    return $_SERVER["REQUEST_METHOD"] == "GET";
}
function filterUserInput()
{
    $filterInputArr = [];
    if (isGetMethod()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterInputArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterInputArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    } elseif (isPostMethod()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $filterInputArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $filterInputArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    } else {
        return "Something is wrong about the method";
    }
    return $filterInputArr;
}


function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function isIntNumber($number)
{
    return filter_var($number, FILTER_VALIDATE_INT);
}
function isValidPassword($string)
{
    $hasLowercase = preg_match('/[a-z]/', $string);

    $hasUppercase = preg_match('/[A-Z]/', $string);

    $hasDigit = preg_match('/[0-9]/', $string);

    $hasSpecialChar = preg_match('/[\W_]/', $string);

    return $hasLowercase && $hasUppercase && $hasDigit && $hasSpecialChar;
}
function sendEmail($to, $subject, $content)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'tonguyen0903@gmail.com';                     //SMTP username
        $mail->Password   = 'vonw glag tdgi uavf';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('tonguyen0903@gmail.com', 'HeyQuestion');
        $mail->addAddress($to);     //Add a recipient



        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->CharSet = 'UTF-8';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}


function validateUserInput($userInputArr)
{
    $errorInput = []; // Khai báo mảng lỗi tại đầu hàm

    // Kiểm tra username
    if (isset($userInputArr["username"])) {
        if (empty($userInputArr["username"])) {
            $errorInput["username"]["require"] = "Required username";
        } elseif (strlen($userInputArr["username"]) < 5) {
            $errorInput["username"]["minCharacter"] = "Username must have at least 5 characters";
        }
    }

    // Kiểm tra email
    if (isset($userInputArr["email"])) {
        if (empty($userInputArr["email"])) {
            $errorInput["email"]["require"] = "Required email";
        } elseif (!isEmail($userInputArr["email"])) {
            $errorInput["email"]["wrongFormat"] = "This is not a valid email format";
        } else {
            $email = $userInputArr["email"];
            $sql = "SELECT id FROM users WHERE email = '$email'";
            if (selectOneRow($sql) > 0) {
                $errorInput["email"]["existed"] = "This email already exists";
            }
        }
    }

    // Kiểm tra password
    if (isset($userInputArr["password"])) {
        if (empty($userInputArr["password"])) {
            $errorInput["password"]["require"] = "Required password";
        } elseif (strlen($userInputArr["password"]) < 7) {
            $errorInput["password"]["minPassword"] = "Password must have at least 6 characters";
        } else {
            if (!isValidPassword($userInputArr["password"])) {
                $errorInput["password"]["wrongFormat"] = "Password must contain a number, special character, uppercase, and lowercase letter.";
            }
        }
    }

    // Kiểm tra confirm password
    if (isset($userInputArr["confirmPassword"])) {
        if (empty($userInputArr["confirmPassword"])) {
            $errorInput["confirmPassword"]["require"] = "Password confirmation is required";
        } elseif ($userInputArr["confirmPassword"] != $userInputArr["password"]) {
            $errorInput["confirmPassword"]["incorrect"] = "Password confirmation is incorrect";
        }
    }

    return $errorInput;
}

function errorInput($error, $field)
{
    if (isset($error[$field])) {
        foreach ($error[$field] as $errorType => $errorMessage) {
            echo "<span style='color: red;'>$errorMessage</span><br>";
        }
    }
}

?>
