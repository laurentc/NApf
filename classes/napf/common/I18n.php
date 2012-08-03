<?php
namespace napf\common;

/**
 * Classe permettant de récupérer la traduction d'un texte
 *
 * @author laurentc
 */
class I18n {
    private static $_instance = null;
        
    public function getLocales(){
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
        
        return $lang_parse[1];
    }
    public function getDefaultLocale(){
        $locales = $this->getLocales();
        
        return $locales[0];
    }
    public function get($code, $locale = null){
        if ($locale == null){
            $locale = $this->getDefaultLocale();
        }
        $tmp = explode('.', $code);
        $file = "";
        $code = "";
        if(count($tmp) < 1){
            throw new \Exception("Code invalide : " + $code);
        }else if(count($tmp) == 1){
            $file = "default";
            $code = $tmp[0];
        }else{
            $file = $tmp[0];
            $code = $tmp[1];
        }
        $xml = new \SimpleXMLElement(file_get_contents(NAPF_TRADUCTIONS_PATH . $file . ".xml"));
        foreach($xml->traduction as $traduction){
            if($traduction['code'] == $code){
                foreach($traduction->lang as $lang){
                    if($lang['locale'] == $locale){
                        return (String)$lang;
                    }
                }
            }
        }
    }
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
