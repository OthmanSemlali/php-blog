<?php
require_once 'include/nav-admin.php';


?>


<body>


    <br><br>

    <section class="container py-4 mb-4">


        <div class="row">

            <!-- <div id="message"></div> -->
            <div class="offset-lg-2 col-lg-8 login-wrap">



                <div style="display: flex; justify-content:space-between">
                    <span><i class="fas fa-edit"></i> Manage Categories / Sub-categories </span> <span class="text-success" id="message"></span>
                </div>
                <form action="" method="POST" id="myForm">
                    <div class="" style="margin: 3%;">


                        <div class="form-group">
                            <fieldset style="border: 1px solid black;">
                                <legend>
                                    <label for="categoryTitleId ">Existing Categories</label>

                                </legend>
                                <form action="" method="get">

                                    <select class="form-control" name="categories_select" id="categories_select" onchange="this.form.submit()">
                                        <?php

                                        // Get all categories in database 

                                        $res = $category->readCategory();

                                        if ($res->rowCount() > 0) {
                                            while ($r = $res->fetch()) {

                                        ?>
                                                <option value="<?php echo $r['id'] . '_' . $r['title'];  ?>"><?php echo $r['title']; ?></option>
                                            <?php }
                                        } else {
                                            ?>
                                            <option value="">No Category Found!</option>
                                        <?php
                                        }


                                        ?>


                                    </select>
                                </form>

                                <script>

                                </script>
                                <div style="
                            display: flex;
                            justify-content:space-between;
                            background-color:azure;
                            border-radius:5px

                            " id="row">



                                    <span class='ml-3' id="category_selected"></span>
                                    <span id="delete_category_selected" class="text-danger btn del">Delete</span>

                                </div>
                                <hr>
                                <div style="
                            display: flex;
                            justify-content:space-between;
                            background-color:azure;
                            border-radius:5px

                            " id="row_sub_category">





                                    <span class='ml-3' id="sub_categories"></span>


                                </div>
                            </fieldset>

                        </div>
                        <div class="form-group">
                            <label for="title">Add new Category </label>
                            <input required class="form-control" type="text" name="title" id="title">
                            <input type="hidden" id="admin" value="<?php echo $_SESSION['usernameAdminConnected']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="category_description">Category Description </label>
                            <textarea class="form-control" name="category_description" id="category_description" cols="10" rows="5"></textarea>

                        </div>


                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Add category
                                </button>

                            </div>
                        </div>

                    </div>
                </form>

                <hr>
                <div class="mt-4">

                    <form action="" method="POST" id="sub_category_form">

                        <div class="form-group">
                            <label for="sub_category_title">Add Sub-Category for <b><span id="category"></span></b> </label>
                            <input required class="form-control" type="text" name="sub_category_title" id="sub_category_title">
                            <input type="hidden" id="admin" value="<?php echo $_SESSION['usernameAdminConnected']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sub_category_description">Category Description </label>
                            <textarea class="form-control" name="sub_category_description" id="sub_category_description" cols="10" rows="5"></textarea>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 mb-2">

                                <button type="submit" name="submit_sub_category" class="btn btn-info btn-block">
                                    <i class="fas fa-check"></i> Add sub-category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

    </section>


    <!-- end main era -->





    <script>
        $(document).ready(function() {
            display_categories();

            function display_categories() {
                $.ajax({

                    url: './adminPanel/ajaxResponses/categories.php',
                    method: 'POST',
                    data: {

                        type: 'display'
                    },

                    success: function(data) {
                        $('#categories_select').html(data)

                    }
                })

            }





            split_info()

            function split_info() {
                let category_val = $('#categories_select').val();
                let categories_splited = category_val.split('_')
                let id = categories_splited[0];
                let title = categories_splited[1];

                $('#category_selected').text(title);

                $('#category').html(title);
                $('#category').val(title);


                $('#category_selected').attr('data-id', id);

            }


            // Show category for deleting after every change of the slect
            $('#categories_select').on('change', function() {
                // alert()
                split_info()
                $('#row').show()

                //show sub_categories
                const selectedOption = $(this).val();
                let category_id = $('#category_selected').attr('data-id');

                $.ajax({
                    url: './adminPanel/ajaxResponses/categories.php',
                    type: 'POST',
                    data: {
                        category_id: category_id,
                        type: 'display_sub_categories'
                    },
                    success: function(response) {
                        console.log(response);
                        $('#sub_categories').html(response)

                    }
                });



            })


            // Delete Categories
            $('.del').click('click', function() {


                let id = $('#category_selected').attr('data-id')
                // alert(id)
                if (confirm('Are you sure you want to delete?')) {


                    $.ajax({
                        url: './adminPanel/ajaxResponses/categories.php',

                        method: 'POST',
                        data: {
                            id: id,
                            type: 'delete'

                        },
                        success: function(data) {
                            if (!data.error) {
                                $('#message').show();

                                $('#message').text('Category Deleted Successfully');
                                // alert(data)

                                setTimeout(() => {
                                    // $('#message').hide();
                                    $('#message').hide();
                                }, 4000);

                                $('#row').hide()


                                display_categories();
                            } else {
                                $('#message_error').text("Something Went Wrong!");

                            }

                        }
                    })

                }

            })




            // Insert Catrgory

            $('#myForm').submit(function() {

                let title = $('#title').val()
                let admin = $('#admin').val();
                let description = $('#category_description').val()

                $.ajax({

                    url: './adminPanel/ajaxResponses/categories.php',
                    data: {
                        title: title,
                        admin: admin,
                        description: description,
                        type: 'insert'
                    },
                    method: 'POST',
                    // dataType: 'JSON',
                    success: function(data) {

                        if (!data.error) {
                            $('#message').show();

                            $('#message').text(" Category Added Successfully");
                            $('#myForm')[0].reset()

                            setTimeout(() => {
                                $('#message').hide();

                            }, 4000);


                            display_categories();
                        } else {
                            $('#message_error').text("Something Went Wrong!");

                        }

                    }
                })
                return false;
            })



            $('#sub_category_form').submit(function(e) {
                e.preventDefault()
                let sub_category_title = $('#sub_category_title').val()
                let sub_category_description = $('#sub_category_description').val()
                let category_id = $('#category_selected').attr('data-id');
                let category_title = $('#category').val()

                $.ajax({

                    url: './adminPanel/ajaxResponses/categories.php',
                    data: {
                        sub_category_title: sub_category_title,
                        sub_category_description: sub_category_description,
                        category_id: category_id,
                        type: 'insert_sub_category'
                    },
                    method: 'POST',
                    // dataType: 'JSON',
                    success: function(data) {

                        if (!data.error) {
                            $('#message').show();

                            $('#message').text("Sub-Category Added Successfully");
                            $('#myForm')[0].reset()

                            setTimeout(() => {
                                $('#message').hide();

                            }, 4000);


                            //display_categories();
                        } else {
                            $('#message_error').text("Something Went Wrong!");

                        }

                    }
                })
                return false;
            })





        })
    </script>

    <?php require_once APPROOT . '/include/footer_admin.php';  ?>