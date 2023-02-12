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


     <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

     <title>Login | Bookyreview</title>

     <meta name="description" content="Our website provides in-depth book reviews and excerpts to help you decide which titles are worth your time and money. We also offer detailed table of contents for each book so you can get a better understanding of the structure and content of the book before you dive in. Our goal is to make your reading experience as enjoyable and informed as possible. Whether you're looking for a new book to add to your to-read list or just want to browse through some reviews, we've got you covered." />

     <meta property="og:title" content="<?php echo SITENAME; ?> | Find the Best Book Reviews on Our Website" />

     <meta property="og:url" content="<?php echo URLROOT; ?>" />
     <!-- <meta property="og:image" content="https://collegeinfogeek.com/wp-content/uploads/2018/11/Essential-Books.jpg" /> -->
     <meta property="og:site_name" content="<?php echo SITENAME; ?>" />

     <link rel="icon" type="image/x-icon" href="https://img.icons8.com/arcade/512/repository.png" />



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
     <div class="login-wrapper">


         <div id="message" class='login-alert '>

         </div>


         <div class="login">


             <div class="login-logo">


                 <div>
                     <a href="https://bookyreview.space/">

                         <span class="booky">Booky</span><span class="review">review</span>
                     </a>

                 </div>

             </div>

             <div class="login-forms">

                 <form method="POST" id="myForm">

                     <div class="form-groups">

                         <div class="form-group">



                             <label for="username">Username</label>
                             <input style="
                                 outline: none;
                            " required id="username" name="username" type="text" class="form-control">
                             <span class="err" id="username_error"></span>
                             <span class="err" id="user_error"></span>
                         </div>


                         <div class="form-group">


                             <label for="password">Password</label>

                             <input style="
                                 outline: none;
                            " required id="password" name="password" type="password" class="form-control">
                             <span id="password_error" class="err"></span>
                             <span id="pass" class="err"></span>



                         </div>
                         <div class="login-btn">
                             <button id="submit" name="submit" type="submit" class="form-control gradient">Continue</button>

                         </div>
                     </div>

                 </form>
             </div>


         </div>
         <div class="newt-to">
             <span>New to Bookyreview?
             </span>

             <span>
                 <a href="<?php echo URLROOT . 'inscription.php' ?>"><u>Create an account</u> </a>
             </span>

         </div>




 </body>

 </html>





 <script>
     $(document).ready(function() {

         $('#myForm').submit(function(event) {




             event.preventDefault();

             let data = $('#myForm').serialize();



             $.ajax({
                 data: data,
                 url: './ajax_responses/login_response.php',
                 method: 'POST',
                 dataType: 'JSON',
                 success: function(data) {
                     // console.log(data);


                     if (data.error) {

                         if (data.error.pass) {

                             $('#pass').text(data.error.pass);

                         }

                         if (data.error.user) {

                             $('#user_error').text(data.error.user)

                         } else {
                             $('#user_error').text('');
                         }
                     } else {
                         $('.err').text('')
                         if (data.success_link) {

                             window.location = "https://admin.bookyreview.space/";

                         } else if (data.success) {
                             $('#message').html("<div class='login-alert info-msg'> <i class='fa fa-info-circle'></i> " + data.success + "</div>");

                             $('#user_error').text('');
                             // $('#pass').text('');


                         }




                     }
                 }
             })





         })
     })
 </script>

 <?php require_once APPROOT . '/include/footer_admin.php';  ?>