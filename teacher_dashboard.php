<?php $title = 'My Dashboard'; ?>

<?php include_once 'includes/header.php'; ?>

<?php require_once 'auth/auth_check.php'; ?>

<?php
// Check if role is Teacher
if ($_SESSION['user_role'] != 'Teacher') {
    header('location: index.php');
}
?>

<?php
// Update Information
if (isset($_POST['submit_information_update'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $short_description = htmlspecialchars($_POST['short_description']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $subjects = $_POST['subjects'];
    $class = $_POST['class'];

    if ($image) {
        move_uploaded_file($image_temp, "uploads/$image");
    } else {
        $image = $_SESSION['user_image'];
    }

    $update_query = "UPDATE users SET name = '$name', email = '$email', mobile = '$mobile', avatar = '$image' WHERE id = " . $_SESSION['user_id'];
    $update = mysqli_query($connection, $update_query);

    $update_teacher_query = "UPDATE teachers SET address = '$address', short_description = '$short_description', description = '$description', image = '$image', class = '$class' WHERE user_id = " . $_SESSION['user_id'];
    $update_teacher = mysqli_query($connection, $update_teacher_query);

    $delete_subjects_query = "DELETE FROM teacher_subjects WHERE teacher_id = " . $_SESSION['teacher_id'];
    $delete_subjects = mysqli_query($connection, $delete_subjects_query);

    foreach ($subjects as $subject) {
        $insert_subject_query = "INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (" . $_SESSION['teacher_id'] . ", $subject)";
        $insert_subject = mysqli_query($connection, $insert_subject_query);
    }

    if (!$update || !$update_teacher || !$delete_subjects || !$insert_subject) {
        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
    } else {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_username'] = $username;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_mobile'] = $mobile;
        $_SESSION['user_image'] = $image;

        $_SESSION['success'] = "Information Updated Successfully!";
        header('location: teacher_dashboard.php');
    }
}

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
                } else {
                    $_SESSION['success'] = "Password Updated Successfully!";
                    header('location: teacher_dashboard.php');
                }
            } else {
                $_SESSION['error'] = "Password is not matching!";
                header('location: teacher_dashboard.php');
            }
        } else {
            $_SESSION['error'] = "Password is not matching!";
            header('location: teacher_dashboard.php');
        }
    }
}

if ($_SESSION['user_role'] == 'Teacher') {
    $query = "SELECT * FROM teachers WHERE user_id = " . $_SESSION['user_id'];
    $result = mysqli_query($connection, $query);
    $teacher = mysqli_fetch_assoc($result);

    $teacher_subjects_query = "SELECT * FROM teacher_subjects WHERE teacher_id = " . $teacher['id'];
    $teacher_subjects_result = mysqli_query($connection, $teacher_subjects_query);
    $teacher_subjects = mysqli_fetch_all($teacher_subjects_result, MYSQLI_ASSOC);

    if (!$result || !$teacher_subjects_result) {
        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
    }
}

// Get Teacher Student Messages With Teacher and Student Sent By Student
$query = "
            SELECT 
                teacher_student_messages.*, 
                student_users.name AS student_name,
                student_users.mobile AS student_mobile,
                student_users.email AS student_email,
                teacher_users.name AS teacher_name
            FROM 
                teacher_student_messages 
            JOIN 
                users AS student_users 
                ON teacher_student_messages.student_id = student_users.id 
            JOIN 
                users AS teacher_users 
                ON teacher_student_messages.teacher_id = teacher_users.id 
            WHERE 
                teacher_student_messages.teacher_id = " . $_SESSION['user_id'] . "
            AND
                teacher_student_messages.sent_by = 'Student'
            ORDER BY 
                teacher_student_messages.date DESC
        ";

$result = mysqli_query($connection, $query);
$messages_by_student = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get Teacher Student Messages With Teacher and Student Sent By Teacher
$query = "
            SELECT 
                teacher_student_messages.*, 
                student_users.name AS student_name,
                student_users.mobile AS student_mobile,
                student_users.email AS student_email,
                teacher_users.email AS teacher_email
            FROM 
                teacher_student_messages 
            JOIN 
                users AS student_users 
                ON teacher_student_messages.student_id = student_users.id 
            JOIN 
                users AS teacher_users 
                ON teacher_student_messages.teacher_id = teacher_users.id 
            WHERE 
                teacher_student_messages.teacher_id = " . $_SESSION['user_id'] . "
            AND
                teacher_student_messages.sent_by = 'Teacher'
            ORDER BY 
                teacher_student_messages.date DESC
        ";
$result = mysqli_query($connection, $query);
$messages_by_teacher = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Send Message
if (isset($_POST['submit_message'])) {
    $message = htmlspecialchars($_POST['message']);
    $student_id = $_POST['student_id'];
    $teacher_id = $_SESSION['user_id'];
    $date = date('Y-m-d');

    $query = "INSERT INTO teacher_student_messages (teacher_id, student_id, message, date, sent_by) VALUES ($teacher_id, $student_id, '$message', '$date', 'Teacher')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Message sent successfully!';
    } else {
        $_SESSION['error'] = 'Failed to send message!';
    }

    header('location: teacher_dashboard.php');
}

// Delete Message
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM teacher_student_messages WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Message deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete message!';
    }

    header('location: teacher_dashboard.php');
}
?>

<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section section-padding text-center breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="breadcrumb-title display-4">My Dashboard</h2>
                <nav>
                    <ol class="breadcrumb
                        justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">My Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Dashboard Section Start -->
<section class="dashboard-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" id="profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="messages">Messages</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12 mt-5" id="profile-tab">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger mb-4" role="alert">
                        <?= $_SESSION['error'] ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success mb-4" role="alert">
                        <?= $_SESSION['success'] ?>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if ($teacher['featured']): ?>
                    <div class="alert alert-success" role="alert">
                        Your profile is featured!
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        Your profile is not featured! Earn more reviews to get featured.
                    </div>
                <?php endif; ?>
                <?php if ($teacher['approved']): ?>
                    <div class="alert alert-success" role="alert">
                        Your profile is approved!
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        Your profile is pending! Update your information to get approved soon.
                    </div>
                <?php endif; ?>
                <hr>
                <h4>Change Information</h4>
                <hr>
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-light">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Enter your name" required
                                       name="name" value="<?= $_SESSION['user_name'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span
                                            class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" id="username"
                                       placeholder="Enter your desired username" required name="username"
                                       value="<?= $_SESSION['user_username'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                       required name="email" value="<?= $_SESSION['user_email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="email"
                                       placeholder="Enter your mobile number" name="mobile"
                                       value="<?= $_SESSION['user_mobile'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter your address"
                                       name="address" value="<?= $teacher['address'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <div class="my-2">
                                    <?php if ($_SESSION['user_image']): ?>
                                        <img src="uploads/<?= $_SESSION['user_image'] ?>" alt="Profile Image"
                                             class="img-thumbnail" style="width: 200px;">
                                    <?php else: ?>
                                        <img src="images/person_placeholder.png" alt="Profile Image"
                                             class="img-thumbnail" style="width: 200px;">
                                    <?php endif; ?>
                                </div>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Short Description</label>
                                <textarea class="form-control" id="bio"
                                          placeholder="Write something about yourself in short (max: 20 words)"
                                          name="short_description"
                                          rows="3"><?= $teacher['short_description'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Description</label>
                                <textarea class="form-control" id="bio" placeholder="Write about yourself in details"
                                          name="description" rows="10"><?= $teacher['description'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="class" placeholder="ex: Class 1-5, 6-8, 9-10, etc."
                                       name="class" value="<?= $teacher['class'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="class" class="form-label">Subjects <span class="text-danger">*</span></label>
                                <select class="form-select" name="subjects[]" id="subjects" multiple required>
                                    <?php
                                    $subjects = $teacher_subjects ? array_column($teacher_subjects, 'subject_id') : [];
                                    $subject_query = "SELECT * FROM subjects";
                                    $subject_result = mysqli_query($connection, $subject_query);
                                    if (!$subject_result) {
                                        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
                                    }
                                    while ($subject = mysqli_fetch_assoc($subject_result)):
                                        ?>
                                        <option value="<?= $subject['id'] ?>"
                                            <?php if (in_array($subject['id'], $subjects)): ?>
                                                selected
                                            <?php endif; ?>>
                                            <?= $subject['subject_name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-start mt-4">
                                <button type="submit" class="btn btn-primary" name="submit_information_update">Update
                                    Information <i class="bi bi-check-all"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <h4 class="mt-5">Change Password</h4>
                <hr>
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-light">
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

            <div class="col-lg-12 mt-5" id="messages-tab" style="display: none;">
                <h4>Messages</h4>
                <hr>
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h6>Sent by you</h6>
                    </div>
                    <div class="card-body bg-light">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($messages_by_teacher) > 0): ?>
                                <?php foreach ($messages_by_teacher as $message): ?>
                                    <tr>
                                        <td class="align-middle"><?= date('d M, Y', strtotime($message['date'])) ?></td>
                                        <td class="align-middle"><?= $message['student_name'] ?></td>
                                        <td class="align-middle"><?= $message['student_mobile'] ? $message['student_mobile'] : 'N/A' ?></td>
                                        <td class="align-middle"><?= $message['student_email'] ?></td>
                                        <td class="align-middle"><?= $message['message'] ?></td>
                                        <td class="text-center align-middle">
                                            <a href="teacher_dashboard.php?delete=<?= $message['id'] ?>" class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No received messages found!</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h6>Received by you</h6>
                    </div>
                    <div class="card-body bg-light">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (count($messages_by_student) > 0): ?>
                                <?php foreach ($messages_by_student as $message): ?>
                                    <tr>
                                        <td class="align-middle"><?= date('d M, Y', strtotime($message['date'])) ?></td>
                                        <td class="align-middle"><?= $message['student_name'] ?></td>
                                        <td class="align-middle"><?= $message['student_mobile'] ? $message['student_mobile'] : 'N/A' ?></td>
                                        <td class="align-middle"><?= $message['student_email'] ?></td>
                                        <td class="align-middle"><?= $message['message'] ?></td>
                                        <td class="text-center align-middle">
                                            <a href="teacher_dashboard.php?delete=<?= $message['id'] ?>" class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#messageModal<?= $message['id'] ?>">
                                                Reply <i class="bi bi-send ms-1"></i>
                                            </button>
                                            <!-- Message Modal Start -->
                                            <div class="modal fade" id="messageModal<?= $message['id'] ?>" tabindex="-1" aria-labelledby="messageModal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg text-start">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Send a Message</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="POST">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="student" class="form-label">To <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control bg-light" id="student" required name="student" value="<?= $message['student_name'] ?>" readonly>
                                                                </div>
                                                                <input type="hidden" name="student_id" value="<?= $message['student_id'] ?>">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Message Modal End -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-danger">No sent messages found!</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Section End -->

<?php include_once 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da !important;
        padding: 5px 10px !important;
    }
</style>

<script>
    $('#subjects').select2({
        placeholder: "Select Subjects",
    });
</script>

<script>
    const profile = document.getElementById('profile');
    const messages = document.getElementById('messages');
    const profileTab = document.getElementById('profile-tab');
    const messagesTab = document.getElementById('messages-tab');
    profile.addEventListener('click', function (e) {
        e.preventDefault();
        profile.classList.add('active');
        messages.classList.remove('active');
        profileTab.style.display = 'block';
        messagesTab.style.display = 'none';
    });
    messages.addEventListener('click', function (e) {
        e.preventDefault();
        messages.classList.add('active');
        profile.classList.remove('active');
        profileTab.style.display = 'none';
        messagesTab.style.display = 'block';
    });
</script>
