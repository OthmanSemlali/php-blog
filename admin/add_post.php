<?php
require_once 'include/nav-admin.php';


?>



<br>
<section class="container py-4 mb-4">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URLROOT ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URLROOT ?>post.php">Manage posts</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add post</li>
        </ol>
    </nav>
    <div class="container mt-4">
        <h5 id="message" class="text-success"></h5>

        <form method="POST" id="myForm" name="myForm" enctype="multipart/form-data">
           
            <div class="form-group">


                <!-- //custom-file-input -->
                <input class="img" type="file" name="image" id="image">
                <label for="image" class="custom-file-label">Select image</label>


                <div id="existing_img">
                    <span> Existing Imgae: </span>
                    <span> <img id="img" alt="" style="border: 1px solid gray" width="170px" height="70" class="mb-2"></span>
                </div>

                <span id="image_error" class="text-danger"></span>


            </div>

            <div class="form-group mb-3">
                <label for="title">Post Title</label>
                <input class="form-control" type="text" name="title" id="title">
                <span id="title_error" class="text-danger"></span>
            </div>

            <div class="form-group mb-3">
                <label for="bookAuthor">Author Name</label>
                <input class="form-control" type="text" name="bookAuthor" id="bookAuthor">
                <span id="author_error" class="text-danger"></span>
            </div>

            <div class="form-group mb-3">
                <label for="category">Choose Category</label>
                <select class="form-control" name="category" id="category">
                    <option disabled>Category</option>
                    <?php

                    $res = $category->readCategory();

                    while ($r = $res->fetch()) {
                    ?>
                        <option value="<?php echo $r['title'] . '_' . $r['id'];  ?>"><?php echo $r['title']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <input type="hidden" id="" value="idCategorySelected" />
                <label for="category">Choose Sub-Category</label>
                <select class="form-control" name="subcategory" id="subcategory">

                </select>
            </div>






            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" rows="10" cols="" name="description" id="description"></textarea>
                <span id="description_error" class="text-danger"></span>

            </div>

            <div class="form-group mb-3">
                <label for="excerpt"> Excerpt</label>
                <textarea class="form-control" rows="10" cols="" name="excerpt" id="excerpt">


                <u>All rights reserved for the author &copy; </u>
                </textarea>


            </div>


            <div class="form-group mb-3">
                <label for="contents"> Table of contents</label>
                <textarea class="form-control" rows="10" cols="" name="contents" id="contents"></textarea>


            </div>

            <h2>SEO</h2>

            <div class="form-group mb-3">
                <label for="seo_description">seo-Description</label>
                <textarea class="form-control" rows="10" cols="" name="seo_description" id="seo_description"></textarea>
                <span id="seo_description_error" class="text-danger"></span>


            </div>


            <!-- </div> -->

            <!-- Modal Footer -->
            <!-- <div class="modal-footer"> -->
            <input type="hidden" id="idPost" name="idPost">

            <input type="hidden" id="idAdmin" name="idAdmin" value="<?php echo  $_SESSION['idAdminConnected']; ?>">

            <input type="hidden" id="nameAdmin" name="nameAdmin" value="<?php echo $_SESSION['usernameAdminConnected']; ?>">

            <input type="hidden" id="action" name="action" value="add">



            <!-- <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-primary" id="action_button">Add</button>

        </form>
    </div>


</section>


<script>
    $(document).ready(function() {

        $("#existing_img").hide();

        $("#image").attr("required", true);



        $("#myForm")[0].reset();



        // $(".text-danger").text("");



        //Display Sub-categories depend on the category

        $('#category').on("change", function() {
            // alert($('#category').val())
            const val = $('#category').val();
            const cat_val = val.split('_');
            const id = cat_val[1]
            const category = cat_val[0]


            $('#subcategory').html("")

            // alert()
            $.ajax({
                url: "adminPanel/ajaxResponses/categories.php",
                type: "POST",
                data: {
                    id: id,
                    // category: category
                    type: 'display_sub_category_belong_to_category'
                },
                // contentType: false,
                // processData: false,
                dataType: "html",

                success: function(data) {
                    // console.log(data);
                    $('#subcategory').append(data)

                }
            })

        })




        $("#myForm").on("submit", function(event) {
            event.preventDefault();

            let form_data = new FormData();

            let title = $("#title").val();
            let bookAuthor = $("#bookAuthor").val();
            let description = $("#description").val();
            // let category = $("#category").val();

            let val = $('#category').val();
            let cat_val = val.split('_');
            // const id = cat_val[1]
            let category = cat_val[0]

            let subcategory = $('#subcategory').val();



            let excerpt = $("#excerpt").val();
            let contents = $("#contents").val();


            let seo_decription = $('#seo_description').val();


            let file_data = $(".img").prop("files")[0];
            form_data.append("file", file_data);

            let idAdmin = $("#idAdmin").val();
            let nameAdmin = $("#nameAdmin").val();
            // alert(nameAdmin)

            let action = $("#action").val();


            let idPost = $("#idPost").val();

            form_data.append("title", title);
            form_data.append("bookAuthor", bookAuthor);
            form_data.append("description", description);
            form_data.append("category", category);
            form_data.append("subcategory", subcategory);

            form_data.append("idAdmin", idAdmin);
            form_data.append("nameAdmin", nameAdmin);
            form_data.append("action", action);
            form_data.append("idPost", idPost);

            form_data.append("excerpt", excerpt);
            form_data.append("contents", contents);

            form_data.append('seo_description', seo_decription)
            // console.log(form_data)
            $.ajax({
                url: "adminPanel/ajaxResponses/add_edit_delete_post.php",
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                dataType: "JSON",

                success: function(data) {

                    console.log('add post response', data);

                    if (data.error) {
                        if (data.error.image_error) {
                            $("#image_error").text(data.error.image_error);
                        } else {
                            $("#image_error").text("");
                        }
                        if (data.error.title_error) {
                            $("#title_error").text(data.error.title_error);
                        } else {
                            $("#title_error").text("");
                        }
                        if (data.error.author_error) {
                            $("#author_error").text(data.error.author_error);
                        } else {
                            $("#author_error").text("");
                        }
                        if (data.error.description_error) {
                            $("#description_error").text(data.error.description_error);
                        } else {
                            $("#description_error").text("");
                        }
                        if (data.error.seo_description_error) {
                            $("#seo_description_error").text(data.error.seo_description_error);
                        }

                        return;
                    } else if (data.success) {
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");

                        $("#message").text(data.success.added);

                        $('.text-danger').text('');

                        $("#myForm")[0].reset();

                    }
                },
            });
        });

    });
</script>

<?php require_once APPROOT . '/include/footer_admin.php';  ?>