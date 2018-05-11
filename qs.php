<?php

/*

 * 
 * 4/AADwIPsTFasF311HWoyB9sWBUAMv-tCSvRdShdmwDOb7pVzucYJ1_lTlDVSvCu4gvU3NMBIeU2-kfqEljsxbLGk#
 *  */
session_start();
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId("3308144268-f3oa2jftuihflln6df7558a3rmfop1ja.apps.googleusercontent.com");
                   //"3308144268-f3oa2jftuihflln6df7558a3rmfop1ja.apps.googleusercontent.com"
$client->setClientSecret("IMkGrLSrLbLARN3p3jyP7m_-");
                        //IMkGrLSrLbLARN3p3jyP7m_-
$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
$client->setAccessType("offline");
$redirect_uri = "https://ex-do.ru/wp-content/plugins/aist-dostavka/qs.php";
$client->setRedirectUri($redirect_uri);

 
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['id_token_token']);
}
if (isset($_GET['code'])) {
	$accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $credentialsPath = __DIR__ . DIRECTORY_SEPARATOR . 'credentials.json';
    // Store the credentials to disk.
    if (!file_exists(dirname($credentialsPath))) {
        mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
}
if (@$_SESSION['id_token_token']) {
	$client->setAccessToken($_SESSION['id_token_token']);
	$token_data = json_decode($_SESSION['id_token_token'], true);
} else {
	$authUrl = $client->createAuthUrl();
	?>
	<div>
		<a href='<?= $authUrl ?>'>Connect Me!</a>
	</div>
	<?php
	exit;
}

function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol.$domainName;
}

function CurrentUrl(){
  return  siteUrl() .  substr($_SERVER['REQUEST_URI'], 1);
}
?>
<div>
	<a href='?logout=1'>Logout</a>
</div>
