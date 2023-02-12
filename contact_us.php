<?php
require_once 'include/header.php';

?>


<?php

require_once APPROOT . '/include/nav.php';

?>

<div class="container">

    <div class="left">
        <span id="message"></span>

        <div class="about-us contactus">






            <h1> Get in touch with us</h1>
            <br>

            <div>
                Welcome to the Contact Us page of our book review website, Bookyreview. We are always happy to hear from our readers and users. If you have any questions, comments, or concerns about our website or services, please don't hesitate to reach out to us.
                <br>
                You can contact us by emailing us at <b>contact@bookyreview.space</b>. We will do our best to respond to your inquiry as soon as possible.
                <br>
                Alternatively, you can also contact us by filling out the contact form provided on this page. Please provide your name, email address, and a brief message describing your inquiry.
                <br>
                <br>
                Thank you for choosing Bookyreview. We look forward to hearing from you!
            </div>
            <br>


            <div>


                <form method="POST" id="form_contact">


                    <div class="form-group">
                        <label for="fullname">Full name <span>*</span></label>
                        <input class="form-control" type="text" name="fullname" id="fullname">
                        <small class="err" id="fullname_error"></small>

                    </div>


                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input class="form-control" type="text" name="email" id="email">
                        <small class="err" id="email_error"></small>

                    </div>

                    <div class="form-group">
                        <label for="message">Message <span>*</span></label>
                        <textarea name="message" id="mes" cols="42" rows="10"></textarea>
                        <small class="err" id="message_error"></small>

                    </div>


                    <div class="mb-2 mt-4">
                        <button class="gradient button" type="submit" name="submit" id="submit_btn">
                            Continue
                        </button>
                    </div>

                </form>


            </div>



        </div>






    </div>

    <div class="rightt">
        <?php require_once "sideArea.php"; ?>

    </div>
</div>




<?php require_once APPROOT . '/include/footer.php';  ?>



<script>
    $(document).ready(function() {


        $('#form_contact').on('submit', function(event) {
            event.preventDefault()


            // let data = $('#form_inscription').serialize();

            let fullname = $('#fullname').val();
            let email = $('#email').val();
            let message = $('#mes').val();

            // alert(message);return
            $.ajax({
                url: './ajax_responses/contact_response.php',
                type: 'POST',
                data: {
                    email: email,
                    fullname: fullname,
                    message: message
                    // submit: 'submit'
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#submit_btn').text('Processing...')

                },
                success: function(data) {



                    if (data.error) {
                        $('#submit_btn').text('Continue');


                        if (data.error.fullname_error) {

                            $('#fullname_error').text(data.error.fullname_error)
                        } else {
                            $('#fullname_error').text('')
                        }


                        if (data.error.email_error) {

                            $('#email_error').text(data.error.email_error)
                        } else {
                            $('#email_error').text('')

                        }


                        if (data.error.message_error) {

                            $('#message_error').text(data.error.message_error)
                        } else {
                            $('#message_error').text('')

                        }



                    } else {



                        setTimeout(() => {

                            if (data.success.valid) {
                                $('.text-danger').text('');


                                $('#message').html('<div class="success-msg">  <i class="fa fa-check"></i> ' + data.success.valid + '</div>');

                                $('#submit_btn').text('Continue');

                            }

                            $('#form_contact')[0].reset();
                            $('.err').text('');

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

</body>

</html>