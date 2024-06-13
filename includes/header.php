<?php session_start(); ?>
<?php require_once 'database/db.php' ?>
<?php require_once 'helpers/functions.php' ?>
<?php
$query = "SELECT * FROM settings WHERE id = 1";
$result = mysqli_query($connection, $query);
$settings = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - Tutor Connect' : 'Tutor Connect' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-primary navbar-dark py-4 main-nav shadow sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">TutorConnect</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#NavBar" aria-controls="NavBar" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="NavBar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= getPageUrl() == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= getPageUrl() == 'teachers.php' || getPageUrl() == 'teacher_detail.php' ? 'active' : '' ?>" href="teachers.php">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= getPageUrl() == 'about-us.php' ? 'active' : '' ?>" href="about-us.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= getPageUrl() == 'services.php' ? 'active' : '' ?>" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= getPageUrl() == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pe-0 text-white" href="registration.php">
                            <i class="bi bi-person me-1"></i>
                            Register
                        </a>
                    </li>
                <?php else: ?>
                    <?php if ($_SESSION['user_role'] == 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../admin/dashboard.php">
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
                    <?php elseif ($_SESSION['user_role'] == 'Student'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="student_dashboard.php">
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
                    <?php elseif ($_SESSION['user_role'] == 'Teacher'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="teacher_dashboard.php">
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
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->