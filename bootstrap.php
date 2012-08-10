<?php
define('NAPF_ROOT_PATH', dirname(realpath(__FILE__)) . '/');
define('NAPF_CORE_PATH', NAPF_ROOT_PATH . 'napf/');
define('NAPF_APPLICATIONS_PATH', NAPF_ROOT_PATH . 'applications/');
define('NAPF_DEFAULT_APPLICATION', 'default');

include NAPF_CORE_PATH . 'autoload.php';
include NAPF_CORE_PATH . 'shortcuts.php';

define('NAPF_ENVIRONMENT', \napf\core\Controller::ENVIRONMENT_DEVELOPMENT); // utilisé par les sections ini

\napf\core\Core::getInstance()->getController()->process();
