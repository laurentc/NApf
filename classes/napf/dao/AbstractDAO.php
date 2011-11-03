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
    /**
     * @var array(AbstractDAOCondition)
     */
    protected $_conditions = array();

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
    public function getFields(){
        return $this->_fields;
    }
}
