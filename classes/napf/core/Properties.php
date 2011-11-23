<?php
namespace napf\core;

class Properties {
	private static $_instance;
	/**
	 *
	 * @var \stdClass 
	 */
	private $_properties;
	
	public function __construct(){
		$this->_properties = new \stdClass();
		$this->_init();
	}
	private function _init(){
		$handle = opendir(NAPF_PROPERTIES_PATH);
		while (($file = readdir($handle)) !== false) {
			if(pathinfo(NAPF_PROPERTIES_PATH . $file, PATHINFO_EXTENSION) == 'ini'){
				$this->load(NAPF_PROPERTIES_PATH . $file);
			}
		}
	}
	public function load($file){
		if(!is_file($file)){
			throw new Exception("Fichier " . $file . " introuvable");
		}
		$content = parse_ini_file($file, true);
		// on récupère les propriétés de l'environnement désiré
		$envprops = $content[NAPF_ENVIRONMENT];
		$object = $this->_convert($envprops);
		$this->_properties->{pathinfo($file, PATHINFO_FILENAME)} = $object;
	}
	/*private function _convert($array){
	    $ar = array();
	    if(is_array($array) && count($array) > 0){
		    foreach ($array as $key=>$val){
			$this->_parseDot($ar,$key, $val);
		    }
	    }
	}
	private function _parseDot(&$array, $string, $value){
	    $part = str_replace('.', '\'][\'', $string);
	    $eval = '$array[\''.$part.'\'] = \'$value\';';
	    eval($eval);
	}*/
	private function _convert($array){
		$object = new \stdClass();
		if(is_array($array) && count($array) > 0){
			foreach ($array as $key=>$val){
				if(is_array($val)){
					$this->_dotToObject($object, $key,$this->_convert($val));
				} else {
					$this->_dotToObject($object, $key,$val);
				}
			}
		}
		return $object;
	}
	private function _dotToObject(&$object, $string, $value=null){
		$parts = explode('.', $string);
		if(count($parts) > 0){
			$obj = $object;
			$i = 1;
			$max = count($parts);			
			foreach($parts as $part){
				if(!isset($obj->$part)){
					$obj->$part = ($i == $max)?$value:new \stdClass();
				}
				$obj = $obj->$part;
				++$i;
			}
			$obj = $value;
		}else{
			$object->$string = $value;
		}
	}
	public function __clone(){}	
	/**
	 * singleton
	 * @return \napf\core\Properties
	 */
	public static function getInstance(){
		if(null === self::$_instance){
			$c = __CLASS__;
			self::$_instance = new $c;
		}
		return self::$_instance;
	}
	public function __get($property){
		if(isset($this->_properties->$property)){
			return $this->_properties->$property;
		}
		return null;
	}
}