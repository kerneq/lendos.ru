<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>WebimCase</title>

    <!--Bootstrap styles for this template -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!--My styles for this template -->
    <link rel='stylesheet' type='text/css' href='css/auth-styles.css'>

    <!--Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</head>

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
                        <button aria-label="Log in" class="dropdown-item" onclick='location.href=
                        "https://oauth.vk.com/authorize?client_id=6225333&display=page&redirect_uri=https://lendos.me/webimcase/myWorkPlace.php&response_type=code"'>in
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

<!-- Wellcome message for outlog users-->
    <div class="alert alert-success wellcome-message" role="alert" aria-label="You're not log in">
        <h4 class="alert-heading">Wellcome to WebimCase</h4>
        <p>Sorry, but you're <b>not log in</b>:(</p>
        <hr>
        <p class="mb-0">
            <input aria-label="Log in" onclick='location.href=
            "https://oauth.vk.com/authorize?client_id=6225333&display=page&redirect_uri=https://lendos.me/webimcase/myWorkPlace.php&response_type=code"'
                   class="btn btn-primary login-button" type="submit" value="Log in">
        </p>
    </div>

</body>

</html>

<!--checks if user was login already -->
<?php
session_start();
if (isset($_SESSION['id'])){
    header("Location: myWorkPlace.php");
    die();
}
?>