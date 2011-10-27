<?php
/**
 * Created by IntelliJ IDEA.
 * User: laurentc
 * Date: 27/06/11
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */
namespace napf\common;
 
class IniFile {
    private $_path;
    private $_params;

    public function __construct($path){
        if(!is_file($path)){
            $path .= ".ini";
        }
        if(!is_file($path)){
            throw new IniFileException("Fichier `$path` introuvable !");
        }
        $this->_path = $path;
        $this->_init();
    }
    public function get($name, $collection=null){
        if($collection === null){
            return $this->_params[$name];
        } else {
            return $this->_params[$collection.".".$name];
        }
    }
    public function toArray(){
        return $this->_params;
    }
    private function _init(){
        //$this->_params = parse_ini_file($this->_path);
        $values = parse_ini_file($this->_path);
        $handler = "";
        foreach($values as $key=>$val){
            $tmp = explode(".", $key);
            $handler .= "\$this->_params";
            foreach ($tmp as $part){
                $handler .= "['$part']";
            }
            $handler .= "= '$val';";
        }
        eval($handler);
    }
}
class IniFileException extends \napf\core\NapfException{}