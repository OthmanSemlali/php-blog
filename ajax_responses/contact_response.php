<?php require_once('../include/model.php');
 ?>



<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

 
    $error = array();
    $output = array();
    $success = array();

    
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    date_default_timezone_set("Africa/Casablanca");
    $date = date('c');


    if (empty($fullname)) {
        $error['fullname_error'] = "Your name is Required";
    } 
    
    if (empty($email)) {
        $error['email_error'] = "Email Is Required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email_error'] = "Please enter valid email";
    }

    if (empty($message)) {

        $error['message_error'] = 'Write your message';
    } elseif (strlen($message) >1000 ) {
        $error['message_error'] = "Your message is too long";
    }


   


    if (count($error) > 0) {
        $output = array(
            'error' => $error
        );
    } else {

        $res = $messages->add($fullname, $email, $message, $date);

        if ($res) {
            $success['valid'] = 'Text message has been sent successfully.';
        } else {
            exit('Something went wrong. Try later');
        }

        $output = array(
            'success' => $success,
        );
    }

    echo json_encode($output);
}
