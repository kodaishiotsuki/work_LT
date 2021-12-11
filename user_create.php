<?php
// var_dump($_POST);
// exit();
session_start();
include('functions.php');



//-----バリデーション-----//
//エラーメッセージ
$err = [];
//ユーザー名
if (!$username = $_POST['username']) {
  $err['username'] = 'メールアドレスを記入してください';
}
//メールアドレス
if (!$email = $_POST['email']) {
  $err['email'] = 'メールアドレスを記入してください';
}
//パスワード(正規表現を使う)
$password = $_POST['password'];
//正規表現
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
  $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください';
}
//パスワード確認
$password_conf = $_POST['password_conf'];
if ($password !== $password_conf) {
  $err['password_conf'] = '確認用パスワードと異なっています';
}

//値を取得
// $username = $_POST["email"];
// $password = $_POST["password"];
// // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// $password_conf = $_POST["password_conf"];


//DB接続
$pdo = connect_to_db();

//もしエラーの配列の中身が空だったら、ユーザー登録処理
if (count($err) === 0) {
  $sql = 'INSERT INTO users_table (id,username,email,password,is_admin,is_deleted,created_at,updated_at) VALUES(NULL,:username,:email,:password,0,0,now(),now())';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録完了画面</title>
</head>

<body>
  <!-- PHP文で作成したエラー内容を表示 -->
  <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
      <p><?= $e ?></p>
    <?php endforeach ?>
  <?php else : ?>
    <p>ユーザー登録が完了しました</p>
  <?php endif ?>
  <a href="./user_input.php">戻る</a>
</body>

</html>