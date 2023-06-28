<?php
session_start();

//1.外部ファイル読み込み＆DB接続
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
//include "../../includes/funcs.php";
include "funcs.php";
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_user_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);  //JSに渡したいとき
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>USER表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}td{padding:5px; margin:5px;border:1px solid #777; background:#fff;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
    <?php echo $_SESSION["name"]; ?>さん　
    <?php include("menu.php"); ?>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">

      <table>
      <?php foreach($values as $v){ ?>
        <tr>
          <td><?=h($v["id"])?></td>
          <td> <a href="user_detail.php?id=<?=h($v["id"])?>"><?=h($v["name"])?></a></td>
          <td><?=h($v["lid"])?></td>

          <?php if($v["kanri_flg"]==1){ ?>
            <td>管理者</td>
          <?php } ?>
          <?php if($v["kanri_flg"]==0){ ?>
            <td>一般</td>
          <?php } ?>

          <?php if($_SESSION["kanri_flg"]=="1"){ ?>
            <td> <a href="user_delete.php?id=<?=h($v["id"])?>">［削除］</a></td>
          <?php } ?>

        </tr>
      <?php } ?>
      </table>

  </div>
</div>
<!-- Main[End] -->


<script>
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
</script>
</body>
</html>
