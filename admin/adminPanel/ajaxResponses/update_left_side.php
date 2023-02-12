<?php
require_once('../../include/model.php');




if ($_SERVER['REQUEST_METHOD'] == 'POST') :



    if (isset($_POST['action'])) :

        // Show image in output
        if ($_POST['action'] == 'file') :
            if ($_FILES['file']['name'] != '') {

                $name = $_FILES['file']['name'];


     $path = "../../admin/files/"; // relative path to the directory where you want to move the image
$serverpath = $path . $image;
                // Target file
                // $location = '../files\\' . $name;

                $tmp_name = $_FILES['file']['tmp_name'];

                move_uploaded_file($_FILES['file']['tmp_name'], $location);

                echo "<img id='uploaded' data-id='" . $tmp_name . "' rel='" . $name . "' src='../../admin/files/" . $name  . "'  class='d-block img-fluid mb-3'/>";
                exit;
            }
        endif;



        // Show text in output
        if ($_POST['action'] == 'text') :

            echo nl2br($_POST['myText']);
            exit;

        endif;




        // Submit change
        if ($_POST['action'] == 'submit') :


            $data = explode('.', @$_FILES['file']['name']);
            $extension = end($data);

            $name = uniqid('IMG-', true) . '.' . $extension;

            $myText = $_POST['myText'];
            $tmp_name = @$_FILES['file']['tmp_name'];


            // Target file
            $location = '../admin' . "\\images\\" . $name;


            $res = $side_left->add($name, $myText);

            if ($res) {
                move_uploaded_file($tmp_name, $location);

                echo 'Side Area Changed Successfully';
            } else {
                echo 'Something went wrong. Try later!';
                
            }



        endif;


    endif;



endif;
