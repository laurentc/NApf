<?php
function __autoload($class)
{
    //trick linux
    $class = str_replace('\\', '/', $class);
    if(!empty($class)){
        if($class != null && strlen($class) > 4 && substr($class, 0, 4) == 'napf'){
            include NAPF_ROOT_PATH . $class . '.php';
        } else {
           $path = NAPF_APPLICATIONS_PATH . $class . ".php";
           include $path;
        }
    }
}