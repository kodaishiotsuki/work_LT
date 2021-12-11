<?php
//-----ユーザー編集-----//
//セッション開始
session_start();
//関数読み込み
include("functions.php");
//セッション確認変数
check_session_id();
// var_dump($_GET);
// exit();

//取得したidを定義(編集,削除などに使う)
$id = $_GET["id"];

//ログイン状態のユーザー確認
$user_id = $_SESSION['user_id'];

//DB接続
$pdo = connect_to_db();

//SQL作成
//idが一致しているものを取得
$sql = 'SELECT * FROM profile_table WHERE id=:id';
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行内容
$record = $stmt->fetch(PDO::FETCH_ASSOC);

//取得したデータ確認
// echo '<pre>';
// var_dump($record);
// echo '</pre>';
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール（編集画面）</title>
</head>

<body>
  <form action="profile_update.php" method="POST">

    <div>
      <label for="nickname">ニックネーム:</label>
      <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
      <input type="text" name="nickname" value="<?= $record['nickname'] ?>">
    </div>

    <div>
      <label for="gender">性別：</label>
      <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
      <!-- 三項演算子（genderが0→男性にchecked） -->
      <input type="radio" name="gender" value="0" <?= $record['gender'] == 0 ? 'checked' : ''; ?> disabled>男性
      <!-- 三項演算子（genderが1→女性にchecked） -->
      <input type="radio" name="gender" value="1" <?= $record['gender'] == 1 ? 'checked' : ''; ?> disabled>女性
    </div>

    <div>
      <label for="birth">生年月日:</label>
      <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
      <input type="date" name="birth" value="<?= $record['birth'] ?>" disabled>
    </div>

    <div>
      <label for="address">居住地:</label>
      <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
      <input type="text" name="address" value="<?= $record['address'] ?>">
    </div>

    <div>
      <label for="self_introduction">自己紹介:</label>
      <!-- 一覧画面で選択されたidをもとにDBから値を取得して表示 -->
      <input type="text" name="self_introduction" style="width:200px" value="<?= $record['self_introduction'] ?>">
    </div>
    <!-- 次の更新処理でidが必要になるため，<input type="hidden">を用いてidを送信する． -->
    <input type="hidden" name="id" value="<?= $record['id'] ?>">
    <div>
      <input type="submit" value="更新">
    </div>
  </form>
  <a href="./main.php">マイページ</a>
  <a href="./logout.php">logout</a>

  </form>
</body>

</html>