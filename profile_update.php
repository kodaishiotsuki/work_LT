<?php
//-----プロフィール編集-----//
//セッション開始
session_start();
//読み取り関数
include("functions.php");
//セッション状態確認
check_session_id();
//エラー確認
if (
  !isset($_POST['nickname']) || $_POST['nickname'] == '' ||
  !isset($_POST['address']) || $_POST['address'] == '' ||
  !isset($_POST['self_introduction']) || $_POST['self_introduction'] == '' ||
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  exit('paramError');
}
//値取得
$nickname = $_POST["nickname"];
$address = $_POST["address"];
$self_introduction = $_POST["self_introduction"];
$id = $_POST["id"];
//DB接続
$pdo = connect_to_db();
//SQL作成
$sql = "UPDATE profile_table SET nickname=:nickname, address=:address,self_introduction=:self_introduction, updated_at=now() WHERE id=:id";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':self_introduction', $self_introduction, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//TOPへ遷移
header("Location:main.php");
exit();
