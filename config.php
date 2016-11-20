<?php
// DB接続に必要な情報 DSNはData Source Nameの略
define('DSN', 'mysql:host=localhost;dbname=test1;charset=utf8');
define('USER', 'testuser');
define('PASSWORD', '9999');
// エラーレベルの設定
error_reporting(E_ALL & ~E_NOTICE);
