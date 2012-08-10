<?php
// MVC
/**
 * @return \napf\core\NapfServletRequest
 */
function getRequest()
{
    return \napf\core\Controller::getInstance()->request;
}

/**
 * @return \napf\core\NapfServletResponse
 */
function getResponse()
{
    return \napf\core\Controller::getInstance()->response;
}

// AUTH
include NAPF_CORE_PATH . "auth/LoginContext.php";
/**
 * @param string $name
 * @return \napf\auth\LoginContext
 */
function getLoginContext($loginModule)
{
    return \napf\auth\LoginContextFactory::get($loginModule);
}

/**
 * @return \napf\auth\Subject
 */
function getUser()
{
    $lc = \napf\core\HttpSession::getAttribute("LoginContext");
    if ($lc !== null && $lc->getSubject() !== null) {
        return $lc->getSubject();
    }
    return new \napf\auth\Subject();
}

// CACHE
/**
 * @param string $name
 * @return mixed
 */
function getCache($name)
{
    return \napf\core\Cache::get($name);
}

/**
 * @param string $name
 * @param mixed $value
 * @return void
 */
function setCache($name, $value)
{
    \napf\core\Cache::set($name, $value);
}

/**
 * @param string $name
 * @return bool
 */
function cacheExist($name)
{
    return \napf\core\Cache::exist($name);
}

// HELPERS
/**
 * @param $path
 * @return \napf\common\IniFile
 */
function getIniFile($path)
{
    return new \napf\common\IniFile($path);
}

/**
 * @param $path
 * @param array $params
 * @return void
 */
function url_echo($path, $params = array())
{
    echo \napf\helpers\Url::get($path, $params);
}

function getProperty($name)
{
    $prop = \napf\core\Properties::getInstance();
    return $prop->$name;
}
/**
 *
 * @param string $code
 * @param string $locale
 * @return string 
 */
function i18n($code, $locale = null){
    return napf\common\I18n::getInstance()->get($code, $locale);
}