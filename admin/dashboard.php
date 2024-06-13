<?php $title = 'Dashboard'; ?>

<?php include_once '../includes/admin_header.php'; ?>

<?php
// Get Message Count
$query = "SELECT COUNT(*) as total FROM messages";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$message_count = $row['total'];

// Get Teachers Count
$query = "SELECT COUNT(*) as total FROM teachers WHERE approved = 1";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$teacher_count = $row['total'];

// Get Student Count
$query = "SELECT COUNT(*) as total FROM users WHERE role = 'student'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$student_count = $row['total'];

// Get Service Count
$query = "SELECT COUNT(*) as total FROM services";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$service_count = $row['total'];
?>

<!-- Content Start -->
<section class="pt-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Dashboard</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card bg-primary text-white mb-4 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people h1"></i>
                        <h6 class="card-title">Students</h6>
                        <p class="card-text display-6"><?= $student_count ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-info text-white mb-4 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-list-check h1"></i>
                        <h6 class="card-title">Services</h6>
                        <p class="card-text display-6"><?= $service_count ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-success text-white mb-4 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-people h1"></i>
                        <h6 class="card-title">Verified Teachers</h6>
                        <p class="card-text display-6"><?= $teacher_count ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card bg-warning text-white mb-4 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-envelope h1"></i>
                        <h6 class="card-title">Contact Messages</h6>
                        <p class="card-text display-6"><?= $message_count ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Content End -->

<?php include_once '../includes/admin_footer.php'; ?>
