<?php


require_once('include/config.php');

require_once(APPROOT . '/include/model.php');
require_once(APPROOT . '/include/functions.php');
require_once(APPROOT . '/include/session.php');



if (!isset($_SESSION['idAdminConnected'])) {
    redirect_to('login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link type="text/css" rel="stylesheet" href="./css/style.css">
    <link type="text/css" rel="stylesheet" href="./css/dash-style.css">
    <!-- <link type="text/css" rel="stylesheet" href="./css/style1.css"> -->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title><?php echo SITENAME; ?> | Dashboard</title>


    <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" />
</head>


<nav class="navbar navbar-expand-lg  navbar-light bg-white  sticky-top shadow-sm" id="nav">
    <div class="container">
        <a target="_blank" href="https://bookyreview.space/" class="navbar-brand" style='font-family:comfortaa;'>
            <span style="color: #5A8FF0;">
                BOOKY<span style="color:#435C4F ;">REVIEW</span>
            </span>

        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navBarCollaps01"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navBarCollaps01" style="position: relative;">
            <!-- unordered list -->
            <ul class="navbar-nav">




                <li class="nav-item">
                    <a href="<?php echo URLROOT ?>" class="nav-link">Dashboard</a>

                </li>





            </ul>

            <li class="ml-auto" style="list-style:none; ">

                <a href="<?php echo URLROOT ?>logout.php">Sign out</a>
            </li>




        </div>
    </div>


</nav>


