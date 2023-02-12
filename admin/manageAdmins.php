<?php
require_once 'include/nav-admin.php';


?>





    <!-- main area -->
    <section class='container py-2 mt-4'>

        <?php


        echo ErrorMessage();
        echo SuccessMessage();

        ?>


        <div class="row " style="margin-top: 3%;">

            <div style="display:flex;justify-content:space-between; width:100%; margin-bottom:1%">
                <div>
                    <span id="message" class="text-success"></span>
                </div>
                <div style="display: flex; ">
                    <span style="margin-right: 5px;" class="btn btn-info" id="approve">Administration requests (<?php echo $admin->totalAdminsNotConfirmed() ?>)</span>
                    <span class="btn btn-primary add" id="add">Add admin</span>
                </div>

            </div>


            <table class='table table-scripted table-hover login-wrap' style="width:100%">

                <thead class='thead-dark'>

                    <tr>
                        <th>#</th>
                        <th>Date Inscription</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Added/Approved by</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tr class="table-active">
                    <td>#</td>
                    <td>
                        30 Juin 2022
                    </td>
                    <td>OTHMAN SEMLALI</td>
                    <td>othmansemlali1@gmail.com</td>
                    <td></td>

                    <td>MANAGER OF BLOG</td>
                    <td>
                        <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&tf=cm&source=mailto&to=othmansemlali1@gmail.com"><span class="btn btn-secondary">Message</span> </a>
                    </td>


                </tr>


                <tbody id="result">


                    <!-- RECORDS -->


                </tbody>

            </table>



        </div>
    </section>


    <!-- Modal add admin -->
    <div class="modal fade" tabindex="-1" id="modall">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="myForm">
                    <!-- modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title"> Add Admin</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                    </div>
                    <!-- modal body -->
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="username">Username: </label>
                            <input class="form-control" type="text" name="username" id="username">
                            <span id="username_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pass1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass1" id="pass1">
                            <span id="pass1_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pass2">Confirm Password: </label>
                            <input class="form-control" type="password" name="pass2" id="pass2">
                            <span id="pass2_error" class="text-danger"></span>

                        </div>

                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submit"> <i class="fas fa-check"></i>Continue</button>
                        <input type="hidden" value="<?php echo $_SESSION['usernameAdminConnected']; ?>" name="admin_connected">
                        <input type="hidden" value="add_admin" name="type">
                    </div>
                </form>
            </div>

        </div>
    </div>







    <!-- modal approve admin -->
    <div class="modal fade" id="modal_approve">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Approve Requests</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <input type="hidden" id="admin_connected" name="approved_by" value="<?php echo $_SESSION['usernameAdminConnected'] ?>">
                </div>
                <span id="messagee" class="text-success ml-3"></span>


                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date inscription</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="display_request_admins">

                            <!-- //* DISPLAY REQUEST HERE -->

                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    </div>







    <script src="./adminPanel/dashboard.js"></script>

    <!-- for get count pending admins  -->
    <script src="./adminPanel/manageAdmins.js"></script>




    <?php require_once APPROOT . '/include/footer_admin.php';  ?>