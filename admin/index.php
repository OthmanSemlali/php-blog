
<?php


require_once 'include/nav-admin.php';

?>

<style>
   
</style>

<h6 class="">Welcome <?php echo $_SESSION['usernameAdminConnected']; ?></h6>


<div class="container mt-4 mb-4 text-center d-flex justify-content-between">

    <div class="col"><a href="<?php echo URLROOT ?>post.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Manage Posts</a></div>
    <div class="col"><a href="<?php echo URLROOT ?>categories.php" class=" btn btn-primary"><i class="fa-solid fa-pen-to-square"></i> Manage Categories</a></div>
    <div class="col"> <a href="<?php echo URLROOT ?>manageAdmins.php" class=" btn btn-info"><i class="fa-solid fa-user-pen"></i> Manage Admins
            <span class="badge rounded-pill badge-notification bg-danger"><?php echo $admin->totalAdminsNotConfirmed() > 0 ?   $admin->totalAdminsNotConfirmed() : '' ?></span>
        </a>
    </div>

    <div class="col">
        <a href="<?php echo URLROOT ?>leftSide.php" class=" btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i> Side Area</a>
    </div>

</div>
<br>
<section class='container py-2 mb-4'>
    <?php
    $_SESSION['InfoMessage'] = null;

    echo ErrorMessage();
    echo SuccessMessage();
    ?>


    <div class="row ">

        <div class="col-lg-2 ">


            <div class=" mb-3 login-wrap counterCard">
                <!-- <br> -->

                <h6 class="lead">All Posts</h6>
                <h5 class="display-5  mt-2">
                    <i class="fa-brands fa-readme">
                        <span id="count_posts"><?php
                                                echo  $posts->totalPost();
                                                ?></span>
                    </i>
                </h5>


            </div>


            <div class="mb-3 login-wrap counterCard">
                <!-- <br> -->

                <h6 class="lead">Categories</h6>
                <h5 class="display-5  mt-2">
                    <i class="fas fa-folder">
                        <span id="count_categories">
                            <?php
                            echo $category->totalCategories();
                            ?>
                        </span>
                    </i>
                </h5>

            </div>




          

            <div class="login-wrap mb-3 mt-2 counterCard">

                <h5 class="lead">Newsletter subscribers</h5>
                <h5 class="display-5">
                    <i class="fas fa-users">
                        <span id="count_pending_admins">
                            <?php
                            echo $mails->getCounterOfNewsLetterSubscribers();
                            ?>
                        </span>
                    </i>
                </h5>

            </div>

        </div>


        <div class="col-lg-10">

            <!-- <h2>Top  Posts</h2> -->
            <span>Top 5 Posts</span>
            <table class='table table-scripted table-hover login-wrap'>
                <thead class='thead-dark'>

                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date&Time</th>
                        <th>Admin</th>
                        <th>Comments</th>


                    </tr>
                </thead>

                <tbody>

                    <?php

                    $posts = new postsData();
                    $com = new commentsData();


                    $res = $posts->topPostByComments();

                    if ($res) {
                        while ($r = $res->fetch()) :
                            $id = $r['id'];


                            $d = strtotime($r['dateTime']);

                            if (date('Y', $d) == date('Y')) {
                                $dateTime = date('d M', $d);
                            } else {
                                $dateTime = date('d M Y', $d);
                            }
                            $title = $r['title'];
                            if (strlen($title) > 10) {
                                $title = substr($title, 0, 10) . '..';
                            }

                            $admin = $r['author'];
                            if (strlen($admin) > 10) {
                                $admin = substr($admin, 0, 10) . '..';
                            }


                    ?>


                            <tr>
                                <td id="id"><?php echo $id; ?></td>
                                <td>
                                    <?php

                                    echo $title; ?>
                                </td>
                                <td><?php echo $dateTime; ?></td>

                                <td><?php

                                    echo $admin; ?></td>
                                <td>
                                    <span class=" badge badge-dark ml-4"><?php echo  $com->totalComments($id);  ?></span>
                                </td>

                            </tr>
                    <?php

                        endwhile;
                    } else {

                        echo  "<span class='text-danger ' style='float:right'>  No Top Post Found!</span>";
                    }


                    ?>


                </tbody>


            </table>



        </div>
    </div>
</section>


<!-- FOOTER -->
<?php require_once APPROOT . '/include/footer_admin.php';  ?>