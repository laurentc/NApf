<?php
/**
 * Created by IntelliJ IDEA.
 * User: laurentc
 * Date: 27/06/11
 * Time: 12:52
 * To change this template use File | Settings | File Templates.
 */
namespace napf\dao;

class SqlDAO extends AbstractDAO
{
    const QUERY_TYPE_SELECT = 0;
    const QUERY_TYPE_INSERT = 1;
    const QUERY_TYPE_UPDATE = 2;
    const QUERY_TYPE_COUNT = 3;
    const QUERY_TYPE_DELETE = 4;
    protected $_fields;
    protected $_primary;
    protected $_table;
    /**
     * 
     * Connection
     * @var \napf\sql\IConnection
     */
    protected $_connection;
    /**
     * Créer un objet DAO
     * 
     * @param string $tablename
     * @param array $connectionParams ('host','db','user','password')
     */
    public function __construct($tablename, $connection){
        $this->_table= $tablename;
        $this->_connection = $connection;
        $this->_introspection();
        $this->_makeBean();
    }
    protected function _introspection(){
        $this->_connection->getFields($this->_table,$this->_fields, $this->_primary);
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
        return $this->_connection->doQuery($query, $bind);
    }
    public function countWhere(){
        $query = "select count(*) from {$this->_table} where";
        foreach ($this->_conditions as $condition){
            $query .= "{$condition->field} {$condition->comparator} :{$condition->field}";
            $query .= " {$condition->link} ";
        }
        $query .= " 1=1";
        return $this->_connection->doQuery($query);
    }
    public function count(){
        $query = "select count(*) from {$this->_table}";
        
        return $this->_connection->doQuery($query);
    }
    public function get($id, $order = null){
        $query = "select * from {$this->_table} where " . $this->_primary . "=:id";
        if($order !== null){
            $query .= " order by " . $order;
        }
        $results = $this->_connection->doQuery($query, array(":id"=>$id));
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
        return $this->_connection->doQuery($query, array());
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
        return $this->_connection->doQuery($query, $bind);
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

        return $this->_connection->doQuery($query, $bind);
    }
    public function delete($id){
        $query = "delete from {$this->_table} where {$this->_primary}=:{$this->_primary}";
        $bind = array(":{$this->_primary}"=>$id);
        
        return $this->_connection->doQuery($query, $bind);
    }
}
