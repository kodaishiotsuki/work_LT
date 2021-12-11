<?php
// var_dump($_SESSION);
session_start();
//エラー表示の変数を定義
$err = $_SESSION;
//sessionの中身(エラーメッセージ)を消す（リロードすると消える処理）
$_SESSION = array();
session_destroy();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
</head>

<body>
  <h2>ログインフォーム</h2>
  <form action="./login.php" method="POST">
    <div>
      <label for="email">メールアドレス:</label>
      <input type="email" name="email">
      <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['email']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <label for="password">パスワード:</label>
      <input type="password" name="password">
      <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['password']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <input type="submit" value="ログイン">
    </div>
  </form>
  <a href="./user_input.php">新規登録はこちら</a>
</body>

</html>