<?php

require_once 'vendor/autoload.php';
$authCode = "4%2FAAC7ogtIhjRKsOCfLoGywnLUFKeuXKJ95Bok3aICnVCUVv7MICxmQ49QBrpO112l9VNe891vByYP_8p0pr-IQzY#";


$client = new Google_Client();
$redirect_uri = "https://ex-do.ru/wp-content/plugins/aist-dostavka/qs.php";
$client->setClientId("3308144268-f3oa2jftuihflln6df7558a3rmfop1ja.apps.googleusercontent.com");
$client->setClientSecret("IMkGrLSrLbLARN3p3jyP7m_-");
$client->setRedirectUri($redirect_uri);
$client->setScopes(array('email', 'https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive.file'));
$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
$credentialsPath = __DIR__ . DIRECTORY_SEPARATOR . 'credentials.json';
// Store the credentials to disk.
if (!file_exists(dirname($credentialsPath))) {
    mkdir(dirname($credentialsPath), 0700, true);
}
file_put_contents($credentialsPath, json_encode($accessToken));
printf("Credentials saved to %s\n", $credentialsPath);