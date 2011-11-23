<?php
namespace napf\auth;

class LoginContext {
    /**
     * @var \napf\auth\LoginModule
     */
    private $_loginModule;
    private $_classModule;
    private $_redirect = null;

    public function __construct($loginModule){
        $this->_classModule = "\\auth\\" . ucfirst($loginModule) . "LoginModule";
        $this->_loginModule = new $this->_classModule;
    }
    public function getSubject(){
        return $this->_loginModule->getSubject();
    }
    public function login($login, $password){
        if($this->_loginModule->login($login, $password)){
            $this->_loginModule->commit();
            return true;
        }
        return false;
    }
    public function logout(){
        $this->_loginModule = new $this->_classModule;
    }
    public function setRedirect($val){
        $this->_redirect = $val;
    }
    public function getRedirect(){
        return $this->_redirect;
    }
}
class LoginContextFactory
{
    public static function get($loginModule){
        $loginContext = \napf\core\HttpSession::getAttribute("LoginContext");
        if($loginContext === null){
            $loginContext= new LoginContext($loginModule);
            \napf\core\HttpSession::setAttribute("LoginContext", $loginContext);
        }
        return $loginContext;
    }
}