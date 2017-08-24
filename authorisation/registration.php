<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 20.08.17
 * Time: 11:06
 */
echo <<<_END
<form enctype="multipart/form-data" action="" method="POST" id='form1'>
<pre>
    
    <input type="text" placeholder='Логин/ваша почта' name="login" required="required">
    
    <input type="password" placeholder='Пароль' name="password1" required="required">
    <input type="password" placeholder='Пароль' name="password2" required="required">     
    <input type="submit" value="Зарегистрироваться" name="in"/>
    
</pre>     
</form>
<form enctype="multipart/form-data" action="" method="POST" id='form2'>
<pre>
<input type="submit" value="Вход" name="in2" />
</pre>     
</form>
_END;
include_once 'DataBase.php';
require_once 'login.php';

$bd = new DataBase($hn, $un, $pw, $db);

if (isset($_POST['in'])){
    if (isset($_POST['login']) && isset($_POST['password1'])
        && isset($_POST['password2']) && isset($_POST['password1'])===isset($_POST['password2'])){
        $bd->add_user($_POST['login'], $_POST['password1']);

    } else {
        echo "пароли не совпадают";
    }
}

if (isset($_POST['in2'])){
    header("Location: main.php");
}


?>