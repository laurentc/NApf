<?php
namespace napf\auth;

abstract class LoginModule
{
    /**
     * @var \napf\auth\Subject
     */
    protected $_subject;
    /**
     * @var array
     */
    protected $_sharedState;
    /**
     * @var array
     */
    protected $_options;
    protected $_succeeded = false;

    /**
     * @abstract
     * @param $login
     * @param $password
     * @return void
     */
    public abstract function login($login, $password);

    /**
     * @abstract
     * @return void
     */
    public abstract function logout();

    public function getSubject()
    {
        return $this->_subject;
    }

    public function __construct()
    {
        $this->_subject = new \napf\auth\Subject();
    }

    public function commit()
    {
        $this->_subject->setConnected(true);
    }
}
