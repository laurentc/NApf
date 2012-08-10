<?php
namespace napf\auth;

class Subject
{
    public $id = null;
    public $login = null;
    private $_connected = false;
    private $_credentials = array();

    public function getCredentials()
    {
        return $this->_credentials;
    }

    public function addCredentials($credential)
    {
        if (!in_array($credential, $this->_credentials)) {
            $this->_credentials[] = $credential;
        }
    }

    public function hasCredential($credential)
    {
        if (in_array($credential, $this->_credentials)) {
            return true;
        }
        return false;
    }

    public function isConnected()
    {
        return $this->_connected;
    }

    public function setConnected($bool = true)
    {
        $this->_connected = $bool;
    }
}
