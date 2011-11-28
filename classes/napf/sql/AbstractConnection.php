<?php
namespace napf\sql;

abstract class AbstractConnection implements IConnection {
    const QUERY_TYPE_SELECT = 0;
    const QUERY_TYPE_INSERT = 1;
    const QUERY_TYPE_UPDATE = 2;
    const QUERY_TYPE_COUNT = 3;
    const QUERY_TYPE_DELETE = 4;
    const QUERY_TYPE_MIXED = 5;
    protected $_host = null;
    protected $_port = null;
    protected $_db = null;
    protected $_user = null;
    protected $_password = null;
    protected $_connection = null;
    
    /**
     * Création de la connection
     * @param string $connectionString 'host:port/base'
     * @param string $user
     * @param string $pass
     */
    public function __construct($connectionString, $user, $password){
	    $this->_user = $user;
	    $this->_password = $password;
	    $this->_getConnectionParams($connectionString);
    }
    /**
     * Ouvre une connection à la base de données
     */
    protected abstract function _connect();
    /**
     * Récupère le type de requête
     * @param string $query
     */
    protected function _queryType($query){
    	// plusieurs requetes dans $query
    	if(strpos($query, ";") > -1){
	    return self::QUERY_TYPE_MIXED;
    	}
        if(preg_match("/^update/", trim($query)) > 0){
            return self::QUERY_TYPE_UPDATE;
        }else if(preg_match("/^insert/", trim($query)) > 0){
            return self::QUERY_TYPE_INSERT;
        }else if(preg_match("/^select( )*count/", trim($query)) > 0){
            return self::QUERY_TYPE_COUNT;
        }else if(preg_match("/^delete/", trim($query)) > 0){
            return self::QUERY_TYPE_DELETE;
        }else {
            return self::QUERY_TYPE_SELECT;
        }
    }
    protected function _getConnectionParams($connectionString){
    	$tmp = explode("/", $connectionString);
    	if(count($tmp) > 1){
	    $this->_db = $tmp[1];
    	}
    	$tmp = explode(":", $tmp[0]);
    	if(count($tmp) > 1){
	    $this->_port = $tmp[1];
    	}
    	$this->_host = $tmp[0];
    }
    protected function _close(){
    	$this->close();
    }
    public function __sleep(){
	return array('_host', '_port', '_db', '_user', '_password', '_connection');
    }
}

?>