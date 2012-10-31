<?php
namespace admin\servlets\application;

class AddAction extends \napf\core\Servlet{
    public function doGet(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response)
    {
        $request->getRequestDispatcher('application/add.php@layout.php')->forward($request, $response);
    }
}