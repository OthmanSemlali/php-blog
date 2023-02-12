function delete_admin() {
  $(document).on("click", ".del", function () {
    let id = $(this).attr("data-id");

    let admin_connected = $("#admin_connected").val();
    // alert(admin_connected)

    if (admin_connected == "uthmeene") {
      // alert(id)

      if (confirm("Are you sure you want to DELETE Admin?")) {
        $.ajax({
          url: "./adminPanel/ajaxResponses/manageadmins.php",
          method: "POST",
          data: {
            id: id,
            type: "delete_admin",
          },
          success: function (data) {
            if (!data.error) {
              $("#message").text(data);

              display_admins();
            } else {
              alert("Something Went Wrong.Try later!");
            }
          },
        });
      }
    } else {
      alert('You Need Administrator Permission To "Delete" Action');
    }
  });
}

function add_admin() {
  $("#myForm").submit(function () {
    let data = $("#myForm").serialize();

    $.ajax({
      url: "./adminPanel/ajaxResponses/manageadmins.php",
      type: "POST",
      data: data,
      dataType: "json",

      success: function (data) {
        if (data.error) {
          if (data.error.username_error) {
            $("#username_error").text(data.error.username_error);
          } else {
            $("#username_error").text("");
          }

          if (data.error.pass1_error) {
            $("#pass1_error").text(data.error.pass1_error);
          } else {
            $("#pass1_error").text("");
          }

          if (data.error.pass2_error) {
            $("#pass2_error").text(data.error.pass2_error);
          } else {
            $("#pass2_error").text("");
          }
        } else {
          display_admins();

          $(".modal").modal("hide");

          $("#message").text(data.success);

          $("#myForm")[0].serialize();

          $(".text-danger").text("");
        }

        // return false;
      },
    });

    return false;
  });
}

// ************************** aprove admins **********************

$("#approve").on("click", function () {
  $("#myForm")[0].reset();

  $(".text-danger").text("");

  $("#modal_approve").modal("show");
});

function display_request() {
  $.post(
    "./adminPanel/ajaxResponses/manageadmins.php",
    { type: "display_request" },
    function (data) {
      if (!data.error) {
        $("#display_request_admins").html(data);
      }
    }
  );
}

function delete_request() {
  $(document).on("click", ".delete_request", function () {
    let id = $(this).attr("data-id");

    // let admin_connected = $('#admin_connected').val();

    if (confirm("Are you sure you want to DELETE this request?")) {
      $.ajax({
        url: "./adminPanel/ajaxResponses/manageadmins.php",
        method: "POST",
        data: {
          id: id,
          type: "delete_request",
        },
        success: function (data) {
          if (!data.error) {
            $("#messagee").text(data);

            display_request();
          } else {
            alert("Something Went Wrong");
          }
        },
      });
    }
  });
}

function approve_request() {
  $(document).on("click", ".approve_request", function () {
    let id = $(this).attr("data-id");

    let email = $(this).attr("rel");

    let admin_connected = $("#admin_connected").val();

    $.ajax({
      url: "./adminPanel/ajaxResponses/manageadmins.php",
      method: "POST",
      data: {
        id: id,
        approved_by: admin_connected,
        email: email,
        type: "approve_request",
      },

      beforeSend: function () {
        $("#messagee").html("<h5>Processing, please wait ...</h5>");
      },

      success: function (data) {
        if (!data.error) {
          $("#messagee").text(data);

          display_request();
          display_admins();
        } else {
          alert(data);
        }
      },
    });
  });
}

function display_admins() {
  $.post(
    "./adminPanel/ajaxResponses/manageadmins.php",
    { type: "display_admins" },
    function (data) {
      if (!data.error) {
        $("#result").html(data);
      }
    }
  );
} // display ends

function show_modal() {
  $("#add").on("click", function () {
    // $('.modal').show()

    $("#myForm")[0].reset();

    $(".text-danger").text("");

    $("#modall").modal("show");
  });
}

$(document).ready(function () {
  delete_admin();
  add_admin();
  display_request();
  delete_request();
  approve_request();

  display_admins();
  show_modal();
});
