<?php
require_once __DIR__ . '/functions.php';
//index.phpから渡されたidをうけとる
$id = filter_input(INPUT_GET, 'id');

//タスク完了処理の実行
//後ほどココにupdateStatusToDone関数を呼び出す処理をする
updateStatusToDone($id);
//index.phpにリダイレクト
header ('Location: index.php');
exit;