
    
    $(document).ready(function() {

        // Newsletter

        $('#button-addon1').click(function() {
            let email = $('#email').val()
            // alert(email)
            $.ajax({
                url: 'ajax_responses/add_email_newsletter.php',
                type: 'POST',
                data: {
                    email: email,
                },
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);


                    if (data.error) {
                        $('#err_msg').text(data.error)

                    } else if (data.success) {
                        // alert()
                        // console.log(data.success);
                        if (data.success.added) {

                            $('#err_msg').text('')

                            $('#success_msg').text(data.success.added);

                        }



                        if (data.success.error) {
                            $('#err_msg').text(data.success.error)

                            $('#success_msg').text('')


                        }

                    }

                }




            })

        })
    })