<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 26.08.17
 * Time: 10:24
 */

// registration info (password #2)
$mrh_pass2 = "q15CS1uno4Mw9RFUmHkl";


//current date
$tm=getdate(time()+9*3600);
$date="$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";

// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item"));


// check signature
if ($my_crc !=$crc)
{
    echo "bad sign\n";
    exit();
}

// success
echo "OK$inv_id\n";

// save order info to file
$f=@fopen("order.txt","a+") or
die("error");
fputs($f,"order_num :$inv_id;Summ :$out_summ;Date :$date\n");
fclose($f);
?>