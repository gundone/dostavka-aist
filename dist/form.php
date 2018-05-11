<?php
wp_enqueue_script("tariff", "/wp-content/plugins/aist-dostavka/dist/js/tariff.js");
wp_enqueue_script("autocomplete", "/wp-content/plugins/aist-dostavka/dist/autocomplete/auto-complete.js");
wp_enqueue_script("dostavka-calc", "/wp-content/plugins/aist-dostavka/dist/js/dostavka-calc.js", array(), "1.44");
wp_enqueue_style ("autoCompleteStyles", "/wp-content/plugins/aist-dostavka/dist/autocomplete/auto-complete.css");
wp_enqueue_style ("dostavka-styles", "/wp-content/plugins/aist-dostavka/dostavka.css");
?>
<h1><b>Калькулятор доставки</b></h1>
<form id="dostavka-form" class="calc" method="post" action="/<?php echo get_option("dostavka_url"); ?>">
  <div class="dostavka-wrapper">
    <span class="twitter-typeahead" style="position: relative; display: inline-block;">
      <input class="dostavka-input" type="text" name ="from" id="dostavka-from" value="<?php echo $_POST['from-p']; ?>" placeholder="Откуда">
    </span>
    <div class="dostavka-wrapper">
      <span class="twitter-typeahead" style="position: relative; display: inline-block;">
        <input class="dostavka-input" type="text" name ="to" id="dostavka-to" value="<?php echo $_POST['to-p']; ?>" placeholder="Куда">
      </span>
    </div>           
    <input name="from_type" type="hidden" value="">
    <input name="to_type" type="hidden" value="">
    
    <div class="tip-dostavki">
        <p><b>Тип доставки:</b></p>
        
        <ul class="check-boxes">
            <li class="check-box">
                <ul class="check-boxes">
                    <li class="check-box">
                        <input type="radio" id="store-store" name="dostavka-tip" value="store-store">
                    </li>
                    <li class="check-box">
                        <label for="store-store">Склад - Склад</label>
                    </li>
                </ul>
            </li>
            <li class="check-box">
                <ul class="check-boxes">
                    <li class="check-box">
                        <input type="radio" id="store-door" name="dostavka-tip" value="store-door" checked>
                    </li>
                    <li class="check-box">
                        <label for="store-door">Склад - Дверь</label>
                    </li>
                </ul>
            </li>
            <li class="check-box">
                <ul class="check-boxes">
                    <li class="check-box">
                        <input type="radio" id="door-door" name="dostavka-tip" value="door-door">
                    </li>
                    <li class="check-box">
                        <label for="door-door">Дверь - Дверь</label>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    
    <div class="form-control field">
      <div>
        <input class="dostavka-input" name="weight" id="dostavka-weight" type="text" value="<?php echo $_POST['weight-p'] == "" ? 1: $_POST['weight-p']; ?>" placeholder="Вес">КГ
      </div>
      <div class="">
        <ul class="all_dost-short">
            <li><input name="volume[]" class="dost-short" id="dostavka-l" type="text" placeholder="Длина">СМ х</li>
            <li><input name="volume[]" class="dost-short" id="dostavka-w" type="text" placeholder="Ширина">СМ х</li>
            <li><input name="volume[]" class="dost-short" id="dostavka-h" type="text" placeholder="Высота">СМ</li>
        </ul>
        <span id="volWeight"></span>
      </div>
    </div>

    
    <p style="margin: 28px 0 5px 0;"><b>Дополнительный параметры:</b></p>
    
    <ul class="check-boxes">
        <li  class="check-box">
            <ul class="check-boxes">
                <li class="check-box">
                    <input type="checkbox" id="oplataPol" name="oplataPol">
                </li>
                <li class="check-box">
                    <label for="oplataPol">Оплата получателем</label>
                </li>
            </ul>
        </li>
        <li class="check-box">
            <ul class="check-boxes">
                <li class="check-box">
                    <input type="checkbox" id="strahovka" name="strahovka">
                </li>
                <li class="check-box">
                    <label for="strahovka">Страховка</label>
                </li>
            </ul>
        </li>
    </ul>
    
<!--    <div>
      <input type="button" id="dostavka-calculate" value ="Рассчитать"/>
    </div>-->
    <div id="dostavka-result" style="display: none;">
      <div id="dostavka-res">

      </div>
    </div>
    <input type="hidden" id ="dost-cost" name="dost-cost" value="0"/>
  </div>
  
  <div id="order-form">
    <input type="text" name="dost-user"  placeholder="Ваше имя"/>
    <input type="text" name="dost-phone" id="dost-phone" placeholder="Контактный телефон"/>
    <input type="text" name="dost-email" id="dost-email" placeholder="e-mail"/>
    <br/>
    <input type="submit" id="dostavka-submit"  value ="Отправить заявку"/>
  </div>
</form>