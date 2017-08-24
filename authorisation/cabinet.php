<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 19.08.17
 * Time: 13:20
 */
include_once 'DataBase.php';
include_once 'login.php';
$bd=new DataBase($hn, $un, $pw, $db);
$bd->start_session();
if (!isset($_SESSION['login'])) die();
echo  <<< _END
<form enctype="multipart/form-data" action="" method="POST" id='form2'>
<pre>
<input type="submit" value="Выход" name="exit" />
</pre>     
</form>
_END;

if (isset($_POST['exit'])){
    $bd->destroy_session_and_data();
    header("Location: main.php");
}


?>