<?php

//接続に必要な情報を定数として定義
define('DSN', 'mysql:host=db;dbname=task_app;charset=utf8');
define('USER', 'task_admin');
define('PASSWORD', '1234');

//エラーメッセージを定数として定義
define('MSG_TITLE_REQUIRED', 'タスク名を入力して下さい');
define('MSG_TITLE_NO_CHANGE', 'タスク名が変更されていません');

//ステータスを定数として定義
define('TASK_STATUS_NOTYET', 'notyet');
define('TASK_STATUS_DONE', 'done');