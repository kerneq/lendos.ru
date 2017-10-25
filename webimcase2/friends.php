<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 18.10.17
 * Time: 11:12
 */

session_start();
if (!isset($_SESSION['id'])){
    header("Location: auth.php");
    die();
}

echo <<<_END
    <html lang="en">

    <head>
        <meta charset="utf-8">
    
        <title>WebimCase</title>
    
        <!--Bootstrap styles for this template -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
        <!--My styles for this template -->
        <link rel='stylesheet' type='text/css' href='css/friends.css'>
    
        <!--Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="bootstrap/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    
    </head>
_END;

echo <<<_END
<body>

<!--Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light my-navbar-style" aria-label="Choose one of category">
        <a class="navbar-brand" href="index.php" aria-label="Go to 1 page">WebimCase</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="myWorkPlace.php" aria-label="Go to Home">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php" aria-label="Go to Profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="friends.php" aria-label="Go to Friends">Friends</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="auth.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Log
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" aria-label="Choose log">
                        <form method="post" action="friends.php" style="margin: 0px">
                            <button class="dropdown-item" name="exit" aria-label="Log out">out</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
_END;
include_once 'authorisation/DataBase.php';
require_once 'authorisation/login.php';

$bd =new DataBase($hn, $un, $pw, $db);

/*
 * if button 'exit' clicked
 */
if (isset($_POST['exit'])){
    $bd->destroy_session_and_data();
    header("Location: index.php");
}

//get all friends of current user
$result = $bd->out_friends();

$rows = $result->num_rows;

$name = $_SESSION['name'];

echo <<<_END

<!--Friends information-->
    <div class="row" style="margin-top: 30px; margin-left: 30px" aria-label="Your friends">
        <div class="col-sm-6">
_END;

    for ($j = 0; $j < $rows - 2; $j++) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);
        echo <<<_END
    <!--Friend-->
        
        <div class="card" style="width: 20rem; margin-top: 15px;">
            <img class="card-img-top" src="$row[6]">
            <div class="card-body">
                <h4 class="card-title">$row[5]</h4>
                <a href="https://vk.com/id$row[4]" class="btn btn-primary" target="_blank">Refresh</a>
            </div>
        </div>
_END;
    }

    echo <<<_END

        </div>          
        <div class="col-sm-6">
_END;

    for ($j = 3; $j < $rows; $j++) {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_NUM);
        echo <<<_END
    <!--Friend-->
        
        <div class="card" style="width: 20rem; margin-top: 15px;">
            <img class="card-img-top" src="$row[6]">
            <div class="card-body">
                <h4 class="card-title">$row[5]</h4>
                <a href="https://vk.com/id$row[4]" class="btn btn-primary" target="_blank">Refresh</a>
            </div>
        </div>
_END;
    }

    echo <<<_END
    </div>
    </div>
    </body>

    </html>
_END;



?>