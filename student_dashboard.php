<?php $title = 'My Dashboard'; ?>

<?php include_once 'includes/header.php'; ?>

<?php require_once 'auth/auth_check.php'; ?>

<?php
// Check if role is Student
if ($_SESSION['user_role'] != 'Student') {
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

    $update_query = "UPDATE users SET name = '$name', username = '$username', email = '$email', mobile = '$mobile' WHERE id = " . $_SESSION['user_id'];
    $update = mysqli_query($connection, $update_query);

    if (!$update) {
        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
    } else {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_username'] = $username;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_mobile'] = $mobile;

        $_SESSION['success'] = "Information Updated Successfully!";
        header('location: student_dashboard.php');
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
                    header('location: student_dashboard.php');
                }
            } else {
                $_SESSION['error'] = "Password is not matching!";
                header('location: student_dashboard.php');
            }
        } else {
            $_SESSION['error'] = "Password is not matching!";
            header('location: student_dashboard.php');
        }
    }
}

// Get Teacher Student Messages With Teacher and Student Sent By Student
$query = "
            SELECT 
                teacher_student_messages.*, 
                student_users.name AS student_name, 
                teacher_users.name AS teacher_name,
                teacher_users.mobile AS teacher_mobile,
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
                teacher_student_messages.student_id = " . $_SESSION['user_id'] . "
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
                teacher_users.name AS teacher_name,
                teacher_users.mobile AS teacher_mobile,
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
                teacher_student_messages.student_id = " . $_SESSION['user_id'] . "
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
    $student_id = $_SESSION['user_id'];
    $teacher_id = $_POST['teacher_id'];
    $date = date('Y-m-d');

    $query = "INSERT INTO teacher_student_messages (teacher_id, student_id, message, date, sent_by) VALUES ($teacher_id, $student_id, '$message', '$date', 'Student')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $_SESSION['success'] = 'Message sent successfully!';
    } else {
        $_SESSION['error'] = 'Failed to send message!';
    }

    header('location: student_dashboard.php');
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

    header('location: student_dashboard.php');
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
                    <h4>Change Information</h4>
                    <hr>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body bg-light">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name" required name="name" value="<?= $_SESSION['user_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control bg-light" id="username" placeholder="Enter your desired username" required name="username" value="<?=  $_SESSION['user_username'] ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required name="email"  value="<?= $_SESSION['user_email'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="email" placeholder="Enter your mobile number" name="mobile"  value="<?= $_SESSION['user_mobile'] ?>">
                                </div>
                                <div class="d-flex justify-content-start mt-4">
                                    <button type="submit" class="btn btn-primary" name="submit_information_update">Update Information <i class="bi bi-check-all"></i>
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
                                    <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="current_password" placeholder="Enter your current password" required name="current_password">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter your new password" required name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="Enter your new password again" required name="password_confirmation">
                                </div>
                                <div class="d-flex justify-content-start mt-4">
                                    <button type="submit" class="btn btn-primary" name="submit_password_update">Update Password <i class="bi bi-check-all"></i>
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
                                    <th>Teacher</th>
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
                                        <td class="align-middle"><?= $message['teacher_name'] ?></td>
                                        <td class="align-middle"><?= $message['teacher_mobile'] ? $message['teacher_mobile'] : 'N/A' ?></td>
                                        <td class="align-middle"><?= $message['teacher_email'] ?></td>
                                        <td class="align-middle"><?= $message['message'] ?></td>
                                        <td class="text-center align-middle">
                                            <a href="student_dashboard.php?delete=<?= $message['id'] ?>" class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
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
                                    <th>Teacher</th>
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
                                            <td><?= date('d M, Y', strtotime($message['date'])) ?></td>
                                            <td><?= $message['teacher_name'] ?></td>
                                            <td><?= $message['teacher_mobile'] ? $message['teacher_mobile'] : 'N/A' ?></td>
                                            <td><?= $message['teacher_email'] ?></td>
                                            <td><?= $message['message'] ?></td>
                                            <td class="text-center align-middle">
                                                <a href="student_dashboard.php?delete=<?= $message['id'] ?>" class="btn btn-danger btn-sm"
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
                                                                        <label for="teacher" class="form-label">To <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control bg-light" id="teacher" required name="teacher" value="<?= $message['teacher_name'] ?>" readonly>
                                                                    </div>
                                                                    <input type="hidden" name="teacher_id" value="<?= $message['teacher_id'] ?>">
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
                                        <td colspan="6" class="text-center text-danger">No received messages found!</td>
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
