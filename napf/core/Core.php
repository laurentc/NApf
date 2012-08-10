<?php
namespace napf\core;

/**
 * Description of Context
 *
 * @author laurentc
 */
class Core 
{
    /**
     *
     * @var \napf\core\Core 
     */
    private static $_instance = null;
    /**
     *
     * @var \napf\core\Controller 
     */
    private $_controller = null;
    /**
     *
     * @var array 
     */
    private $_applications = array();

    public function __construct(){
        $this->_controller = Controller::getInstance();
        $this->listApplications();
    }
    
    private function listApplications(){
        $fHandler = opendir(NAPF_APPLICATIONS_PATH);
        while($file = readdir($fHandler)){
            if(!in_array($file, array('.', '..'))){
                $this->_applications[$file] = new Application($file);
            }
        }
    }
    
    public function getController(){
        return $this->_controller;
    }
    
    /**
     *
     * @param string $name
     * @return \napf\core\Application
     * @throws \Exception 
     */
    public function getApplication($name){
        if(!isset($this->_applications[$name])){
            throw new \Exception("Application '$name' inexistante");
        }
       return  $this->_applications[$name];
    }
    /**
     *
     * @return \napf\core\Core 
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }
}
