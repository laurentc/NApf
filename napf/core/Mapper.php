<?php
namespace napf\core;

class Mapper
{
    private static $_instance = null;
    private $_mappings = array();
    public $currentApplication;

    /**
     * @static
     * @return \napf\core\Mapper
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }
    /**
     *
     * @param \napf\core\Application $application 
     */
    public function add($application){
        if(!isset($this->_mappings[$application->getName()]) 
                || NAPF_ENVIRONMENT === Controller::ENVIRONMENT_DEVELOPMENT){
            $this->_mappings[$application->getName()] = $this->_refreshCache($application);
        }
    }

    public function getMapInfo($path)
    {
        $tmp = explode("/", $path);
        if(count($tmp) > 0){
            $application = $tmp[0];
            unset($tmp[0]);
        } else{
            $application = NAPF_DEFAULT_APPLICATION;
        }
        $mapping = null;
        try{
            $this->currentApplication = Core::getInstance()->getApplication($application);
            $servletPath = implode("/", $tmp);
            $mapping = $this->_mappings[$application];
            $servletPath = substr($servletPath, 0, 1) !== "/" ? "/" . $servletPath : "";
            if(isset($mapping[$servletPath])){
                $mapping[$servletPath]['classname'] = $application . "\\" . $mapping[$servletPath]['classname'];
            }
        }catch(\Exception $e){
            \napf\helpers\Logger::getInstance('napf_core')->log($e->getMessage());
        }
        if($mapping === null || !isset($mapping[$servletPath])){
            throw new \Exception('Mapping introuvable');
        }
        return $mapping[$servletPath];
    }

    /**
     *
     * @param \napf\core\Application $application
     * @return type 
     */
    private function _refreshCache($application)
    {
        $toReturn = array();
        
        if(is_file($application->getPath() . $application->getConfigurationPath() ."mapping.xml")){
            $xml = new \SimpleXMLElement(file_get_contents($application->getPath() . $application->getConfigurationPath() ."mapping.xml"));
            $temp = $xml->xpath("/web-app/servlet/servlet-name");
            foreach ($temp as $object) {
                $temp2 = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/url-pattern");
                $temp3 = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/servlet-class");
                $params = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/init-param");
                $temp4 = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/php-file");
                $initParams = array();
                foreach ($params as $param) {
                    $name = $param->xpath("param-name");
                    $value = $param->xpath("param-value");
                    $initParams[(string)$name[0]] = (string)$value[0];
                }
                if(!isset($initParams['context'])){
                    $initParams['context'] = (string)$temp[0];
                }

                $pattern = (count($temp2) > 0) ? $temp2[0] : null;
                if($pattern !== null){
                    $toReturn[(string)$pattern]["classname"] = (count($temp3) > 0) ? (string)$temp3[0] : null;
                    $toReturn[(string)$pattern]["initparams"] = $initParams;
                    $toReturn[(string)$pattern]["php-file"] = (count($temp4) > 0) ? (string)$temp4[0] : null;
                }
            }
        }else{
            throw new Exception("Aucun fichier de mapping trouvé pour l'application '" . $application->getName() . "'");
        }
            
        return $toReturn;
    }
}