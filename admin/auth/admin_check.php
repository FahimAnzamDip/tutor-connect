<?php
if (isset($_SESSION['user_username'])) {
    if (!$_SESSION['user_role'] == 'Admin') {
        $_SESSION['login_required'] = "Your are unauthorized to view the page!";
        header('location: ../../login.php');
    }
} else {
    $_SESSION['login_required'] = "Please login to view the page!";
    header('location: ../../login.php');
}
