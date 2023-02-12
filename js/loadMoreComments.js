$(document).ready(function () {
  $(".moreComments").on("click", function () {
    let id_post = $("#idPost").val();

    let last_comment = $(this).data("id");

    $.ajax({
      url: "./ajax_responses/display_more_comments.php",
      method: "POST",
      data: {
        last_comment: last_comment,
        id_post: id_post,
      },
      dataType: "text",
      beforeSend: function () {
        $("#moreComments").html("Loading...");
      },
      success: function (data) {
        setTimeout(function () {
          if (data != "") {
            $("#remove_row").remove();
            $("#moreComments").remove();
            $("#result_comments").append(data);
          } else {
            // $('#load_more').html('No Data Found!');
            $("#remove_row").append(data);
          }
        }, 500);
      },
    });
  });
});
