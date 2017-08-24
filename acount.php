<?php
include_once 'authorisation/DataBase.php';
require_once 'authorisation/login.php';
$bd =new DataBase($hn, $un, $pw, $db);
if (!$_GET['code']) {
    exit('error code');
}

$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=6156122&redirect_uri=http://5426df90.ngrok.io/acount.php&client_secret=ckVSU9iKn9VB7f3TFGEy&code='.$_GET['code']), true);

if (!$token){
    $token = json_decode(file_get_contents('https://graph.facebook.com/v2.9/oauth/access_token?client_id=261920790992777&redirect_uri=http://5426df90.ngrok.io/acount.php&client_secret=4f16c767c37c3383d7d1861deb7ff007&code='.$_GET['code']), true);
    if (!$token){
        exit("error token");
    }
    $data = json_decode(file_get_contents('https://graph.facebook.com/v2.9/me?client_id=261920790992777&redirect_uri=http://5426df90.ngrok.io/acount.php&client_secret=4f16c767c37c3383d7d1861deb7ff007&code='.$_GET['code'].'&access_token='.$token['access_token'].'&fields=id,name,email'), true);

    if (!$data) {
        exit('error data');
    }


} else {
    $data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&access_token='.$token['access_token'].'&fields=uid,first_name,last_name,contacts,email'), true);

    if (!$data) {
        exit('error data');
    }

    $data = $data['response'][0];
}

$bd->user_add($data);
//$bd->add_order('df', 'sfd', 'sfd', 'sfd', 'sfd', 'sfd', 'sfd', 'sfd');
$bd->out_orders();

?>