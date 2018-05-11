<?php
/*
Plugin Name: Доставка Аист
Plugin URI: http://aistseo.ru
Description: Этот плагин доставляет. Просто таки неимоверно доставляет.
Version: 1.0
Author: Ivan SizeOff
Author URI: http://aistseo.ru
*/


define(DOSTAVKA_DIST_FOLDER,   __DIR__ 
                . DIRECTORY_SEPARATOR . "dist"
                . DIRECTORY_SEPARATOR);

define(DOSTAVKA_TRACKING_FOLDER,   __DIR__ 
                . DIRECTORY_SEPARATOR . "tracking"
                . DIRECTORY_SEPARATOR);

require_once __DIR__."/common/simplexlsx.class.php";
require_once __DIR__."/common/dostavka-menu-functions.php";
require_once __DIR__."/common/dostavka-content-functions.php";

add_action("admin_menu", "dostavka_menu");
add_action('init', "dostavka_init");
add_action('the_content', "dostavka_content");
