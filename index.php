<?php $title = 'Home'; ?>

<?php include_once 'includes/header.php'; ?>

<?php
// Get Featured Teachers
$query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id WHERE (featured = 1 AND approved = 1)";
$result = mysqli_query($connection, $query);
$teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Hero Section Start -->
<section class="hero section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title display-1 mb-4"><?= $settings['hero_title'] ?></h1>
                <p class="hero-text text-justify mb-5"><?= $settings['hero_subtitle'] ?></p>
                <a href="registration.php" class="btn btn-primary btn-lg mb-4">
                    Get Started
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="col-lg-5">
                <img src="uploads/<?= $settings['hero_image'] ?>" alt="Hero Image" class="img-fluid">
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Teachers Section Start -->
<section class="teachers section-padding bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="section-title text-start mb-4 display-4">Featured Teachers</h2>
                <a href="teachers.php" class="btn btn-link btn-lg">
                    View All Teachers
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <?php if (count($teachers) == 0): ?>
                <div class="col-md-12">
                    <div class="alert alert-info">
                        No featured teachers found!
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($teachers as $teacher): ?>
                <!-- teacher card start-->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-4">
                            <div class="teacher-image d-flex justify-content-center mb-4">
                                <?php if ($teacher['image']): ?>
                                    <img style="width: 100px;height: 100px;" src="uploads/<?= $teacher['image'] ?>"
                                         alt="Teacher"
                                         class="img-fluid rounded-circle">
                                <?php else: ?>
                                    <img style="width: 100px;height: 100px;" src="images/person_placeholder.png"
                                         alt="Teacher"
                                         class="img-fluid rounded-circle">
                                <?php endif; ?>
                            </div>
                            <h4 class="teacher-name mb-3 text-center d-flex align-items-center justify-content-center flex-wrap">
                                <span class="me-1"><?= $teacher['name'] ?></span>
                                <?php
                                $teacher_id = $teacher['teacher_id'];
                                $query = "SELECT AVG(rating) AS rating FROM reviews WHERE teacher_id = $teacher_id";
                                $result = mysqli_query($connection, $query);
                                $rating = mysqli_fetch_assoc($result);
                                ?>
                                <span style="font-size: 20px;" class="text-muted">
                                    (<i class="bi bi-star-fill text-warning"></i><span class="ms-1"><?= isset($rating['rating']) ? number_format($rating['rating'], 1) : number_format(0, 1) ?></span>)
                                </span>
                            </h4>
                            <div class="teacher-class mb-3 text-center">
                                <span class="badge bg-info p-2"><?= $teacher['class'] ?></span>
                            </div>
                            <div class="teacher-skills mb-3 text-center">
                                <?php
                                // Get Teacher Subjects
                                $teacher_id = $teacher['teacher_id'];
                                $query = "SELECT subjects.subject_name FROM teacher_subjects JOIN subjects ON teacher_subjects.subject_id = subjects.id WHERE teacher_subjects.teacher_id = $teacher_id";
                                $result = mysqli_query($connection, $query);
                                $subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                ?>
                                <?php foreach ($subjects as $subject): ?>
                                    <span class="badge bg-light text-dark p-2 mb-1"><?= $subject['subject_name'] ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="short-bio mb-4 text-center px-3">
                                <p class="text-muted">
                                    <?= $teacher['short_description'] ?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="teacher_detail.php?id=<?= $teacher['teacher_id'] ?>" class="btn btn-outline-warning">
                                    View Profile
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- teacher card end -->
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Teachers Section End -->

<?php include_once 'includes/footer.php'; ?>
