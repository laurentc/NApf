<?php
function __autoload($class){
	//trick linux
	$class = str_replace('\\', '/', $class);
	$path = NAPF_CLASSES_PATH . $class .".php";
	if(is_file($path)){
		include $path;
	}else {
        throw new Exception("Classe $class introuvable");
	}
}