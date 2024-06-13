<?php $title = 'Teachers'; ?>

<?php include 'includes/header.php'; ?>

<?php
// Get All Teachers
if (isset($_GET['subject'])) {
    $subject_id = $_GET['subject'];
    $query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id JOIN teacher_subjects ON teachers.id = teacher_subjects.teacher_id WHERE teacher_subjects.subject_id = $subject_id AND teachers.approved = 1";
} elseif (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Search subject name
    $query = "SELECT DISTINCT teachers.id AS teacher_id, teachers.*, users.*
            FROM teachers
            JOIN users ON teachers.user_id = users.id
            JOIN teacher_subjects ON teachers.id = teacher_subjects.teacher_id
            JOIN subjects ON teacher_subjects.subject_id = subjects.id
            WHERE subjects.subject_name LIKE '%$search%' OR users.name LIKE '%$search%'
            AND teachers.approved = 1";
} else {
    $query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id
        WHERE teachers.approved = 1";
}
$result = mysqli_query($connection, $query);
$teachers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section section-padding text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title display-4">Our Expert Teachers</h2>
                <nav>
                    <ol class="breadcrumb
                        justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Teachers Section Start -->
<section class="teachers section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <form action="teachers.php" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control py-3 px-4"
                                       placeholder="Search for your desired teachers ...." name="search"
                                        value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                                <button class="btn btn-primary py-3 px-4" type="submit">
                                    <i class="bi bi-search me-1"></i>
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <?php if (count($teachers) == 0): ?>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                No teachers found!
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
                                    <div class="short-bio mb-4 text-center">
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
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Subjects -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="card-title
                                    mb-4 pb-3" style="border-bottom: 1px dashed #ddd;">Subjects</h4>
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <a href="teachers.php">
                                            All Subjects
                                        </a>
                                    </li>
                                    <?php
                                    $query = "SELECT * FROM subjects";
                                    $result = mysqli_query($connection, $query);
                                    $subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    ?>
                                    <?php foreach ($subjects as $subject): ?>
                                        <li class="list-group-item list-group-item-action">
                                            <a href="teachers.php?subject=<?= $subject['id'] ?>">
                                                <?= $subject['subject_name'] ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<!-- Teachers Section End -->

<?php include 'includes/footer.php'; ?>