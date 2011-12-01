<?php
namespace napf\core;

class ServletResponse
{
    const SC_ACCEPTED = '202';
    const SC_BAD_GATEWAY = '502';
    const SC_BAD_REQUEST = '400';
    const SC_CONFLICT = '409';
    const SC_CONTINUE = '100';
    const SC_CREATED = '201';
    const SC_EXPECTATION_FAILED = '417';
    const SC_FORBIDDEN = '403';
    const SC_GATEWAY_TIMEOUT = '504';
    const SC_GONE = '410';
    const SC_HTTP_VERSION_NOT_SUPPORTED = '50';
    const SC_INTERNAL_SERVER_ERROR = '500';
    const SC_LENGTH_REQUIRED = '411';
    const SC_METHOD_NOT_ALLOWED = '405';
    const SC_MOVED_PERMANENTLY = '301';
    const SC_MOVED_TEMPORARILY = '302';
    const SC_MULTIPLE_CHOICES = '300';
    const SC_NO_CONTENT = '204';
    const SC_NON_AUTHORITATIVE_INFORMATION = '203';
    const SC_NOT_ACCEPTABLE = '406';
    const SC_NOT_FOUND = '404';
    const SC_NOT_IMPLEMENTED = '501';
    const SC_NOT_MODIFIED = '304';
    const SC_OK = '200';
    const SC_PARTIAL_CONTENT = '206';
    const SC_PAYMENT_REQUIRED = '402';
    const SC_PRECONDITION_FAILED = '412';
    const SC_PROXY_AUTHENTICATION_REQUIRED = '407';
    const SC_REQUEST_ENTITY_TOO_LARGE = '413';
    const SC_REQUEST_TIMEOUT = '408';
    const SC_REQUEST_URI_TOO_LONG = '414';
    const SC_REQUESTED_RANGE_NOT_SATISFIABLE = '416';
    const SC_RESET_CONTENT = '205';
    const SC_SEE_OTHER = '303';
    const SC_SERVICE_UNAVAILABLE = '503';
    const SC_SWITCHING_PROTOCOLS = '101';
    const SC_TEMPORARY_REDIRECT = '307';
    const SC_UNAUTHORIZED = '401';
    const SC_UNSUPPORTED_MEDIA_TYPE = '415';
    const SC_USE_PROXY = '305';

    public function addCookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
    {
        return setcookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false);
    }

    public function addDateHeader($name, $date)
    {
        $this->addHeader($name, $date);
    }

    public function addHeader($name, $value)
    {
        header($name . ": " . $value);
    }

    public function addIntHeader($name, $value)
    {
        $this->addHeader($name, $value);
    }

    public function containsHeader($name)
    {
    }

    public function encodeRedirectURL($url)
    {
    }

    public function encodeURL($url)
    {
    }

    public function sendError($sc, $msg = null)
    {
    }

    /**
     * @param $location
     * @param bool $transform : $location est un pattern Napf ?
     * @return void
     */
    public function sendRedirect($location, $transform = true)
    {
        $location = \napf\helpers\Url::get($location);
        header("Location: " . $location);
    }

    public function setDateHeader($name, $date)
    {
    }

    public function setHeader($name, $value)
    {
    }

    public function setIntHeader($name, $value)
    {
    }

    public function setStatus($sc)
    {
    }
}