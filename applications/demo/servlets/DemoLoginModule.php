<?php
/**
 * Created by JetBrains PhpStorm.
 * User: laurentc
 * Date: 15/12/11
 * Time: 13:43
 * To change this template use File | Settings | File Templates.
 */
namespace demo\servlets;

class DemoLoginModule extends \napf\auth\LoginModule
{

    /**
     * @param $login
     * @param $password
     * @return void
     */
    public function login($login, $password)
    {
        $idents = array('admin'=>'nimda');
        if(isset($idents[$login]) && $idents[$login] === $password){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return void
     */
    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
