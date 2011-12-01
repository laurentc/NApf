<?php
namespace napf\sql;

class ConnectionFactory
{
    /**
     * créer un object connection
     * @param string $driver
     * @param array $parameters
     * @return IConnection|null
     */
    public static function get($driver, $parameters)
    {
        switch (strtolower($driver)) {
            case 'mysql' :
                if (in_array("mysql", pdo_drivers())) {
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
