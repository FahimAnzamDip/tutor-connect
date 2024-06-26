<?php $title = 'About Us'; ?>

<?php include 'includes/header.php'; ?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section section-padding text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title display-4">About Us</h2>
                <nav>
                    <ol class="breadcrumb
                        justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- About Seciton Start -->
<section class="about-us section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="uploads/<?= $settings['about_image'] ?>" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="section-title pb-3 mb-3" style="border-bottom: 1px dashed #ddd;"><?= $settings['about_title'] ?></h2>

                <p class="section-text"><?= htmlspecialchars_decode($settings['about_content']) ?></p>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Stats Section Start -->
<section class="stats section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="stats-box text-center">
                    <img width="70px" class="mb-3" src="images/student.png" alt="Students Icon">
                    <h2 class="stats-number display-5 fw-medium">1000+</h2>
                    <p class="stats-text text-warning lead">Students</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box text-center">
                    <img width="70px" class="mb-3" src="images/teacher.png" alt="Teachers Icon">
                    <h2 class="stats-number display-5 fw-medium">200+</h2>
                    <p class="stats-text text-warning lead">Tutors</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box text-center">
                    <img width="70px" class="mb-3" src="images/book.png" alt="Subjects Icon">
                    <h2 class="stats-number display-5 fw-medium">50+</h2>
                    <p class="stats-text text-warning lead">Subjects</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-box text-center">
                    <img width="70px" class="mb-3" src="images/trophy.png" alt="Success Rate Icon">
                    <h2 class="stats-number display-5 fw-medium">95%</h2>
                    <p class="stats-text text-warning lead">Success Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Stats Section End -->

<?php include 'includes/footer.php'; ?>