<?php require_once('../include/model.php'); ?>



<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    $error = array();
    $output = array();
    $success = array();

    $addedBy = "SELF";
    $fullname = trim($_POST['fullname']);

    date_default_timezone_set("Africa/Casablanca");
    $date = date("d M Y H:i:s");


    // admin change these informations in his profile
    $headLine = 'X';
    $adminBio = 'X';
    $adminImage = "X";

    // Admin pending
    $status = 'Off';

    $username = trim($_POST['username']);

    if (empty($username)) {
        $error['username_error'] = "Username Is Required";
    } elseif ($admin->checkUsernameExisting($username)) {
        $error['username_error'] = 'Username Alaready exist, Try another One!';
    } elseif (!preg_match("/^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/", $username)) {
        $error['username_error'] = "Username not match";
    }

    $email = $_POST['email'];
    if (empty($email)) {
        $error['email_error'] = "Email Is Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email_error'] = "Please enter valid email";
    }



    $pass1 = $_POST['pass1'];
    if (empty($pass1)) {

        $error['pass1_error'] = 'Password Is Required';
    } elseif (strlen($pass1) < 8) {
        $error['pass1_error'] = "Password should be greater than 8 characters";
    }


    $pass2 = $_POST['pass2'];
    if (empty($pass2)) {
        $error['pass2_error'] = 'Password Is Required';
    } elseif ($pass1 != $pass2) {
        $error['pass2_error'] = 'Confirm your password!';
    } else {
        $password = password_hash($pass1, PASSWORD_BCRYPT);
        
    }


    if (count($error) > 0) {
        $output = array(
            'error' => $error
        );
    } else {

        $res = $admin->createAccount($date, $username, $password, $fullname, $addedBy, $headLine, $adminBio, $adminImage, $status, $email);

        if ($res) {
            $success['valid'] = 'Action has been confimred, and is now waiting for administrator approval. As soon as your request is approved you will receive a confirmation email. THANK YOU :)';
        } else {
            exit('Something went wrong. Try later');
        }

        $output = array(
            'success' => $success,
        );
    }

    echo json_encode($output);
}
