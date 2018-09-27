<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['name']) || $_POST['name']=='' ||
  !isset($_POST['mail']) || $_POST['mail']=='' ||
  !isset($_POST['sex']) || $_POST['sex']==''||
  !isset($_POST['id']) || $_POST['id']=='' ||
  !isset($_POST['anime']) || $_POST['anime']=='' 
){
  exit('ParamError');
}

//1. POSTデータ取得
$id     = $_POST['id'];
$name   = $_POST['name'];
$mail  = $_POST['mail'];
$sex = $_POST['sex'];
$anime = $_POST['anime'];

//2. DB接続します(エラー処理追加)
include('functions.php');
$pdo = db_conn();

//3．データ登録SQL作成
$stmt = $pdo->prepare('UPDATE '. $table .' SET name=:a1, mail=:a2, sex=:a3 WHERE id=:id');
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $mail, PDO::PARAM_STR);
$stmt->bindValue(':a3', $sex, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

$stmt2 = $pdo->prepare('DELETE FROM posted_anime WHERE post_id=:id');
$stmt2->bindValue(':id', $id, PDO::PARAM_INT);
$status2 = $stmt2->execute();


foreach($anime as $value){
$stmt3 = $pdo->prepare("INSERT INTO posted_anime(post_id,anime_id) VALUES (:id,:b2)");
$stmt3->bindValue(':id', $id, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt3->bindValue(':b2', $value, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$status3 = $stmt3->execute();
}



//4．データ登録処理後
if($status==false || $status2 == false|| $status3 == false){
  errorMsg($stmt);
  errorMsg($stmt2);
  errorMsg($stmt3);
}else{
  header('Location: select.php');
  exit;
}
?>
