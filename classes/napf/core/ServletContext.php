<?php
namespace napf\core;

class ServletContext {
    /**
     * Nom du context
     * @var string 
     */
    private $_name = null;
    /**
     *	liste des attributs
     * @var array<mixed> 
     */
    private $_attributes = array();
    private static $_array = array();
    private $_connections = array();
    
    public function __construct($name){
	$this->_name = $name;
	$property = new Properties();
	$this->_attributes = $property->$name;
    }
    /**
     *
     * @param string $name
     * @return \napf\sql\IConnection|null 
     */
    public function getConnection($name = 'default'){
	if(!isset($this->_connections[$name])){
	    if(isset($this->_attributes['connection'][$name])){
		$parameters = $this->_attributes['connection'][$name];
		foreach ($parameters as $key=>$val){
		    break;
		}
		$this->_connections[$name] =  \napf\sql\ConnectionFactory::get($key, $val);
	    } else {
		return null;
	    }
	}
	return $this->_connections[$name];
    }
    /**
     * usine de contexte
     * @param string $name
     * @param string $session
     * @return \napf\core\Context 
     */
    public static function factory($name){
	if(!isset(self::$_array[$name])){
		    $c = __CLASS__;
		    self::$_array[$name] = new $c($name);
	}
	
	return self::$_array[$name];
    }
    public function __clone(){}
    public static function destroy(){
	self::$_array = array();
    }
    public static function invalidate(){
	self::destroy();
    }
    public function getAttributeNames(){
	return $this->_attributes;
    }
    public function getAttribute($attribute){
	if(isset($this->_attributes[$attribute])){
	    return $this->_attributes[$attribute];
	}
	
	return null;
    }
}

