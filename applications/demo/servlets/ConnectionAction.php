<?php
namespace demo\servlets;

class ConnectionAction extends \napf\core\Servlet
{
     public function doGet(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response) {
         \napf\core\Properties::getInstance()->connection;
         //$connection = new \napf\sql\MysqlConnection($connectionString, $user, $password);
         
         return $request->getRequestDispatcher("connection.php")->forward($request, $response);
     }
}