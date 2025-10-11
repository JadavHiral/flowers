<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <script src="js/validate.js"></script>


    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }



        .container-fluid {
            flex: 1;
        }


        footer {
            width: 100%;
            margin: 10px;
            padding: 15px 0;
            background: #222;
            color: white;
            text-align: center;
            margin-top: 60px auto;
        }

        .btn {

            background-color: #ff6f91;
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 150px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.0s;
        }

        .btn:hover {
            background-color: #ed6386ff;
        }

        .dropdown-menu {
            background-color: #f8dfe9ff;
            padding: 15px;
            border-radius: 15px;
            border: 2px solid #0e0105ff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            width: 50px;
        }

        .dropdown-menu .dropdown-item {
            background-color: #ffe6f0;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 6px;
            color: #0a0000ff;

        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f894adff;
            color: black;
            transition: 0.3ms;
        }

        .nav-link:hover {
            color: #fe6f9cff;
        }

        .custome-dropdown ::after {
            display: none;
        }

        @media (max-width: 576px) {
            .btn {
                padding: 10px 20px;
                font-size: 0.9em;
            }

            .dropdown-menu {
                width: auto;
                padding: 10px;
            }
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!--first row-->
        <div class="row">
            <!--NAVBAR-->
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">

                <div class="container-fluid">
                    <a class="navbar-brand" href="javascript:void(0)">🌷<b>Flowers</b></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="mynavbar">
                        <ul class="navbar-nav me-auto mb-2 mb-md-0">

                            <li class="nav-item">
                                <a class="nav-link" href="home.php"> Home </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="category.php"> Category </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="contact.php"> Contact Us </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="aboutus.php"> About Us </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="register.php"> Register </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php"> Login </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="feedback.php"> Feedback </a>
                            </li>
                            <!--dropdown-->
                            <!--<li class="nav-item dropdown">
                                <a class="nav-link dropdown" href="#" data-bs-toggle="dropdown">
                                    <img src="images/user.png" alt="user 3" width="20px" height="20px">
                                </a>
                                <ul class="dropdown-menu dropdown-menu end">
                                    <li><a class="dropdown-item" href="uprofile.php"> My Account </a>
                                    </li>
                                    <li><a class="dropdown-item" href="feedback.php"> Feedback </a>
                                    </li>
                                </ul>

                            </li>-->
                        </ul>
                        <!--<form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Search">
                            <button class="btn" type="button">Search</button>
                        </form>-->
                    </div>
                </div>
            </nav>
        </div>

        <!--dynamic content-->
        <!--second row-->
        <div class="row">
            <?php

            if (isset($title_page)) {
                echo $title_page;
            }
            if (isset($content1)) {
                echo $content1;
            }
            ?>
        </div>


        <!--third row-->
        <div class="main-content">
            <div class="row">

               
                        <!--FOOTER-->
                <footer class="bg-dark text-white text-center py-3 w-100 m-0">
                    <p>© 2025 Flower Shop | Designed by [Diya Apte] [Hiral Jadav] [Jagruti Sagathiya]</p>

                </footer>
                
            </div>

        </div>
    </div>
</body>

</html>
