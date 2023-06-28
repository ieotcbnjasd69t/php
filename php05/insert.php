<?php
//1. POSTデータ取得
$name   = $_POST["name"];
$email  = $_POST["email"];
$naiyou = $_POST["naiyou"];

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//*******************************************************
// File処理：[fileupload("POST送信名","アップロードフォルダ名");]
// 1.TABLE定義修正 [img(varchar 255)追加]
// 2.SQL修正       [SQLカラムとバインド変数の追加]
// ※フォルダの「読み書き権限」特にMacユーザー
//*******************************************************
// $status = fileUpload("upfile","upload/");
// if($status==1 || $status==2){
//   //Error
//   exit("UploadError");
// }else{
//   //Good
//   $img = $status;  //ファイル名
// }


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES(:name,:email,:naiyou,sysdate())");
$stmt->bindValue(':name',   $name, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email',  $email, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("index.php");
}

