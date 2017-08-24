<?php
if (!$_GET['code']) {
    exit('error code');
}



$token = json_decode(file_get_contents('https://graph.facebook.com/v2.9/oauth/access_token?client_id=808636295976597&redirect_uri=http://966bd571.ngrok.io/acount.php&client_secret=2c2a865ae628f3bb8bc69607b6fe1e3f&code='.$_GET['code']), true);

if (!$token) {
    exit('error token');
}

$data = json_decode(file_get_contents('https://graph.facebook.com/v2.9/me?client_id=808636295976597&redirect_uri=http://966bd571.ngrok.io/acount.php&client_secret=2c2a865ae628f3bb8bc69607b6fe1e3f&code='.$_GET['code'].'&access_token='.$token['access_token'].'&fields=id,name,email'), true);

if (!$data) {
    exit('error data');
}

//$data['avatar'] = 'https://graph.facebook.com/v2.9/'.$data['id'].'/picture?width=200&height=200';

echo $data['id'];
echo '<pre>';
var_dump($data);
echo '</pre>';
?>