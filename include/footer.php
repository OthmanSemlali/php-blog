<?php

$posts = new postsData();

$res = $posts->topPostByComments();



?>
<style>

</style>



<div class="fbody">
    <footer>
        <div class="row primary">
            <div class="column about">

                <h3><img src="styles/logo.png"  height='45' width="220" alt="bookyreview logo" style="margin-top: -15px;"></h3>

                <p>
                    Just like the name says... this is a place where you can find your next great read
                </p>

      
            </div>

            <div class="column links">
                <h3>TOP 5 POSTS</h3>

                <ul>

                    <?php

                    if ($res) {
                        while ($r = $res->fetch()) {
                            $title = $r['title'];
                            $id = $r['id']

                    ?>
                            <li class="mb-2"><a href="<?php echo URLROOT ?>fullPost.php?id=<?php echo $id; ?>&title=<?php echo myUrlEncode(strip_tags_content($title)); ?>" class="text-muted">

                                    <?php
                                    if (strlen($title) > 35) {
                                        echo substr($title, 0, 35), '...';
                                    } else {
                                        echo $r['title'];
                                    }

                                    ?></a></li>


                    <?php
                        }
                    }

                    ?>
                </ul>


            </div>


            <div class="column links">
                <h3>ACCOUNTS</h3>
                <ul>
                    <li>
                        <a href="https://admin.bookyreview.space/login.php">Login</a>
                    </li>
                    <li>
                        <a href="https://admin.bookyreview.space/inscription.php">Join us</a>
                    </li>

                </ul>
            </div>

            <div class="column newsletter">
                <h3>Newsletter</h3>

                <!-- <div class="search-box"> -->
                <p class="text-email">
                    Get the best quoetes, new books reviews notifications.
                </p>
                <div id="email-container" class="email-container" >


                    <input class="email-input" type="email" name="email" id="email" placeholder="example@example.com" style="background-color:white" />
                    <!-- <input class="email-button gradient" type="submit" name="submit" value="subscribe"> -->
                    <button id="button-addon1" class="email-button gradient" style="color:white;cursor:pointer;font-weight:bold;border:1px white solid">SUBSCRIBE</button>

                </div>
                <small><span class='err-msg' id="err_msg"> </span></small>
                <small><span class='succ-msg' id="success_msg"></span></small>

            </div>

        </div>

        <div class="row copyright">
            <div class="footer-menu">

                <!-- <a href="">Home</a> -->
                <small><a href="<?php echo URLROOT ?>about_us.php">About</a> <span class="sep">|</span></small>
                <small><a href="<?php echo URLROOT ?>terms_and_conditions.php">Terms</a> <span class="sep">|</span></small>
                <small><a href="<?php echo URLROOT ?>privacy_policy.php">Privacy</a> <span class="sep">|</span></small>
                <small><a href="<?php echo URLROOT ?>contact_us.php">Contact</a></small>

            </div>
            <p>Copyright &copy; <?php echo date('Y') ?> Bookyreview</p>
        </div>
    </footer>
</div>



<style>
  




    .gradient {
        box-sizing: border-box;
        /* font-size: 12px; */
        /* font-weight: 700; */
        color: #fff;
        text-transform: uppercase;
        border: 1px;
        background-image: -moz-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -ms-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -o-linear-gradient(to left, #74ebd5, #9face6);
        background-image: -webkit-linear-gradient(to left, #74ebd5, #9face6);
        background-image: linear-gradient(to left, #74ebd5, #9face6);
    }

    




    /************************************* Footer Style *************************************/
    .fbody {
        padding: 0;
        margin: 0;

        margin-top: 40px;

    }

    footer {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto 50px;

    }

    .row h3 {
        font-family: Trebuchet MS;
        opacity: 0.7;

    }

    .row {
        transition: all 0.2s linear;

    }

    .primary {
        background-color: white;
        padding-left: 15px;
        padding-right: 15px;
        padding-top: 20px;
        padding-bottom: 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: minmax(200px, auto);
    }

    .primary .email-input {
        padding: 8px 15px;
        border: none;
        outline: none;
        border-radius: 10px;

    }

    .email-container {
        display: flex;
        border: 1px solid #3e8da8;
        border-radius: 10px;
        justify-content: space-between;
        width: 295px;

    }

    .text-email {
        margin-bottom: 20px
    }

    .primary .email-button {

        padding: 8px 10px;
        border-radius: 10px;
        outline: none;
        border: none;
        cursor: pointer;
    }

    .primary .email-button :hover {
        cursor: pointer;
    }

    .copyright {
        background-color: #f5f5f5;
        color: #C0C0C0;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

        padding-left: 15px;
        padding-right: 15px;
        height: 50px;
        transition: all 0.2s linear;
    }




    .sep {
        color: black;
    }

    .column h3 {
        margin-bottom: 15px;
    }

    .column ul li {
        padding-bottom: 10px;
    }

    .column ul li a:hover {
        color: #5a8ff0;
    }


    @media screen and (max-width: 1160px) {}

    @media screen and (max-width: 950px) {
        .primary {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, auto);

        }
    }

    @media screen and (max-width: 768px) {
        .email-container{
            width: 310px;
        }
        .primary {
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr 1fr 1fr;
            /* left: 0; */

        }

        .copyright {

            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            padding: 10px;
        }
      
    }

    .primary .about p {
        font-family: Trebuchet MS;
        opacity: 0.9;
        transition: all 0.2s linear;

    }

    .about {
        margin-right: 5px;

    }

    .newsletter p {
        font-family: Trebuchet MS;
        opacity: 0.9;

        transition: all 0.2s linear;

    }

    .newsletter input {
        transition: all 0.2s linear;


    }

    .err-msg {
        color: brown;
    }

    .succ-msg {
        color: green;
    }

    .links ul li {
        margin: 5px;

    }

</style>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<!-- Add user email to newsletter table -->
<script src="./js/newsletter.js"></script>

<script src="./js/subCat.js"></script>
<script src="./js/lazyLoading.js"></script>
<script src="./js/autocomplete.js"></script>
<script src="./js/navbar.js"></script>