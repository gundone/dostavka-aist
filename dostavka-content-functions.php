<?php
function dostavka_init(){
  $page_url = get_option("dostavka_url");
}


function dostavka_content($content){
  $scodeFull = get_option("scodeFull");
  $scodeLite = get_option("scodeLite");
  $scodeSrch = get_option("scodeSrch");
  
  if(strpos($content, $scodeLite) !==FALSE){
    ob_start();
      include( __DIR__ . DIRECTORY_SEPARATOR . "preview.php");
    $form = ob_get_clean();
    $content = str_replace($scodeLite, $form, $content);
  }
  
  if(strpos($content, $scodeSrch) !==FALSE){
    ob_start();
      include( __DIR__ . DIRECTORY_SEPARATOR . "search-form.php");
    $form = ob_get_clean();
   
    
    
    if(isset($_POST["dostavka-srch"]) && strlen($_POST["dostavka-srch"]) > 0 ){
      require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
      ob_start();
        include( __DIR__ . DIRECTORY_SEPARATOR . "search-engine.php");
      $srchData = ob_get_clean();
      $form .= $srchData;
    }
    $content = str_replace($scodeSrch, $form, $content);
  }

  if(strpos($content, $scodeFull) !==FALSE){
    if(isset($_POST["from"]) && strlen($_POST["from"]) > 0 ){
      $data = $_POST;
      $report = report_delivery_order($data);
      $content = str_replace($scodeFull, $report, $content);
    }
    else {
      ob_start();
        include( __DIR__ . DIRECTORY_SEPARATOR . "form.php");
      $form = ob_get_clean();
      $content = str_replace($scodeFull, $form, $content);
    }
  }
  return $content;
}

function report_delivery_order($formData){
  $dost = "Склад-дверь";
  switch ($formData["dostavka-tip"]) {
    case "door-door":
      $dost = "дверь-дверь";

      break;
    case "store-store":
      $dost = "Склад-Cклад";
    default:
      $dost = "Склад-дверь";
      break;
  }
  $strah = $formData["strahovka"]?"Да":"Нет";
  $opl = $formData["oplataPol"]?"Да":"Нет";
  $message = "Имя: ".sanitize_text_field($formData["dost-user"])
           .", тел.".sanitize_text_field($formData["dost-phone"])."\r\n"
           . "email.".sanitize_text_field($formData["dost-email"])."\r\n" 
           . "Из: ".sanitize_text_field($formData["from"])      ."\r\n"    
           . "В: ".sanitize_text_field($formData["to"])         ."\r\n"  
           . "Вес: ".sanitize_text_field($formData["weight"])   ."кг\r\n"  
           . "Объем (габариты): ".sanitize_text_field($formData["volume"]) ."\r\n"  
           . "Доставка: ".sanitize_text_field($dost)            ."\r\n" 
           . "Страховка: ".sanitize_text_field($strah)."\r\n" 
           . "Оплата получателем: ".sanitize_text_field($opl)."\r\n" 
           . "Стоимость по калькулятору: ".sanitize_text_field($formData["dost-cost"]) ."\r\n";
  $headers = '';
  $sent = wp_mail(get_option("email_reporting"), 
          "Заказ: ".sanitize_text_field($formData["from"])."-".sanitize_text_field($formData["to"]), 
          $message, 
          $headers);
  if($sent){
    $unsent_emails = get_option("unsent_emails");
    update_option("unsent_emails", $unsent_emails. "\r\n\r\n*******************\r\n\r\n" . $message);
  }
  else{
    $unsent_emails = get_option("unsent_emails");
    update_option("unsent_emails", $unsent_emails. "\r\n\r\n*******************\r\n\r\n" . $message);
  }
  return "Ваша заявка отправлена";
}