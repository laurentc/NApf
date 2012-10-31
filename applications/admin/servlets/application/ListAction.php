<?php
namespace admin\servlets\application;

class ListAction extends \napf\core\Servlet{
    public function doGet(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response)
    {
        $request->setAttribute('list', \napf\core\Application::getList());
        return $request->getRequestDispatcher('application/liste.php@layout.php')->forward($request, $response);
    }
}