<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\detail.php
*ファイル名:detail.php
*アクセスURL:http://localhost/DT/buy_login/detail.php
*/

namespace buy_login;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use buy_login\Bootstrap;
use buy_login\master\initMaster;
use buy_login\lib\Database;
use buy_login\lib\Common;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, array(
    'cache' => Bootstrap::CACHE_DIR
));

$db = new Database(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS,
Bootstrap::DB_NAME);
$initMaster = new initMaster();

if (isset($_GET['mem_id']) === true && $_GET['mem_id'] !== '') {
    $mem_id = $_GET['mem_id'];

    $query = " SELECT "
        . " mem_id, "
        . " family_name, "
        . " first_name, "
        . " family_name_kana, "
        . " first_name_kana, "
        . " sex, "
        . "year, "
        . "month, "
        . "day,"
        . "zip1, "
        . "zip2, "
        . "address, "
        . " email, "
        . "tel1, "
        . "tel2, "
        . "tel3, "
        . " regist_date "
        . " FROM "
        . "     buy_member "
        . " WHERE "
        . "      mem_id = " . $db->quote($mem_id);
    $data = $db->select($query);
    $db->close();
    $dataArr = ($data !== "" && $data !== []) ? $data[0] : '';
    
    $context = [];
    $context['dataArr'] = $dataArr;
    $template = $twig->loadTemplate('detail.html.twig');
    $template->display($context);
} else {
    header('Location: ' . Bootstrap::ENTRY_URL .'list.php');
    exit(); 
}    