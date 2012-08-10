<?php
namespace auth;

class DemoLoginModule extends \napf\auth\LoginModule
{

    /**
     * @param $login
     * @param $password
     * @return void
     */
    public function login($login, $password)
    {
        $tals = array('admin'=>'login');
        if($tals[$login] === $password){
            $this->getSubject()->login = $login;
            $this->getSubject()->password = $password;
            $this->getSubject()->addCredentials("demo");
            $this->commit();
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
