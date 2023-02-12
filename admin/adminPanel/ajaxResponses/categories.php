<?php

require_once('../../include/model.php');




function display()
{
    $category = new categoriesData();
    $post = new postsData();


    $res = $category->readCategory();
    if ($res->rowCount() > 0) :
        while ($r = $res->fetch()) :
            $count_posts = $post->totalPostByCategory($r['title']);

?>
            <option value="<?php echo $r['id'] . '_' . $r['title']; ?>"><?php echo $r['title']; ?> <?php echo "----" . $count_posts . " Post"; ?></option>
        <?php

        endwhile;
    else :

        ?>
        <option value="">No Category Found!</option>
<?php

    endif;
}


function display_sub_categories()
{
    $subcategory = new subcategoryData();

    $category_id = intval($_POST['category_id']);
    $res = $subcategory->displaySubCategoriesOfCategory($category_id);

    while ($row = $res->fetch()) {
        echo "<li id='dd' class='dd' data-id='" . $row['id'] . "'>" . $row['NAME'] . "<span class='text-danger btn del_sub'>Delete Sub-category</span></li>";
    }
}

function insert()
{

    $category = new categoriesData();

    $title = trim($_POST['title']);
    $author = $_POST['admin'];
    $description = trim($_POST['description']);

    $res = $category->addCategory($title, $description, $author);

    if ($res) {
        return true;
    } else {
        die('Something went wrong. Refrech the page');
    }
}

function insert_sub_category()
{
    $subcategory = new subcategoryData();

    $name = trim($_POST['sub_category_title']);
    $description = $_POST['sub_category_description'];
    $category_id = $_POST['category_id'];

    $res = $subcategory->addSubCategory($name, $description, $category_id);

    if ($res) {
        return true;
    } else {
        die('Something went wrong. Refrech the page');
    }
}



function delete()
{

    $category = new categoriesData();

    $idCategory = $_POST['id'];

    $res = $category->delete($idCategory);

    if ($res) {

        return true;
    } else {
        die('Something went wrong. Refrech the page');
    }
}

function delete_sub_category()
{
    $subcategory = new subcategoryData();

    $idSubCategory = $_POST['id'];

    $res = $subcategory->delete($idSubCategory);

    if ($res) {

        return true;
    } else {
        die('Something went wrong. Refrech the page');
    }
}

function display_sub_category_belong_to_category()
{



    $subcategory = new subcategoryData();

    // $category = $_POST['category'];
    $category_id = $_POST['id'];

    $res = $subcategory->displaySubCategoriesOfCategory($category_id);


    if ($res->rowCount() > 0) :
        while ($row = $res->fetch()) {

            echo "<option value='" . $row['NAME'] . "'>" . $row['NAME'] . "</option>";
        }
    else :
        echo "There's no sub-category for this category";

    endif;
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') :

    switch ($_POST['type']) {


        case 'insert':

            insert();
            break;

        case 'delete':

            delete();
            break;

        case 'insert_sub_category':
            insert_sub_category();
            break;

        case 'display_sub_categories':
            display_sub_categories();
            break;

        case 'delete_sub_category':
            delete_sub_category();
            break;


        case 'display_sub_category_belong_to_category':
            display_sub_category_belong_to_category();
            break;

        default:
            display();
            break;
    }


endif;

?>
<script>
    // Delete sub Categories
    $('.dd').click('click', function() {



        // let id = $('#selected_id').text()
        let id = $(this).data('id')
        if (confirm('Are you sure you want to delete?')) {


            $.ajax({
                url: './adminPanel/ajaxResponses/categories.php',

                method: 'POST',
                data: {
                    id: id,
                    type: 'delete_sub_category'

                },
                success: function(data) {
                    if (!data.error) {
                        $('#message').show();

                        $('#message').text('Sub-Category Deleted Successfully');
                        // alert(data)

                        setTimeout(() => {
                            // $('#message').hide();
                            $('#message').hide();
                        }, 4000);

                        $('#row').hide()


                        // delete_sub_category();

                    } else {
                        $('#message_error').text("Something Went Wrong!");

                    }

                }
            })

        }

    })
</script>