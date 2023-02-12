<?php require_once('../include/model.php');  ?>


<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_EMAIL);

    $email = $_POST['email'];




    $output = [];
    $error = [];
    // $success = [];

    if ($email == '') {
        $error =  'Email required.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter valid email.';
    }

    if ($error) {


        $output = array(
            'error' => $error
        );
        echo json_encode($output);
        exit;
    } else {



        $res = $mails->add($email);

        if ($res) {
            $success['added'] = 'Success, You\'re now subscribed!';

            // echo 'Success, You\'re now subscribed!';
        } else {
            // echo "Something went wrong, try later!";
            $success['error'] = "Something went wrong, try later!";
            
        }
        $output = array(
            'success' => $success
        );

        echo json_encode($output);
        exit;
    }
}

?>