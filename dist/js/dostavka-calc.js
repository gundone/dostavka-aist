/* global tariff */

if (!Array.prototype.filter) {
  Array.prototype.filter = function(fun/*, thisArg*/) {
    'use strict';

    if (this === void 0 || this === null) {
      throw new TypeError();
    }

    var t = Object(this);
    var len = t.length >>> 0;
    if (typeof fun !== 'function') {
      throw new TypeError();
    }

    var res = [];
    var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
    for (var i = 0; i < len; i++) {
      if (i in t) {
        var val = t[i];
        if (fun.call(thisArg, val, i, t)) {
          res.push(val);
        }
      }
    }

    return res;
  };
}

jQuery( document ).ready(function() {
  
    
  
    var regexFloat = /([0-9]+)[\.,]?([0-9]+)?/g;
    console.log(jQuery.fn.jquery);
    console.log("v=1.32");
    var calculate = function(){
      if(!jQuery("#dostavka-from").length)
        return;
      if(jQuery("#dostavka-from").val().length == 0 || jQuery("#dostavka-to").val().length == 0){
        jQuery("#dostavka-result").hide();
        return;
      }
      
      
      var variants = tariff.filter(arraySearch);
      var weight = parseFloat(jQuery("#dostavka-weight").val());
      if(isNaN(weight)){
        weight = 1;
      }
      jQuery("#dostavka-res").text("");
      jQuery("#dostavka-result").hide();
      var volume = Math.ceil(getVolume() / 5000);
      if(!isNaN(volume)){
        weight = Math.max(weight, volume);
      }
      if(typeof(weight) === 'number' && variants.length > 0){
        if(weight < 1){
          for(var x in variants){
            var cost = variants[x].upto_1;
            appendVariants(cost, variants, x);
          }
        }
        else {
          for(var x in variants){
            var cost;
            var price;
            if(weight < 1){
              price = variants[x].upto_1
            }
            else if( weight <=20){
              price = variants[x].upto_20
            }
            else if (weight <= 30){
              price = variants[x].upto_30
            }
            else if (weight <= 100){
              price = variants[x].upto_100
            }
            else if (weight <= 300){
              price = variants[x].upto_300
            }
            else if (weight <= 500){
              price = variants[x].upto_500
            }
            
            if(/\d+\s*\(\+\d+\)/i.test(price)){
              var fixPrice = price.match(regexFloat);
              cost = Math.ceil(weight) * parseFloat(fixPrice[0]) + parseFloat(fixPrice[1]);
            }
            else if(!isNaN(price)){
               cost = variants[x].upto_1 
                      + Math.max(0, Math.min(19, Math.ceil(weight-1)))    *(isNaN(variants[x].upto_20)  ? 0 : variants[x].upto_20)
                      + Math.max(0, Math.min(10, Math.ceil(weight-20)))   *(isNaN(variants[x].upto_30)  ? 0 : variants[x].upto_30)
                      + Math.max(0, Math.min(70, Math.ceil(weight-30)))   *(isNaN(variants[x].upto_100) ? 0 : variants[x].upto_100)
                      + Math.max(0, Math.min(200, Math.ceil(weight-100))) *(isNaN(variants[x].upto_300) ? 0 : variants[x].upto_300)
                      + Math.max(0, Math.min(200, Math.ceil(weight-300))) *(isNaN(variants[x].upto_500) ? 0 : variants[x].upto_500);
                   
            }
            else {
              cost = price;
            }
            appendVariants(cost, variants, x);
          }
        }
        jQuery("#dostavka-result").show();
      }
      else if(jQuery("#dostavka-from").val().length > 0 && jQuery("#dostavka-to").val().length > 0 ) {
        jQuery("#dostavka-res").append("<p>По данным параметрам мы можем предложить вам индивидуальный расчет. Пожалуйста, укажите свои контактные данные и наши специалисты свяжутся с Вами");
        jQuery("#dostavka-result").show();
        jQuery("#order-form").show();
      }
    };
   
    calculate();
    jQuery("#dostavka-weight").keypress(function(e) {
      e = e || window.event;
      var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
      var charStr = String.fromCharCode(charCode);
      if (!/\d/.test(charStr)) {
          return false;
      }
    });
    jQuery("#strahovka").change(calculate);
    jQuery("#dostavka-calculate").click(calculate);
    jQuery("#oplataPol").change(calculate);
    jQuery("input[name='dostavka-tip']").change(calculate);
   
    
    jQuery(".dost_zakaz").live ("click", function(){
      var calc = jQuery(this).prev("b").text();
     
      jQuery('#dost-cost').val(calc);
      console.log(jQuery('#dost-cost').val());
      jQuery("#order-form").show();
    });
    
    jQuery("#dost-phone").keyup(function(){
      var phone = jQuery(this).val();
      var regex = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
      if(regex.test(phone)){
        console.log("test true");
        jQuery("#dostavka-submit").show();
      }
      else {
         console.log("test false");
        jQuery("#dostavka-submit").hide();
      }
    
    });
    
    jQuery("#dost-phone").click(function(){
      var phone = jQuery(this).val();
      var regex = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
      if(regex.test(phone)){
        console.log("test true");
        jQuery("#dostavka-submit").show();
      }
      else {
         console.log("test false");
        jQuery("#dostavka-submit").hide();
      }
    
    });
    
    jQuery("#dost-phone").change(function(){
      var phone = jQuery(this).val();
      var regex = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
      if(regex.test(phone)){
        console.log("test true");
        jQuery("#dostavka-submit").show();
      }
      else {
         console.log("test false");
        jQuery("#dostavka-submit").hide();
      }
    
    });
    
    jQuery('#dostavka-form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });
    new autoComplete({
      selector: '#dostavka-from',
      minChars: 1,
      source: function(term, suggest){
        var list =  tariff.filter(arrayMatchFrom);
        var from = [];
        for(var x in list)
              from.push(list[x].from);
        suggest(from.filter(onlyUnique));
      }, 
      onSelect: function(e, term, item){
        calculate();
      }
    });
     new autoComplete({
      selector: '#dostavka-to',
      minChars: 1,
      source: function(term, suggest){
        var list =  tariff.filter(arrayMatchTo);
        var to = [];
        for(var x in list)
              to.push(list[x].to);
        suggest(to.filter(onlyUnique));
      },
      onSelect: function(e, term, item){
        calculate();
      }
    });
    new autoComplete({
      selector: '#dostavka-from-p',
      minChars: 1,
      source: function(term, suggest){
        var list =  tariff.filter(arrayMatchFromP);
        var from = [];
        for(var x in list)
              from.push(list[x].from);
        suggest(from.filter(onlyUnique));
      }
    });
     new autoComplete({
      selector: '#dostavka-to-p',
      minChars: 1,
      source: function(term, suggest){
        var list =  tariff.filter(arrayMatchToP);
        var to = [];
        for(var x in list)
              to.push(list[x].to);
        suggest(to.filter(onlyUnique));
      }
    });
    function arrayMatchFrom(element){
      if(typeof(element.from) === 'string')
        return element.from.toLowerCase().search(jQuery("#dostavka-from").val().toLowerCase()) >= 0;
      return false;
    }
    function arrayMatchFromP(element){
      if(typeof(element.from) === 'string')
        return element.from.toLowerCase().search(jQuery("#dostavka-from-p").val().toLowerCase()) >= 0;
      return false;
    }
    function arrayMatchTo(element){
      if(typeof(element.to) === 'string')
        return element.to.toLowerCase().indexOf(jQuery("#dostavka-to").val().toLowerCase()) >=0;
      return false;
    }
    function arrayMatchToP(element){
      if(typeof(element.to) === 'string')
        return element.to.toLowerCase().indexOf(jQuery("#dostavka-to-p").val().toLowerCase()) >=0;
      return false;
    }
    
    function arraySearch(element){
      var type = jQuery('input[name=dostavka-tip]:checked', '.calc').val();
      if(typeof(element.from) === 'string' && typeof(element.to) === 'string')
        return element.from.toLowerCase() === jQuery("#dostavka-from").val().toLowerCase()
            && element.to.toLowerCase() === jQuery("#dostavka-to").val().toLowerCase()
            && element[type] === "+";
      return false;
    }
    
    function getVolume(){
      var vol = parseFloat(jQuery("#dostavka-l").val()) 
              * parseFloat(jQuery("#dostavka-w").val()) 
              * parseFloat(jQuery("#dostavka-h").val());
      console.log("vol = "+vol);
      //console.log(vol);
      return vol;
    }
    
    function appendVariants(cost, variants, x){
      if(jQuery("#strahovka").prop("checked"))
                cost = cost * 1.00;
      if(jQuery("#oplataPol").prop("checked"))
        cost = cost + 100;
      if (isNaN(cost))
        cost = "индивидуально";
      else 
        cost = cost + "руб.";
      jQuery("#dostavka-res").append("<p>" + variants[x].time + ":&nbsp;" + "<b>"+cost+"</b>"
              + "&nbsp;<input type='button' class='dost_zakaz' value='Заказать'/>");
    }
    function onlyUnique(value, index, self) { 
      return self.indexOf(value) === index;
    }
    
    
    jQuery("#dostavka-weight").keyup(function(){
       if(!isNaN(parseFloat(jQuery("#dostavka-weight").val()))){
          calculate();
       }
    });
    jQuery("input.dost-short").keyup(function(){
      var vol = Math.ceil(parseFloat(jQuery("#dostavka-l").val()) 
              * parseFloat(jQuery("#dostavka-w").val()) 
              * parseFloat(jQuery("#dostavka-h").val()) / 5000);
      if(!isNaN(vol)){
        jQuery("#volWeight").text("Объемный вес = "+vol+"кг");
        calculate();
      }
      else {
        jQuery("#volWeight").text("");
      }
    });
});

