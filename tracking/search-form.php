<?php
wp_enqueue_style("dostavka-styles", "/wp-content/plugins/aist-dostavka/dostavka.css");
?>
<h1><b>Отслеживание посылки</b></h1>
<form id="dostavka-form" class="calc" method="post"/>
  <div class="dostavka-wrapper">
    <span class="twitter-typeahead" style="position: relative; display: inline-block;">
      <input class="dostavka-input" 
             type="text" 
             name ="dostavka-srch" 
             value="<?php echo $_POST['dostavka-srch']; ?>" placeholder="Введите № отправления"/>
      <input id="dostavka-srch"
             type="submit" 
             style=" width: 105px;  padding: 0;  margin: 0;  font: normal bold 18px / 16px 'Roboto', Helvetica, Arial, Verdana, sans-serif;"
             id="dostavka-submit"  
             value ="Искать"/>
    </span>
    
  </div>
</form>