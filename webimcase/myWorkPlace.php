<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 18.10.17
 * Time: 11:12
 */

include_once 'authorisation/DataBase.php';
require_once 'authorisation/login.php';

$bd =new DataBase($hn, $un, $pw, $db);

if (!$_GET['code']) {

    //check if user has already auth
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: auth.php");
        die();
    }
} else {

    /*
     * authairisation via vk and fb
     * out - $data
     */
    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=6225333&redirect_uri=https://lendos.me/webimcase/myWorkPlace.php&client_secret=zzWmki2cEDOHSFolLONg&code=' . $_GET['code']), true);

    if (!$token) {
        header("Location: auth.php");
        die();
    } else {
        $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id=' . $token['user_id'] . '&access_token=' . $token['access_token'] . '&fields=uid,first_name,last_name,contacts,email'), true);
        $data1 = json_decode(file_get_contents('https://api.vk.com/method/friends.get?user_id=' . $token['user_id'] . '&access_token=' . $token['access_token'] . '&order=hints&count=5&fields=uid,first_name,last_name,photo_200'), true);


        if (!$data) {
            exit('error data');
        }

        $data = $data['response'][0];

        if (!$data1) {
            exit('error data1');
        }

        $data1 = $data1['response'];
    }


    //adds user to bd 'users'
    $bd->user_add($data, $data1);
}

    echo <<<_END
    <html lang="en">

    <head>
        <meta charset="utf-8">
    
        <title>WebimCase</title>
    
        <!--Bootstrap styles for this template -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
        <!--My styles for this template -->
        <link rel='stylesheet' type='text/css' href='css/myWorkPlace-styles.css'>
    
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
                        <form method="post" action="myWorkPlace.php" style="margin: 0px">
                            <button class="dropdown-item" name="exit" aria-label="Log out">out
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

_END;

/*
 * if button 'exit' clicked
 */
if (isset($_POST['exit'])) {
    $bd->destroy_session_and_data();
    header("Location: index.php");
}

/*
* get current name of user
*/


$result = $bd->take_inf();
$result->data_seek(0);
$row = $result->fetch_array(MYSQLI_NUM);

$name = $row[1];

echo <<<_END
<!-- Wellcome message for outlog users-->
    <div class="alert alert-success wellcome-message" role="alert" aria-label="You're not log in">
        <h4 class="alert-heading">Wellcome to WebimCase, $name</h4>
        <p>Now you can use all features of WebimCase</p>
    </div>

_END;


echo <<<_END

</body>
</html>

_END;

?>