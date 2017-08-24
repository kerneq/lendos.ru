<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 19.08.17
 * Time: 12:37
 */
include_once 'DataBase.php';
require_once 'login.php';
$bd = new DataBase($hn, $un, $pw, $db);
/*
 * form
 */
echo <<<_END
<form enctype="multipart/form-data" action="" method="POST" id='form1'>
<pre>
    
    <input type="text" placeholder='Логин/ваша почта' name="login" required="required">
    
    <input type="password" placeholder='Пароль' name="password" required="required">
         
    <input type="submit" value="Вход" name="enter"/>
    
    
</pre>     
</form>
<form enctype="multipart/form-data" action="" method="POST" id='form2'>
<pre>
<input type="submit" value="Регистрация" name="registration" />
</pre>     
</form>
_END;
$bd->start_session();
if (isset($_SESSION['login'])){
    echo <<<_END
    <a href="authorisation/cabinet.php">Личный кабинет</a>

_END;

}


if (isset($_POST['enter'])){
    if (isset($_POST['login']) && isset($_POST['password'])){
        if ($bd->is_user($_POST['login'], $_POST['password'])){
            $bd->add_session($_POST['login'], $_POST['password']);
            if ($_SERVER['PHP_SELF']==='/index.php')
            header("Location: authorisation/cabinet.php");
            else
                header("Location: cabinet.php");
        } else {
            echo "неверный логин или пароль";
        }
    } else {
        echo "не ввели логин или пароль!";
    }
}

if (isset($_POST['registration'])){
    if ($_SERVER['PHP_SELF']==='/index.php')
        header("Location: authorisation/registration.php");
    else
        header("Location: registration.php");

}


?>