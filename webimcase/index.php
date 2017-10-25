<?php
if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
    echo "yes";
   //header("Location: myWorkPlace.php");
   //die();
} else {
    echo "no";
    //header("Location: auth.php");
    //die();
}
?>