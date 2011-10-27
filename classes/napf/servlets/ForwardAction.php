<?php
namespace napf\servlets;

class ForwardAction extends \napf\core\NapfServlet{
    public function doRequest(\napf\core\NapfServletRequest &$request, \napf\core\NapfServletResponse &$response, $forward){
        $request->getRequestDispatcher($forward)->forward($request, $response);
    }
}
