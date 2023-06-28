<?php
session_start();
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_an_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
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
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<style>div{padding: 10px;font-size:16px;}td{padding:5px; margin:5px;border:1px solid #777; background:#fff;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<?php include("menu.php"); ?>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">

      <table id="list">
      <?php foreach($values as $v){ ?>
        <tr>
          <td><?=h($v["id"])?></td>
          <td> <a href="detail.php?id=<?=h($v["id"])?>"><?=h($v["name"])?></a></td>
          <td><?=h($v["email"])?></td>
          <td><?=h($v["indate"])?></td>
          <?php if($_SESSION["kanri_flg"]=="1"){ ?>
            <td> <a href="delete.php?id=<?=h($v["id"])?>">［削除］</a></td>
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
