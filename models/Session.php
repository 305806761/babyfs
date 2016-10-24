<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/12
 * Time: 11:53
 */

namespace app\models;


class Session
{
    static private $_begin = 0;
    static private $_instance = null;
    static private $_debug = false;

    static public function Init($debug=false)
    {
        self::$_instance = new Session();
        self::$_debug = $debug;
        session_start();
    }

    static public function Set($name, $v)
    {
        $_SESSION[$name] = $v;
    }

    static public function Get($name, $once=false)
    {
        $v = null;
        if ( isset($_SESSION[$name]) )
        {
            $v = $_SESSION[$name];
            if ( $once ) unset( $_SESSION[$name] );
        }
        return $v;
    }

    function __construct()
    {
        self::$_begin = microtime(true);
    }

    function __destruct()
    {
    }

}