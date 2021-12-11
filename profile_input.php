<?php
//-----プロフィール登録-----//
// //セッション開始
session_start();
// //関数読み込み
include("functions.php");
// //セッション状態確認
check_session_id();
//ログイン中のユーザー確認
// var_dump($_SESSION);
// exit();

$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール入力画面</title>
</head>



<body>
  <h2>プロフィール入力画面</h2>
  <form action="./profile_create.php" method="POST" enctype="multipart/form-data">
    <div>
      <label for="nickname">ニックネーム:</label>
      <input type="text" name="nickname">
    </div>

    <div>
      <label for="gender">性別：</label>
      <input type="radio" name="gender" value="0">男性
      <input type="radio" name="gender" value="1">女性
    </div>

    <div>
      <label for="birth">生年月日:</label>
      <input type="date" name="birth">
    </div>

    <div>
      <label for="address">居住地:</label>
      <input type="text" name="address">
    </div>

    <div>
      <!-- <label for="upfile">プロフィール画像:</label> -->
      <input type="file" name="upfile" accept="image/*" capture="camera">
    </div>

    <div>
      <label for="self_introduction">自己紹介:</label>
      <input type="text" name="self_introduction" style="width:100px; height:50px;">
    </div>

    <!-- ユーザーIDを取得しておく部分 -->
    <input type="hidden" name="user_id" value=<?= $user_id ?>>
    <div>
      <input type="submit" value="登録">
    </div>
  </form>
  <a href="./main.php">マイページ</a>
  <a href="./logout.php">logout</a>
</body>

</html>