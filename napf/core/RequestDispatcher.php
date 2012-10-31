<?php
namespace napf\core;

class RequestDispatcher
{
    private $_path;
    private $_layout = null;
    private $_application = null;
    public $request;
    public $response;

    /**
     * @param  string $path
     */
    public function __construct($path, $application = null)
    {
        if (strstr($path, "@")) {
            $tmp = explode("@", $path);
            $this->_path = $tmp[0];
            $this->_layout = $tmp[1];
        } else {
            $this->_path = $path;
        }
        if($application === null){
            $application = Controller::getInstance()->getCurrentApplication()->getName();
        }
        $this->_application = $application;
    }

    public function forward(ServletRequest &$request, ServletResponse &$response)
    {
        $this->request = $request;
        $this->response = $response;
        $output = "";
        $tmp = explode(".", $this->_path);
        $file = NAPF_APPLICATIONS_PATH . $this->_application . "/www/" . $this->_path;
        if (!is_file($file)) {
            throw new RequestDispatcherException("Fichier `$file` introuvable");
        }
        ob_start();
        include $file;
        $output = ob_get_contents();
        ob_end_clean();
        if ($this->_layout === null) {
            echo $output;
        } else {
            $layout = NAPF_WWW_PATH . $this->_layout;
            if (!is_file($layout)) {
                throw new RequestDispatcherException("Fichier `$layout` introuvable");
            }
            $CONTENT = $output;
            include NAPF_WWW_PATH . $this->_layout;
        }
    }

    /* TODO : voir si besoin de passer les parametres de request en _params de l'objet
      * public function __set($pName, $pValue){
         $this->_params[$pName] = utf8_encode($pValue);
     }
     public function __get($pName){
         if(isset($this->_params[$pName])){
             return $this->_params[$pName];
         } else {
             return null;
         }
     }*/
    public function attach(ServletRequest &$request, ServletResponse &$response)
    {
        include $request->getContextPath() . $this->_path;
    }
}
