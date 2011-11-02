<?php
namespace napf\sql;

class MysqlConnection extends AbstractConnection implements IConnection {
	
    public function __construct($connectionString, $user, $password){
    	parent::__construct($connectionString, $user, $password);
    	if($this->_port === null){
    		$this->_port = '3306';
    	}
    }
	public function doQuery($query, array $bind = null){
        $toReturn = array();
        $this->_connect();
        if($bind !== null){
            foreach($bind as $key=>$val){
                if(is_numeric($val)){
                    $query = str_replace($key,mysql_real_escape_string($val, $this->_connection),$query);
                }else {
                    $query = str_replace($key,"'".mysql_real_escape_string($val, $this->_connection)."'",$query);
                }
            }
        }
        if($this->_db !== null && !mysql_select_db($this->_db)){
            throw new ConnectionException(mysql_error($this->_connection));
        }
        $result = mysql_query($query,$this->_connection);
        if(!$result){
            throw new ConnectionException(mysql_error($this->_connection));
        }
        switch ($this->_queryType($query)){
            case self::QUERY_TYPE_INSERT:
                $toReturn = mysql_insert_id($this->_connection);
                break;
            case self::QUERY_TYPE_UPDATE:
            case self::QUERY_TYPE_DELETE:
                $toReturn = true;
                break;
            case self::QUERY_TYPE_COUNT:
                // TODO revoir le systeme de récupération du résultat des requêtes count
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    if(count($row) > 0){
                        $tmp = array_values($row);
                        $toReturn = $tmp[0];
                    }else {
                        $toReturn = 0;
                    }
                break;
            default:
                while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
                    $toReturn[] = $row;
                }
                break;
        }
        $this->_close();
        
        return $toReturn;
	}
	protected function _connect(){
        if($this->_connection === null){
            $this->_connection = mysql_connect($this->_host . ':' . $this->_port,$this->_user, $this->_password);
        }
	}
	public function close(){
        if($this->_connection !== null){
            mysql_close($this->_connection);
            $this->_connection = null;
        }
	}
}