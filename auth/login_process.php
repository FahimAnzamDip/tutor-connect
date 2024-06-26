<?php
session_start();
require_once '../database/db.php';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    $login_query = "SELECT * FROM users WHERE (email = '$email' OR username = '$email') AND password = '$hashed_password'";
    $login = mysqli_query($connection, $login_query);

    if (!$login) {
        die("QUERY FAILED:" . "</br>" . mysqli_error($connection));
    } else {
        if ($login->num_rows == 1) {
            $user = mysqli_fetch_assoc($login);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_password'] = $user['password'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_mobile'] = $user['mobile'];
            $_SESSION['user_image'] = $user['avatar'];
            $_SESSION['user_role'] = $user['role'];

            if ($_SESSION['user_role'] == 'Admin') {
                header('location: ../admin/dashboard.php');
            } elseif ($_SESSION['user_role'] == 'Student') {
                header('location: ../student_dashboard.php');
            } elseif ($_SESSION['user_role'] == 'Teacher') {
                $query = "SELECT * FROM teachers WHERE user_id = " . $_SESSION['user_id'];
                $result = mysqli_query($connection, $query);
                $teacher = mysqli_fetch_assoc($result);

                $_SESSION['teacher_id'] = $teacher['id'];
                $_SESSION['user_image'] = $teacher['image'];

                header('location: ../teacher_dashboard.php');
            } else {
                header('location: ../index.php');
            }
        } else {
            $_SESSION['login_required'] = "Invalid email/username or password";
            header('location: ../login.php');
        }
    }
}