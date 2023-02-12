<!DOCTYPE html>
<html lang="en">

<?php
require_once('include/config.php');
require_once(APPROOT . '/include/model.php');
require_once(APPROOT . '/include/functions.php');
require_once(APPROOT . '/include/session.php');



//* In case users use the search bar from the fullPost page we have to redirect them to index.php with the desired search query
if (isset($_GET['search'])) {

    // redirect_to(URLROOT . '?search=' . $_GET['search']);
    echo "<script>window.top.location='" . URLROOT . "?search=" . $_GET['search'] . "'</script>";
    exit;
}


// Post id
$p = @$_GET['id'];


// Some validation for the URL..
if (!isset($p)) {

    $_SESSION['ErrorMessage'] = " Bad Request";

    // redirect_to('blog.php?page=1');
    echo "<script>window.top.location='" . URLROOT . "'</script>";
    exit;
}

if (isset($p)) {
    if ($p == null || $p == 0  || preg_match('/[A-z]/', $p)) {

        $_SESSION['ErrorMessage'] = 'Bad Request';

        echo "<script>window.top.location='" . URLROOT . "'</script>";

        exit;

    } elseif (!$res = $posts->isThere($p)) {
        //* isThere method return True if the post doesn't exitn in the Database

        $_SESSION['ErrorMessage'] = " The post you were looking for doesn't exist.";
        echo "<script>window.top.location='" . URLROOT . "'</script>";
        exit;
    }
}



// Read post Informations
$res = $posts->read($p);
$r = $res->fetch();


$id = $r['id'];
$d = strtotime($r['dateTime']);

// Format date
if (date('Y', $d) == date('Y')) {
    $dateTime = date('d M', $d);
} else {
    $dateTime = date('d M Y', $d);
}


$title = $r['title'];
$category = $r['category'];
$admin = $r['author'];
$image = $r['image'];
$description = $r['description'];

$excerpt = $r['excerpt'];
$contents = $r['contents'];
$seo_description = $r['seo_description'];

$author = $r['bookAuthor'];



?>



<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title . " by " . $author;; ?></title>

    <meta name="description" content='<?php echo $seo_description; ?>' />
    <meta property="og:title" content='<?php echo SITENAME; ?> | <?php echo $title . " by " . $author; ?>' />
    <meta property="og:description" content='<?php echo $seo_description; ?>' />

    <!-- <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" /> -->

    <meta property="og:url" content="<?php echo URLROOT . 'fullPost.php?id=' . $id . '&title=' . myUrlEncode(strip_tags_content($title)); ?>" />
    <meta property="og:image" content="admin/upload/<?php echo $image; ?>" />
    <meta property="og:site_name" content="<?php echo SITENAME; ?>" />

    <style>
        /************************************* FullPost page Style *************************************/
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

            -webkit-transition: 0.3s all ease;
            -o-transition: 0.3s all ease;
            transition: 0.3s all ease;
        }

        a:hover,
        a:focus {
            text-decoration: none !important;
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        ol,
        ul {
            margin-left: 15px;
        }

        .badge {
            background-color: #f5f5f5;
            padding: 3px 5px;
            border-radius: 8px;
            font-size: 13px;

        }

        .note {
            background-color: #f5f5f5;
            border-left: solid 4px #3498db;
            line-height: 18px;
            /* mc-auto-number-format: "{b}Note: {/b}"; */
            overflow: hidden;
            padding: 12px;

            border-radius: 10px;
            /* transition:cubic-bezier(0.075, 0.82, 0.165, 1); */
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

        .blur {
            filter: blur(5px);
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


        .info-msg,
        .success-msg,
        .warning-msg,
        .error-msg {
            margin: 10px 0;
            padding: 10px;
            border-radius: 3px 3px 3px 3px;
        }

        .info-msg {
            color: #059;
            background-color: #bef;
        }

        .success-msg {
            color: #270;
            background-color: #dff2bf;
        }

        .warning-msg {
            color: #9f6000;
            background-color: #feefb3;
        }

        .error-msg {
            color: #d8000c;
            background-color: #ffbaba;
        }

        .single-post-left {

            height: auto;

            display: grid;

            grid-template-columns: 1fr;
            grid-template-rows: auto;

            transition: all 0.2s linear;
        }

        .single-post-head {
            height: 510px;
            display: grid;

            border-top-right-radius: 10px;
            border-top-left-radius: 10px;

            grid-template-rows: 360px 50px 50px 50px;

            background-color: white;

            transition: all 0.2s linear;
        }

        .single-post-body {
            background-color: white;
            padding-top: 20px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            transition: all 0.2s linear;
        }

        .single-post-image {
            /* height: 360px */
            border-bottom-right-radius: 10px;
            transition: all 0.2s linear;
        }

        .single-post-image img {
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;

            transition: all 0.2s linear;
        }

        .single-post-title {

            display: flex;
            align-items: center;
            padding-left: 10px;
            transition: all 0.2s linear;
        }

        .single-post-title h3 {
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
                "Lucida Sans", Arial, sans-serif;
        }

        .single-post-cat-com {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 10px;
            padding-right: 10px;
            transition: all 0.2s linear;
        }

        .single-post-select {
            padding-left: 10px;
        }

        .single-post-footer {
            margin-top: 10px;
            border-radius: 10px;
            background-color: white;
            transition: all 0.2s linear;
        }

        .description-wrap {
            padding: 10px;
            font-family: Trebuchet MS;
            line-height: 1.8em;
            opacity: 0.9;




        }

        .underline {
            width: 10rem;
            height: 0.15rem;
            background: #49a6e9;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            transition: all 0.2s linear;
        }

        .socials {
            float: bottom;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            column-gap: 10px;
            border-radius: 10px;
            transition: all 0.2s linear;
        }

        .socials a {
            border-radius: 10px;
        }

        .result_comment {
            font-family: Trebuchet MS;
            line-height: 1.8em;
            transition: all 0.2s linear;
        }

        .span-com {
            margin: 3% 3% 0% 3%;
            font-family: Trebuchet MS;
        }

        .add-com-btn {
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .badge {
            font-size: 13px;
        }

        .sub-card-title a:hover {
            color: #005e90;
        }

        .form-com-wrap {
            padding: 10px;
            font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
                "Lucida Sans", Arial, sans-serif;

            transition: all 0.2s linear;
        }

        .add-cancel-btns button {
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .add-cancel-btns {
            display: flex;
            justify-content: space-between;
        }

        .close {
            cursor: pointer;
            color: #005e90;
        }

        .form-group {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .form-group input {
            width: 305px;

            outline: none;
            padding: 5px 10px;
            transition: all 0.2s linear;

            border-radius: 5px;
            border: 1px solid #3e8da8;
        }

        .form-group .textarea-com {
            padding: 5px 10px;
            border-radius: 5px;
            outline: none;
            border-radius: 5px;
            border: 1px solid #3e8da8;
        }

        .read-more-com-btn {
            cursor: pointer;
            color: #005e90;
            padding-left: 10px;
        }

        .single-com {
            overflow: hidden;
            padding: 5px 20px;
            overflow: hidden;
        }

        .image-post {
            height: 360px;
            transition: all 0.2s linear;
        }

        .gradient {
            box-sizing: border-box;
            /* font-size: 12px; */
            /* font-weight: 700; */
            color: #fff;
            text-transform: uppercase;
            border: 1px;
            background-image: -moz-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -ms-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -o-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -webkit-linear-gradient(to left, #74ebd5, #9face6);
            background-image: linear-gradient(to left, #74ebd5, #9face6);
        }

        .note {
            background-color: #f5f5f5;

            border-left: solid 4px #3498db;
            line-height: 1.5em;
            /* mc-auto-number-format: "{b}Note: {/b}"; */
            overflow: hidden;
            padding: 12px;
            opacity: 0.7;
            font-family: Trebuchet MS;
            font-size: 15px;

            border-radius: 10px;
            /* transition:cubic-bezier(0.075, 0.82, 0.165, 1); */
        }

        .wrapper .menu select {
            border: #5a8ff0 solid 1.5px;
            border-radius: 5px;
            outline: none;
            font-family: Verdana;
            padding: 1%;
            padding-right: 2%;
        }

        a.social-link {
            display: inline;
            background-color: #aaa;
            color: #fff !important;
            text-decoration: none;
            padding: 6px 12px;
            margin: 0;
            -webkit-transition: background 0.1s linear;
            -moz-transition: background 0.1s linear;
            -ms-transition: background 0.1s linear;
            -o-transition: background 0.1s linear;
            transition: background 0.1s linear;
        }

        a:hover.facebook {
            background-color: #4a66b7;
        }

        a:hover.twitter {
            background-color: #00acee;
        }

        a:hover.linkedin {
            background-color: #1b86bc;
        }

        a:hover.gplus {
            background-color: #dd4b38;
        }

        a:hover.email {
            background-color: #ff9600;
        }

        a:hover.whatsapp {
            background-color: #25d366;
        }



        @media screen and (max-width: 1160px) {}

        @media screen and (max-width: 950px) {
            .container {
                grid-template-columns: 1fr;
                grid-template-rows: minmax(200px, auto);

            }

            /* .container {
                display: grid;
                grid-template-columns: 2fr 1fr;
                grid-template-rows: minmax(200px, auto);

                margin-left: 5%;
                margin-right: 5%;
                margin-top: 80px;

                /* grid-gap: 15px 20px; */
        }





        @media screen and (max-width: 768px) {
            .single-post-title h3 {
                font-size: 16px;
            }

            .description-wrap {
                font-size: 14px;
            }



            .single-post-cat-com {
                font-size: 14px;
            }

            .socials {
                font-size: 15px;
            }


            /* .button-read-more {
                font-size: 12px;
            } */




        }

        @media screen and (max-width: 500px) {
            .single-post-head {
                height: 370px;
                grid-template-rows: 220px 50px 50px 50px;


            }


            .image-post {
                height: 220px;
            }

        }
    </style>


</head>

<?php

require_once APPROOT . '/include/nav.php';

?>

<div class="container">

    <div class="single-post-left">

        <div>

            <div id="SuccessMessage" class="success-msg" style="display: none;">

            </div>
            <?php


            if (isset($_SESSION)) {

                echo ErrorMessage();
                echo SuccessMessage();
            }



            ?>


            <div class="single-post-head">
                <div class="single-post-image">
                    <img class="image-post lazy blur" height='100%' width="100%" src="admin/upload/<?php echo $image; ?>" alt="<?php echo $title; ?>" />
                </div>



                <div class="single-post-title">
                    <h3><?php echo $title ?></h3>
                </div>



                <div class="single-post-cat-com">
                    <span><?php echo $dateTime; ?>. <a href="<?php echo URLROOT ?>?category=<?php echo urlencode($category); ?>"><?php echo htmlentities($category); ?></a></span>
                    <span class="badge">Comments: <span id="post-comment" class="count"></span></span>
                </div>


                <div class="single-post-select">
                    <input type="hidden" value="<?php echo $id; ?>" id="id_post_hide">


                    <div class="wrapper">
                        <div class='menu'>
                            <select id="name">
                                <option value="overview">Overview</option>
                                <option value="excerpt">Read an excerpt</option>
                                <option value="contents">Table of contents</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="gradient underline">

                </div>
            </div>

            <div class="single-post-body">
                <div class="description-wrap">

                    <div id="overview" class="data">
                        <p><?php


                            echo nl2br($description);
                            ?></p>

                    </div>
                    <div id="excerpt" class="data"><?php echo nl2br($excerpt) ?></div>
                    <div id="contents" class="data"><?php echo nl2br($contents); ?></div>
                </div>

                <br>

                <div class="socials ">

                    <a class="social-link whatsapp " target='_blank' href="https://web.whatsapp.com/send?text=<?php echo URLROOT ?>/fullPost.php?id=<?php echo $id ?>"> Send</a>

                    <a class="social-link facebook ml-2" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo URLROOT ?>/fullPost.php?id=<?php echo $id ?>&t=<?php echo $title ?>" id="fb-share" rel="nofollow" target="_blank" title="Share on Facebook"> Share</a>

                    <a class="social-link twitter ml-2" href="https://twitter.com/share?url=<?php echo URLROOT ?>/fullPost.php?id=<?php echo $id ?>&via=booky_review&text=<?php echo $title ?>" id="tweet" rel="nofollow" target="_blank" title="Tweet this Page"> Tweet</a>

                    <a class="social-link linkedin ml-2" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo URLROOT ?>/fullPost.php?id=<?php echo $id ?>&title=<?php echo $title ?>&source=LinkedIn
                        " id=" linkedin" rel="nofollow" target="_blank" title="Share on LinkedIn"> LinkedIn</a>

                </div>

            </div>

            <div class="single-post-footer">


                <span class="span-com">Comments:</span>



                <input type="hidden" value="<?php echo $p; ?>" id="idPost">

                <div>

                    <!-- Display Post Comments -->
                    <div class="result_comment" id="result_comments">



                    </div>


                </div>


            </div>

            <div style=" margin-top: 10px; ">


                <span class="add-com-btn gradient" id="AddComment">Add Comment</span>



                <div class="comment-area" id="comment_area" style="display: none; background-color: white; border-radius: 10px;">
                    <form action="/ajax_responses/add_comments.php" method="POST" id="form_comments">

                        <div class="form-com-wrap">
                            <h5>Share your thoughts about this post</h5><span id="err_msg_comments"></span>

                            <div class="form-group">

                                <input required type="text" class="input-com" name="nameUser" placeholder="Your name">

                            </div>
                            <span id="name_error" class="text-danger"></span>
                            <input type="hidden" value="<?php echo $p; ?>" name="id">



                            <div class="form-group">

                                <textarea placeholder="Your comment" required name="comment" id="" cols="37" rows="5" class="textarea-com"></textarea>
                            </div>
                            <span id="comment_error" class="text-danger"></span>


                            <div class="add-cancel-btns">
                                <button type="submit" class="gradient" name="commentSubmit">Share</button>

                                <span type="submit" class="close" id="close">
                                    Cancel <i class="uil uil-times"></i>
                                </span>
                            </div>
                        </div>

                    </form>
                </div>


            </div>

        </div>






    </div>

    <div class="rightt">
        <?php require_once "sideArea.php"; ?>

    </div>
</div>

<?php require_once APPROOT . '/include/footer.php';  ?>

<!-- Add comments + read comments + display more comments -->
<script src="./js/commentStufs.js"></script>


</body>

</html>