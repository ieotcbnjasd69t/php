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
<style>div{padding: 10px;font-size:16px;}td{padding:5px; margin:5px;border:1px solid #777; background:#fff;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<?php include("menu.php"); ?>
<!-- Head[End] -->

<div>
  <input type="text" id="s">
  <button id="btn">送信</button>
</div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
//登録ボタンをクリック
document.querySelector("#btn").onclick=function() {
    //axiosでAjax送信（非同期通信）
    //送信データをオブジェクト変数で用意！
    const params = new URLSearchParams();
    params.append('s',  $("#s").val());

    //axiosでAjax送信
    let html="";
    axios.post('select2_json.php',params).then(function (response) {
        console.log(typeof response.data); //通信OK
        for(let i=0;i<response.data.length;i++){
          console.log(response.data[i]);
          html += `
              <tr>
                <td>${response.data[i].indate}</td>
                <td><a href="detail.php?id=${response.data[i].id}">${response.data[i].name}</a></td>
                <td>${response.data[i].email}</td>
                <td> <a href="delete.php?id=${response.data[i].id}">［削除］</a></td>
              </tr>
          `;
        }
        $("#list").html(html); 
    }).catch(function (error) {
        console.log(error);  //通信Error
    }).then(function () {
        console.log("Last"); //通信OK/Error後に処理を必ずさせたい場合
    });
}
</script>
<script>
const j = '<?php echo $json; ?>';
console.log(JSON.parse(j));



</script>
</body>
</html>
