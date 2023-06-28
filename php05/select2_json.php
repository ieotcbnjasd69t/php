<?php
session_start();
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_an_table WHERE email LIKE :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":email", '%'.$_POST["s"].'%' ,PDO::PARAM_STR); //あいまい検索
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}else{
  //全データ取得
  $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
  echo $json = json_encode($values,JSON_UNESCAPED_UNICODE);  //JSに渡したいとき
}