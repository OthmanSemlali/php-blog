<?php
require_once('../include/model.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') :
    $p = $_POST['id'];
    $res = $com->showComments($p);


    // Get number of comment in db minus 2 comments
    $count_comments = $com->count_comments($p);

    // prevent display numbers < 0 in count
    if ($count_comments < 0) {
        $count_comments = 0;
    }


    if ($res) :

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
                    <h3>
                        <u>
                            <?php echo $name;  ?>
                        </u>
                    </h3>


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
    else :
        echo '<small class="container ml-2 text-muted"> O comments yet. Be the first to comment</small>';
    endif;
endif;
?>


<!-- 
    Click btn Read more Comments =>
 -->
<script src="../js/loadMoreComments.js"></script>