<?php
require_once __DIR__ . '/functions.php';

//index.phpから渡されたidを受け取る
$id = filter_input(INPUT_GET, 'id');

//受けとったidのレコードを取得
$task = findById($id);

/*タスク更新処理
---------------------------------------------*/
//初期化
$title = '';
$errors = [];

//リクエストメソッドの判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //フォームに入力されたデータを受け取る
    $title = filter_input(INPUT_POST, 'title');

    //バリデーション
    //後ほどココにupdateValidate関数を呼びだし戻り値を$errorsに入れる処理をする
    //$errors = updateValidate関数の戻値(エラーメッセージを保存された配列)
    $errors = updateValidate($title, $task);
    //エラーチェック
    if (empty($errors)) {
        //タスク更新処理の実行
        //後ほどここにupdateTask関数を呼び出す処理を追記する
        updateTask($id, $title);
        //index.phpにリダイレクト
        header('Location: index.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h2>タスク更新</h2>
        <!--エラーが発生した場合､エラーメッセージを出力-->
        <?php if ($errors) echo (createErrMsg($errors)) ?>
        <form action="" method="post">
            <input type="text" name="title" value="<?= h($task['title']) ?>">
            <input type="submit" value="更新" class="btn submit-btn">
        </form>
        <a href="index.php" class="btn return-btn">戻る</a>
    </div>
</body>
</html>