<?php
/**
 * Usine de connection 
 */
namespace napf\sql;

class ConnectionFactory
{
    const MYSQL = "mysql";
    /**
     * créer un object connection
     * @param string $driver
     * @param array $parameters ['connexionString','user','password']
     * @return IConnection|null
     */
    public static function get($driver, $parameters)
    {
        switch (strtolower($driver)) {
            case MYSQL :
                if (in_array(MYSQL, pdo_drivers())) {
                    return new MysqlPdoConnection($parameters['connexionString'], $parameters['user'], $parameters['password']);
                } else {
                    return new MysqlConnection($parameters['connexionString'], $parameters['user'], $parameters['password']);
                }
                break;
        }
        return null;
    }
}

?>
