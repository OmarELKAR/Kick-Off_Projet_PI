<?php
require './vendor/autoload.php';
$fb = new Facebook\Facebook([
    'app_id'=>'526431636241185',
    'app_secret'=>'4a4795d5a94d7f577e787cd2beab808b',
    'default_graph_version'=>'v16.0'
]);

$helper= $fb->getRedirectLoginHelper();
$login_url=$helper->getLoginUrl('http://localhost/fb-login');
print_r($login_url);