<?php
require_once('include/config.php');


// var_dump(APPROOT);
require_once(APPROOT . '/include/model.php');
require_once(APPROOT . '/include/functions.php');
require_once(APPROOT . '/include/session.php');



unset($_SESSION['idAdminConnected']);
unset($_SESSION['usernameAdminConnected']);
unset($_SESSION['nameAdminConnected']);
// session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
// header("location:/<"); //to redirect back to "index.php" after logging out
redirect_to(URLROOT . 'login.php');

exit;
