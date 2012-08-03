<?php
/**
 * Driver Oracle
 *
 * @author laurentc
 */
namespace \napf\sql;

class OracleConnection extends AbstractConnection{
    const ORACLE_DEFAULT_PORT = '1521';
    
    protected function _connect() {
        if($this->_connection === null){
            $this->_connection = oci_connect($this->_user, $this->_password, $this->_connectionString, null, null);
            if(!$this->_connection){
                throw new ConnectionException("Connexion impossible : " . oci_error());
            }
        }
    }
    public function close() {
        if($this->_connection !== null){
            oci_close($this->_connection);
            $this->_connection = null;
        }
    }
    public function doQuery($query, array $bind = null) {
        
    }
    public function getConnection() {
        return $this->_connection;
    }
    public function getFields($table, &$fields, &$primary) {
        
    }
    public function getTables() {
        
    }
}
