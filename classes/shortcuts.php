<?php
// MVC
/**
 * @return \napf\core\NapfServletRequest
 */
function getRequest(){
    return \napf\core\NapfController::getInstance()->request;
}
/**
 * @return \napf\core\NapfServletResponse
 */
function getResponse(){
    return \napf\core\NapfController::getInstance()->response;
}
// AUTH
include NAPF_CLASSES_PATH . "napf/auth/LoginContext.php";
/**
 * @param string $name
 * @return \napf\auth\LoginContext
 */
function getLoginContext($loginModule){
    return \napf\auth\LoginContextFactory::get($loginModule);
}
/**
 * @return \napf\auth\Subject
 */
function getUser(){
    $lc = \napf\core\NapfHttpSession::getAttribute("LoginContext");
    if($lc !== null && $lc->getSubject() !== null){
        return $lc->getSubject();
    }
    return new \napf\auth\Subject();
}
// CACHE
/**
 * @param string $name
 * @return mixed
 */
function getCache($name){
    return \napf\core\Cache::get($name);
}
/**
 * @param string $name
 * @param mixed $value
 * @return void
 */
function setCache($name, $value){
    \napf\core\Cache::set($name, $value);
}
/**
 * @param string $name
 * @return bool
 */
function cacheExist($name){
    return \napf\core\Cache::exist($name);
}
// HELPERS
/**
 * @param $path
 * @return \napf\common\IniFile
 */
function getIniFile($path){
    return new \napf\common\IniFile($path);
}
/**
 * @param $path
 * @param array $params
 * @return void
 */
function url_echo($path, $params = array()){
    echo \napf\helpers\Url::get($path, $params);
}
function getProperty($name){
    $prop = \napf\core\Properties::getInstance();
    return $prop->$name;
}
