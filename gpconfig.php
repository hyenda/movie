<?php
//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
//Set the OAuth 2.0 Client ID
$google_client->setClientId('627236923905-j1idvr83kt9jb4mb146ig60fmo19d4fe.apps.googleusercontent.com');
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/movie/google.php'); 

$google_client->addScope('email');
$google_client->addScope('profile');
?>