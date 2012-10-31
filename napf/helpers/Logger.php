<?php
namespace napf\helpers;

class Logger{
    private static $_loggers = array();
    private $_filePath;
    private $_handler;
    
    public function __construct($file = 'default') {
        $this->_filePath = NAPF_LOGS_PATH . $file . '.log';
    }
    /**
     *
     * @param String $file
     * @return \napf\helpers\Logger 
     */
    public static function getInstance($file = 'default'){
        if(!isset(self::$_loggers[$file])){
            self::$_loggers[$file] = new Logger($file);
        }
        return self::$_loggers[$file];
    }
    public function log($message){
        $this->_handler = fopen($this->_filePath, 'a+');
        $date = new \DateTime();
        $content = "\n" . $date->format('Y-m-d H:i:s') . ',' . $message;
        fwrite($this->_handler, $content);
        fclose($this->_handler);
    }
}