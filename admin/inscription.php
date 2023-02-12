<?php


require_once('include/config.php');

require_once(APPROOT . '/include/model.php');
require_once(APPROOT . '/include/functions.php');
require_once(APPROOT . '/include/session.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link type="text/css" rel="stylesheet" href="./css/style.css"> -->
    <link rel="stylesheet" type="text/css" href="css/main-style.css" />

    <link type="text/css" rel="stylesheet" href="css/login-style.css">

    <link type="text/css" rel="stylesheet" href="css/inscription-style.css">



    <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title>Join Us | Bookyreview</title>

    <meta name="description" content="Our website provides in-depth book reviews and excerpts to help you decide which titles are worth your time and money. We also offer detailed table of contents for each book so you can get a better understanding of the structure and content of the book before you dive in. Our goal is to make your reading experience as enjoyable and informed as possible. Whether you're looking for a new book to add to your to-read list or just want to browse through some reviews, we've got you covered." />

    <meta property="og:title" content="<?php echo SITENAME; ?> | Find the Best Book Reviews on Our Website" />

    <meta property="og:url" content="<?php echo URLROOT; ?>" />
    <meta property="og:site_name" content="<?php echo SITENAME; ?>" />

    <style>
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
    </style>

<body>
    <div class="inscription-wrapper">


        <div id="message" class='login-alert '>

        </div>


        <div class="inscription">
            <!-- <span id="message" class="text-info">hh</span> -->

            <div class="login-logo">

                <div>
                    <a href="https://bookyreview.space/">

                        <span class="booky">Booky</span><span class="review">review</span>
                    </a>

                </div>

            </div>

            <div class="inscription-forms">

                <form method="POST" id="form_inscription">

                    <div class="form-groups-inscription">

                        <div class="form-group">



                            <label for="username">Username </label>
                            <input class="form-control" type="text" name="username" id="username">
                            <small class="err " id="username_error"></small>
                        </div>


                        <div class="form-group">


                            <label class="text-muted" for="fullname">Full Name
                                <small class="text-muted">(Optional)</small>

                            </label>
                            <input class="form-control" type="text" name="fullname" id="fullname">


                        </div>

                        <div class="form-group">


                            <label for="email">Email </label>
                            <input class="form-control" type="text" name="email" id="email">
                            <small class="err" id="email_error"></small>

                        </div>

                        <div class="form-group">


                            <labelfor="pass1">Password </labelfor=>
                                <input class="form-control" type="password" name="pass1" id="pass1">
                                <small class="err" id="pass1_error"></small>
                        </div>

                        <div class="form-group">



                            <label for="pass2">Confirm Password </label>
                            <input class="form-control " type="password" name="pass2" id="pass2">
                            <small class="err " id="pass2_error"></small>
                        </div>
                        <div class="login-btn">
                            <button type="submit" name="submit" class="form-control gradient" id="submit_btn">
                                Continue
                            </button>
                        </div>
                    </div>

                </form>
            </div>


        </div>
        <div class="newt-to">
            <span>Already have an account?
            </span>

            <span>
                <a href="<?php echo URLROOT . 'login.php' ?>"><u> Sign In now</u></a>

            </span>

        </div>
    </div>




</body>

</html>





<script>
    $(document).ready(function() {


        $('#form_inscription').on('submit', function(event) {
            event.preventDefault()


            // let data = $('#form_inscription').serialize();

            let username = $('#username').val();
            let email = $('#email').val();
            let fullname = $('#fullname').val();
            let pass1 = $('#pass1').val();
            let pass2 = $('#pass2').val();



            $.ajax({
                url: './ajax_responses/inscription_response.php',
                type: 'POST',
                data: {
                    username: username,
                    email: email,
                    fullname: fullname,
                    pass1: pass1,
                    pass2: pass2,
                    // submit: 'submit'
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#submit_btn').text('Processing...')

                },
                success: function(data) {



                    if (data.error) {
                        $('#submit_btn').text('Continue');


                        if (data.error.username_error) {

                            $('#username_error').text(data.error.username_error)
                        } else {
                            $('#username_error').text('')
                        }


                        if (data.error.email_error) {

                            $('#email_error').text(data.error.email_error)
                        } else {
                            $('#email_error').text('')

                        }


                        if (data.error.pass1_error) {

                            $('#pass1_error').text(data.error.pass1_error)
                        } else {
                            $('#pass1_error').text('')

                        }

                        if (data.error.pass2_error) {


                            $('#pass2_error').text(data.error.pass2_error)
                        } else {
                            $('#pass2_error').text('')

                        }


                    } else {
                        $('.err').text('')



                        setTimeout(() => {

                            if (data.success.valid) {
                                $('.text-danger').text('');


                                $('#message').html("<div class='login-alert success-msg'> <i class='fa fa-info-circle'></i> " + data.success.valid + "</div>");


                                $('#submit_btn').text('Continue');

                            }

                            $('#form_inscription')[0].reset();


                            // setTimeout(() => {
                            //     $('#message').html('');
                            // }, 5000);


                        }, 2000);


                    }
                },

                // complete: function () {

                // }


            })


        })


    })
</script>

<?php require_once APPROOT . '/include/footer_admin.php';  ?>