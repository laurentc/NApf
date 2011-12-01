<?php
namespace napf\helpers;

class Url
{
    public static function get($pattern, $params = array())
    {
        if (substr(trim($pattern), 0, 4) === "http") {
            $toReturn = $pattern;
        } else {
            $url = getRequest()->getRootURL();
            $toReturn = $url . preg_replace("#/(/)*#", "/", "/" . $pattern);
        }
        if (!empty($params)) {
            $first = true;
            foreach ($params as $key => $val) {
                ($first) ? $toReturn .= "?" : $toReturn .= "&";
                $toReturn .= $key . "=" . $val;
            }
        }
        //$toReturn = preg_replace("#/(/)*#","/",$toReturn);

        return $toReturn;
    }
}