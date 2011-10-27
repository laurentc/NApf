<?php
/**
 * Created by IntelliJ IDEA.
 * User: laurentc
 * Date: 27/06/11
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */
namespace napf\dao;

abstract class AbstractDAO
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
    /**
     * @var array(AbstractDAOCondition)
     */
    protected $_conditions = array();

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
    public abstract function get($id, $order = null);
    public abstract function getAll($order = null);
    public abstract function getWhere($order = null);
    public abstract function insert(array $datas);
    public abstract function update($id, array $datas);
    public abstract function delete($id);
    public function count(){}
    public function countWhere(){}
    /**
     * @param string $field
     * @param string $comparator
     * @param string $value
     * @param string $link
     * @return void
     */
    public function addCondition($field, $comparator, $value, $link = "and"){
        $this->_conditions[] = new AbstractDAOCondition($field, $comparator, $value, $link = "and");
    }
    public function resetCondition(){
        $this->_conditions = array();
    }
    protected function _introspection(){}
    protected function _connect(){}
    protected function _close(){}
    public function doQuery(){}
    protected function _queryType($query){
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
    public function getFields(){
        return $this->_fields;
    }
    protected function _makeBean(){
        if(!is_file(NAPF_CLASSES_PATH . "beans/" . $this->_table . "Bean.php")){
            $class = get_class($this);
            include NAPF_CLASSES_PATH . "napf/common/BeanModel.php";
            file_put_contents(NAPF_CLASSES_PATH . "beans/" . $this->_table . "Bean.php", $output);
        }
    }
}
class AbstractDAOException extends \napf\core\NapfException
{
    
}
class AbstractDAOCondition
{
    public $link;
    public $field;
    public $comparator;
    public $value;
    
    public function __construct($field, $comparator, $value, $link){
        $this->field = $field;
        $this->comparator = $comparator;
        $this->value = $value;
        $this->link = $link;
    }
}