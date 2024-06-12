<?php
if (!isset($_SESSION['user_name'])) {
    $_SESSION['login_required'] = "Please login to view the page!";
    header('location: ../../login.php');
}
