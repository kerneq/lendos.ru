<?php
if (isset($_SESSION['id'])) {
    header("Location: myWorkPlace.php");
    die();
} else {
    header("Location: auth.php");
    die();
}
?>