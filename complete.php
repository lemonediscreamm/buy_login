<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\complete.php
*ファイル名:complete.php
*アクセスURL:http://localhost/DT/buy_login/complete.php
*/

namespace buy_login;

require_once ( dirname(__FILE__) . '/Bootstrap.class.php');

use buy_login\Bootstrap;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);
$template = $twig->loadTemplate('complete.html.twig');
$template->display([]);

//header('Location: ' . Bootstrap::ENTRY_URL. 'list.php');
