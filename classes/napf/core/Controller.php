<?php
namespace napf\core;

class Controller
{
    const ENVIRONMENT_DEVELOPMENT = 0;
    const ENVIRONMENT_PRODUCTION = 1;
    private static $_instance = null;
    /**
     * @var \napf\core\ServletRequest
     */
    public $request = null;
    /**
     * @var \napf\core\ServletResponse
     */
    public $response = null;
    /*
     * @var \napf\core\Mapper
     */
    public $mapper = null;


    /**
     * @static
     * @return \napf\core\Controller
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }

    public function __clone()
    {
    }

    public function __construct()
    {
        $this->response = new ServletResponse();
        $this->mapper = Mapper::getInstance();
    }

    public function process()
    {
        $info = null;
        if (isset($_REQUEST["napfmap"])) {
            $info = $this->mapper->getMapInfo($_REQUEST["napfmap"]);
        }
        var_dump($info);
        if ($info !== null) {
            if($info['jsp-file'] !== null){
                $class = "napf\servlets\ForwardAction";
            } else {
                $class = $info["classname"];
            }
            $classAction = new $class;
            $contextName = ($info["initparams"]["context"]) ? $info["initparams"]["context"] : 'default';
            HttpSession::setAttribute('ServletContext', ServletContext::factory($contextName));
            $this->request = new ServletRequest($info["initparams"]);
            $classAction->doBefore($this->request, $this->response);
            if($info['jsp-file'] !== null){
                $classAction->doRequest($this->request, $this->response, $info['jsp']);
            } else {
                $method = ucfirst($this->request->getMethod());
                $actionName = "do$method";
                $classAction->$actionName($this->request, $this->response);
            }
            $classAction->doAfter($this->request, $this->response);
        } else {
            $classAction = new \napf\servlets\NotFoundAction();
            $classAction->doGet(new ServletRequest(), $this->response);
        }
    }

}