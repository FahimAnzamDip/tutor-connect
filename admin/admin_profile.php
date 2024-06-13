<?php $title = 'Edit Settings' ?>

<?php include_once '../includes/admin_header.php' ?>

<?php
// Update Password
if (isset($_POST['submit_password_update'])) {
    $current_password = $_POST['current_password'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    $hashed_current_password = md5($current_password);
    $hashed_password = md5($password);
    $hashed_password_confirmation = md5($password_confirmation);

    $password_query = "SELECT * FROM users WHERE id = " . $_SESSION['user_id'] . " AND password = '$hashed_current_password'";
    $password_check = mysqli_query($connection, $password_query);

    if (!$password_check) {
        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
    } else {
        if ($password_check->num_rows == 1) {
            if ($hashed_password == $hashed_password_confirmation) {
                $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE id = " . $_SESSION['user_id'];
                $update_password = mysqli_query($connection, $update_password_query);

                if (!$update_password) {
                    die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
                    exit();
                } else {
                    $_SESSION['success'] = "Password Updated Successfully!";
                    header('location: student_dashboard.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Password is not matching!";
                header('location: student_dashboard.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Password is not matching!";
            header('location: student_dashboard.php');
            exit();
        }
    }
}
?>

<!-- Content Start -->
<section class="py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="display-6">Profile</h2>
                <!-- Breadcrumb -->
                <nav class="dashboard-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php"><i class="bi bi-house-fill text-warning"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Content Start -->
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']) ?>
                    </div>
                <?php endif; ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="display-6 text-success mb-0">Welcome, <?= $_SESSION['user_username'] ?></h3>
                    </div>
                </div>
                <h4 class="mt-5">Change Password</h4>
                <hr>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="current_password"
                                       placeholder="Enter your current password" required name="current_password">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password"
                                       placeholder="Enter your new password" required name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       placeholder="Enter your new password again" required
                                       name="password_confirmation">
                            </div>
                            <div class="d-flex justify-content-start mt-4">
                                <button type="submit" class="btn btn-primary" name="submit_password_update">Update
                                    Password <i class="bi bi-check-all"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </div>
</section>
<!-- Content End -->

<?php include_once '../includes/admin_footer.php' ?>
