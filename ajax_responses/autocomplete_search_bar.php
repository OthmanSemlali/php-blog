<?php
require_once('../include/model.php');

require_once('../include/config.php');

require_once('../include/functions.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    if ($_POST['action'] == 'search_bar') :


        $search = trim($_POST['searchKey']);


        if (!empty($search)) {

            $res = $posts->search_bar($search);
            if ($res->rowCount() > 0) {

                while ($r = $res->fetch()) :
                    $title = $r['title'];

                    if (strlen($title) > 30) {
                        $title = substr($title, 0, 30) . '..';
                    }

?>

                    <a href="<?php echo URLROOT . 'fullPost.php?id=' . $r['id'] . '&title=' . urlencode(strip_tags_content($title)) ?>" class='link-item-search'>

                        <li class="li-item-search">


                            <?php echo $title; ?> <b><small><?php echo "by " . $r['bookAuthor'] ?></small></b>

                        </li>

                    </a>

                    <!-- echo "<a href='" . URLROOT . "?search=" . $title . "'  class='link'> <li>" . $title . "</li></a>"; -->
<?php
                endwhile;
            } else {
                echo '<small>Not Found!</small>';
            }
        }

    endif;
endif;


?>