<?php
namespace napf\core;

class NapfController
{
	private static $_instance = null;
    /**
     * @var \napf\core\NapfServletRequest
     */
    public $request;
    /**
     * @var NapfServletResponse
     */
    public $response;
    /**
     * @var NapfHttpSession
     */
    public $context;

	/**
     * @static
     * @return \napf\core\NapfController
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
        $this->response = new NapfServletResponse();
    }
    public function process(){
        $mapper = NapfMapper::getInstance();
        $info = null;
        if(isset($_REQUEST["napfmap"])){
        	$info = $mapper->getMapInfo($_REQUEST["napfmap"]);
        }
        if($info !== null){
            $class = $info["classname"];
            $classAction = new $class;
            $this->request = new NapfServletRequest($info["initparams"]);
            $method = ucfirst($this->request->getMethod());
            $actionName = "do$method";
            $classAction->doBefore($this->request,$this->response);
            $classAction->$actionName($this->request,$this->response);
            $classAction->doAfter($this->request,$this->response);
        } else {
            $classAction = new \napf\servlets\NotFoundAction();
            $classAction->doGet(new NapfServletRequest(), $this->response);
        }
    }
}