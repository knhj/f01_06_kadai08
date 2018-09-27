<?php
$name = $_POST["name"];
$mail = $_POST["mail"];
$sex = $_POST["sex"];
$anime = $_POST['anime'];

// DB 接続します
include('functions.php');
$pdo = db_conn();

// try {
//   $pdo = new PDO('mysql:dbname=gs_f01_db06;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('dbError:'.$e->getMessage());
// }

$sql ="INSERT INTO anime_post(id,name,mail,sex,created_at) 
VALUES (null,:a1,:a2,:a3,sysdate())";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $mail, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $sex, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


$sql ="INSERT INTO posted_anime(post_id,anime_id) 
VALUES (:b1,:b2)";
$last_id = $pdo->lastInsertID('id');



foreach($anime as $value){
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':b1', $last_id, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':b2', $value, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();
}




//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
//   header("location: index.php");

// echo $last_id;
// echo "\n";
}

?>


<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>書き込み画面</title>
        <style>
        body{
	        font-family: Roboto, "Yu Gothic Medium", "游ゴシック Medium", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", "メイリオ", sans-serif;
	        line-height: 1.75;
        	font-size: 16px;
        }
        .link{
            font-size:30px;
            text-align:center;
            margin: 10px;
        }
        h1 {
            margin-top:100px;
            text-align:center;
            margin-bottom:30px;
        }
        a {
            text-decoration: underline;
        }
        </style>
    </head>
    <body>
    <h1>ご回答ありがとうございます！！</h1> 
    <div class="link"><a href="read.php">人気ランキングはこちら</a></div>



 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>