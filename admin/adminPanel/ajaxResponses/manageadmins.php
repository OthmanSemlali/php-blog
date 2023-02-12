<?php
require_once('../../include/model.php');




function add_admin()
{



    $admin = new adminsData();

    $addedBy = $_POST['admin_connected'];
    date_default_timezone_set("Africa/Casablanca");

    $date = date("d M Y H:i:s");
    $headLine = 'X';
    $adminBio = 'X';
    $adminImage = "X";
    $status = 'On';
    $fullname = 'X';
    $email = 'X';


    $output = array();
    $error = array();

    $username = trim($_POST['username']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];


    if (empty($username)) {
        $error['username_error'] = 'Username Is Required';
    } elseif ($admin->checkUsernameExisting($username)) {
        $error['username_error'] = 'Username Alaready exist, Try another One!';
    } elseif (!preg_match("/^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/", $username)) {
        $error['username_error'] = "Username not match";
    }


    if (empty($pass1)) {
        $error['pass1_error'] = 'Password Is Required';
    } elseif (strlen($pass1) < 8) {
        $error['pass1_error'] = "Password should be greater than 8 characters";
    }


    if (empty($pass2)) {
        $error['pass2_error'] = "Password Is Required";
    } elseif ($pass1 != $pass2) {
        $error['pass2_error'] = 'Confirm your password!';
    }


    if (count($error) > 0) {
        $output = array(
            'error'  =>  $error
        );
    } else {
        $res = $admin->createAccount($date, $username, $pass1, $fullname, $addedBy, $headLine, $adminBio, $adminImage, $status, $email);

        if ($res) {

            $output = array(
                'success'  =>  $username . ' Added Successfully'
            );
        } else {
            die('Something went wrong. Refresh the page & try later!');
        }
    }


    echo json_encode($output);
}


function delete_admin()
{
    $admin = new adminsData();


    $id = $_POST['id'];
    $res = $admin->delete($id);

    if ($res) {
        echo 'Deleted successfully';
    } else {
        die('Something went wrong. Refresh the page & try later!');
    }
}


function display_admins()
{
    $admin = new adminsData();

    $res = $admin->existingAdminsExceptManager();


    while ($r = $res->fetch()) {
        $id = $r['id'];
        $d = strtotime($r['dateTime']);
        if (date('Y', $d) == date('Y')) {
            $dateTime = date('d M', $d);
        } else {
            $dateTime = date('d M Y', $d);
        }

        $email = $r['email'];
        $status = $r['status'];
        $username = $r['username'];


?>


        <tr>
            <td><?php echo $id; ?></td>
            <td>
                <?php

                echo $dateTime; ?>
            </td>
            <td><?php


                echo $username; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $r['added_approved_by']; ?></td>

            <td><?php
                echo $status;
                ?></td>
            <td>
                <button class="btn btn-danger del " data-id="<?php echo $id; ?>">Delete</button>
            </td>

        </tr>

        <?php
    }
}







function approve_request()
{

    $admin = new adminsData();


    $approved_by = $_POST['approved_by'];
    $id = $_POST['id'];
    $email = $_POST['email'];
    $On = "On";

    $res = $admin->confirmAdmin($On, $approved_by, $id);

    if ($res) {
        // Setup php mailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '8cb149bc025308';
        $mail->Password = 'ecdf5a20f3706e';

        $url = "http://localhost/chaghaf/login.php";

        $message = "<div style='margin:5%;'>";
        $message .= "<br><br>";

        $message .= 'Hello, your registration request has been confirmed successfully and you can login now as an admin';
        $message .= "<br><br><br>";

        $message .= "<a style='text-decoration: none;color: white; ' href='" . $url . "' class='btn btn-primary'>
        <button style='marging:5%; outline:none; cursor:pointer;padding: 12px 28px;color: white;
        border-radius: 4px;background-color: #008CBA; border:none;text-align: center;'>
        Back to Login Page
        </button></a>";

        $message .= "<br><br><br>";
        $message .= "<br>";
        $message .= "<p>Thank you,</p>";
        $message .= "</div>";



        $mail->setFrom('othmansemlali1@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Request Confirmed';
        $mail->Body = $message;
        $mail->addAddress($email);
        $mail->send();

        echo 'approved Successfully';
    } else {
        echo 'Something Went Wrong at all!';
    }
}


function delete_request()
{
    $admin = new adminsData();

    $id = $_POST['id'];
    $res = $admin->delete($id);

    if ($res) {
        echo 'Deleted successfully';
    } else {
        die('Something went wrong. Refresh the page & try later!');
    }
}


function display_request()
{
    $admin = new adminsData();

    $res = $admin->pendingAdmins();

    if ($res) {
        while ($r = $res->fetch()) :
            $id = $r['id'];
            $dateTime = $r['dateTime'];
            $email = $r['email'];
            $username = $r['username'];

        ?>
            <tr>
                <td><?php echo $dateTime; ?></td>
                <td><?php echo $username; ?></td>
                <td><?php echo $email; ?></td>
                <td style="display: flex;"><span style="margin-right: 5px;" class="btn btn-success approve_request" rel='<?php echo $email; ?>' data-id="<?php echo $id; ?>">Approve</span>
                    <span class="btn btn-danger delete_request" data-id="<?php echo $id; ?>">Delete</span>
                </td>

            </tr>

<?php
        endwhile;
    } else {

        echo  "<span class='text-danger ml-auto'>  No Request Found!</span>";
    }
}










if ($_SERVER['REQUEST_METHOD'] == 'POST') :


    switch ($_POST['type']) {

        case 'add_admin':
            add_admin();
            break;

        case 'delete_admin':
            delete_admin();
            break;

        case 'display_admins':
            display_admins();
            break;

        case 'approve_request':

            approve_request();
            break;

        case 'delete_request':

            delete_request();
            break;

        case 'display_request':

            display_request();
            break;
    }

endif;
