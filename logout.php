<?php

session_start();

$_SESSION = array();
//$_SESSION = array();でセッション変数を解除した後でもcookieが残っている場合があるのでそれを消す
//session_name()は、セッションID名を返す関数
//setcookie()はクッキー変数を設定する関数

if (isset($_COOKIE[session_name()]))
{
  //第一引数session_name()、第二引数 ''、第三引数time() - 86400
    setcookie(session_name(), '', time() - 86400);

}

//さらにセッションを破壊する.サーバ側での、セッションIDの破棄.
session_destroy();

header('Location: login.php');