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
    
    public function __construct($name, $session){
	$this->_name = $name;
	$property = new Properties();
	$this->_attributes = (array)$property->demo;
    }
    public function getConnection($name = 'default'){
	if($this->_attributes['connection'][$name]){
	    $parameters = $this->_attributes['connection'][$name];
	    
	}
	return null;
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
