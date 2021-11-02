<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

/*タスク登録
-------------------------*/
//初期化
$title = '';
$errors = [];

//リクエストメソッドの判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //フォームに入力されたデータを受け取る
    $title = filter_input(INPUT_POST, 'title');

    //バリデーション
    $errors = insertValidate($title);

    //エラーチェック
    if (empty($errors)) {
    //タスクの登録処理の実行
    insertTask($title);
    }
}
//データベースに接続
//$dbh = connectDb();
/*タスク照会
--------------------------------------*/
//statusを抽出条件に指定してデータを取得
/*$sql = <<<EOM
SELECT
    *
FROM
    tasks
WHERE
    status = :status;
EOM;

//プリペアドステートメントの準備
//$stmt = $dbh->prepare($sql);

//バインドを(代入)するパラメータの準備
$status = 'notyet';

//パラメータのバインド
//$stmt->bindParam(':status', $status, PDO::PARAM_STR);

//プリペアドステートメントの実行
//$stmt->execute();

//結果の取得
//$notyet_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);*/

//未完了のタスクを取得
$notyet_tasks = findTaskByStatus(TASK_STATUS_NOTYET);
$done_tasks = findTaskByStatus(TASK_STATUS_DONE);

//var_dump($notyet_tasks);
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <div class="new-task">
            <h1>My Tasks</h1>
            <!--エラーが発生した場合､エラーメッセージを出力-->
            <?php if ($errors) echo (createErrMsg($erros)) ?>
            <form action="" method="post">
                <input type="text" name="title" placeholder="タスクを入力して下さい">
                <input type="submit" value="登録" class="btn submit-btn">
            </form>
        </div>
        <div class="notyet-task">
            <h2>未完了タスク</h2>
            <ul>
                <?php foreach ($notyet_tasks as $task): ?>
                <li>
                    <a href="done.php?id=<?= h($task['id']) ?>" class="btn done-btn">完了</a>
                    <a href="edit.php?id=<?= h($task['id']) ?>" class="btn edit-btn">編集</a>
                    <a href="delete.php?id=<?= h($task['id'])?>" class="btn delete-btn">削除</a>
                    <?= h($task['title']); ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <hr>
        <div class="done-task">
            <h2>完了タスク</h2>
            <ul>
                <?php foreach ($done_tasks as $task): ?>
                    <li>
                        <?= h($task['title']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</body>

</html>