<?php
require_once __DIR__ .'/config.php';

//接続処理を行う
function connectDb()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

//エスケープ処理を行う関数
function h($str)
{
    //ENT_QUOTES:シングルオートとダブルクオートを共に変換する
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//タスク登録時のバリデーション
function insertValidate($title)
{
    //初期化
    $errors = [];

    if ($title == '') {
        $errors[] = MSG_TITLE_REQUIRED;
    }

    return $errors;
}

//タスク登録
function insertTask($title)
{
    //データベースに接続
    $dbh = connectDb();

    //レコードを取得
    $sql = <<<EOM
    INSERT INTO
        tasks
        (title)
    VALUES
        (:title)
    EOM;

    //プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    //パラメータのバインド
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);

    //プリペアドステートメントの実行
    $stmt->execute();
}

//エラーメッセージ作成
function createErrMsg($errors)
{
    $err_msg = "<ul class=\"errors\">\n";

    foreach ($errors as $error) {
        $err_msg .= "<li>" . h($error) . "</li>\n";
    }

    $err_msg .= "</ul>\n";

    return $err_msg;
}

//タスク完了
function updateStatusToDone($id)
{
    //データベースに接続
    $dbh = connectDb();
    // $idを使用してデータを更新
    $sql = <<<EOM
    UPDATE
        tasks
    SET
        status = 'done'
    WHERE
        id =:id
    EOM;

    //プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    //パラメータのバインド
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //プリペアドステートメントの実行
    $stmt->execute();
}

function updateStatus($id, $status)
{
    //データベースに接続
    $dbh = connectDb();

    //idを使用してデータを更新
    $sql = <<<EOM
    UPDATE
        tasks
    SET
        status = :status
    WHERE
        id = :id
    EOM;
    
    //プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    //パラメータのバインド
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    //プリペアドステートメントの実行
    $stmt->execute();

}

//実行する時はステータスを渡す
//notyetに更新
updateStatus($id, TASK_STATUS_NOTYET);
//doneに更新
updateStatus($id, TASK_STATUS_DONE);

//statusに応じてレコードを取得
function findTaskByStatus($status)
{
    //データベースに接続
    $dbh = connectDb();

    //statusで該当レコードを取得
    $sql = <<<EOM
    SELECT
        *
    FROM
        tasks
    WHERE
        status = :status;
    EOM;

//プリペアドステートメントの準備
$stmt = $dbh->prepare($sql);

//パラメータのバインド
$stmt->bindParam(':status', $status, PDO::PARAM_STR);

//プリペアドステートメントの実行
$stmt->execute();

//結果の取得
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//受け取った id のレコードを取得
function findById($id)
{
    //データベースに接続
    $dbh = connectDb();

    //$idを使用してデータを取得
    $sql = <<<EOM
    SELECT
        *
    FROM
        tasks
    WHERE
        id = :id;
    EOM;

    //プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    //パラメータバインド
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //プリペアドステートメントの実行
    $stmt->execute();

    //結果の取得
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//タスク更新処理時のバリデーション
function updateValidate($title, $task)
{
    //初期化
    $errors = [];

    if ($title === '') {
        $errors[] = MSG_TITLE_REQUIRED;
    }

    if ($title == $task['title']) {
        $errors[] = MSG_TITLE_NO_CHANGE;
    }

    return $errors;
}

//タスク更新
function updateTask($id, $title)
{
    //データベースに接続
    $dbh = connectDb();

    //$IDを使用してデータを更新
    $sql = <<<EOM
    UPDATE
        tasks
    SET
        title = :title
    WHERE
    id =:id
    EOM;

    //プリペアドステートメント準備
    $stmt = $dbh->prepare($sql);

    //パラメータバインド
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //プリペアドステートメントの実行
    $stmt->execute();
}

//タスクの削除
function deleteTask($id)
{
    //データベースに接続
    $dbh = connectDb();

    //$idを使用してデータを削除
    $sql = <<<EOM
    DELETE FROM
        tasks
    WHERE
        id = :id
    EOM;

    //プリペアドステートメントの準備
    $stmt = $dbh->prepare($sql);

    //パラメータバインド
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //プリペアドステートメントの実行
    $stmt->execute();
}