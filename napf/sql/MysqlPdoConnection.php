<?php
/**
 * Driver Pdo MySQL 
 */
namespace napf\sql;

class MysqlPdoConnection extends MysqlConnection
{
    public function doQuery($query, array $bind = null, $drivers = array())
    {
        if ($this->_connection === null) {
            $dns = "mysql:host={$this->_host}";
            if ($this->_db !== null) {
                $dns .= ";dbname={$this->_db}";
            }
            $this->_connection = new \PDO($dns, $this->_user, $this->_password);
        }
        $toReturn = null;
        $statement = $this->_connection->prepare($query, $drivers);
        $statement->execute($bind);
        switch ($this->_queryType($query)) {
            case self::QUERY_TYPE_INSERT:
                $toReturn = $this->_connection->lastInsertId();
                break;
            case self::QUERY_TYPE_UPDATE:
            case self::QUERY_TYPE_DELETE:
                $toReturn = true;
                break;
            case self::QUERY_TYPE_COUNT:
                $toReturn = $statement->rowCount();
                break;
            default:
                $toReturn = $statement->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        return $toReturn;
    }

    /**
     *
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->_connection;
    }
}

?>