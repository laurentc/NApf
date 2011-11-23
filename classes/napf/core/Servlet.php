<?php
namespace napf\core;

abstract class Servlet
{
	public function doAfter(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	public function doBefore(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a DELETE request.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function doDelete(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a GET request.
	 * 
	 * @param unknown_type $request
	 * @param unknown_type $response
	 */
	public function doGet(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Receives an HTTP HEAD request from the protected service method and handles the request.
	 * 
	 * @param unknown_type $request
	 * @param unknown_type $response
	 */
	public function doHead(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a OPTIONS request.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function doOptions(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a POST request.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function doPost(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a PUT request.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function doPut(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Called by the server (via the service method) to allow a servlet to handle a TRACE request.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function doTrace(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
	/**
	 * Returns the time the HttpServletRequest object was last modified, in milliseconds since midnight January 1, 1970 GMT.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @return long
	 */
	public function getLastModified(\napf\core\ServletRequest &$request){}
	/**
	 * Receives standard HTTP requests from the public service method and dispatches them to the doXXX methods defined in this class.
	 * 
	 * @param \napf\core\ServletRequest $request
	 * @param \napf\core\ServletResponse $response
	 */
	public function service(\napf\core\ServletRequest &$request,\napf\core\ServletResponse &$response){}
}