<?php
namespace napf\sql;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectionFactory
 *
 * @author laurentc
 */
class ConnectionFactory {
    private static $_instance = null;
    
    public static function getInstance($name = 'default'){
	if(self::$_instance === null){
	    $test = \napf\core\Properties::getInstance();
	    $cnx = new MysqlPdoConnection($test->demo->mysql->connexionString
		    , $test->demo->mysql->user
		    , $test->demo->mysql->password
		    );                
	}
    }
}

?>
