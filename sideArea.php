<?php
include_once(APPROOT . '/include/model.php');

$category = new categoriesData();
?>


<style>
    * {
        padding: 0;
        margin: 0;


    }

    .card {
        display: grid;
        /* grid-template-rows: 50px 1fr; */
        /* background-color: rgb(243, 0, 0); */
        /* border-radius: 5px;
  */
        grid-template-rows: 45px auto;
        /* overflow */
        background-color: white;
        border-radius: 10px;

        /* margin-bottom: 10%; */

        -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
        -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
        box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
    }


    .card-head {
        /* width: 100%; */
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        -o-border-radius: 5px;
        -ms-border-radius: 5px;
        padding-left: 15px;
        padding-top: 15px;
        box-sizing: border-box;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        border: none;
        background-image: -moz-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -ms-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -o-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -webkit-linear-gradient(to left, #74ebd5, #9face6);
        background-image: linear-gradient(to left, #74ebd5, #9face6);
    }

    .heading:hover {
        color: #0090db;
        cursor: pointer;
    }


    ul {
        color: black;
        list-style: none;

        /* width: 1000px; */
    }


    .drop_down_link {
        /* padding-left: 5px;
  padding-right: 5px; */
        padding: 5px 5px 5px 5px;
        /* overflow: hidden; */
        margin: 5px;
    }

    .drop_down_link i {
        /* margin-top: 2%; */

        color: #5a8ff0;
        float: right;
        /* display: inline-block; */
        /* float:left;  remove */
    }

    .drop_down_link:hover {
        background-color: #f5f5f5;
        cursor: pointer;
        border-radius: 10px;
        transition: 0.3s;
    }





    .sub-categories {
        margin: 10px
    }

    .subcategories {
        padding: 10px;

    }


    .card-body-suggestions {
        display: grid;

        grid-template-rows: repeat(6, auto);
        grid-template-columns: repeat(1, 1fr);
    }

    .sub-card {
        /* background-color: red; */
        display: grid;
        /* grid-template-columns: 1fr; */
        /* grid-template-rows: repeat(6, 1fr); */
        /* padding-top: 10px; */

        transition: all 0.2s linear;
    }

    .sub-card-title {
        grid-column: 1 / 2;
        grid-row: 1 / 2;
        padding-bottom: 5px;

        padding-left: 5px;
        color: #005e90;
    }

    .sub-card-subtitle {
        grid-column: 1 / 2;
        grid-row: 2 / 3;
        padding-bottom: 3px;
        padding-left: 5px;
        color: #8c92ac;
    }

    .sub-card-subtitle i {
        font-family: Trebuchet MS;
        opacity: 0.9;
    }

    .sub-card-date {
        grid-column: 1 / 2;
        grid-row: 3 / 4;
        padding-bottom: 3px;
        padding-left: 5px;
    }

    .sub-card-separator {
        /* width: 100%; */
        /* border-top: 1px solid #ccc; */
        /* margin: 10px 0; */

        margin-top: 10px;
        margin-bottom: 10px;
    }

    .card-body {
        /* background-color: #fff; */

        padding: 15px 15px 15px 15px;
    }





    .card-body-logo {
        color: #8c92ac;

        padding: 15px 15px 15px 15px;
        /* height:1000px; */
    }


    .side-area-head-logo {
        /* background-color: white */

        padding-left: 15px;
        padding-top: 15px;
    }


    .hover {
        cursor: pointer;
        border-radius: 10px;
        background-color: #f5f5f5;
        transition: 0.3s;
    }

    .subcategories.hidden {
        display: none;
    }


    .sub-genre {
        margin-left: 30px;
        color: #8c92ac;
    }

    .sub-genre:hover {
        color: #005e90;
    }

    /* Duplicate */
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

    .uil {
        color: #3e8da8;
        float: right;
    }


    /* ends duplicate */


    @media screen and (max-width: 1160px) {}

    @media screen and (max-width: 950px) {

        .card-body-suggestions {
            grid-template-rows: repeat(3, auto);
            grid-template-columns: repeat(2, 1fr);
        }



    }





    @media screen and (max-width: 768px) {

        .card-body-suggestions {
            grid-template-rows: repeat(6, auto);
            grid-template-columns: repeat(1, 1fr);
        }

        .card {
            font-size: 15px;
        }





    }

    @media screen and (max-width: 500px) {}

    @media screen and (max-width: 400px) {
        .text {
            font-size: 14px;
        }





    }
</style>



<div class="card">
    <div class="side-area-head-logo">
        <!-- <img src="css/logo.png" alt="bookyreview logo" height='30' width="120"> -->
        <i>Book of the Week!</i>


    </div>

    <div class="card-body-logo card-body" style="font-family: Trebuchet MS;line-height:1.7rem">
        <?php
        // $res = $side_left->read();

        // while ($r = $res->fetch()) {


        ?>
        <!-- <div style="font-family: Trebuchet MS;line-height:1.8em "> -->

        <b>The Fault in Our Stars</b> is a young adult novel written by John Green and published in 2012.
        <br>
        It tells the story of two young cancer patients, Hazel Grace Lancaster and Augustus Waters, who fall in love and navigate the challenges of terminal illness.
        <br>

        The story begins with Hazel, a 16-year-old girl who has been living with thyroid cancer for three years.
        <br>
        Despite her illness, Hazel is intelligent, witty, and determined to live a meaningful life. She is also a fan of a novel called An Imperial Affliction, written by an author named Peter Van Houten. The book is about a girl named Anna who also has cancer, and it deeply resonates with Hazel.

        <br>
        One day, Hazel is forced by her parents to attend a cancer support group, where she meets Augustus Waters, a handsome and charismatic teenage boy who has lost a leg to osteosarcoma..
         <a href="https://bookyreview.space/fullPost.php?id=6&title=The-Fault-in-Our-Stars">Continue Reading</a>






        <!-- </div> -->



        <?php
        // }

        ?>
    </div>
</div>

<div class="card">
    <div class="card-head">Categories</div>
    <div class="card-boddy">

        <?php

        $stmt = $category->getCategories();


        echo '<ul  id="categories" class="sub-categories">';

        $currentCategory = '';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['category'] != $currentCategory) {
                // This is a new category, so we need to close the previous category's list and start a new one
                if ($currentCategory != '') {
                    // If this isn't the first category, close the previous category's list
                    echo '</ul></li>';
                }
                // Start a new category
                // echo '<i class="fa fa-caret-down"></i>';
                echo '<li  class="drop_down_link ">';

                echo "<a href=" . URLROOT . '?category=' . urlencode($row['category']) . "><span class='heading text'>" . $row['category'] . "</span></a>";
                echo $row['subcategory'] !== null ? ' <i class="uil uil-angle-down"></i>' : '';

                echo '<ul class="subcategories hidden ">';
                $currentCategory = $row['category'];
            }
            // Add the subcategory to the current category's list
            if ($row['subcategory'] !== null) {
                // echo '<li>' . $row['subcategory'] . '</li>'; 
                echo "<li style='padding-bottom:5px'><a   href=" . URLROOT . '?category=' . urlencode($row['category']) . "&sub_genre=" . urlencode($row['subcategory']) . "><span class='sub-genre '>" . $row['subcategory'] . "</span></a></li>";
            }
        }
        // Close the final category's list
        echo '</ul></li>';
        echo '</ul>';
        ?>
    </div>
</div>


<div class="card card-suggestions">
    <div class="card-head">Suggestions</div>
    <div class="card-body card-body-suggestions">


        <?php
        $stmt = $posts->suggestion();

        while ($r = $stmt->fetch()) {
            $id = $r['id'];
            $title = $r['title'];
            $author = $r['bookAuthor'];
            $d = strtotime($r['dateTime']);
            if (date('Y', $d) == date('Y')) {
                $dateTime = date('d M', $d);
            } else {
                $dateTime = date('d M Y', $d);
            }
            $image = $r['image'];

        ?>

            <div class="sub-card">

                <div class="sub-card-title">

                    <a href="fullPost.php?id=<?php echo $id; ?>&title=<?php echo myUrlEncode(strip_tags_content($title)); ?>" target="">
                        <i class="uil uil-book-open"></i><?php echo  strlen($title) > 35 ?  substr($title, 0, 35) . '..' : $title; ?>


                    </a>
                </div>


                <div class="sub-card-subtitle"><i> By <?php echo  strlen($author) > 35 ?  substr($author, 0, 35) . '..' : $author; ?></i>
                </div>
                <div class="sub-card-date"><small><?php echo htmlentities($dateTime); ?></small></div>
                <hr class="sub-card-separator">


            </div>

        <?php } ?>



    </div>
</div>
<script>


</script>