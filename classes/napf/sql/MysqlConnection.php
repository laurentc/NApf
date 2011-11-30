<?php
namespace napf\sql;
// TODO voir cas ou l'on aurait pas de base selectionnée
class MysqlConnection extends AbstractConnection {
    const FIELD_TYPE_PRIMARY = 'PRI';
    const MYSQL_DEFAULT_PORT = '3306';
    const MYSQL_FIELD_FIELD = 'Field';
    const MYSQL_FIELD_TYPE = 'Type';
    const MYSQL_FIELD_NULL = 'Null';
    const MYSQL_FIELD_KEY = 'Key';
    const MYSQL_FIELD_DEFAULT = 'Default';
    const MYSQL_FIELD_EXTRA = 'Extra';
    const MYSQL_SHOW_TABLES_RETURN = 'Tables_in_';
	
    public function __construct($connectionString, $user, $password){
    	parent::__construct($connectionString, $user, $password);
    	if($this->_port === null){
	    $this->_port = self::MYSQL_DEFAULT_PORT;
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
	public function getTables(){
            $toReturn = array();
            $tables = $this->doQuery("SHOW TABLES");
	    if(count($tables) > 0){
		foreach ($tables as $table){
		    $toReturn[] = $table[self::MYSQL_SHOW_TABLES_RETURN . $this->_db];
		}
	    }
	    
	    return $toReturn;
	}
	public function getFields($table, &$fields = null, &$primary = null){
	    $toReturn = array();
	    $columns =  $this->doQuery("SHOW COLUMNS FROM $table");
	    foreach($columns as $column){
		$toReturn[$column[self::MYSQL_FIELD_FIELD]] = array(
		    "type"=>$column[self::MYSQL_FIELD_TYPE],
		    "null"=>($column[self::MYSQL_FIELD_NULL]=="NO"?false:true),
		    "key"=>$column[self::MYSQL_FIELD_KEY],
		    "default"=>$column[self::MYSQL_FIELD_DEFAULT],
		    "extra"=>$column[self::MYSQL_FIELD_EXTRA]
		);
		$fields[$column[self::MYSQL_FIELD_FIELD]] = $toReturn[$column[self::MYSQL_FIELD_FIELD]];
		if($column[self::MYSQL_FIELD_KEY] === self::FIELD_TYPE_PRIMARY){
		    $primary = $column[self::MYSQL_FIELD_FIELD];
		}
	    }
        
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
        /**
         *
         * @return resource 
         */
        public function getConnection(){
            return $this->_connection;
        }
}