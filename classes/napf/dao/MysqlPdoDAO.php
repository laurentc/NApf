<?php
/**
 * Created by JetBrains PhpStorm.
 * User: laurentc
 * Date: 01/07/11
 * Time: 11:00
 * To change this template use File | Settings | File Templates.
 */
namespace napf\dao;
 
class MysqlPdoDAO extends MysqlDAO
{
    /**
     * @var PDO
     */
    private $_pdo = null;

    protected function _connect(){
    }
    protected function _close(){
    }
    public function doQuery($query, array $bind = array(), $drivers = array())
    {
        if($this->_pdo === null){
            $dns = "mysql:host={$this->_host};dbname={$this->_db}";
            $this->_pdo = new \PDO($dns,$this->_user,$this->_password);
        }
        $toReturn = null;
        $statement = $this->_pdo->prepare($query, $drivers);
        $statement->execute($bind);
        switch ($this->_queryType($query)){
            case AbstractDAO::QUERY_TYPE_INSERT:
                $toReturn = $this->_pdo->lastInsertId();
                break;
            case AbstractDAO::QUERY_TYPE_UPDATE:
            case AbstractDAO::QUERY_TYPE_DELETE:
                $toReturn = (isset($bind[":{$this->_primary}"]))?$bind[":{$this->_primary}"]:true;
                break;
            case AbstractDAO::QUERY_TYPE_COUNT:
                $toReturn = $statement->rowCount();
                break;
            default:
                $toReturn = $statement->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }
        
        return $toReturn;
    }
}
