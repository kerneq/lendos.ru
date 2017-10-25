<?php
if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];

   header("Location: myWorkPlace.php");
   die();
} else {
    header("Location: auth.php");
    die();
}
?>