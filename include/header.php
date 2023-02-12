<?php

require_once('include/config.php');
require_once('include/model.php');
require_once('include/functions.php');
require_once('include/session.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITENAME; ?> | Find your next great read</title>

    <meta name="description" content="Our website provides in-depth book reviews and excerpts to help you decide which titles are worth your time and money. We also offer detailed table of contents for each book so you can get a better understanding of the structure and content of the book before you dive in. Our goal is to make your reading experience as enjoyable and informed as possible. Whether you're looking for a new book to add to your to-read list or just want to browse through some reviews, we've got you covered." />

    <meta property="og:title" content="<?php echo SITENAME; ?> | Find the Best Book Reviews on Our Website" />
    <meta property="og:description" content="Our website provides in-depth book reviews and excerpts to help you decide which titles are worth your time and money. We also offer detailed table of contents for each book so you can get a better understanding of the structure and content of the book before you dive in. Our goal is to make your reading experience as enjoyable and informed as possible. Whether you're looking for a new book to add to your to-read list or just want to browse through some reviews, we've got you covered." />

    <meta property="og:url" content="<?php echo URLROOT; ?>" />
    <meta property="og:site_name" content="<?php echo SITENAME; ?>" />

    <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" />


    <style>
        /************************************* Global classes *************************************/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f0faff;
        }

        a {
            color: gray;
            text-decoration: none;
        }

        .booky {
            color: #5a8ff0;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;

        }

        .review {
            color: #435c4f;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;


        }

        .about-us {
            border-radius: 5px;
            background-color: white;
            padding: 10px;
            font-family: Trebuchet MS;
            line-height: 1.8em;
            opacity: 0.8;
        }


        .container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: minmax(200px, auto);

            margin-left: 5%;
            margin-right: 5%;
            margin-top: 80px;

            /* grid-gap: 15px ; */
            grid-gap: 15px 25px;

            /* background-color: bisque; */
        }

        .left {

            /* background-color: red; */
            height: auto;

            display: grid;

            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr 50px;

            border-radius: 10px;

            row-gap: 15px;

            transition: all 0.2s linear;
        }

        .rightt {

            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        @media screen and (max-width: 950px) {
            .container {
                grid-template-columns: 1fr;
                grid-template-rows: minmax(200px, auto);

            }


        }

        /************************************ contact page style *************************************/
        .contactus {

            padding: 45px;
        }

        .contactus .form-group {
            margin-bottom: 20px;
        }

        .contactus .form-group label {
            display: block;
        }

        .contactus .form-group label span {
            color: brown;
        }

        .contactus .form-group .form-control,
        .contactus .form-group textarea {
            width: 100%;

            padding: 5px 10px;

        }

        .contactus .form-group input {
            height: 2rem;
        }

        .contactus .form-group input,
        .contactus .form-group textarea {
            border-radius: 5px;
            border: 1px solid #3e8da8;

        }

        .contactus .button {
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .contactus .err {
            display: block;
            color: brown;
        }
    </style>
</head>