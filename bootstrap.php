<?php 
define('NAPF_ROOT_PATH', dirname(realpath(__FILE__)) . '/');
define('NAPF_CLASSES_PATH', NAPF_ROOT_PATH . 'classes/');
define('NAPF_CACHE_PATH', NAPF_ROOT_PATH . 'caches/');
define('NAPF_MAPPINGS_PATH', NAPF_ROOT_PATH . 'configurations/mappings/');
define('NAPF_PROPERTIES_PATH', NAPF_ROOT_PATH . 'configurations/properties/');
define('NAPF_WWW_PATH', NAPF_ROOT_PATH . 'www/');
define('NAPF_3PARTS_PATH', NAPF_ROOT_PATH . 'thirdparts/');
include 'classes/autoload.php';
include 'classes/shortcuts.php';

\napf\core\NapfController::getInstance()->process();
