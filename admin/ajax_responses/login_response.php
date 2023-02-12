<?php
require_once('../include/model.php');

session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') :

    // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    $error = array();
    $output = array();

    $user = trim($_POST['username']);
    $pass = $_POST['password'];


    // if (!$admin->checkUsernameExisting($user)) {
    // }


    $res = $admin->checkUsername($user);

    if ($res) {


        $r = $res->fetch();

        if (!password_verify($pass, $r['password'])) {
            $error['pass'] = 'Wrong password. Please try again';

            $output = array(
                'error' => $error
            );

            echo json_encode($output);

            exit;
        } else {

            if ($r['status'] == 'On') {


                $_SESSION['idAdminConnected'] = @$r['id'];
                $_SESSION['usernameAdminConnected'] = @$r['username'];
                $_SESSION['nameAdminConnected'] = @$_POST['adminName'];

                $output = array(
                    'success_link' => 'logoded In',

                );
            }
            if ($r['status'] == 'Off') {
                $output = array(
                    'success' => 'Your account is still under review'
                );
            }

            echo json_encode($output);

            exit;
        }
    } else {
        $error['user'] = 'Username does not exist';

        $output = array(
            'error' => $error
        );

        echo json_encode($output);

        exit;
    }


endif;
