<?php
namespace napf\core;

class Controller
{
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
     *
     * @var \napf\core\Context 
     */
    private $_context = null;
    
    

    /**
     * @static
     * @return \napf\core\Controller
     */
    public static function getInstance(){
	    if(null === self::$_instance){
		    $c = __CLASS__;
		    self::$_instance = new $c;
	    }
	    return self::$_instance;
    }

    public function __clone(){}

    public function __construct(){
        $this->response = new ServletResponse();
	$this->mapper = Mapper::getInstance();
    }
    
    public function process(){
        $info = null;
        if(isset($_REQUEST["napfmap"])){
        	$info = $this->mapper->getMapInfo($_REQUEST["napfmap"]);
        }
        if($info !== null){
            $class = $info["classname"];
            $classAction = new $class;
	    $this->setContext(($info["initparams"]["context"])?$info["initparams"]["context"]:'default');
            $this->request = new ServletRequest($info["initparams"]);
            $method = ucfirst($this->request->getMethod());
            $actionName = "do$method";
            $classAction->doBefore($this->request,$this->response);
            $classAction->$actionName($this->request,$this->response);
            $classAction->doAfter($this->request,$this->response);
        } else {
            $classAction = new \napf\servlets\NotFoundAction();
            $classAction->doGet(new ServletRequest(), $this->response);
        }
    }
    
    private function setContext($contextName){
	$this->_context = Context::factory($contextName, HttpSession::getSessionID());
    }
    
    public function getContext(){
	return $this->_context;
    }
}