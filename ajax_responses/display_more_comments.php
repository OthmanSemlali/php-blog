<?php
require_once('../include/model.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $id_comment  = '';

    $id_comment = $_POST['last_comment'];
    $id_post = $_POST['id_post'];


    // Get number of comments still in db
    $count_comments = $com->count_comments($id_post, $id_comment);




    if ($count_comments < 0) {
        $count_comments = 0;
    }

    $res = $com->showMoreComment($id_post, $id_comment);

    if ($res->rowCount() > 0) {

        while ($datarows = $res->fetch()) :

            $d = strtotime($datarows['dateTime']);
            if (date('Y', $d) == date('Y')) {
                $dateFromDb = date('d M', $d);
            } else {
                $dateFromDb = date('d M Y', $d);
            }
            $name = $datarows['nameUser'];
            $comment = $datarows['comment'];

            if (strlen($comment) > 300) {
                $comment =  substr($comment, 0, 300) . '..';
            }


            $id_comment = $datarows['id'];



?>

            <div class="single-com">

                <div style="overflow: hidden;">
                    <h6>
                        <u>
                            <?php echo $name;  ?>
                        </u>
                    </h6>


                    <i>
                        <small><?php echo $dateFromDb; ?></small>
                    </i>

                    <p><?php echo $comment;  ?></p>
                </div>
            </div>
            <hr>

        <?php

        endwhile;
        ?>


        <div id="remove_row">

            <span class="read-more-com-btn moreComments" id="moreComments" data-id="<?php echo $id_comment; ?>">
                Load More (<?php echo $count_comments; ?>)

            </span>
        </div>


<?php
    }
endif;
?>


<script src="../js/loadMoreComments.js"></script>

