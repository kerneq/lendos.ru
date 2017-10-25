<?php
if (isset($_COOKIE['id'])) {
    session_start();
    $_SESSION['id'] = $_COOKIE['id'];
    header("Location: myWorkPlace.php");
    die();
} else {
    header("Location: auth.php");
    die();
}
?>