<?php require_once('../include/model.php');  ?>

<?php

date_default_timezone_set("Africa/Casablanca");



if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $_SESSION['SuccessMessage'] = 'Comment Submited Successfully';

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    $date = date("d M Y");
    $name = trim($_POST['nameUser']);
    //$emailUser = trim($_POST['emailUser']);
    $comment = trim($_POST['comment']);
    $idPost = $_POST['id'];



    $output = [];
    $error = [];


    /*if (!filter_var($emailUser, FILTER_VALIDATE_EMAIL)) {
        $error['email_error'] = 'Email not valid';
    }*/

    if (strlen($comment) > 500) {
        $error['comment_error'] = 'Comment lenght should be less than 500 characters';
    }




    if (count($error) > 0) {
        $output = array(
            'error' => $error
        );
    } else {

        $res = $com->addComment($date, $name, $comment, $idPost);

        if ($res) {

            $output = array(
                'success' => 'Comment Submited Successfully'
            );
        }
    }

    echo json_encode($output);

endif;
