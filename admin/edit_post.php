<?php

require_once 'include/nav-admin.php';


$id = $_GET['id'];
if ($id !=  '') {

    $res = $posts->read($id);


    $result = $category->readCategory();


    $r = $res->fetch();

    if ($res->rowCount() == 0) {
        exit('this post doesn\'t exist');
    }

    $id = $r['id'];



    $d = strtotime($r['dateTime']);
    // if (date('Y', $d) == date('Y')) {
    //     $dateTime = date('d M', $d);
    // } else {
    //     $dateTime = date('d M Y', $d);
    // }
    $title = $r['title'];
    $category = $r['category'];
    $admin = $r['author'];
    $image = $r['image'];
    $description = $r['description'];

    $author = $r['bookAuthor'];

    $excerpt = $r['excerpt'];
    $contents = $r['contents'];
    $seo_description = $r['seo_description'];
    $subcategory = $r['sub_category'];
} else {
    exit('Something wrong try again!');
}
?>



<br>

<section class="container py-4 mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URLROOT ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URLROOT ?>post.php">Manage posts</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit post</li>
        </ol>
    </nav>
    <div class="container mt-4">
        <h5 id="message" class="text-success"></h5>

        <form method="POST" id="myForm" enctype="multipart/form-data">
           
            <div class="form-group">


                <!-- //custom-file-input -->
                <input class="img" type="file" name="image" id="image">
                <label for="image" class="custom-file-label">Select image</label>
                <span id="image_error" class="text-danger"></span>

                <div id="existing_img">
                    <span> Existing Imgae: </span>
                    <span> <img src="upload/<?php echo $image ?>" id="img" alt="" style="border: 1px solid gray" width="170px" height="70" class="mb-2"></span>
                </div>

            </div>

            <div class="form-group mb-3">
                <label for="title">Post Title</label>
                <input class="form-control" type="text" name="title" id="title" value="<?php echo $title ?>">
                <span id="title_error" class="text-danger"></span>
            </div>

            <div class="form-group mb-3">
                <label for="bookAuthor">Author Name</label>
                <input class="form-control" type="text" name="bookAuthor" id="bookAuthor" value="<?php echo $author; ?>">
                <span id="author_error" class="text-danger"></span>
            </div>

            <div class="form-group mb-3">
                <label for="category">Edit Category :
                    <?php echo $category; ?>

                </label>

                <select class="form-control" name="category" id="category">
                    <?php

                    // var_dump($res);

                    while ($r = $result->fetch()) {



                    ?>
                        <option <?php if ($r['title'] == $category) {
                                    echo 'selected';
                                }  ?> value="<?php echo $r['title'] . '_' . $r['id'];  ?>"><?php echo $r['title']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>



            <div class="form-group mb-3">
                <label for="category">Edit Sub-Category :
                    <?php echo $subcategory; ?>

                </label>

                <select disabled class="form-control" name="subcategory" id="subcategory">

                </select>
            </div>



            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" rows="10" cols="" name="description" id="description"><?php echo $description ?></textarea>
                <span id="description_error" class="text-danger"></span>

            </div>

            <div class="form-group mb-3">
                <label for="excerpt"> Excerpt</label>
                <textarea class="form-control" rows="10" cols="" name="excerpt" id="excerpt"><?php echo $excerpt  ?></textarea>


            </div>


            <div class="form-group mb-3">
                <label for="contents"> Table of contents</label>
                <textarea class="form-control" rows="10" cols="" name="contents" id="contents"><?php echo $contents ?></textarea>


            </div>

            <h2>SEO</h2>

            <div class="form-group mb-3">
                <label for="seo_description">seo-Description</label>
                <textarea class="form-control" rows="10" cols="" name="seo_description" id="seo_description"><?php echo $seo_description; ?></textarea>
                <span id="seo_description_error" class="text-danger"></span>


            </div>
            <!-- </div> -->

            <!-- Modal Footer -->
            <!-- <div class="modal-footer"> -->
            <input type="hidden" id="idPost" name="idPost" value="<?php echo $id ?>">

            <input type="hidden" id="idAdmin" name="idAdmin" value="<?php echo  $_SESSION['idAdminConnected']; ?>">

            <input type="hidden" id="nameAdmin" name="nameAdmin" value="<?php echo $_SESSION['usernameAdminConnected']; ?>">

            <input type="hidden" id="action" name="action" value="edit">

            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="action_button">Edit</button>
            <!-- </div> -->
        </form>
    </div>


</section>


<script>
    $(document).ready(function() {


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

                    $('#subcategory').append(data)
                    console.log(data);




                }
            })

        })




        $("#image").attr("required", false);

        $("#existing_img").show();


        // $(".text-danger").text("");


        $("#myForm").on("submit", function(event) {
            event.preventDefault();

            let form_data = new FormData();

            let title = $("#title").val();
            let bookAuthor = $("#bookAuthor").val();
            let description = $("#description").val();


            let val = $('#category').val();
            let cat_val = val.split('_');
            // let id = cat_val[1]
            let category = cat_val[0]

            let excerpt = $("#excerpt").val();
            let contents = $("#contents").val();
            let seo_description = $('#seo_description').val();


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
            form_data.append('seo_description', seo_description);
            form_data.append("idAdmin", idAdmin);
            form_data.append("nameAdmin", nameAdmin);
            form_data.append("action", action);
            form_data.append("idPost", idPost);

            form_data.append("excerpt", excerpt);
            form_data.append("contents", contents);



            $.ajax({
                url: "adminPanel/ajaxResponses/add_edit_delete_post.php",
                type: "POST",
                data: form_data,
                contentType: false,
                processData: false,
                dataType: "JSON",

                success: function(data) {



                    console.log("result edit", data);


                    if (data.error) {

                        // console.log('Errors',data.error);

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
                        } else {
                            $("#seo_description_error").text("");
                        }

                        return;
                    }
                    if (data.success) {
                        $("html, body").animate({ scrollTop: 0 }, "slow");

                        $("#message").text(data.success.added);


                       

                        $('.text-danger').text('');




                        // remove message after 5sec
                        // setTimeout(function() {
                        //     $("#message").html("");
                        // }, 5000);
                    }
                },
            });
        });

    });
</script>

<?php require_once APPROOT . '/include/footer_admin.php';  ?>