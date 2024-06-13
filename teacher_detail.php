<?php $title = 'Teacher Details'; ?>

<?php include 'includes/header.php'; ?>

<?php
// Get Teacher Details
$teacher_id = $_GET['id'];
$query = "SELECT teachers.id AS teacher_id, teachers.*, users.* FROM teachers JOIN users ON teachers.user_id = users.id WHERE teachers.id = $teacher_id";
$result = mysqli_query($connection, $query);
$teacher = mysqli_fetch_assoc($result);

// Calcuate Rating
$query = "SELECT AVG(rating) AS rating FROM reviews WHERE teacher_id = $teacher_id";
$result = mysqli_query($connection, $query);
$rating = mysqli_fetch_assoc($result);

// Send Message
if (isset($_POST['submit_message'])) {
    $message = $_POST['message'];
    $student_id = $_SESSION['user_id'];
    $teacher_id = $teacher['id'];
    $date = date('Y-m-d');

    $query = "INSERT INTO teacher_student_messages (student_id, teacher_id, message, date, sent_by) VALUES ($student_id, $teacher_id, '$message', '$date', 'Student')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['message'] = 'Message sent successfully!';
    } else {
        $_SESSION['error'] = 'Failed to send message!';
    }

    header('location: teacher_detail.php?id=' . $teacher['teacher_id']);
    exit();
}

// Review
if (isset($_POST['rating_submit'])) {
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id'];
    $teacher_id = $teacher['teacher_id'];

    // Check if user already rated
    $query = "SELECT * FROM reviews WHERE user_id = $user_id AND teacher_id = $teacher_id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Update Rating
        $query = "UPDATE reviews SET rating = $rating WHERE user_id = $user_id AND teacher_id = $teacher_id";
        $result = mysqli_query($connection, $query);
    } else {
        // Insert Rating
        $query = "INSERT INTO reviews (user_id, teacher_id, rating) VALUES ($user_id, $teacher_id, $rating)";
        $result = mysqli_query($connection, $query);
    }

    if ($result) {
        $_SESSION['message'] = 'You rated this teacher ' . $rating . ' stars!';
    } else {
        $_SESSION['error'] = 'Failed to submit rating!';
    }

    header('location: teacher_detail.php?id=' . $teacher_id);
    exit();
}
?>

    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section section-padding text-center breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="breadcrumb-title display-4">Teacher Details</h2>
                    <nav>
                        <ol class="breadcrumb
                        justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="index.php">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="teachers.php">Teachers</a>
                            </li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Teacher Details Section Start -->
    <section class="teacher-details section-padding">
        <div class="container">
            <?php if (isset($_SESSION['message']) || isset($_SESSION['error'])): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['message'] ?>
                            </div>
                            <?php unset($_SESSION['message']); ?>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['error'] ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row gap-10">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <?php if ($teacher['image']): ?>
                                            <img src="uploads/<?= $teacher['image'] ?>"
                                                 alt="Teacher"
                                                 class="img-fluid rounded-circle">
                                        <?php else: ?>
                                            <img src="images/person_placeholder.png"
                                                 alt="Teacher"
                                                 class="img-fluid rounded-circle">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="ms-4">
                                        <h2 class="teacher-name mb-3 d-flex align-items-center flex-wrap display-4">
                                            <span class="me-1"><?= $teacher['name'] ?></span>
                                            <span style="font-size: 26px;" class="text-muted">
                                            (<i class="bi bi-star-fill text-warning"></i><span class="ms-1"><?= isset($rating['rating']) ? number_format($rating['rating'], 1) : number_format(0, 1) ?></span>)
                                        </span>
                                        </h2>
                                        <div class="teacher-class mb-3">
                                            <span class="badge bg-info p-2"><?= $teacher['class'] ?></span>
                                        </div>
                                        <div class="teacher-skills mb-3">
                                            <?php
                                                // Get Teacher Subjects
                                                $teacher_id = $teacher['teacher_id'];
                                                $query = "SELECT subjects.subject_name FROM teacher_subjects JOIN subjects ON teacher_subjects.subject_id = subjects.id WHERE teacher_subjects.teacher_id = $teacher_id";
                                                $result = mysqli_query($connection, $query);
                                                $subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                            ?>
                                            <?php foreach ($subjects as $subject): ?>
                                                <span class="badge bg-light text-dark p-2"><?= $subject['subject_name'] ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <p>
                                            <?= $teacher['short_description'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-light">
                            <div class="teacher-details">
                                <h3 class="section-title display-6">About</h3>
                                <p class="text-muted mb-4">
                                    <?= htmlspecialchars_decode($teacher['description']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="section-title display-6">Contact</h3>
                            <div class="contact-info mb-4 d-flex align-items-center">
                                <div class="icon" style="font-size: 40px;">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </div>
                                <div class="info ms-2">
                                    <p class="text-muted mb-0">Address</p>
                                    <p class="mb-0"><?= $teacher['address'] ?></p>
                                </div>
                            </div>
                            <div class="contact-info mb-4 d-flex align-items-center">
                                <div class="icon" style="font-size: 40px;">
                                    <i class="bi bi-phone text-primary"></i>
                                </div>
                                <div class="info ms-2">
                                    <p class="text-muted mb-0">Mobile</p>
                                    <p class="mb-0"><?= $teacher['mobile'] ?></p>
                                </div>
                            </div>
                            <div class="contact-info mb-4 d-flex align-items-center">
                                <div class="icon" style="font-size: 40px;">
                                    <i class="bi bi-send text-primary"></i>
                                </div>
                                <div class="info ms-2">
                                    <p class="text-muted mb-0">Email</p>
                                    <p class="mb-0"><?= $teacher['email'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#messageModal"
                                class="btn btn-primary btn-lg d-flex align-items-center justify-content-center">
                            <span>Message</span>
                            <i class="bi bi-envelope-paper ms-2"></i>
                        </button>
                    </div>
                    <!-- Review -->
                    <?php if (isset($_SESSION['user_role'])): ?>
                        <?php if ($_SESSION['user_role'] == 'Student'): ?>
                        <div class="mt-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h3 class="section-title display-6 mb-3">Review</h3>
                                    <form action="" class="row row-cols-lg-auto g-3 align-items-center" method="POST">
                                        <div class="col-12">
                                            <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-star-fill text-warning"></i></div>
                                                <label class="visually-hidden" for="rating">Rating</label>
                                                <?php
                                                    $user_id = $_SESSION['user_id'];
                                                    $query = "SELECT * FROM reviews WHERE user_id = $user_id AND teacher_id = $teacher_id";
                                                    $result = mysqli_query($connection, $query);
                                                    $review = mysqli_fetch_assoc($result);
                                                ?>
                                                <select class="form-select" id="rating" required name="rating">
                                                    <option selected class="text-muted" value="">Choose Rating</option>
                                                    <option <?= isset($review['rating']) ? $review['rating']  == 1 ? 'selected' : '' : '' ?> value="1">One</option>
                                                    <option <?= isset($review['rating']) ? $review['rating']  == 2 ? 'selected' : '' : '' ?> value="2">Two</option>
                                                    <option <?= isset($review['rating']) ? $review['rating']  == 3 ? 'selected' : '' : '' ?> value="3">Three</option>
                                                    <option <?= isset($review['rating']) ? $review['rating']  == 4 ? 'selected' : '' : '' ?> value="4">Four</option>
                                                    <option <?= isset($review['rating']) ? $review['rating']  == 5 ? 'selected' : '' : '' ?> value="5">Five</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary" name="rating_submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Teacher Details Section End -->

    <!-- Message Modal Start -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Send a Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'Student'): ?>
                    <form action="" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user_type" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id=L"message" required name="message" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit_message">Save changes</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            You need to login as a student to send a message.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Message Modal End -->
<?php include 'includes/footer.php'; ?>