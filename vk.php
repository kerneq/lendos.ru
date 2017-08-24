<?php

if (!$_GET['code']) {
    exit('error code');
}


$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=6156122&redirect_uri=http://966bd571.ngrok.io/acount.php&client_secret=ckVSU9iKn9VB7f3TFGEy&code='.$_GET['code']), true);

if (!$token) {
    exit('error token');
}


$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&access_token='.$token['access_token'].'&fields=uid,first_name,last_name,contacts,email'), true);

if (!$data) {
    exit('error data');
}

$data = $data['response'][0];


echo '<pre>';
var_dump($data);
echo '</pre>';

?>