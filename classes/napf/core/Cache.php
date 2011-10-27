<?php
namespace napf\core;
 
class Cache {
    public static function set($name, $value){
        file_put_contents(NAPF_CACHE_PATH . "$name", serialize($value));
    }
    public static function get($name){
        if(is_file(NAPF_CACHE_PATH . "$name")){
            return unserialize(file_get_contents(NAPF_CACHE_PATH . "$name"));
        }
        return null;
    }
    public static function exist($name){
        if(is_file(NAPF_CACHE_PATH . "$name")){
            return true;
        }
        return false;
    }
    public static function delete($name){
        unlink(NAPF_CACHE_PATH . "$name");
    }
}
