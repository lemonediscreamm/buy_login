<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\bootstrap.class.php
*ファイル名:Bootstrap.class.php(設定に関するプログラム)
*アクセスURL:http://localhost/DT/buy_login/Bootstrap.class.php
*/
namespace buy_login;


require_once dirname(__FILE__) . './../vendor/autoload.php';

class Bootstrap
{
    const DB_HOST = 'localhost';

    const DB_NAME = 'buy_member_db';

    const DB_USER = 'buy_member_user';

    const DB_PASS = 'buy_member_pass';

    const APP_DIR = 'C:/Users/lemon/downloads/pleiades-2018-09-php-win-64bit-jre_20181004/pleiades/xampp/htdocs/DT/';

    const TEMPLATE_DIR = self::APP_DIR . 'templates/buy_login/';

    const CACHE_DIR = false;
    //const CACHE_DIR  = self::APP_DIR . 'templates_c/login/';
    const APP_URL = 'http://localhost/DT/';

    const ENTRY_URL = self::APP_URL . 'buy_login/';

    public static function loadClass($class)
    {
        $path = str_replace('\\', '/', self::APP_DIR . $class . '.class.php');
        //$path=c:/xampp/htdocs/DT/login/Database.class.php
        require_once $path;
    }    
}

//これを実行しないとオートローダーとして動かない
spl_autoload_register([
    'buy_login\Bootstrap',
    'loadClass'
]);