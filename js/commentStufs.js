

// Display Comments Function
function read_comment() {
  //read comments data
  let id_post = $("#idPost").val();
  

  $.ajax({
    url: "./ajax_responses/display_comments.php",
    type: "POST",
    data: {
      id: id_post,
    },
    beforeSend: function () {
      $("#result_comments").html(
        '<img alt="Loading.." src="./styles/loader.gif" width=100  style="display: block; margin-left: auto; margin-right: auto;">'
        // "Loading.."
      );
    },
    success: function (data) {
      if (!data.error) {
        setTimeout(() => {
          $("#result_comments").html(data);
          // $('#leegend').show();
        }, 2000);
      } else {
        // $('#leegend').hide();
      }
    },
  });
} //Ends Display comments()

// get count comments function
function get_count_comment_one_post() {
  let id = $("#id_post_hide").val();
  // alert(id)

  $.ajax({
    url: "./ajax_responses/count_comments_post.php",
    method: "POST",
    data: {
      id: id,
    },
    success: function (data) {
      if (!data.error) {
        $(".count").html(data);
        // alert(data);
      }
    },
  });
} //ends  function Count cmnt one post

$(document).ready(function () {



  $("#name")
    .on("change", function () {
      $(".data").hide();
      $("#" + $(this).val()).fadeIn(500);
    })
    .change();

  read_comment();


  // Show Comments Area
  $("#AddComment").on("click", function () {
    $("#comment_area").show();
    $(this).hide();
    $("#err_msg_comments").text("");
  });

  // Cancel Btn
  $("#close").on("click", function () {
    $("#comment_area").hide();
    $("#AddComment").show();
    $("#form_comments")[0].reset();
    $("#email_error").hide();
  });

  // $('#commentSubmit').on('click', function(event) {
  $("#form_comments").on("submit", function (event) {
    event.preventDefault();

    // let url = $('#form_comments').attr('action');
    // let p = $('#form_comments').attr('rel');
    // let name = $('input[name="nameUser"]').val();
    // let email = $('input[name="emailUser"]').val();
    // let comment = $('input[name="comment"]').val();

    let data = $("#form_comments").serialize();

    // alert(name)
    $.ajax({
      url: "./ajax_responses/add_comments.php",
      method: "POST",
      data: data,
      dataType: "JSON",

      success: function (data) {
        if (!data.error) {
          get_count_comment_one_post();

          $("#SuccessMessage").html(
            "<i class='fa fa-check'></i> " + data.success
          );
          $("#SuccessMessage").show();

          // Display Comments Before Adding Comment
          read_comment();

          $("#form_comments")[0].reset();

          $("#comment_area").hide();
          $("#AddComment").show();

          $("html, body").animate(
            {
              scrollTop: "0px",
            },
            0
          );

          $("#email_error").hide();
          $("#comment_error").hide();

          setTimeout(() => {
            $("#SuccessMessage").hide();
          }, 2000);
        }
        if (data.error) {
          // alert(data.error.email_error)
          if (data.error.email_error) {
            $("#email_error").show();
            $("#email_error").text(data.error.email_error);
          } else {
            $("#email_error").hide();
          }

          if (data.error.comment_error) {
            $("#comment_error").show();
            $("#comment_error").text(data.error.comment_error);
          } else {
            $("#comment_error").text("");
          }
        }
      },
    });
  });

  // get_count_post();

  get_count_comment_one_post();

});
