<?php
//1.  DB接続します
include('functions.php');
$pdo = db_conn();


// try {
//   $pdo = new PDO('mysql:dbname=gs_f01_db06;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('dbError:'.$e->getMessage());
// }


//２．データ登録SQL作成
$stmt = $pdo->prepare("select * from selectedanime ");
$status = $stmt->execute();

//３．データ表示
$view="";
$is2016 = "true";
$is2017 = "true";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	// $view .= "<p>".$result["animeID"]."-".$result["title"]."-".$result["year"]."</p>";
	$title = $result["title"];
	$year = $result["year"];
	$animeID = $result["animeID"];

 	if($year== "2016"){
					if($is2016 == "true"){
						$view .= '<li id="year2016" class="btn btn-primary">2016年</li><br>';
						$is2016 = "false";
					}
			   }
	if($year == "2017"){
					if($is2017 == "true"){
						$view .= '<li id="year2017" class="btn btn-primary">2017年</li><br>';
						$is2017 = "false";
					}
			   }

	 $view .='<li class="anititle year';
	 $view .=$year;
	 $view .='">';
	 $view .='<input type="checkbox" name="anime[]" value="';
	 $view .=$animeID;
	 $view .='">'; 
	 $view .=$title;
	 $view .='</li>';
  }
}

?>


<html>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
		 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <title>アニメアンケート</title>
		<style>
		body{
	        font-family: Roboto, "Yu Gothic Medium", "游ゴシック Medium", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", "メイリオ", sans-serif;
	        line-height: 1.75;
        	font-size: 16px;
        }
		*{
			list-style:none;
		}
		.flex{
			display:flex;
			justify-content:center;
			width:960px;
		}
		.cell1 {
			width:150px;
			text-align:left;
            height:30px;
			line-height: 30px;
			margin: 10px;
		}
		.cell2 {
			width:400px;
			text-align:left;
            height:30px;
			line-height: 30px;
			margin: 10px;
			
		}
		.bo{
			border: 2px gray solid;
			width:300px;
			border-radius: 6px;	
		}
		.checktitle{
        font-size: 20px;
        margin: 5px;
		border-bottom: 2px gray solid;
        width: 960px;
        margin: 0 auto 25px auto;
		}
		.btn {
			margin: 0 auto;
		}
		.anititle{
			width :960px;
			text-align:center;
		}
		.cent{
			display:flex;
			justify-content:center;
		}
		.year2015,.year2016,.year2017{
			display:none;
		}
		.anititle{
			background-color: #f0ebe5;
			line-height:30px;
			height:30px;
			width:680px;
			text-align:left;
			margin: 3px auto;
			border-radius: 6px;	
			/* border: 2px solid black; */
		}
		.btn {
			margin-bottom:3px;
		}
		</style>
	</head>
	<body style="padding: 50px;">
	<h1 class="text-center bg-primary text-light font-weight-bold display-4">好きなアニメアンケート</h1>
		<form action="write.php" method="post">
			<ul >
				<li class="flex">
				    <div class="cell1">名前:</div>
					 <div class="cell2"><input class="bo" type="text" name="name"><div>
				</li>
				<li class="flex">
			    	<div class="cell1">EMAIL:</div> 
				    <div class="cell2"><input class="bo" type="text" name="mail"></div>
				</li>
				<li class="flex">
			    	<div class="cell1">性別:</div>
					<div class="cell2"><input type="radio" name="sex" value="man" >男／
			    	<input class=”” type="radio" name="sex" value="woman" >女</div>
				</li>
				<li class="checktitle">放送開始年をクリック後、好きなタイトルを選択してください。</li>
				<li id="year2015" class="btn btn-primary">2015年</li><br>
    			<?=$view?>

			</ul>
			<div class="cent">
			<input class="btn btn-primary btn-lg" type="submit" value="送信">
			</div>
		</form>
		

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 <script>
 $('#year2015').click(function(){
       
		 $('.year2015').show();
 });
 $('#year2016').click(function(){
        
		 $('.year2016').show();
 });
$('#year2017').click(function(){
        
		 $('.year2017').show();
 });

 </script>
 
 </body>

</html>