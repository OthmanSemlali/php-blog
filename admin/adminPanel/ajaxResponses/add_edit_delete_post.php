<?php
require_once('../../include/model.php');
require_once('../../include/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') :




    if ($_POST['action'] == 'add' || $_POST['action'] == 'edit') {


        // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        $error = [];
        $output = [];

        $idAdmin = $_POST['idAdmin'];
        $author = $_POST['nameAdmin'];
        $category = $_POST['category'];


        date_default_timezone_set("Africa/Casablanca");
        $dateTime = date('c');

        $excerpt = $_POST['excerpt'];
        $contents = $_POST['contents'];

        $seo_description = trim($_POST['seo_description']);


        // geetting image data and store them in variables
        // $image = @$_FILES['file']['name'];
        // $img_size = $_FILES['file']['size'];
        // $tmp_name = $_FILES['file']['name'];
        // $error    = $_FILES['file']['error'];


        if (isset($_FILES['file']['name'])) {


            // Validation File
            if ($_FILES['file']['error'] == 0) {


                if ($_FILES['file']['size'] > 1000000) {
                    $error['image_error'] = 'Sorry, your file is too large.';

                    $output = array(
                        'error'    =>   $error
                    );

                    echo json_encode($output);
                    exit;
                } else {

                    // Get image extention store it in var
                    $img_ex = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

                    // Converting the images Extentions into lower case and store it in var
                    $img_ex_lc = strtolower($img_ex);

                    // Creating array that stores allowed ext
                    $allowed_ext = array('jpg', 'jpeg', 'png');

                    // Check if the image extention is present in $allowed ext array
                    if (in_array($img_ex_lc, $allowed_ext)) {

                        // renaiming the image name with random string
                        $image = uniqid("add-", true) . '.' . $img_ex_lc;


                        $imagick = new \Imagick();
                        $imagick->readImage($_FILES['file']['tmp_name']);
                        $imagick->setImageCompressionQuality(70); // Quality between 0 and 100
                        $imagick->writeImage($image);
                        $imagick->destroy();
                    } else {
                        $error['image_error'] = "You can't upload files of this type";

                        $output = array(
                            'error'    =>   $error
                        );

                        echo json_encode($output);
                        exit;
                    }
                }
            } else {
                // error message
                $error['image_error'] = "unknown error occurred!";

                $output = array(
                    'error'    =>   $error
                );

                echo json_encode($output);
                exit;
            }
        }



        // Target file
        // $approot = dirname(__DIR__);
        // $serverpath = $approot . "upload\\" . @$image;


        $title = trim($_POST['title']);
        if (empty($title)) {
            $error['title_error'] = 'Title Is Required';
        }



        $bookAuthor = trim($_POST['bookAuthor']);

        if (empty($bookAuthor)) {
            $error['author_error'] = 'Author Name Is Required';
        }

        $description = trim($_POST['description']);

        if (empty($description)) {
            $error['description_error'] = 'Description Is Required';
        }

        if (empty($seo_description)) {
            $error['seo_description_error'] = 'seo Description Is Required';
        }


        if (count($error) > 0) {
            $output = array(
                'error'    =>   $error
            );
            // echo print_r($output);
            // exit;
            echo json_encode($output);
            exit;
        } else {

            if ($_POST['action'] == 'add') {
                $subcategory = $_POST['subcategory'];


                $res = $posts->addPost($dateTime, $title, $category, $image, $description, $author, $idAdmin, $bookAuthor, $excerpt, $contents, $seo_description, $subcategory);

                if ($res) {

                    // $serverpath = '../../upload\\' . $image;
                    // $serverpath = APPROOT . '/upload' . $image;

                    $path = "../../upload/"; // relative path to the directory where you want to move the image
                    $serverpath = $path . $image;

                    $success['added'] = 'Post Added successfully';
                    move_uploaded_file($_FILES['file']['tmp_name'], $serverpath);

                    $output = array(
                        'success' => $success
                    );
                    echo json_encode($output);
                } else {
                    die('Something went wrong. Try later!');
                }

                exit;
            }

            if ($_POST['action'] == 'edit') {

                $id = $_POST['idPost'];

                if (isset($image)) {

                    $result = $posts->edit($title, $category, $image, $description, $author, $idAdmin, $bookAuthor, $excerpt, $contents, $seo_description, $id);
                } else {

                    $result = $posts->edit($title, $category, $image = null, $description, $author, $idAdmin, $bookAuthor, $excerpt, $contents, $seo_description, $id);
                }


                if ($result) {

                    // Target file
                    // $approot = dirname(dirname(__DIR__));
                    // $serverpath = APPROOT . "upload/" . @$image;

                    $path = "../../upload/"; // relative path to the directory where you want to move the image
                    $serverpath = $path . $image;

                    // $serverpath = '/upload/' . $image;
                    // $serverpath = APPROOT.'/upload\\';
                    $success['added'] = 'Post Updated successfully';
                    move_uploaded_file(@$_FILES['file']['tmp_name'], $serverpath);


                    $output = array(
                        'success' => $success
                    );

                    echo json_encode($output);
                } else {
                    die('Something went wrong. Try later!');
                }

                exit;
            }
        }


        // Send data into JSON Format
        //echo json_encode($output);
    }


    // get old data for Updating
    if ($_POST['action'] == 'fetch_single') {
        $data = array();

        // id Post
        $id = $_POST['id'];

        $res = $posts->read($id);

        $r = $res->fetch();

        // all data into array    
        $data['title'] = $r['title'];
        $data['category'] = $r['category'];
        $data['description'] = $r['description'];
        $data['image'] = $r['image'];
        $data['author'] = $r['bookAuthor'];
        $data['excerpt'] = $r['excerpt'];
        $data['contents'] = $r['contents'];
        $data['seo_description'] = $r['seo_description'];


        // send Data as an Object
        echo json_encode($data);
    }



    // Now for deleting
    if ($_POST['action'] == 'delete') {
        $id  = $_POST['id'];

        $res = $posts->delete($id);
        if ($res) {
            $output = array(
                'success' => 'Data Deleted'
            );
        }
        echo json_encode($output);
    }


endif;
