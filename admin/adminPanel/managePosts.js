// Display all posts in table
function display_all_record() {
  $.ajax({
    url: "./adminPanel/ajaxResponses/display_records.php",
    type: "POST",
    dataType: "text",
    data: {
      type: "all_record",
    },
    success: function (data) {
      if (data != "") {
        $("#result_all_record").html(data);
      }
    },
  });
} //Function Ends

// Function for pagination table
function pagination() {
  $(".pagintion_link").on("click", function () {
    let page = $(this).data("id");
    $.ajax({
      url: "./adminPanel/ajaxResponses/display_records.php",
      type: "POST",
      dataType: "text",
      data: {
        type: "all_record",
        page: page,
      },
      success: function (data) {
        $("#result_all_record").html(data);
      },
    });
  });
} // pagination ends

//Function for serach using search bar
function searchBar() {
  // *** Search suing Search bar ***
  $("#search_bar").keyup(function () {
    let search = $("#search_bar").val();

    $.ajax({
      url: "./adminPanel/ajaxResponses/display_records.php",

      type: "POST",
      data: {
        // Key:Value
        type: "all_record",
        search: search,
      },
      success: function (data) {
        if (!data.error) {
          $("#result_all_record").html(data);
        }
      },
    });
  });
} //search code ends

// Function for select number of rows show in Table
function read_by_limit_selected() {
  $("#pages").on("change", function () {
    let selected_option_value = $(this).find(":selected").val();

    $.post(
      "./adminPanel/ajaxResponses/display_records.php",
      {
        selected: selected_option_value,
        type: "all_record",
      },
      function (data) {
        $("#result_all_record").html(data);
      }
    );
  });
} // Function ends

// Delete post Function
function delete_post() {
  $(document).on("click", ".del", function () {
    var id = $(this).data("id");
    var action = "delete";

    if (confirm("Are you sure you want to DELETE?")) {
      $.ajax({
        url: "./adminPanel/ajaxResponses/add_edit_delete_post.php",
        method: "POST",
        data: {
          id: id,
          action: action,
        },
        dataType: "JSON",
        success: function (data) {
          $("#message").html(
            '<div class="alert alert-success">' + data.success + "</div>"
          );
          display_all_record();

         
        },
      });
    }
  });
} // Delete Function Ends

// Show modal after click edit btn
function edit_post() {} // Edit Post Function Ends

$(document).ready(function () {
  display_all_record();

  pagination();

  searchBar();

  read_by_limit_selected();

  delete_post();

  add_post();

  edit_post();

  submit();
});
