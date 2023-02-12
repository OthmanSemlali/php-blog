<?php
require_once('../../include/model.php');



// Displaying Posts in table
// Search for Post
// Pagination table posts


function display_all_records()
{

    $posts = new postsData();
    $com = new commentsData();


    $record_per_page = 10;
    $page = '';

    if (isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $record_per_page;



    if (isset($_POST['page'])) {
        $res = $posts->showPostFrom($start_from, $record_per_page);
    } elseif (!empty($_POST['search'])) {
        $search = trim($_POST['search']);
        $res = $posts->search_bar($search);
    } elseif (isset($_POST['selected'])) {
        $until = $_POST['selected'];
        $res = $posts->read_until($until);
    } else {
        $res = $posts->readPostForPostPage();
    }


    if ($res->rowCount() > 0) {
        while ($r = $res->fetch()) :
            $id = $r['id'];

            $d = strtotime($r['dateTime']);

            if (date('Y', $d) == date('Y')) {
                $dateTime = date('d M', $d);
            } else {
                $dateTime = date('d M Y', $d);
            }

            $title = $r['title'];
            if (strlen($title) > 15) {
                $title = substr($title, 0, 15) . '...';
            }

            $category = $r['category'];
            if (strlen($category) > 10) {
                $category = substr($category, 0, 10) . '..';
            }

            $image = $r['image'];

            $bookAuthor = $r['bookAuthor'];


?>


            <tr>
                <td><?php echo $id; ?></td>
                <td>
                    <?php echo $title; ?>
                </td>
                <td><?php echo $category; ?></td>
                <td><?php echo $dateTime; ?></td>
                <td><?php echo $bookAuthor; ?></td>

                <td><img src="upload/<?php echo  $image; ?>" width='170px' height='50px'></td>

                <td>
                    <span class="badge badge-dark ml-4"><?php echo  $com->totalComments($id); ?></span>
                </td>
                <td>
                    <a href="edit_post.php?id=<?php echo $id; ?>"><span class="btn btn-warning edit" data-id="<?php echo $id; ?>">Edit</span></a>
                    <span class="btn btn-danger del" data-id="<?php echo $id; ?>">Delete</span>
                </td>

            </tr>
<?php

        endwhile;
    } else {

        echo  "<span class='text-danger ' style='float:right'>  No Post Found!</span>";
    }
}









if ($_SERVER['REQUEST_METHOD'] == 'POST') :


    if ($_POST['type'] == 'all_record') {
        display_all_records();
    }



endif;
