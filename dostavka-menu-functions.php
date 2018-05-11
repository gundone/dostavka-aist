<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$aist_dostavka_options_page_url = "aist_dostavka";
function dostavka_menu(){
    global $aist_dostavka_options_page_url;
    add_options_page("Настройки доставки", "Аист Доставка", 8, $aist_dostavka_options_page_url, "dostavka_options_page");
}

function dostavka_options_page(){
    echo "<h2>Настройка доставки</h2>";
    add_option("aistDost_tariff", "Не задано");
    add_option("dostavka_url", "servis/kalkulyator");
    add_option("scodeLite", "[dostavka_preview]");
    add_option("scodeFull", "[dostavka_calculator]");
    add_option("email_reporting", "email@me.com");
    add_option("unsent_emails", "");
    dostavka_render_options();
}
function sep($a){
    return $a != sep;
}

function dostavka_render_options(){
    global $aist_dostavka_options_page_url;
    $uploaddir = plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    $separator = array_filter(['/','\\'], "sep")[0];
    $uploaddir = str_replace($separator, "", $uploaddir);
    if(isset($_FILES['tariff'])){
        $uploadfile = $uploaddir . basename($_FILES['tariff']['name']);
        if (move_uploaded_file($_FILES['tariff']['tmp_name'], $uploadfile)) {
            dostavka_process_tariff($uploadfile);
            update_option("aistDost_tariff", $uploadfile);
        } else {
            echo "Tariff not uploaded\n";
        }
    }
    if(isset($_POST['scodeFull'])){
      update_option("scodeFull", sanitize_text_field($_POST['scodeFull']));
    }
    if(isset($_POST['scodeLite'])){
      update_option("scodeLite", sanitize_text_field($_POST['scodeLite']));
    }
     if(isset($_POST['scodeSrch'])){
      update_option("scodeSrch", sanitize_text_field($_POST['scodeSrch']));
    }
    if(isset($_POST['email_reporting'])){
      update_option("email_reporting", sanitize_text_field($_POST['email_reporting']));
    }
    if(isset($_POST['unsent_emails'])){
      $mail = str_replace('/','', sanitize_text_field($_POST['unsent_emails']));
      update_option("unsent_emails", $mail);
    }
    echo
    "<form action='".$_SERVER['PHP_SELF']."?page=".$aist_dostavka_options_page_url."' method='post' enctype='multipart/form-data'>
        <table>
        <tr>
        <td>Shortсode калькулятора</td>
        <td colspan='2'><input type='text' name='scodeFull' value='".get_option('scodeFull')."'/></td>
        </tr>
        <tr>
        <td>Shortсode превьюшки</td>
        <td colspan='2'><input type='text' name='scodeLite' value='".get_option('scodeLite')."'/></td>
        </tr>
        <tr>
        <td>Shortсode отслеживания</td>
        <td colspan='2'><input type='text' name='scodeSrch' value='".get_option('scodeSrch')."'/></td>
        </tr>
        <tr>
        <td>Url калькулятора для отправки с превью</td>
        <td colspan='2'><input type='text' name='dostavka_url' value='".get_option('dostavka_url')."'/></td>
        </tr>
        <tr>
        <td colspan='3'>Файл тарифов: `".get_option('aistDost_tariff')."`</td>
        </tr>
        <td>Имя файла латиницей!</td>
        <td colspan='2'><input type='file' name='tariff'/></td>
        </tr>
        <tr>
          <td colspan='2'>Email для уведомлений о заказах</td>
          <td >
            <input type ='text' name='email_reporting' value='".str_replace("/", "", get_option('email_reporting'))."'/>
          </td>
        </tr>
        <tr>
        <td colspan='3'><textarea name ='unsent_emails' style='width: 100%; height: 200px;'>".get_option("unsent_emails")."</textarea></td>
        </tr>
        <tr>
        <td colspan='3'><input type ='submit' value='OK'/></td>
        </tr>
        </table>
    </form>";
}

function dostavka_process_tariff($file){
  if ( $xlsx = SimpleXLSX::parse($file) ) {
    list($num_cols, $num_rows) = $xlsx->dimension();
//    echo "cols=".$num_cols;
//    echo "rows=".$num_rows;
    $tariff = array();

    for($i = 2; $i< $num_rows; $i++){
        $row = $xlsx->rows()[$i];
        if(isset($row) 
            && isset($row[1]) 
            && isset($row[2])
            && isset($row[3])){
          $dost = [
           "from"=>$row[2],
           "to"=>$row[3],
           "time"=>$row[1],
           "store-store" =>strlen($row[4])>0? $row[4]:"-",
           "store-door" =>strlen($row[5])>0? $row[5]:"-",
           "door-door" =>strlen($row[6])>0? $row[6]:"-",
           "upto_1"=>$row[7],
           "upto_20"=>$row[8],
           "upto_30"=>$row[9],
           "upto_100"=>$row[10],
           "upto_300"=>$row[11],
           "upto_500"=>strlen($row[12]) > 0? $row[12] : $row[11],
        ];
        array_push($tariff, $dost);
        }
    }
    $json = "var tariff = " . json_encode($tariff, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    $js = plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR . "tariff.js";
    file_put_contents ( $js , $json );
  } else {
    echo SimpleXLSX::parse_error();
  }
  list($num_cols, $num_rows) = $xlsx->dimension();
//    echo "cols=".$num_cols;
//    echo "rows=".$num_rows;
  $tariff = array();

  for($i = 2; $i< $num_rows; $i++){
      $row = $xlsx->rows()[i];
      $dost = [
          "from"=>$xlsx
      ];
  }
}