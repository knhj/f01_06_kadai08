<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['name']) || $_POST['name']=="" ||
  !isset($_POST['lid']) || $_POST['lid']=="" ||
  !isset($_POST['lpw']) || $_POST['lpw']=="" ||
  !isset($_POST['kanri_flg']) || $_POST['kanri_flg']=="" ||
  !isset($_POST['life_flg']) || $_POST['life_flg']==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$name   = $_POST['name'];
$lid  = $_POST['lid'];
$lpw = $_POST['lpw'];
$kanri_flg = $_POST['kanri_flg'];
$life_flg = $_POST['life_flg'];

//2. DB接続します(エラー処理追加)
include('functions.php');
$pdo = db_conn();

// var_dump($kanri_flg);


//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO '. $table .'(id, name, lid, lpw, kanri_flg, life_flg ) VALUES (NULL, :a1, :a2, :a3, :a4, :a5)');
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':a4', intval($kanri_flg), PDO::PARAM_INT);
$stmt->bindValue(':a5', intval($life_flg), PDO::PARAM_INT);

// var_dump($stmt);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  //５．index.phpへリダイレクト
  header('Location: user_index.php');
  exit;
}
?>
