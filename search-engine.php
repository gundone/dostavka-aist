<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

// 1/Y9brSzdAsOaHYYCDGskEa-26Gk2BRJkRisrVGR-Uza8

$keyfile = 'dostavka-aist-74bea31f127e.json';

function getClient(){
  $client = new Google_Client();
  $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
  putenv('GOOGLE_APPLICATION_CREDENTIALS=' 
          . __DIR__ 
          . DIRECTORY_SEPARATOR 
          . $keyfile);
  $client->useApplicationDefaultCredentials();
  $credentialsPath = __DIR__ . DIRECTORY_SEPARATOR . 'credentials.json';
  return $client;
}

$client = getClient();
$service = new Google_Service_Sheets($client);
$spreadSheetId = "1vNQnqUJFTeDMv39jbOsLPGTBrDgmWfZwy2oVGmKG-3w";
$range = 'Оператор!C13:U';
$response = $service->spreadsheets_values->get($spreadSheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "ERROR connecting data server.";
} else {
  $found = false;
  foreach ($values as $row) {
    if(mb_strtolower($row[0]) == mb_strtolower($_POST["dostavka-srch"])){
      $found = true;
      printf("Накладная: № <b>%s</b><br/>"
              . "Город отправителя: <b>%s</b><br/>"
              . "Город получателя: <b>%s</b><br/>"
              . "Вариант доставки (до получателя, до склада):<b>%s</b><br/>"
              . "Вид доставки (стандарт или экспресс:)<b>%s</b><br/>"
              . "Количество мест:<b>%s</b><br/>"
              . "Общий вес:<b>%s</b><br/>"
              . "Статус доставки:<b>%s</b><br/>"
              . "Дата доставки:<b>%s</b><br/> "
              . "Время доставки:<b>%s</b><br/>", 
              $row[0], 
              $row[3], 
              $row[6], 
              $row[8], 
              $row[9], 
              $row[10], 
              $row[13], 
              $row[15], 
              $row[16], 
              $row[17]);
    }
  }
  if(!$found)
  {
    printf("Информации по отправлению %s не найдено" ,$_POST["dostavka-srch"]);
  }
}

