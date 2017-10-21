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
        <link rel='stylesheet' type='text/css' href='css/profile.css'>
    
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
                        <form method="post" action="profile.php" style="margin: 0px">
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

/*
 * update data of current user
 */
include_once 'authorisation/login.php';
include_once 'authorisation/DataBase.php';

$bd = new DataBase($hn,$un,$pw,$db);

//get data of currenr user from table 'users'
$bd->start_session();
$result = $bd->take_inf();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_NUM);

$user_name = $row[1];
$user_email = $row[2];
$user_phone = $row[3];

/*
 * if button 'send' clicked
 * change data of current user
 * page content change to 'myWorkPlace.php'
 * it is nessesary to apply changies to user see
 */
if (isset($_POST['save'])) {
    $bd->update($_POST['name'], $_POST['email'], $_POST['phone']);
    header("Location: ../myWorkPlace.php");
}

echo <<<_END
<!--Users data-->
    <form class="contact-form" method="post" action="profile.php" aria-label="Choose the data to changed">
        <div class="alert alert-success form-group profile-message" role="alert" aria-label="Add or update data">
            <p><b>Add or update you profile information</b></p>
        </div>
        
        <div class="form-group" aria-label="Enter name to change">
            <label for="exampleInputName">Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputName" placeholder="$user_name">
        </div>
    
        <div class="form-group" aria-label="Enter name to change">
            <label for="exampleInputEmail1">Email</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="$user_email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        
        <div class="form-group" aria-label="Enter name to change">
            <label for="exampleInputPhone">Phone</label>
            <input name="phone" type="text" class="form-control" id="exampleInputPhone" placeholder="$user_phone">
        </div>
        
        <button type="submit" name="save" class="btn btn-primary" aria-label="Save new data">Save</button>
    </form>
_END;


echo <<<_END
</body>

</html>

_END;

?>