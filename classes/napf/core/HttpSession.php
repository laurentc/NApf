<?php
namespace napf\core;
session_start();

class NapfHttpSession
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
}