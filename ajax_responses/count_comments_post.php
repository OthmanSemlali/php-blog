<?php
require_once('../include/model.php');



if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $id = $_POST['id'];
    $res = $com->totalComments($id);
    
    echo $res;
}
