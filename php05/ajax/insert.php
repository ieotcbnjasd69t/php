<?php
//1. POSTデータ取得
$name   = $_POST["name"];
$email  = $_POST["email"];
$naiyou = $_POST["naiyou"];

//2. DB接続します(エラー処理追加)
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_an_table( name, email, naiyou, indate )VALUES(:name, :email, :naiyou, sysdate())");
$stmt->bindValue(':name', $name);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':naiyou', $naiyou);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  echo "false";
}else{
  echo "true";
}
?>
