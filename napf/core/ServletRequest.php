<?php
namespace napf\core;

class ServletRequest
{
    /**
     * String identifier for Basic authentication.
     * @var String
     */
    public static $BASIC_AUTH;
    /**
     * String identifier for Basic authentication.
     * @var String
     */
    public static $CLIENT_CERT_AUTH;
    /**
     * String identifier for Basic authentication.
     * @var String
     */
    public static $DIGEST_AUTH;
    /**
     * String identifier for Basic authentication.
     * @var String
     */
    public static $FORM_AUTH;
    /**
     * @var array
     */
    private $_parameters = array();
    /**
     * @var array
     */
    private $_attributes = array();
    /**
     * @var string
     */
    private $_contextPath;
    /**
     * @var string
     */
    private $_servletPath;

    public function __construct()
    {
        $this->_parameters = array_merge($_GET, $_POST);
        $this->_splitPath();
    }

    /**
     * @param  string $name
     * @return string|null
     */
    public function getAttribute($name)
    {
        if (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        }
        return null;
    }
    
    public function getContextPath(){
        return $this->_contextPath;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $_COOKIE;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $_SERVER["QUERY_STRING"];
    }

    /**
     * @param  string $name
     * @return string
     */
    public function getParameter($name)
    {
        if (isset($this->_parameters[$name])) {
            return $this->_parameters[$name];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getParameterMap()
    {
        return $this->_parameters;
    }

    /**
     * Returns a RequestDispatcher object that acts as a wrapper for the resource located at the given path.
     *
     * @param String $path
     * @return RequestDispatcher
     */
    public function getRequestDispatcher($path)
    {
        $requestDispatcher = new RequestDispatcher($path);
        return $requestDispatcher;
    }

    public function getRequestURI()
    {
        return $_SERVER["REQUEST_URI"];
    }

    public function getRequestURL()
    {
        $host = ($this->isSecure() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $url = $_SERVER["REQUEST_URI"];

        return $host . $url;
    }

    public function getRootURL()
    {
        $host = ($this->isSecure() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $url = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        return $host . $url;
    }

    public function getServletPath()
    {
        return $this->_servletPath;
    }

    /**
     * @param bool $create default true
     * @return array
     */
    public function getSession($create = true)
    {
        return $_SESSION;
    }

    public function isSecure()
    {
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            return true;
        }
    }

    /**
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    private function _splitPath()
    {
        $temp = explode("=", $this->getParameter("napfmap"));
        $temp = explode("?", $temp[count($temp) - 1]);
        //$temp = explode("/", $temp[0]);
        if (count($temp) > 1) {
            $this->_contextPath = (isset($temp[0])) ? $temp[0] : null;
            $this->_servletPath = (isset($temp[1])) ? "/" . $temp[1] : null;
        } else {
            $this->_contextPath = "default";
            $this->_servletPath = (isset($temp[0])) ? "/" . $temp[0] : null;
        }
    }
    public function __get($name){
        if(isset($this->_parameters[$name])){
            return $this->_parameters[$name];
        } else if(isset($this->_attributes[$name])){
            return $this->_attributes[$name];
        }
        return null;
    }
}