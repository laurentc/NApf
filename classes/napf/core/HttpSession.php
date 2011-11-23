<?php
namespace napf\core;
session_start();

class HttpSession
{    
    /**
     * @param  string $name
     * @return mixed
     */
    public static  function getAttribute($name){
        return (isset($_SESSION[$name]))?$_SESSION[$name]:null;
    }
    /**
     * @return array
     */
    public static  function getAttributeNames(){
        return array_keys($_SESSION);
    }
    public static  function destroy(){
        unset($_SESSION);
    }
    public static  function invalidate(){
        self::destroy();
    }
    public static function setAttribute($name, $value){
        $_SESSION[$name] = $value;
    }
    public static  function removeAttribute($name){
        unset($_SESSION[$name]);
    }
    public static function setContext($contextname = 'default'){
	if(!isset($_SESSION['context']) || !in_array($contextname, $_SESSION['context'])){
	    $_SESSION['context'][$contextname] = new Context($contextname, session_id());
	}
    }
    /**
     * \napf\core\Context
     * @return type 
     */
    public static function getContext(){
	return (isset($_SESSION['context']))?$_SESSION['context']:null;
    }
}