<?php $title = 'Registration'; ?>

<?php include 'includes/header.php'; ?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section section-padding text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title display-4">Register</h2>
                <nav>
                    <ol class="breadcrumb
                        justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Register Section Start -->
<section class="login-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="section-title display-6">Join Us! For the best experience....</h2>
                <p class="section-desc">Already have an account? Then please <a href="login.php">Log in</a>....
                </p>
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-light">
                        <form action="auth/registration_process.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter your name" required name="name" value="<?= isset($_GET['current_name']) ? $_GET['current_name'] : '' ?>">
                                <?php if (isset($_GET['name_err'])): ?>
                                    <p class="text-danger"><?php echo $_GET['name_err'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" placeholder="Enter your desired username" required name="username" value="<?= isset($_GET['current_username']) ? $_GET['current_username'] : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" required name="email"  value="<?= isset($_GET['current_email']) ? $_GET['current_email'] : '' ?>">
                                <?php if (isset($_GET['email_err'])): ?>
                                    <p class="text-danger"><?php echo $_GET['email_err'] ?></p>
                                <?php endif; ?>

                                <?php if (isset($_GET['email_err_aa'])): ?>
                                    <p class="text-danger"><?php echo $_GET['email_err_aa'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span
                                                    class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password"
                                               placeholder="Enter your password (min: 6)" required name="password" value="<?= isset($_GET['password']) ? $_GET['password'] : '' ?>">
                                        <?php if (isset($_GET['pass_err'])): ?>
                                            <p class="text-danger"><?php echo $_GET['pass_err'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span
                                                    class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               placeholder="Confirm your password" required name="password_confirmation" value="<?= isset($_GET['password_confirmation']) ? $_GET['password_confirmation'] : '' ?>">
                                        <?php if (isset($_GET['password_err2'])): ?>
                                            <p class="text-danger"><?php echo $_GET['password_err'] ?></p>
                                        <?php endif; ?>
                                        <?php if (isset($_GET['not_match'])): ?>
                                            <p class="text-danger"><?php echo $_GET['not_match'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">What service do you want to take? <span class="text-danger">*</span></label>
                                <select class="form-select" id="user_type" required name="user_type">
                                    <option value="" selected class="text-muted">Select Service</option>
                                    <option value="Teacher">I will teach</option>
                                    <option value="Student">I want a teacher</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary">Register <i class="bi bi-check-all"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Register Section End -->

<?php include 'includes/footer.php'; ?>