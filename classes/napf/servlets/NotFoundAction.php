<?php
/**
 * Created by JetBrains PhpStorm.
 * User: laurentc
 * Date: 23/06/11
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
 namespace napf\servlets;

 class NotFoundAction extends \napf\core\Servlet
 {
     public function doGet(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){
         $request->getRequestDispatcher("404.php")->forward($request, $response);
     }
 }