<?php
namespace napf\core;

class Context {
    /**
     *	liste des sessions
     * @var array<string>
     */
    private $_sessions = array();
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
    
    public function __construct($name, $session){
	$this->_name = $name;
	$property = new Properties();
	$this->_attributes = (array)$property->demo;
	if(!in_array($session, $this->_sessions)){
	    $this->_sessions[] = $session;
	}
    }
    public function getConnection($name = 'default'){
	if($this->_attributes['connection'][$name]){
	    $parameters = $this->_attributes['connection'][$name];
	    
	}
	return null;
    }
    /**
     * usine de contexte
     * @param string $name
     * @param string $session
     * @return \napf\core\Context 
     */
    public static function factory($name, $session){
	if(!isset(self::$_array[$name])){
		    $c = __CLASS__;
		    self::$_array[$name] = new $c($name, $session);
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
    public function getAttributes(){
	return $this->_attributes;
    }
    public function getAttribute($attribute){
	if(isset($this->_attributes[$attribute])){
	    return $this->_attributes[$attribute];
	}
	
	return null;
    }
    public function addSession($session){
	$this->_sessions[] = $session;
    }
    public function getSessions(){
	return $this->_sessions;
    }
}

?>
