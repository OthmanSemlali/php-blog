<?php

require_once 'include/nav-admin.php';

?>

<body>

    <!-- main area -->
    <section class='container py-2 mb-4 mt-4'>
        <span id="message"></span>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();

        ?>
        <div class="row">
            <div class="col-lg-12">

                <!-- Select & Search bar & btn Add -->
                <div style="display: flex; justify-content:space-between; margin-bottom:1%">

                    <span style="float: left;  ">
                        <form action="select.php" method="POST">

                            <style>
                                a {
                                    text-decoration: none;
                                }

                                .sel {
                                    /* height: 40px; */
                                    border: none;
                                    outline: none;
                                    width: 65px;
                                    background-color: transparent;
                                    cursor: pointer;
                                    /* border: 0.1px solid white; */
                                    margin-top: 10px;
                                    color: black;
                                }
                                .pagination-links{
                                    display: grid;
                                    grid-template-columns: repeat(15, 1fr);
                                    grid-gap: 5px;
                                }

                                #pagination_link:hover {
                                    background-color: #ccc;
                                }

                                .act {
                                    background-color: #ccc;
                                }
                            </style>
                            <select name="" id="pages" class="sel form-submit">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </form>

                    </span>

                    <span style="width:80%;"><input type="text" id="search_bar" class="form-control" placeholder="Search by Keyword: Id / Title / Category"></span>
                    <span class="width:65px;  ">
                        <a href="add_post.php"><button class="form-submit add_data" style="float: right; margin-top:10px; color:black" style="padding-top:10%;" id="add_data">Add Post</button></a>


                    </span>

                </div>


                <!-- Table -->
                <table class='table table-scripted table-hover login-wrap' id="myTable">
                    <thead class='thead-dark'>


                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody id="result_all_record">

                        <!-- RECORDS  -->

                    </tbody>

                </table>



                <?php
                // Show links Pagination

                $record_per_page = 10;
                $total_records = $posts->totalPost();

                $total_pages = ceil($total_records / $record_per_page);


                ?>

                <span class="pagination-links">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) :


                    ?>


                        <button id="pagination_link" class='pagintion_link btn ' style='cursor:pointure; padding:8px; margin:2px; border:1px solid #ccc;' data-id='<?php echo $i ?>'><?php echo $i ?></span>
            <?php
                    endfor;

            ?>

            </span>


            </div>
        </div>
    </section>







    <script src="./adminPanel/managePosts.js"></script>

    <?php require_once APPROOT . '/include/footer_admin.php';  ?>