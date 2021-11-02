<?php
require_once __DIR__ . '/functions.php';
//index.phpからわたされた id をうけとる
$id = filter_input(INPUT_GET, 'id');

//タスク処理後の実行
//後ほどここにdeleteTask関数を呼び出す
deleteTask($id);
//index.phpにリダイレクト
header('Location: index.php');
exit;