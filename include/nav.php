<head>
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />


    <style>
        /* duplicate */
        .booky {
            color: #5a8ff0;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;

        }

        .review {
            color: #435c4f;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;


        }


        /* ends duplicate */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            /* padding: 15px 100px 15px 100px; */
            padding-top: 15px;
            padding-bottom: 15px;
            padding-left: 100px;
            padding-right: 100px;
            /* background: #4a98f7; */
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            z-index: 100;
        }

        .nav,
        .nav .nav-links {
            display: flex;
            align-items: right;
            /* color: black; */
        }



        .nav .logo {
            font-size: 22px;
            font-weight: 500;
            margin-right: 4%;
            color: #4a98f7;
        }

        .nav .nav-links {
            column-gap: 20px;
            list-style: none;
        }

        .nav .nav-links a {
            transition: all 0.2s linear;
        }

        .nav.openSearch .nav-links a {
            opacity: 0;
            pointer-events: none;
        }

        .nav #searchIcon {
            display: none;
        }

        .nav .search-box {
            position: absolute;
            /* right: 250px; */
            right: 170px;

            max-width: 555px;
            width: 400px;
            /* opacity: 0; */
            /* pointer-events: none; */
            transition: all 0.2s linear;
        }

        .nav.openSearch .search-box {
            opacity: 1;
            pointer-events: auto;
        }

        .search-box .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            left: 15px;
            color: #4a98f7;
            transform: translateY(-50%);
            display: block;
        }

        .searchIcon {
            display: none;
        }

        .search-box input {
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            border-radius: 6px;
            background-color: #fff;
            padding: 0 15px 0 45px;
            border-bottom: 1px #4a98f7 solid;
        }

        .nav .navOpenBtn,
        .nav .navCloseBtn {
            display: none;
        }

        .search-box {
            position: relative;
            height: 40px;
            width: 40px;
        }

        /* .autocomplete-results {
            scrollbar-width: thin;
            scrollbar-color: #6969dd #e0e0e0;

            max-height: 220px;
            overflow-y: auto;
            scrollbar-gutter: stable;
        } */

        .autocomplete-results {
            z-index: 1;
            margin-top: 2%;
            border-radius: 5px;
            border: none;
            background-color: white;
            border: none;
            max-height: 300px;
            overflow: auto;
            list-style: none;
            transition: none;
        }



        .autocomplete-results .li-item-search {
            color: black;

            cursor: pointer;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 4%;

            border-radius: 5px;
            width: 100%;
        }

        .autocomplete-results .li-item-search:hover {
            cursor: pointer;
            background-color: #f5f5f5;
            /* background-color: red; */
        }

        .link-item-search {
            /* background-color: red; */
            display: block;
            color: black;
            /* width: 100%; */
        }

        /* Custom Scroll bar */
        .autocomplete-results::-webkit-scrollbar {
            width: 16px;
        }

        .autocomplete-results::-webkit-scrollbar-track {
            background-color: #e4e4e4;
            border-radius: 100px;
        }

        .autocomplete-results::-webkit-scrollbar-thumb {
            /* background-color: #4a98f7; */
            border: none;
            background-image: -moz-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -ms-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -o-linear-gradient(to left, #74ebd5, #9face6);
            background-image: -webkit-linear-gradient(to left, #74ebd5, #9face6);
            background-image: linear-gradient(to left, #74ebd5, #9face6);
            border-radius: 100px;
        }

        @media screen and (max-width: 1160px) {
            .nav {
                padding: 15px 100px;

                /* background-color: aqua; */
            }

            .nav .search-box {
                right: 150px;
            }
        }

        @media screen and (max-width: 950px) {

            .nav {
                padding: 15px 50px;

                /* background-color: aquamarine; */
            }

            .nav .search-box {
                right: 100px;
                max-width: 300px;
            }
        }





        @media screen and (max-width: 768px) {

            .nav .navOpenBtn,
            .nav .navCloseBtn {
                display: block;
            }

            .nav #searchIcon {
                display: block;
                color: #4a98f7;
            }

            .nav {
                padding: 15px 20px;
                /* background-color: red; */

                justify-content: space-between;

                /* background-color: red; */
            }

            .nav .search-box {
                position: absolute;
                right: 250px;
                height: 45px;
                max-width: 555px;
                width: 100%;
                opacity: 0;
                /* pointer-events: none; */
                transition: all 0.2s linear;
            }

            .search-box .search-icon {
                position: absolute;
                left: 15px;
                top: 50%;
                left: 15px;
                color: #4a98f7;
                transform: translateY(-50%);
                display: block;
            }

            .nav .search-icon {
                color: #fff;
                font-size: 20px;
                cursor: pointer;
                /* display: block; */
                color: #4a98f7;
            }

            .nav .nav-links {
                position: fixed;
                top: 0;
                left: -100%;
                height: 100%;
                max-width: 280px;
                width: 100%;
                padding-top: 100px;
                row-gap: 30px;
                flex-direction: column;
                background-color: #11101d;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.4s ease;
                z-index: 100;

                align-items: center;
            }

            .nav.openNav .nav-links {
                left: 0;
            }

            .nav .navOpenBtn {
                color: #4a98f7;
                font-size: 20px;
                cursor: pointer;
            }

            .nav .navCloseBtn {
                position: absolute;
                top: 20px;
                right: 20px;
                color: #fff;
                font-size: 20px;
                cursor: pointer;
            }

            .nav .search-box {
                top: calc(100% + 10px);
                max-width: calc(100% - 20px);
                right: 50%;
                transform: translateX(50%);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }




        }

        @media screen and (max-width: 500px) {}

        @media screen and (max-width: 400px) {}
    </style>
</head>

<nav class="nav ">
    <i class="uil uil-bars navOpenBtn"></i>
    <a class="logo" href="<?php echo URLROOT; ?>">

        <span class="booky">Booky</span><span class="review">review</span>
    </a>

    <ul class="nav-links">
        <li>

            <i class="uil uil-times navCloseBtn"></i>
        </li>

        <li><a href="<?php echo URLROOT ?>">Home</a></li>
        <!-- <li><a href="#">Authors</a></li> -->
        <!-- <li><a href="#">Products</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li> -->
    </ul>

    <i class="uil uil-search search-icon" id="searchIcon"></i>


    <div class="search-box">


        <i class="uil uil-search search-icon"></i>
        <form action="<?php echo URLROOT; ?>">

            <input style=" height: 44px;" name="search" id="search-input" type="text" placeholder="Search here..." />


        </form>

        <div class="autocomplete-results hidden" id="search_result">
            <!-- Search items result -->



        </div>
    </div>

</nav>