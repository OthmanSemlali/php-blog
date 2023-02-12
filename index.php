<!DOCTYPE html>
<html lang="en">

<?php

require_once('include/config.php');
require_once('include/model.php');
require_once('include/functions.php');
require_once('include/session.php');

?>



<?php
$meta_url = URLROOT;
$meta_title = SITENAME . " | Find your next great read";
$meta_description = "Our website provides in-depth book reviews and excerpts to help you decide which titles are worth your time and money. We also offer detailed table of contents for each book so you can get a better understanding of the structure and content of the book before you dive in. Our goal is to make your reading experience as enjoyable and informed as possible. Whether you're looking for a new book to add to your to-read list or just want to browse through some reviews, we've got you covered.";
$meta_image = "https://collegeinfogeek.com/wp-content/uploads/2018/11/Essential-Books.jpg";



//* This is for the notes section that appears when selecting categories or sub-categories from the side area
if (isset($_GET['category']) && !isset($_GET['sub_genre'])) {

    $cat = $_GET['category'];
    // var_dump($cat);
    $stmt = $category->readCategory($cat);
    $res = $stmt->fetch();

    $meta_title = "Discover the Magic of " . $res['title'] . " Books";
    $meta_url = URLROOT . '?category=' . urlencode($res['title']);

    if (@$res['description']) {
        $meta_description = $res['description'];
    }
}

if (isset($_GET['category']) && isset($_GET['sub_genre'])) {
    $cat = $_GET['category'];
    $sub_cat = $_GET['sub_genre'];
    $cat_id = $category->getCategoryId($cat);

    $stmt = $subcategory->readSubCategory($sub_cat, $cat_id);
    $res = $stmt->fetch();


    $meta_url = URLROOT . '?category=' . urlencode($cat) . '&sub_genre=' . urlencode($sub_cat);
    $meta_title = "Explore the Best " . $sub_cat . " Books in the " . $cat . " Category";

    if (@$res['description']) {
        $meta_description = $res['description'];
    }
}



?>

<head>

    <meta name="google-site-verification" content="8SeNBmQD5wfkgZFy-QC3hmmharRvohQ169Vsuy3M2pc" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title><?php echo $meta_title; ?></title>

    <meta name="description" content="<?php echo $meta_description ?>" />

    <meta property="og:title" content="<?php echo SITENAME . ' | ' . $meta_title; ?>" />

    <meta property="og:description" content="<?php echo $meta_description ?>" />

    <meta property="og:url" content="<?php echo $meta_url; ?>" />
    <meta property="og:image" content="<?php echo $meta_image;  ?>" />

    <meta property="og:site_name" content="<?php echo SITENAME; ?>" />

    <!-- <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" /> -->
    <style>
        /************************************* Homepage Style *************************************/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f0faff;
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

        .badge {
            background-color: #f5f5f5;
            padding: 3px 5px;
            border-radius: 8px;
            font-size: 13px;
        }


        .articles {
            /* background-color: blue; */
            /* height: 1000px; */

            display: grid;
            grid-template-columns: 1fr;
            /* grid-template-rows: minmax(auto, 600px); */

            row-gap: 20px;
        }

        .article {
            background-color: white;
            max-height: 600px;
            overflow: hidden;

            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 360px 240px;

            border-radius: 10px;

            -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);

            transition: all 0.2s linear;
        }

        .image-post {
            height: 360px;
            transition: all 0.2s linear;
        }

        .body-post {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 35px 35px 125px 50px;

            padding: 10px 20px;
            /* background-color: red; */
        }

        .body-post .post-cat-com {
            /* background-color: blue; */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .body-post .post-description {
            /* background-color: aqua; */
            max-height: 130px;
            overflow: hidden;
        }

        .body-post .read-more {
            /* background-color: blue; */

            display: flex;
        }

        .body-post .post-read-more button {
            float: right;
            /* margin-top: 5px; */
            padding: 5px 10px;
            border-radius: 7px;
            cursor: pointer;
        }



        .sep hr {
            margin-bottom: 10px;
            /* color: red; */
        }

        .blur {
            filter: blur(5px);
        }

        .pagination-icons nav ul {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .pagination-icons nav ul a {
            color: white;
        }

        .pagination-icons nav ul .sep-pages-items {
            margin-right: 5px;
        }

        .page-item {
            padding: 10px;
            margin-right: 5px;
            border-radius: 5px;
            transition: all 0.2s linear;
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


            .button-read-more {
                font-size: 12px;
            }



        }

        @media screen and (max-width: 500px) {
            .article {
                max-height: 500px;
                grid-template-rows: 220px 280px;
            }

            .image-post {
                height: 220px;
            }

            .body-post {
                grid-template-rows: 50px 35px 120px 35px;
            }

            .body-post .post-read-more button {
                margin-top: 15px;
            }

        }
    </style>
</head>



<body>


    <?php
    require_once APPROOT . '/include/nav.php';
    ?>

    <div class="container">

        <div class="left">

            <?php

            // ? This is Optional is just deal with the Errors in category and subcategories Queries (Someone put category doesn't exist..)

            if (isset($_GET['category']) && isset($_GET['sub_genre'])) {
                $cat = $_GET['category'];
                $sub_cat = $_GET['sub_genre'];
                $cat_id = $category->getCategoryId($cat);

                $stmt = $subcategory->readSubCategory($sub_cat, $cat_id);
                $res = $stmt->fetch();

                if (@$res['description'] && $cat !== '' &&  $sub_cat !== '') {
                    echo "<div class='note '>" . $res['description'] . "</div>";
                } elseif ($cat == '' or $sub_cat == '') {
                    echo '<div class="error-msg">
                    <i class="fa  fa-times-circle"></i> Please provide both category name and sub-category name.</div>';
                    // redirect_to(URLROOT);

                }

                $stmt = $posts->getPostsBySubCategory($cat, $sub_cat);
            }
            if (isset($_GET['category']) && !isset($_GET['sub_genre'])) {

                $cat = $_GET['category'];
                // var_dump($cat);
                $stmt = $category->readCategory($cat);
                $res = $stmt->fetch();
                if (@$res['description'] && $cat !== '') {
                    echo "<div class='note mb-2'>" . $res['description'] . "</div>";
                } elseif ($cat == '') {
                    echo '<div class="error-msg">
                    <i class="fa  fa-times-circle"></i> Please provide the category name!</div>';
                    // redirect_to(URLROOT);


                }
            }

            ?>


            <!-- read the posts list depend on the user's choice or behavior -->
            <div class="articles">
                <!-- List posts -->

                <?php
                if (isset($_SESSION)) {

                    echo ErrorMessage();
                    echo ErrorMessage();
                    echo InfoMessage();
                }

                ?>


                <?php

                $totalPost = $posts->totalPost();
                $postPagination =  $totalPost / 5;
                $postPagination = ceil($postPagination);

                if (isset($_GET['page'])) {

                    // query when pagination is active
                    $page = $_GET['page'];


                    if ($page > $postPagination) {

                        // $_SESSION['ErrorMessage'] = "The page you were looking for doesn't exist";
                        // redirect_to('blog.php?page=1');
                        $page = 1;
                        echo '<div class="error-msg">
                        <i class="fa fa-times-circle"></i> The page you were looking for doesn\'t exist.</div>';


                        // exit('The page you were looking for doesn\'t exist <a href="' . URLROOT . '">Home</a>');
                    }


                    if ($page == 0 || $page < 1 || !is_numeric($page)) {
                        $showPostFrom = 0;
                        echo '<div class="error-msg">
                        <i class="fa fa-times-circle"></i> Bad request.</div>';
                    } else {
                        $showPostFrom = ($page * 5) - 5;
                    }

                    $stmt = $posts->showPostFrom($showPostFrom);
                } elseif (isset($_GET['category']) && $_GET['category'] !== '' && !isset($_GET['sub_genre'])) {
         
                    $cat = $_GET['category'];
                   
                    $stmt = $posts->getPostsByCategory($cat);
                } elseif (isset($_GET['category']) && isset($_GET['sub_genre']) && $_GET['category'] !== '' && $_GET['sub_genre'] !== '') {

                    $cat = $_GET['category'];

                    $sub_cat = $_GET['sub_genre'];
                    $cat_id = $category->getCategoryId($cat);


                    $stmt = $posts->getPostsBySubCategory($cat, $sub_cat);
                }

                //  elseif (isset($_GET['searchBtn'])) {  // SQL QUERY WHENE SEARCH BUTTON IS ACTIVE 


                //     $search = trim($_GET['search']);
                //     $stmt = $posts->selectPosts($search);


                //     if ($stmt->rowCount() == 0) {
                //         $stmt = $posts->selectPosts();
                //         $_SESSION['ErrorMessage'] = "We're sorry. We were not able to find a match.";
                //     }
                // }
                elseif (isset($_GET['search'])) {
                    $searche = $_GET['search'];
                    // var_dump($searche);
                    $stmt = $posts->selectPosts($searche);
                    if ($stmt->rowCount() == 0) {
                        $stmt = $posts->selectPosts();
                        // $_SESSION['ErrorMessage'] = "We're sorry. We were not able to find a match.";
                        echo '<div class="error-msg">
                        <i class="fa fa-times-circle"></i> We\'re sorry. We were not able to find a match.</div>';
                    }
                } else {
                    // THE DEFAULT SQL QUERY
                    $stmt = $posts->selectPosts();
                }


                if ($stmt->rowCount() > 0) :


                    while ($r = $stmt->fetch()) :
                        $id = $r['id'];
                        $d = strtotime($r['dateTime']);


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

                ?>


                        <div class="article">
                            <div class="image-post">

                                <img class="image-post lazy blur" height='100%' width="100%" src="admin/upload/<?php echo $image; ?>" alt="<?php echo $title; ?>" />
                            </div>
                            <div class="body-post">


                                <div class="post-title">
                                    <h3 style="
                                             font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; box-sizing: border-box;
                                    "><?php echo $title; ?></h3>
                                </div>
                                <div class="post-cat-com">


                                    <span><?php echo $dateTime; ?>. <a href="<?php echo URLROOT ?>?category=<?php echo urlencode($category); ?>"><?php echo htmlentities($category); ?></a></span>
                                    <span class="badge">Comments: <?php echo $com->totalComments($id); ?></span>
                                </div>
                                <div class="post-description">
                                    <span class="sep">
                                        <hr />
                                    </span>

                                    <p style="
                font-family: Trebuchet MS;line-height:1.8em ;opacity: 0.8;
                                    ">

                                        <?php

                                        if (strlen($description) > 300) {
                                            $description = substr($description, 0, 150) . '...';
                                        }

                                        echo ($description);
                                        ?>
                                    </p>

                                </div>
                                <div class="post-read-more">



                                    <a href="<?php echo URLROOT ?>fullPost.php?id=<?php echo $id; ?>&title=<?php echo myUrlEncode(strip_tags_content($title)); ?>">
                                        <button class="gradient button-read-more">
                                            <b> Continue Reading </b>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>


                <?php


                    endwhile;
                else :


                    // $_SESSION['InfoMessage'] = 'There are no posts to show.';
                 
                    exit('<div class="info-msg">
                    <i class="fa fa-info-circle"></i> There are no posts to show. <a href="' . URLROOT . '">Home</a></div>');
               


                endif;


                ?>
            </div>



            <div class="pagination-icons">

                <!-- DISPLAY PAGINATION ITEMS -->
                <nav>

                    <ul>
                        <?php


                        if (isset($page)) :


                            // Create Backword Button
                            if ($page > 1) :
                        ?>


                                <li><a class="page-item gradient " id="st" href=" <?php echo URLROOT . '?page=' . $page - 1;  ?>" class="page-link ml-1">&laquo;</a></li>



                                <?php
                            endif;
                        endif;




                        // Display Items 

                        if ($postPagination > 3) :
                            $newpagination = 3;

                            for ($j = 1; $j <= $newpagination; $j++) :

                                if ($j == @$page) :
                                ?>

                                    <li>
                                        <a class="page-item gradient active" style="border:1px black solid; color:black" href="<?php echo URLROOT . '?page=' . $j ?>" class="page-link ml-1"><?php echo $j; ?></a>

                                    </li>

                                <?php
                                else :

                                ?>
                                    <li>
                                        <a class="page-item gradient  " href="<?php echo URLROOT . '?page=' . $j; ?>" class="page-link ml-1"><?php echo $j; ?></a>

                                    </li>




                                    <?php
                                endif;
                            endfor;



                            for ($i = 4; $i <= $postPagination - 1; $i++) :



                                if ($i == @$page) :

                                    if ($i > 4) {
                                    ?>
                                        <li class="sep-pages-items">
                                            <span><i class="uil uil-ellipsis-h"></i></span>

                                        </li>
                                    <?php
                                    }
                                    ?>

                                    <li>

                                        <a class="page-item gradient active " style="border:1px black solid; color:black" href="<?php echo URLROOT . '?page=' . $i ?>" class="page-link ml-1"><?php echo $i; ?></a>

                                    </li>

                                <?php


                                endif;
                            endfor;


                            if (@$page <= $postPagination - 2) {
                                ?>

                                <li class="sep-pages-items"><span><i class="uil uil-ellipsis-h"></i></span></li>


                            <?php
                            }

                            ?>

                            <li>

                                <a class="page-item gradient" href="<?php echo URLROOT . '?page=' . $postPagination; ?>" class="page-link ml-1"><?php echo $postPagination; ?></a>
                            </li>


                            <?php

                        endif;



                        if (isset($page)) :
                            // Create Forward Button

                            if ($page == null) {
                                $page = 1;
                            }
                            if ($page + 1 <= $postPagination) :

                            ?>

                                <li>

                                    <a class="page-item gradient  " href="<?php echo URLROOT . '?page=' . $page + 1 ?>" class="page-link ml-1">&raquo;</a>

                                </li>


                        <?php

                            endif;

                        endif;

                        ?>


                    </ul>
                </nav>

            </div>

        </div>
        <div class="rightt">
            <?php
            require_once "sideArea.php";
            ?>

        </div>

    </div>



    <?php require_once APPROOT . '/include/footer.php';  ?>


</body>

</html>