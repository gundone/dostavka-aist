<?php
/*
Plugin Name: Доставка Аист
Plugin URI: http://aistseo.ru
Description: Этот плагин доставляет. Просто таки неимоверно доставляет.
Version: 1.0
Author: Ivan SizeOff
Author URI: http://aistseo.ru
*/
require_once __DIR__."/simplexlsx.class.php";
require_once __DIR__."/dostavka-menu-functions.php";
require_once __DIR__."/dostavka-content-functions.php";

add_action("admin_menu", "dostavka_menu");
add_action('init', "dostavka_init");
add_action('the_content', "dostavka_content");
