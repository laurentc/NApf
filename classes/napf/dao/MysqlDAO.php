<?php
/**
 * Created by IntelliJ IDEA.
 * User: laurentc
 * Date: 27/06/11
 * Time: 12:52
 * To change this template use File | Settings | File Templates.
 */
namespace napf\dao;

class MysqlDAO extends AbstractDAO
{
    const QUERY_TYPE_SELECT = 0;
    const QUERY_TYPE_INSERT = 1;
    const QUERY_TYPE_UPDATE = 2;
    const QUERY_TYPE_COUNT = 3;
    const QUERY_TYPE_DELETE = 4;
    protected $_fields;
    protected $_primary;
    protected $_table;
    protected $_host;
    protected $_user;
    protected $_password;
    protected $_db;
    protected $_connexionParams;
	/** todo:passer la connection en statique ?
     *
     * @var resource
     */
    protected $_connection = null;
    
    /**
     * Créer un objet DAO
     * 
     * @param string $tablename
     * @param array $connectionParams ('host','db','user','password')
     */
    public function __construct($tablename, $connectionParams){
        $this->_host = $connectionParams['host'];
        $this->_db = $connectionParams['db'];
        $this->_user = $connectionParams['user'];
        $this->_password = $connectionParams['password'];
        $this->_table= $tablename;
        $this->_connexionParams = $connectionParams;
        $this->_introspection();
        $this->_makeBean();
    }
    protected function _connect(){
        if($this->_connection === null){
            $this->_connection = mysql_connect($this->_host,$this->_user, $this->_password);
        }
    }
    protected function _close(){
        if($this->_connection !== null){
            mysql_close($this->_connection);
            $this->_connection = null;
        }
    }
    protected function _introspection(){
        $fields = $this->doQuery("SHOW COLUMNS FROM {$this->_table}");
        foreach($fields as $field){
            $this->_fields[$field["Field"]] = array(
                "type"=>$field["Type"],
                "null"=>($field["Null"]=="NO"?false:true),
                "key"=>$field["Key"],
                "default"=>$field["Default"],
                "extra"=>$field["Extra"]
            );
            if($field["Key"] == "PRI"){
                $this->_primary = $field["Field"];
            }
        }
    }
    public function getWhere($order = null)
    {
        $query = "select * from {$this->_table} where ";
        $bind = array();
        foreach ($this->_conditions as $condition){
            $query .= "{$condition->field} {$condition->comparator} :{$condition->field}";
            $bind[":{$condition->field}"] = $condition->value;
            $query .= " {$condition->link} ";
        }
        $query .= " 1=1";
        if($order !== null){
            $query .= " order by " . $order;
        }
        return $this->doQuery($query, $bind);
    }
    public function countWhere(){
        $query = "select count(*) from {$this->_table} where";
        foreach ($this->_conditions as $condition){
            $query .= "{$condition->field} {$condition->comparator} :{$condition->field}";
            $query .= " {$condition->link} ";
        }
        $query .= " 1=1";
        return $this->doQuery($query);
    }
    public function count(){
        $query = "select count(*) from {$this->_table}";
        
        return $this->doQuery($query);
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
        if(!mysql_select_db($this->_db)){
            throw new AbstractDAOException(mysql_error($this->_connection));
        }
        $result = mysql_query($query,$this->_connection);
        if(!$result){
            throw new AbstractDAOException(mysql_error($this->_connection));
        }
        switch ($this->_queryType($query)){
            case self::QUERY_TYPE_INSERT:
                $toReturn = mysql_insert_id($this->_connection);
                break;
            case self::QUERY_TYPE_UPDATE:
            case self::QUERY_TYPE_DELETE:
                $toReturn = (isset($bind[":{$this->_primary}"]))?$bind[":{$this->_primary}"]:true;
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
    public function get($id, $order = null){
        $query = "select * from {$this->_table} where " . $this->_primary . "=:id";
        if($order !== null){
            $query .= " order by " . $order;
        }
        $results = $this->doQuery($query, array(":id"=>$id));
        $result = array();
        if($results !== null && count($results) > 0){
            $result = $results[0];
        }
        return $result;
    }
    public function getAll($order = null){
        $query = "select * from {$this->_table}";
        if($order !== null){
            $query .= " order by " .$order;
        }
        return $this->doQuery($query, array());
    }
    public function insert(array $datas){
        $fields = "(";
        $values = "(";
        $bind = array();
        $first = true;
        foreach($datas as $key=>$val){
            if(!$first){
                $fields .= ",";
                $values .= ",";
            }
            $fields .= "$key";
            $values .= ":$key";
            $bind[":$key"] = $val;
            $first = false;
        }
        $fields .= ")";
        $values .= ")";
        $query = "insert into {$this->_table} {$fields} values {$values}";
        return $this->doQuery($query, $bind);
    }
    public function update($id, array $datas){
        $query = "update {$this->_table} set ";
        $bind = array(":{$this->_primary}"=>$id);
        $first = true;
        foreach($datas as $key=>$val){
            if(!$first){
                $query .= ",";
            }
            $query .= "$key=:$key";
            $bind[":$key"] = $val;
            $first = false;
        }
        $query .= " where {$this->_primary}=:{$this->_primary}";

        return $this->doQuery($query, $bind);
    }
    public function delete($id){
        $query = "delete from {$this->_table} where {$this->_primary}=:{$this->_primary}";
        $bind = array(":{$this->_primary}"=>$id);
        
        return $this->doQuery($query, $bind);
    }
}
