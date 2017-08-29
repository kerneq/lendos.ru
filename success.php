<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 26.08.17
 * Time: 10:25
 */

//parameter for testing 1 - test 0 - not test
$IsTest=1;
//password1
if ($IsTest===0)
    $mrh_pass1 = "a1EH0K5FXTUfOfK5asP3";
else
    $mrh_pass1 = "Rp6L1MOZh8YjY40RJllf";
// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item"));
session_start();
$_SESSION['we'] = "hello";
// check signature
if ($my_crc != $crc)
{
    echo "bad sign\n";
    exit();
} else {
    /*
     * change status in order on 'paid'
     */
    include_once 'authorisation/login.php';
    include_once 'authorisation/DataBase.php';
    include_once 'mail/contact_mail.php';
    $bd = new DataBase($hn,$un,$pw,$db);
    $bd->paid_order($inv_id);
    $result = $bd->take_inf();
    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_NUM);
    $user_name = $row[2];
    $user_email = $row[3];
    $user_phone = $row[4];
    $user_vk = $row[5];
    $user_fb = $row[6];
    new contact_mail($_SESSION['id'], NULL,$user_name, $user_email, $user_phone, NULL, $user_vk, $user_fb, $inv_id,$hn,$un,$pw,$db);

}
/*
// check of number of the order info in history of operations
$f=@fopen("order.txt","r+") or die("error");

while(!feof($f))
{
    $str=fgets($f);

    $str_exp = explode(";", $str);
    if ($str_exp[0]=="order_num :$inv_id")
    {
        echo "Операция прошла успешно\n";
        echo "Operation of payment is successfully completed\n";
    }
}
fclose($f);
*/
?>

