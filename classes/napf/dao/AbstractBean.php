<?php
namespace napf\dao;

abstract class AbstractBean
{
    /**
     * @var \napf\dao\SqlDAO
     **/
    private $_dao;

    public function __construct(\napf\sql\IConnection $connection, $id = null)
    {
    }

    public abstract function preSave();

    public abstract function postSave();

    public abstract function preLoad();

    public abstract function postLoad();

    public abstract function save();

    public abstract function delete();

    public function __get($name)
    {
        $private = "_$name";
        if (isset($this->$private)) {
            return $this->$private;
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $private = "_$name";
        if (isset($this->$private)) {
            $this->$private = $value;
        }
    }
}
