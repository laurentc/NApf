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
    
    public function __construct($name, $session){
	$this->_name = $name;
    }
    public function addSession($session){
	$this->_sessions[] = $session;
    }
    public function getSessions(){
	return $this->_sessions;
    }
}

?>
