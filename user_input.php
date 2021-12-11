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
  <title>ユーザー登録</title>
</head>

<body>
  <h2>ユーザー登録フォーム</h2>

  <form action="./user_create.php" method="POST">
    <div>
      <label for="username">ユーザー名:</label>
      <input type="text" name="username">
      <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['username']; ?></p>
      <?php endif; ?>
    </div>
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
      <label for="password_conf">パスワード確認:</label>
      <input type="password" name="password_conf">
      <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['password_conf']; ?></p>
      <?php endif; ?>
    </div>
    <div>
      <input type="submit" value="新規登録">
    </div>
    <a href="login_form.php">ログインする</a>
  </form>



</body>

</html>