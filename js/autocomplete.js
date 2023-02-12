$(document).ready(function() {

    // hide search search div when clicking outside
    $(document).mouseup(function(e) {
        var container = $("#search_result");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
            // $('#search_input').removeClass('foc');

        }
    });


    // *** Search suing Search bar ***
    $('#search-input').keyup(function() {


        let search = $(this).val();

        // console.log('sear', search);

        // setTimeout(() => {

        $.ajax({
            url: './ajax_responses/autocomplete_search_bar.php',
            type: 'POST',
            data: {
                // Key:Value
                searchKey: search,
                action: 'search_bar'
            },
            // beforeSend: function() {
            //     $('#search_result').html('Loading..');


            // },
            success: function(data) {

                if (!data.error) {
                    $('#search_result').html(data);
                    $('#search_result').show();

                }


            }

        })
        // }, 1000);

    }) //search code ends

});