<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\list.php
*ファイル名:list.php
*アクセスURL:http://localhost/DT/buy_login/list.php
*/
namespace buy_login;

require_once dirname(__FILE__). '/Bootstrap.class.php';

use buy_login\Bootstrap;
use buy_login\master\initMaster;
use buy_login\lib\Database;
use buy_login\lib\Common;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);
$db = new Database(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS,
Bootstrap::DB_NAME);

$query = " SELECT "
        . " email, "
        . " password, "
        . " regist_date "
        . " FROM "
        . "     buy_member ";
$dataArr = $db->select($query);
$db->close();

$context = [];
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);