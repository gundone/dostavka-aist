<?php
wp_enqueue_script("tariff", "/wp-content/plugins/aist-dostavka/tariff.js");
wp_enqueue_script("autocomplete", "/wp-content/plugins/aist-dostavka/autocomplete/auto-complete.js");
wp_enqueue_script("dostavka-calc", "/wp-content/plugins/aist-dostavka/dostavka-calc.js", array(), "1.32");
wp_enqueue_style("autoCompleteStyles", "/wp-content/plugins/aist-dostavka/autocomplete/auto-complete.css");
wp_enqueue_style("dostavka-styles", "/wp-content/plugins/aist-dostavka/dostavka.css");
?>
<form id="dostavka-form" class="calc" method="post" action="/<?= get_option("dostavka_url") ?>">
  <div class="dostavka-wrapper">
    <div style="margin: 0 0 -5px 0 !important;" class="dostavka-wrapper">
      <span class="twitter-typeahead" style="position: relative; display: inline-block; margin: 0 !important;">
        <input type="text" name ="from-p" id="dostavka-from-p" placeholder="Откуда"/>
      </span>
    </div>
    <div style="margin: 0 0 25px 0 !important;" class="dostavka-wrapper">
      <span class="twitter-typeahead" style="position: relative; display: inline-block; margin: 0 !important;">
        <input type="text" name ="to-p" id="dostavka-to-p" placeholder="Куда"/>
      </span>
    </div>    
    <div style="margin: 0 0 25px 0 !important;">
        <input name="weight-p" id="dostavka-weight-p" type="text" placeholder="Вес, кг" >
    </div>
    <div><input type="submit" id="dostavka-calculate" value ="Рассчитать"/></div>
  </div>
</form>