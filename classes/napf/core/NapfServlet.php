<?php
namespace napf\core;

abstract class NapfServlet
{
	public function doAfter(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	public function doBefore(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a DELETE request.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function doDelete(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a GET request.
	 * 
	 * @param unknown_type $request
	 * @param unknown_type $response
	 */
	public function doGet(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Receives an HTTP HEAD request from the protected service method and handles the request.
	 * 
	 * @param unknown_type $request
	 * @param unknown_type $response
	 */
	public function doHead(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a OPTIONS request.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function doOptions(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a POST request.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function doPost(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a PUT request.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function doPut(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a TRACE request.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function doTrace(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
	/**
	 * Returns the time the HttpServletRequest object was last modified, in milliseconds since midnight January 1, 1970 GMT.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @return long
	 */
	public function getLastModified(\napf\core\NapfServletRequest &$request){}
	/**
	 * Receives standard HTTP requests from the public service method and dispatches them to the doXXX methods defined in this class.
	 * 
	 * @param \napf\core\NapfServletRequest $request
	 * @param \napf\core\NapfServletResponse $response
	 */
	public function service(\napf\core\NapfServletRequest &$request,\napf\core\NapfServletResponse &$response){}
}