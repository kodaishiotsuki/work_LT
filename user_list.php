<?php
//-----登録ユーザー一覧-----//
// var_dump($_SESSION);
session_start();
//関数読み込み
include('./functions.php');
//セッション状態確認
check_session_id();

// //変数にユーザーIDとユーザータイプを取得
// $user_id = $_SESSION['user_id'];
// $admin = $_SESSION['is_admin'];

// // 管理者としてログインしているか確認
// if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {

//   // ログインページへリダイレクト
//   header("Location:login_form");
//   exit;
// }



//DB接続
$pdo = connect_to_db();

//SQL作成
$sql = "SELECT * FROM users_table WHERE is_deleted=0 ORDER BY created_at DESC";
//SQL準備
$stmt = $pdo->prepare($sql);
//今回は"ユーザーが入力したデータを使用しないのでバインド変数は不要"
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行処理内容
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//繰り返し処理でHTML文に表示
$output = "";
foreach ($result as $record) {
  $output .= "
  <tr>
    <td>{$record["username"]}</td>
    <td>{$record["email"]}</td>
    <td>{$record["password"]}</td>
    <td>
        <a href=user_edit.php?id={$record["id"]}>edit</a>
      </td>
      <td>
        <a href=user_delete.php?id={$record["id"]}>delete</a>
      </td>
    </tr>";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザーリスト（管理画面）</title>
</head>

<body>
  <fieldset>
    <legend>ユーザーリスト（管理画面）</legend>
    <a href="./user_input.php">ユーザー登録画面</a>
    <a href="main.php">TOP</a>
    <table>
      <thead>
        <tr>
          <th>username</th>
          <th>email</th>
          <th>password</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>username</td><td>password</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>