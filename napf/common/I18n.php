<?php
namespace napf\common;

/**
 * Classe permettant de récupérer la traduction d'un texte
 *
 * @author laurentc
 */
class I18n {
    private static $_instance = null;
    private $_locale;
    private $_traductions = array();
    
    public function __construct(){
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
        $this->_locale = $lang_parse[1];
    }
        
    public function getCurrentLocales(){
        return $this->_locale;
    }
    
    public function getCurrentLocale(){
        return $this->_locale[0];
    }
        
    public function get($code, $locale = null){
        if ($locale == null){
            $locale = $this->getCurrentLocale();
        }
        $appname = \napf\core\Controller::getInstance()->getCurrentApplication()->getName();
        if(!isset($this->_traductions[$appname][$code])){            
            return "_{$code}_";
        }else if(isset($this->_traductions[$appname][$code][$locale])){
            return $this->_traductions[$appname][$code][$locale];
        }else{
            $tmp = explode('-', $locale);
            if(isset($this->_traductions[$appname][$code][$tmp[0]])){
                return $this->_traductions[$appname][$code][$tmp[0]];
            }else{
                $trads = array_values($this->_traductions[$appname][$code]);
                return $trads[0];
            }
        }
    }
    /**
     *
     * @param \napf\core\Application $application 
     */
    public function add($application){
        if(isset($this->_traductions[$application->getName()])
            || NAPF_ENVIRONMENT === 'development'){
            $this->_traductions[$application->getName()] = $this->_refreshCache($application);
        }
    }
    
    /**
     *
     * @param \napf\core\Application $application
     * @return type 
     */
    private function _refreshCache($application){
        $files = $this->getI18nFiles(NAPF_APPLICATIONS_PATH . $application->getName() . "/" . $application->getConfigurationPath());
        $toReturn = array();
        foreach($files as $file){
            $xml = new \SimpleXMLElement(file_get_contents(NAPF_APPLICATIONS_PATH . $application->getName() . "/" . $application->getConfigurationPath() . "/" . $file));
            foreach($xml->traduction as $traduction){
                $toReturn[(string)$traduction['code']] = array();
                foreach($traduction->lang as $lang){
                    $toReturn[(string)$traduction['code']][(string)$lang['locale']] = (String)$lang;
                }
            }
        }
        
        return $toReturn;
    }
    
    private function getI18nFiles($path){
        $toReturn = array();
        $handler = opendir($path);
        while($file = readdir($handler)){
            if(preg_match("/^i18n(.)*.xml$/", $file)){
                $toReturn[] = $file;
            }
        }
        
        return $toReturn;
    }
    /**
     *
     * @return \napf\common\I18n 
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

?>
