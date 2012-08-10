<?php
namespace napf\core;

class Properties
{
    private static $_instance;
    private $_properties = array();
    
    /**
     *
     * @param \napf\core\Application $application 
     */
    public function add($application){
        if(!isset($this->_properties[$application->getName()]) 
                || NAPF_ENVIRONMENT === Controller::ENVIRONMENT_DEVELOPMENT){
            $this->_properties[$application->getName()] = $this->_refreshCache($application);
        }
    }
    
    /**
     *
     * @param \napf\core\Application $application 
     */
    private function _refreshCache($application){
        $this->loadIni($application->getPath() . $application->getConfigurationPath() ."properties.ini", $application->getName());
    }
    
    public function loadIni($file, $applicationName)
    {
        if (!is_file($file)) {
            throw new \Exception("Fichier " . $file . " introuvable");
        }
        $content = parse_ini_file($file, true);
        // on récupère les propriétés de l'environnement désiré
        $envprops = $content[NAPF_ENVIRONMENT];
        $object = $this->_convert($envprops);
        $this->_properties[$applicationName] = $object;
        var_dump($this->_properties);
    }

    private function _convert($array)
    {
        $ar = array();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $key => $val) {
                $this->_parseDot($ar, $key, $val);
            }
        }
        return $ar;
    }

    private function _parseDot(&$array, $string, $value)
    {
        $part = str_replace('.', '\'][\'', $string);
        $eval = '$array[\'' . $part . "'] = '$value';";
        eval($eval);
    }

    public function __get($name)
    {
        debug_print_backtrace();
        var_dump($this->_properties);
        return (isset($this->_properties[$name])) ? $this->_properties[$name] : null;
    }

    public function __clone()
    {
    }

    /**
     * singleton
     * @return \napf\core\Properties
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