<?php
namespace napf\core;

class Mapper
{
    private static $_instance = null;
    private $_initParams = null;

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

    public function getMapInfo($servletPath)
    {
        if (!\napf\core\Cache::exist("mapping")) {
            \napf\core\Cache::set("mapping", $this->refreshCache());
        }
        $mapping = \napf\core\Cache::get("mapping");
        $servletPath = substr($servletPath, 0, 1) !== "/" ? "/" . $servletPath : "";
        return ($mapping !== null && isset($mapping[$servletPath])) ? $mapping[$servletPath] : null;
    }

    public function refreshCache()
    {
        $toReturn = array();
        $dir = opendir(NAPF_MAPPINGS_PATH);
        while (($file = readdir($dir)) !== false) {
            $temp = explode(".", $file);
            if ($temp[count($temp) - 1] == "xml") {
                $xml = new \SimpleXMLElement(file_get_contents(NAPF_MAPPINGS_PATH . $file));
                $temp = $xml->xpath("/web-app/servlet/servlet-name");
                foreach ($temp as $object) {
                    $temp2 = $xml->xpath("/web-app/servlet-mapping[servlet-name='" . (string)$object . "']/url-pattern");
                    $temp3 = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/servlet-class");
                    $params = $xml->xpath("/web-app/servlet[servlet-name='" . (string)$object . "']/init-param");
                    $initParams = array();
                    foreach ($params as $param) {
                        $name = $param->xpath("param-name");
                        $value = $param->xpath("param-value");
                        $initParams[(string)$name[0]] = (string)$value[0];
                    }

                    $pattern = (count($temp2) > 0) ? $temp2[0] : null;
                    $className = (count($temp3) > 0) ? $temp3[0] : null;
                    $toReturn[(string)$pattern]["classname"] = (string)$className;
                    $toReturn[(string)$pattern]["initparams"] = $initParams;
                }
            }
        }
        closedir($dir);
        return $toReturn;
    }
}