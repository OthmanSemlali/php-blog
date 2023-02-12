<?php

require_once 'include/nav-admin.php';

//! If you want to make the side area dynamic, read its info from db in the side area page. bcs at this time side area content is static



?>

<body>


    <br>
    <div class="container" style=" display:flex;">


        <div class="col-lg-6">
            <div class="container">
                <h4>Edite</h4>
                <span id="message" class="text-success"></span>
                <hr>

                <form action="" id="myForm" method="POST" enctype="multipart/form-data">


                    <div class="form-group">
                        <input name="file" type="file" id="file" class="form-control image" placeholder="Select image">
                    </div>


                    <div class="form-group">
                        <label for="myText">Text:</label>

                        <textarea name="text" id="myText" cols="30" rows="10" class="form-control"></textarea>

                    </div>

                    <input type="button" id="submit" class="form-control btn btn-primary" value="Confirm Change">
                </form>

            </div>
        </div>


        <div class="col-lg-6 col-lg-offset-6">
            <div class="container">
                <h4>Output</h4>

                <hr>


                <div class="card login-wrap col-lg-9" style="margin-left: 12%;">
                    <div class="card-body">



                        <div id="uploaded_image">

                            <!-- Output image here -->

                        </div>


                        <div class="text-dark " id="text">

                            <!-- Output text here -->

                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>



    <script>
        $(document).ready(function() {

            $(document).on('change', '#file', function() {

                let property = document.querySelector('#file').files[0];

                let image_name = property.name;

                let image_extension = image_name.split('.').pop().toLowerCase();

                let image_size = property.size;

                if (image_size > 2000000) {
                    alert('Your file is too large')
                }
                if (image_extension == 'rar' || image_extension == 'mp4' || image_extension == 'mp3') {
                    alert('You cant upload file of this type')

                } else {

                    let form_data = new FormData();

                    form_data.append('file', property);
                    form_data.append('action', 'file');


                    $.ajax({

                        url: './adminPanel/ajaxResponses/update_left_side.php',
                        method: 'POST',
                        data: form_data,
                        dataType: 'text',
                        contentType: false,
                        processData: false,
                        cache: false,

                        beforeSend: function() {

                            $('#uploaded_image').html("<h5>Image uploading...</h5>")
                        },
                        success: function(data) {

                            $('#uploaded_image').html(data)


                        }


                    })
                }
            })




            $('#myText').keyup(function() {



                let myText = $('#myText').val();

                $.ajax({

                    url: './adminPanel/ajaxResponses/update_left_side.php',
                    method: 'POST',
                    data: {
                        myText: myText,
                        action: 'text'
                    },

                    success: function(data) {
                        $('#text').html(data);

                    }
                })

            })
            // return false;


            $('#submit').click(function(evt) {

                evt.preventDefault();

                let form_data = new FormData();

                let property = document.querySelector('#file').files[0];


                let myText = $('#myText').val()


                form_data.append('file', property);
                form_data.append('myText', myText);
                form_data.append('action', 'submit');



                $.ajax({

                    url: './adminPanel/ajaxResponses/update_left_side.php',
                    method: 'POST',
                    dataType: 'TEXT',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    cache: false,


                    beforeSend: function() {
                        $('#submit').val('Please Wait...');
                    },
                    success: function(data) {
                        // $('#text').html(data);




                        $('#message').text(data)
                        $('#submit').val('Changes confirmed');

                        $('#myForm')[0].reset();







                    },


                })






                return false;
            })




        })
    </script>

    <?php require_once APPROOT . '/include/footer_admin.php';  ?>