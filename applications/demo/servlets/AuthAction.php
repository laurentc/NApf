<?php
/**
 * Created by JetBrains PhpStorm.
 * User: laurentc
 * Date: 15/12/11
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

namespace demo\servlets;

class AuthAction extends \napf\core\Servlet
{
    public function doPost(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response){
        $login = $request->getParameter('login');
        $pass = $request->getParameter('pass');
        $loginContext = \napf\auth\LoginContextFactory::get(new DemoLoginModule());
        $isauth = $loginContext->login($login, $pass);
        if($isauth){
            $request->getRequestDispatcher('demo/auth2.php')->forward($request, $response);
        } else {
            $response->sendRedirect('demo_auth.na?errors=Login/mot de passe incorrect');
        }
    }
}
