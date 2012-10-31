<?php
namespace admin\servlets\application;

class UpdAction extends \napf\core\Servlet{
    public function doGet(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response)
    {
        $request->getRequestDispatcher('application/mod.php@layout.php')->forward($request, $response);
    }
}