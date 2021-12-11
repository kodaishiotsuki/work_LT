<?php
echo '<pre>';
var_dump($_POST);
echo '</pre>';
exit();

//セッション開始
session_start();
//関数読み込み
include("functions.php");
//セッション状態確認
// check_session_id();

// $user_id = $_SESSION['user_id'];

//-----バリデーション-----//
//エラーメッセージ
$err = [];
//ニックネーム
if (!$nickname = $_POST['nickname']) {
  $err['nickname'] = 'ニックネームを入力してください!!';
  //sessionは連想配列
}
//性別
if (!$gender = $_POST['gender']) {
  $err['gender'] = '性別を選んでください!!';
  //sessionは連想配列
}
//生年月日
if (!$birth = $_POST['birth']) {
  $err['birth'] = '生年月日を入力してください!!';
  //sessionは連想配列
}
//自己紹介
if (!$self_introduction = $_POST['self_introduction']) {
  $err['self_introduction'] = '自己紹介を入力してください!!';
  //sessionは連想配列
}

//値の取得
$nickname = $_POST['nickname'];
$gender = $_POST['gender'];
$birth = $_POST['birth'];
$self_introduction = $_POST['self_introduction'];

//DB接続
$pdo = connect_to_db();

//-----プロフィール作成時にエラーがあった場合にプロフィール作成フォームに表示-----//
if (count($err) > 0) {
  //エラーがあった場合
  //セッションにエラーメッセージを入れて、ログイン画面に戻す
  $_SESSION = $err;
  header('Location:profile_input.php');
  return; //処理を止める
};


//-----プロフィール作成、成功時の処理-----//
if (count($err) === 0) {
  //SQL作成
  $sql = 'INSERT INTO profile_table(id, nickname, gender,birth,self_introduction,created_at,updated_at) VALUES(NULL, :nickname,:gender,:birth,:self_introduction, now(), now())';
}
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':nickname', $username, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_INT);
$stmt->bindValue(':birth', $birth, PDO::PARAM_STR);
$stmt->bindValue(':self_introduction', $self_introduction, PDO::PARAM_STR);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//TOP画面へ遷移
header("Location:todo_read.php");
exit();
?>


<!-- <!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール登録完了画面</title>
</head>

<body>
  <!-- PHP文で作成したエラー内容を表示 -->
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <p><?= $e ?></p>
    <?php endforeach ?>
  <?php else : ?>
    <p>プロフィール登録が完了しました</p>
  <?php endif ?>
  <a href="./todo_read.php">マイページへ</a>
</body>

</html> -->