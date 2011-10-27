<?php
namespace napf\core;

class NapfRequestDispatcher
{
    private $_path;
    private $_layout = null;

    /**
     * @param  string $path
     */
    public function __construct($path){
    	if(strstr($path, "@")){
    		$tmp = explode("@", $path);
    		$this->_path = $tmp[0];
    		$this->_layout = $tmp[1];
    	}else{
    		$this->_path = $path;
    	}
    }
	public function forward(NapfServletRequest &$request,NapfServletResponse &$response){
		$output = "";
        $tmp = explode(".", $this->_path);
        $file = NAPF_WWW_PATH . $this->_path;
        if(!is_file($file)){
            throw new NapfRequestDispatcherException("Fichier `$file` introuvable");
        }
        if($tmp[count($tmp)-1] == "tpl"){
            include NAPF_3PARTS_PATH . "smarty/Smarty.class.php";
            $smarty = new \Smarty();
            $smarty->template_dir = NAPF_3PARTS_PATH . "smarty/templates";
            $smarty->compile_dir = NAPF_3PARTS_PATH . "smarty/compile";
            $smarty->config_dir = NAPF_3PARTS_PATH . "smarty/config";
            $smarty->cache_dir = NAPF_3PARTS_PATH . "smarty/cache";
            $smarty->assign("request",$request);
            $smarty->assign("response",$response);

            $output = $smarty->fetch($file);
        }else{
        	ob_start();
            include $file;
            $output = ob_get_contents();
            ob_end_clean();
        }
        if($this->_layout === null){
        	echo $output;
		} else {
			$layout = NAPF_WWW_PATH . $this->_layout;
			if(!is_file($layout)){
				throw new NapfRequestDispatcherException("Fichier `$layout` introuvable");
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
	public function attach(NapfServletRequest &$request,NapfServletResponse &$response){
		include $request->getContextPath() . $this->_path;
	}
}
class NapfRequestDispatcherException extends NapfException
{

}