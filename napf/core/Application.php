<?php
namespace napf\core;

/**
 * Description of Application
 *
 * @author laurentc
 */
class Application {
    private $_name;
    private $_auth_path = "auth/";
    private $_beans_path = "bean/";
    private $_configuration_path = "configuration/";
    private $_servlets_path = "servlets/";
    private $_www_path = "www/";
    
    public function __construct($name){
        $this->_name = $name;
        Mapper::getInstance()->add($this);
        Properties::getInstance()->add($this);
        \napf\common\I18n::getInstance()->add($this);
    }
    
    public function getAuthPath(){
        return $this->_auth_path;
    }
    
    public function getBeansPath(){
        return $this->_beans_path;
    }
    
    public function getConfigurationPath(){
        return $this->_configuration_path;
    }
    
    public function getServletsPath(){
        return $this->_servlets_path;
    }
    
    public function getWwwPath(){
        return $this->_www_path;
    }
    
    public function getName(){
        return $this->_name;
    }
    
    public function getPath(){
        return NAPF_APPLICATIONS_PATH . $this->_name . "/";
    }
    
}