<?php
//-----トップ画面-----//
//セッション開始
session_start();
//読み込み関数
include("functions.php");
//セッション状態確認
check_session_id();
//ログイン中のユーザー確認
$user_id = $_SESSION['user_id'];
//DB接続
$pdo = connect_to_db();

//SQL作成
$sql = "SELECT * FROM profile_table WHERE user_id = :user_id";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド関数
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行内容
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($records);
// exit();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ジムれる？</title>
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
  <div class="wrapper">
    <?php foreach ($records as $record) { ?>
      <!-- ヘッダー -->
      <header>
        <!-- ヘッダー左 -->
        <div class="header-left">
          <h2>マイページ</h2>
        </div>
        <!-- ヘッダー右 -->
        <div class="header-right">
          <a href="./logout.php">
            <img src="./img/logout.png" alt="" height="50px">
          </a>
        </div>
      </header>
      <!-- プロフィールセクション -->
      <div class="main">
        <div>
          <!-- プロフ画像（編集可） -->
          <a href="./profile_edit.php?id=<?= $record['id'] ?>">
            <img src="<?= $record['image'] ?>" alt="" height="200px">
          </a>
          <!-- 表示名 -->
          <p><?= $record['nickname'] ?></p>

        </div>
        <a href="./profile_input.php">入力画面</a>
      </div>

      <!-- 通知セクション -->
      <div class="sub">

      </div>
      <!-- フッター -->
      <footer>
        <div>
          <a href="./main.php">
            <img src="./img/home.png" alt="" height="50px">
          </a>
        </div>
        <div>
          <a href="#">
            <img src="./img/like.png" alt="" height="50px">
          </a>
        </div>
        <div>
          <a href="#">
            <img src="./img/mail.png" alt="" height="50px">
          </a>
        </div>
        <div>
          <a href="#">
            <img src="./img/search.png" alt="" height="50px">
          </a>
        </div>
      </footer>


    <?php } ?>
  </div>

</body>

</html>