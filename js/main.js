// Pure js
const nav = document.querySelector(".nav"),
  searchIcon = document.querySelector("#searchIcon"),
  navOpenBtn = document.querySelector(".navOpenBtn"),
  navCloseBtn = document.querySelector(".navCloseBtn");

searchIcon.addEventListener("click", () => {
  nav.classList.toggle("openSearch");
  nav.classList.remove("openNav");
  if (nav.classList.contains("openSearch")) {
    return searchIcon.classList.replace("uil-search", "uil-times");
  }
  searchIcon.classList.replace("uil-times", "uil-search");
});

navOpenBtn.addEventListener("click", () => {
  nav.classList.add("openNav");
  nav.classList.remove("openSearch");
  searchIcon.classList.replace("uil-times", "uil-search");
});
navCloseBtn.addEventListener("click", () => {
  nav.classList.remove("openNav");
});










  




// Lazy Loadin
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.remove("blur");
      }
    });
  });
  
  document.querySelectorAll("img.lazy").forEach((image) => {
    observer.observe(image);
  });








  // Sub-categories JS (for handle the dropdowns )
const categories = document.querySelector("#categories");
const categoryLis = categories.querySelectorAll("li");
categoryLis.forEach(function (li) {
  const subcategories = li.querySelector(".subcategories");
  const icon = li.querySelector(".fa");

  if (subcategories) {
    li.addEventListener("click", function (event) {
      // Hide any open subcategories
      const openSubcategories = categories.querySelectorAll(
        ".subcategories:not(.hidden)"
      );
      subcategories.classList.add("hover");

      openSubcategories.forEach(function (el) {
        el.classList.add("hidden");
      });

      // Toggle the clicked subcategory
      subcategories.classList.toggle("hidden");
      // icon.classList.toggle('fa-caret-down');
      // icon.classList.toggle('fa-caret-up');
    });
  }
});

// **************************************** jQuery Stufs

// Display Comments Function
function read_comment() {
  //read comments data
  let id_post = $("#idPost").val();
  // LAST COMMENT
  // let last_comment = $(this).data('id');

  $.ajax({
    url: "./ajax_responses/display_comments.php",
    type: "POST",
    data: {
      id: id_post,
    },
    beforeSend: function () {
      $("#result_comments").html(
        '<img src="./css/loader.gif" width=100  style="  display: block; margin-left: auto; margin-right: auto;">'
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

  $("#name")
    .on("change", function () {
      $(".data").hide();
      $("#" + $(this).val()).fadeIn(500);
    })
    .change();

  read_comment();

  // $('#comment_area').hide();
  // $('#ErrorMessage').hide();
  //     $('#SuccessMessage').hide();

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

      // dataType: 'text',

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
$(document).ready(function () {
  // $('#SuccessMessage').hide();



  // Search bar ajax

  // hide search search div when clicking outside
  $(document).mouseup(function (e) {
    var container = $("#search_result");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.hide();
      // $('#search_input').removeClass('foc');
    }
  });

  // *** Search suing Search bar ***
  $("#search-input").keyup(function () {
    let search = $(this).val();

    // console.log('sear', search);

    // setTimeout(() => {

    $.ajax({
      url: "./ajax_responses/autocomplete_search_bar.php",
      type: "POST",
      data: {
        // Key:Value
        searchKey: search,
        action: "search_bar",
      },
      // beforeSend: function() {
      //     $('#search_result').html('Loading..');

      // },
      success: function (data) {
        if (!data.error) {
          $("#search_result").html(data);
          $("#search_result").show();
        }
      },
    });
    // }, 1000);
  }); //search code ends







  
  // Newsletter

  $("#button-addon1").click(function () {
    let email = $("#email").val();
    // alert(email)
    $.ajax({
      url: "ajax_responses/add_email_newsletter.php",
      type: "POST",
      data: {
        email: email,
      },
      dataType: "JSON",
      success: function (data) {
        // console.log(data);

        if (data.error) {
          $("#err_msg").text(data.error);
        } else if (data.success) {
          // alert()
          // console.log(data.success);
          if (data.success.added) {
            $("#err_msg").text("");

            $("#success_msg").text(data.success.added);
          }

          if (data.success.error) {
            $("#err_msg").text(data.success.error);

            $("#success_msg").text("");
          }
        }
      },
    });
  });





  // hide search search div when clicking outside
$(document).mouseup(function (e) {
    var container = $("#search_result");
  
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.hide();
      $("#search_input").removeClass("foc");
    }
  });
  
  // *** Search suing Search bar ***
  $("#search").keyup(function () {
    let search = $("#search").val();
  
    // setTimeout(() => {
  
    $.ajax({
      url: "./ajax_responses/autocomplete_search_bar.php",
      type: "POST",
      data: {
        // Key:Value
        searchKey: search,
        action: "search_bar",
      },
      // beforeSend: function() {
      //     $('#search_result').html('Loading..');
  
      // },
      success: function (data) {
        if (!data.error) {
          $("#search_result").html(data);
          $("#search_result").show();
        }
      },
    });
    // }, 1000);
  }); //search code ends
  

});







