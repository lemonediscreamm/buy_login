<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\buy_login\lib\Common.class.php
*ファイル名:Common..class.php
*アクセスURL:http://localhost/DT/buy_login/lib/Common.class.php
*/

namespace buy_login\lib;

class Common
{
    private $dataArr = [];
    private $errArr = [];
    
    //初期化
    public function __construct()
    {
    }
    public function errorCheck($dataArr)
    { 
        $this->dataArr = $dataArr;
        //クラス内のメソッドを読み込む
        $this->createErrorMessage();
        
        $this->emailcheck();
        $this->passwordcheck();
        // $this->unregisteredemailCheck();
        
        return $this->errArr;
    }

    private function createErrorMessage()
    {
        foreach ($this->dataArr as $key => $val){
            $this->errArr[$key] = '';
        }
    }

    private function emailCheck()
    {
        if($this->dataArr['email'] === '') {
            $this->errArr['email'] = 'ユーザIDを入力してください';
        }
    }

    private function passwordCheck()
    {
        if($this->dataArr['password'] === '') {
            $this->errArr['password'] = 'パスワードを入力してください';
        }
    }
    // private function unregisteredemailCheck ()
    // {
    //     if($this->dataArr['email'] === '') {
    //         $this->errArr['email'] = '登録されていないIDです。';
    //     }
    // }
        public function getErrorFlg()
        {
            $err_check = true;
            foreach ($this->errArr as $key => $value) {
                if ($value !== '') {
                    $err_check = false;
                }
            }
            return $err_check;
        }
    } 