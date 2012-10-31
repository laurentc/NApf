<?php
namespace napf\core;

class Controller
{
    const ENVIRONMENT_DEVELOPMENT = 'development';
    const ENVIRONMENT_PRODUCTION = 'production';
    
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
    /**
     *
     * @return \napf\core\Application 
     */
    public function getCurrentApplication(){
        return $this->mapper->currentApplication;
    }
    public function process()
    {
        $info = null;
        if (isset($_REQUEST["napfmap"])) {
            try{
                $info = $this->mapper->getMapInfo($_REQUEST["napfmap"]);
            }catch(\Exception $e){
                \napf\helpers\Logger::getInstance('napf_core')->log($e->getMessage() . ': ' . $_REQUEST["napfmap"]);
            }
            if ($info !== null) {
                if(is_file(NAPF_APPLICATIONS_PATH . $this->getCurrentApplication()->getName() . "/bootstrap.php")){
                    include(NAPF_APPLICATIONS_PATH . $this->getCurrentApplication()->getName() . "/bootstrap.php");
                }
                if($info['php-file'] !== null){
                    $class = "napf\servlets\ForwardAction";
                } else {
                    $class = $info["classname"];
                }
                $classAction = new $class;
                $this->request = new ServletRequest($info["initparams"]);
                $classAction->doBefore($this->request, $this->response);
                if($info['php-file'] !== null){
                    $classAction->doRequest($this->request, $this->response, $info['php-file']);
                } else {
                    $method = ucfirst($this->request->getMethod());
                    $actionName = "do$method";
                    $classAction->$actionName($this->request, $this->response);
                }
                $classAction->doAfter($this->request, $this->response);
            } else {
                $this->request = new ServletRequest();
                $classAction = new \napf\servlets\NotFoundAction();
                $classAction->doGet(new ServletRequest(), $this->response);
            }
        }
    }

}