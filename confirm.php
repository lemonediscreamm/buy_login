<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\confirm.php
*ファイル名:confirm.php
*アクセスURL:http://localhost/DT/buy_login/confirm.php
*/
namespace buy_login;

require_once dirname(__FILE__). '/Bootstrap.class.php';

use buy_login\master\initMaster;
use buy_login\lib\Database;
use buy_login\lib\Common;

//テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader,[
    'cache' => Bootstrap::CACHE_DIR
]);

$db = new Database(Bootstrap::DB_HOST,Bootstrap::DB_USER, Bootstrap::DB_PASS,
Bootstrap::DB_NAME);

$common = new Common();

//モード判定（どの画面から来たのか判断）
//登録画面からきた場合
if (isset($_POST['confirm']) === true) {
    $mode = 'confirm';
}
//戻る場合
if (isset($_POST['back']) === true) {
    $mode = 'back';
}
//登録完了
if (isset($_POST['complete']) === true) {
    $mode = 'complete';
}

$err ='';
$res1='';
$dataArr='';
//ボタンのモードよって処理をかえる
switch ($mode) {
    case 'confirm'://ログインボタンを押したとき

        unset($_POST['confirm']);

        //PWかIDが空だった時、エラー表示
        if($_POST['password'] === '' ||  $_POST['email'] === ''){
        $dataArr = $_POST;
        $errArr = $common->errorCheck($dataArr);
        $err_check = $common->getErrorFlg();
        $template = 'regist.html.twig';
        }
        //PWとIDともに空でない時
        if($_POST['password'] !== '' && $_POST['email'] !== ''){
            $query ='';
            $query1 ='';
            //DBからid,family_name取得
            $query= "select mem_id, family_name from buy_member where email = "."'".$_POST['email']."'";
            $res1 = $db->select($query);
            //IDがDBに登録されていた場合
            if(!empty($res1)){
                //DBからpassword取得
                $query1 = "select password from buy_member where mem_id = ".$res1[0]['mem_id'];
                $res2 = $db->select($query1);
                // if($_POST['password'] !== '' && $_POST['email'] !== '' && password_verify ($_POST['password'],$res2[0]['password'])) {
                //     session_start();
                //     $_SESSION['family_name'] = $res1[0]['family_name'];
                //     $_SESSION['mem_id'] =$res1[0]['mem_id'];
                //     header('Location: http://localhost/DT/buy/list.php');
                //     exit();
                // //IDとPWが不一致の時    
                // }elseif($_POST['password'] !== '' && $_POST['email'] !== '' && password_verify ($_POST['password'],$res2[0]['password']) === false){
                //     $err = 'IDとパスワードが一致しません';
                //     $template = 'regist.html.twig';          
                // }else{
                //     $template = 'regist.html.twig';  
                // }
                // $dataArr = $_POST;
            //IDが未登録    
            }else{
                $err = '登録されていないIDです。';
                $template = 'regist.html.twig';   
            }
        }
        //IDが登録されていた場合
        if(!empty($res1)){
            //IDとPWが一致した時
            if($_POST['password'] !== '' && $_POST['email'] !== '' 
                && password_verify ($_POST['password'],$res2[0]['password'])){
                session_start();
                $_SESSION['family_name'] = $res1[0]['family_name'];
                $_SESSION['mem_id'] =$res1[0]['mem_id'];
                header('Location: http://localhost/DT/buy/list.php');
                exit();
            //IDとPWが不一致の時    
            }elseif($_POST['password'] !== '' && $_POST['email'] !== '' && password_verify ($_POST['password'],$res2[0]['password']) === false){
                $err = 'IDとパスワードが一致しません';
                $template = 'regist.html.twig';          
            }else{
                $template = 'regist.html.twig';  
            }
            $dataArr = $_POST;
        }
        
        if($dataArr != ''){
            $errArr = $common->errorCheck($dataArr);
            $err_check = $common->getErrorFlg();
    
        }

        //err_check = false →エラーがあります
        //err_check = true →エラーがないです
        break;
    case 'back'://戻るボタンを押したとき
                //ポストされたデータを元に戻すので、$dataArrに入れる
        $dataArr = $_POST;
        unset($dataArr['back']);
        
        //エラーも定義しておかないと、Undefinedエラーがでる
        foreach ($dataArr as $key => $value) {
            $errArr[$key] = '';
        }

        $template = 'regist.html.twig';
        break;

    case 'complete'://登録完了
        $dataArr =  $_POST;
        //↓この情報はいらないので外しておく
        unset($dataArr['complete']);
        $column = '';
        $insData = '';

        //foreach の中でSQL文を作る
        foreach ($dataArr as $key => $value) {
            $column .= $key . ', ';
            if ($key === 'password') {
                $value = password_hash ($dataArr['password'], PASSWORD_DEFAULT);
            }
            $insData .= $db->str_quote($value) . ', ';
        }

    $query = " INSERT INTO login ( "
            . $column
            . " regist_date "
            ." ) VALUES ( "
            . $insData
            ." NOW() "
            . " ) ";

    $res = $db->execute($query);
    $db->close();
    if ($res === true) {
        //登録成功時は完成時はページへ
        header('Location: ' . Bootstrap::ENTRY_URL . 'update.php');
        exit();
     }else {
        //登録失敗時は登録画面に戻る
        $template = 'regist.html.twig';
        foreach ($dataArr as $key => $value) {
            $errArr[$key] = '';
        }
    }

    break;
}
$context['err'] = $err;
if($dataArr != ''){
    $context['dataArr'] = $dataArr;
    $context['errArr'] = $errArr;
}    

$template = $twig->loadTemplate($template);
$template->display($context);
