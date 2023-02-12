<head>
    <style>
        @import url('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');

        .info-msg,
        .success-msg,
        .warning-msg,
        .error-msg {
            margin: 10px 0;
            padding: 10px;
            border-radius: 3px 3px 3px 3px;
        }

        .info-msg {
            color: #059;
            background-color: #BEF;
        }

        .success-msg {
            color: #270;
            background-color: #DFF2BF;
        }

        .warning-msg {
            color: #9F6000;
            background-color: #FEEFB3;
        }

        .error-msg {
            color: #D8000C;
            background-color: #FFBABA;
        }
    </style>
</head>


<?php
session_start();


function ErrorMessage()
{
    if (isset($_SESSION['ErrorMessage'])) {
        $Output =
            '<div class="error-msg">
          <i class="fa fa-times-circle"></i>';
        $Output .= htmlentities($_SESSION['ErrorMessage']);
        $Output .= "</div>";
        $_SESSION['ErrorMessage'] = null;
        return $Output;
    }
}




function SuccessMessage()
{
    if (isset($_SESSION['SuccessMessage'])) {
        $Output = "<div class='success-msg'>  <i class='fa fa-check'></i>
        ";
        $Output .= htmlentities($_SESSION['SuccessMessage']);
        $Output .= "</div>";
        $_SESSION['SuccessMessage'] = null;
        return $Output;
    }
}
function InfoMessage()
{
    if (isset($_SESSION['InfoMessage'])) {
        $Output = '<div class="info-msg">
        <i class="fa fa-info-circle"></i>';
        $Output .= htmlentities($_SESSION['InfoMessage']);
        $Output .= "</div>";
        $_SESSION['InfoMessage'] = null;
        return $Output;
    }
}
function Error404()
{
    if (isset($_SESSION['Error404'])) {
        $Output = "<div ><h1>404</h1> ";
        $Output .= nl2br($_SESSION['Error404']);
        $Output .= "<a href='blog.php?page=1' >Home</a>";
        $Output .= "</div>";
        $_SESSION['Error404'] = null;
        return $Output;
    }
}
