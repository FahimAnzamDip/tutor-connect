<?php session_start(); ?>
<?php require_once '../database/db.php' ?>
<?php require_once '../helpers/functions.php' ?>
<?php require_once '../auth/admin_check.php' ?>
<?php
// Check if not Admin
if ($_SESSION['user_role'] != 'Admin') {
    header('location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Tutor Connect' : 'Tutor Connect' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="navbar bg-primary navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">TutorConnect</a>
        <div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="../admin/admin_profile.php">
                        <i class="bi bi-person me-1"></i>
                        <?= $_SESSION['user_username'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pe-0 text-white" href="../auth/logout.php">
                        <i class="bi bi-box-arrow-in-left me-1"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- Navbar Start -->
<nav class="dashboard navbar navbar-expand-lg bg-light navbar-light shadow">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#NavBar"
                aria-controls="NavBar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="NavBar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link ps-0 <?= getPageUrl() == 'dashboard.php' ? 'text-warning fw-medium' : '' ?>"
                       href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'subjects') ? 'text-warning fw-medium' : '' ?>"
                       href="subjects.php">Subjects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'students') ? 'text-warning fw-medium' : '' ?>"
                       href="students.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'teachers') ? 'text-warning fw-medium' : '' ?>"
                       href="teachers.php">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'messages') ? 'text-warning fw-medium' : '' ?>"
                       href="messages.php">Contact messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'services') ? 'text-warning fw-medium' : '' ?>"
                       href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(getPageUrl(), 'settings') ? 'text-warning fw-medium' : '' ?>"
                       href="settings.php">Settings</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->