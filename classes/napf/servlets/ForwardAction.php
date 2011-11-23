<?php
namespace napf\servlets;

class ForwardAction extends \napf\core\Servlet{
    public function doRequest(\napf\core\ServletRequest &$request, \napf\core\ServletResponse &$response, $forward){
        $request->getRequestDispatcher($forward)->forward($request, $response);
    }
}
