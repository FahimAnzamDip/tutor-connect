<?php
session_start();
require_once '../database/db.php';

//Password Conditions check
$upper_case = preg_match('@[A-Z]@', $_POST['password']);
$lower_case = preg_match('@[a-z]@', $_POST['password']);
$number = preg_match('@[0-9]@', $_POST['password']);
$special_char = preg_match('@[#, $, %]@', $_POST['password']);

//Name error check
if (empty($_POST['name'])) {
    $name_err = "Please provide your name!";
    header('location: ../registration.php?name_err=' . $name_err);
}

//Email error check
else if (empty($_POST['email'])) {
    $email_err = "Please provide your email!";
    $current_name = $_POST['name'];
    $current_username = $_POST['username'];
    header('location: ../registration.php?email_err=' . $email_err . '&current_name=' . $current_name . '&current_username=' . $current_username);
}

//Password error check
else if (empty($_POST['password'])) {
    $password_err = "Please provide your password!";
    $current_name = $_POST['name'];
    $current_username = $_POST['username'];
    $current_email = $_POST['email'];
    header('location: ../registration.php?password_err=' . $password_err . '&current_name=' . $current_name . '&current_username=' . $current_username . '&current_email=' . $current_email);
}
//Password error check
else if (!$upper_case || !$lower_case || !$number || !$special_char) {
    $pass_err = "Need a password with an uppercase, a lowercase, numbers, a special character!";
    $current_name = $_POST['name'];
    $current_username = $_POST['username'];
    $current_email = $_POST['email'];
    $password = $_POST['password'];
    header('location: ../registration.php?pass_err=' . $pass_err . '&current_name=' . $current_name . '&current_username=' . $current_username . '&current_email=' . $current_email . '&password=' . $password);
}
//Password error check
else if (empty($_POST['password_confirmation'])) {
    $password_err2 = "Please provide your password again!";
    $current_name = $_POST['name'];
    $current_username = $_POST['username'];
    $current_email = $_POST['email'];
    $password = $_POST['password'];
    header('location: ../registration.php?password_err2=' . $password_err2 . '&current_name=' . $current_name . '&current_username=' . $current_username . '&current_email=' . $current_email . '&password=' . $password);
}
//Macthing confirm password
else if ($_POST['password'] != $_POST['password_confirmation']) {
    $not_match = "Password is not matching! Enter again.";
    $current_name = $_POST['name'];
    $current_username = $_POST['username'];
    $current_email = $_POST['email'];
    $password = $_POST['password'];
    header('location: ../registration.php?not_match=' . $not_match . '&current_name=' . $current_name . '&current_username=' . $current_username . '&current_email=' . $current_email . '&password=' . $password);
}

//After validaton successfull
else {
    $name = $_POST['name'];
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $final_password = md5($user_password);

    //Insert Data into Database
    $insert_query = "INSERT INTO users (name, username, email, password, role) VALUES ('$name', '$user_name', '$user_email', '$final_password', '$user_type')";

    //Email / Username availability check in Database
    $email_error_check = "SELECT * FROM users WHERE email = '$user_email'";
    $email_err_ch_query = mysqli_query($connection, $email_error_check);
    $username_error_check = "SELECT * FROM users WHERE username = '$user_name'";
    $username_err_ch_query = mysqli_query($connection, $username_error_check);

    if ($email_err_ch_query->num_rows == 1 || $username_err_ch_query->num_rows == 1) {
        $email_err_aa = "This email / username is already used! Try another one.";
        $current_name = $_POST['name'];
        $current_username = $_POST['username'];
        $current_email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['password_confirmation'];

        header('location: ../registration.php?email_err_aa=' . $email_err_aa . '&current_name=' . $current_name . '&current_username=' . $current_username . '&current_email=' . $current_email . '&password=' . $password . '&confirm_password=' . $confirm_password);
    } else {
        //Insert Data into Database
        $insert_to_db = mysqli_query($connection, $insert_query);

        //Create a teacher if user_type is Teacher with created user_id
        if ($user_type == 'Teacher') {
            $teacher_query = "INSERT INTO teachers (user_id) VALUES (" . mysqli_insert_id($connection) . ")";
            $insert_teacher = mysqli_query($connection, $teacher_query);
        }

        if (!$insert_to_db) {
            die("Query Failed:" . "</br>" . mysqli_error($connection));
        } else {
            $_SESSION['login_required'] = "Registration Successful! Please Login.";
            header('location: ../login.php');
        }
    }
}