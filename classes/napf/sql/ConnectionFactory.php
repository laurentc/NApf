<?php
namespace napf\sql;

class ConnectionFactory {    
    /**
     * créer un object connection
     * @param string $driver
     * @param array $parameters
     * @return IConnection|null 
     */
    public static function get($driver, $parameters){
	switch (strtolower($driver)){
	    case 'mysql' :
		return new MysqlConnection($parameters['connexionString'], $parameters['user'], $parameters['password']);
		break;
	    case 'pdomysql' :
		return new MysqlPdoConnection($parameters['connexionString'], $parameters['user'], $parameters['password']);
		break;
	}
	return null;
    }
}

?>
