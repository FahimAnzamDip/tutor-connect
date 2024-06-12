<?php $title = 'Login'; ?>

<?php include_once 'includes/header.php'; ?>

<?php
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'Admin') {
        header('location: admin/dashboard.php');
    } else {
        header('location: ../index.php');
    }
}
?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section section-padding text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title display-4">Login</h2>
                <nav>
                    <ol class="breadcrumb
                        justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Login Section Start -->
<section class="login-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="section-title display-6">Welcome back!</h2>
                <p class="section-desc">Please login to your account or new here? Then please <a
                            href="registration.php">register</a>....</p>
                <div class="login-img mt-4">
                    <img src="images/login.svg" alt="Login">
                </div>
            </div>
            <div class="col-md-6">
                <?php if (isset($_SESSION['login_required'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['login_required'];
                        unset($_SESSION['login_required']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-light">
                        <form action="admin/auth/login_process.php" method="POST" class="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email / Username <span
                                            class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="login">
                                Login
                                <i class="bi bi-box-arrow-in-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->

<?php include_once 'includes/footer.php'; ?>