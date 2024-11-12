<?php
if (!defined('_authorizedAccess') || !_authorizedAccess) {
    die("Access denied");
}

layout("header", $title);
?>

<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #e3b142;">
    <div class="container-fluid">
        <!-- Brand name, căn giữa khi màn hình nhỏ, căn trái khi màn hình lớn -->
        <a class="navbar-brand mx-auto d-block d-lg-inline ms-5" href="?module=User&action=home">HeyQuestion</a>

        <!-- Navbar links and buttons -->
        <div class="collapse navbar-collapse d-lg-flex justify-content-left align-items-center" id="navbarContent">
            <!-- Centered links -->
            <ul class="navbar-nav ms-auto">
                <li class="navCommon nav-item">
                    <a class="nav-link <?= (isset($_GET["action"]) && $_GET["action"] === "home") || $_SERVER['REQUEST_URI'] === "/phpExercises/coursework/public/" ? "active" : "" ?>" href="?module=User&action=home">Home</a>
                </li>
                <li class="navCommon nav-item">
                    <a class="nav-link <?= isset($_GET["action"]) && $_GET["action"] === "askQuestion" ? "active" : "" ?>" href="?module=User&action=askQuestion">Ask Question</a>
                </li>
            </ul>

            <!-- Right-aligned buttons -->
            <div class="d-flex ms-5 me-5">
                <a class="btn btn-dark me-2" href="?module=Auth&action=login">Sign Up</a>
                <a class="btn btn-dark" href="?module=Auth&action=logout">Log Out</a>
            </div>
        </div>

        <!-- Dropdown toggle for small screens -->
        <div class="d-lg-none dropdown">
            <a class="btn " role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="width: 50px; padding: 5px;">
                <span class="navbar-toggler-icon"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink" style="width: 200px; border: 1px solid black;">
                <li><a class="dropdown-item" href="?module=User&action=home">Home</a></li>
                <li><a class="dropdown-item" href="?module=User&action=askQuestion">Ask Question</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item btn btn-dark w-100" href="?module=Auth&action=login">Sign Up</a></li>
                <li><a class="dropdown-item btn btn-dark w-100 mt-2" href="?module=Auth&action=logout">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?= isset($output) ? $output : null; ?>
</main>

<?php
autoResizeTextArea("commentPost");
autoResizeTextArea("editContent");

autoResizeTextArea("contentPost");
autoResizeTextArea("emailContent");
seeMore("text-content", "boxContent");
layout("footer");
?>