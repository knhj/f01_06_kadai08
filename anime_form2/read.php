<?php

include('functions.php');
$pdo = db_conn();

// try {
//   $pdo = new PDO('mysql:dbname=gs_f01_db06;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('dbError:'.$e->getMessage());
// }

//２．データ登録SQL作成
$stmt = $pdo->prepare("select count(*) from anime_post");
$status = $stmt->execute();

//３．データ表示
$MWrank = array();
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$goukei = $result["count(*)"];
	
  }
}



?>





<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ランキング表示</title>
        <style>

        body{
	        font-family: Roboto, "Yu Gothic Medium", "游ゴシック Medium", YuGothic, "游ゴシック体", "ヒラギノ角ゴ Pro W3", "メイリオ", sans-serif;
	        line-height: 1.75;
        	font-size: 16px;
        }

        table {
          border-collapse:  collapse; /* セルの線を重ねる */
        }
 
        tr:nth-child(odd) {
           background-color:  #ddd;    /* 背景色指定 */
        }
 
        th,td {
            padding: 5px 10px;          /* 余白指定 */
        }
        h1 {
            text-align:center;
            color:#fff;
            background-color:blue;
          
        }
        .sou{
            font-size:20px;
        }
        .flex{
            display:flex;
            justify-content:center;
        }
        #top{
            color:#fff;
            background-color:blue;
        }
        .center{
         text-align:center;
        }
        </style>
    </head>
    <body>


<h1>アニメ人気ランキング</h1>
<div class="sou">総投稿数:<?php echo $goukei;?></div>

<table class="flex">
    <tbody>
        <tr id="top">
            <th></th>
            <td class="center" >男</td>
            <td class="center">投票数</td>
            <td class="center">女</td>
            <td class="center">投票数</td>
        </tr>
<?php  


//２．データ登録SQL作成
$stmt = $pdo->prepare("select selectedanime.title,count(*) from posted_anime join selectedanime on selectedanime.animeID = posted_anime.anime_id join anime_post on anime_post.id = posted_anime.post_id  where anime_post.sex = 'man' group by posted_anime.anime_id order by count(*) desc limit 10");
$status = $stmt->execute();

//３．データ表示
$MWrank = array();
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  $i=0;
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$title = $result["title"];
	$count = $result["count(*)"];
    $MWrank[$i][0] = $title;
    $MWrank[$i][1] = $count;
    $i++;
    
  }
}

//２．データ登録SQL作成
$stmt = $pdo->prepare("select selectedanime.title,count(*) from posted_anime join selectedanime on selectedanime.animeID = posted_anime.anime_id join anime_post on anime_post.id = posted_anime.post_id  where anime_post.sex = 'woman' group by posted_anime.anime_id order by count(*) desc limit 10");
$status = $stmt->execute();

//３．データ表示

if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  $i=0;
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$title = $result["title"];
	$count = $result["count(*)"];
    $MWrank[$i][2] = $title;
    $MWrank[$i][3] = $count;
    $i++;
  }
}

//ここまでで[男アニメタイトル、票数、女アニメタイトル、票数]が要素の要素数が順位の配列ができる
$i=0;
foreach($MWrank as $value){
    $num = $i + 1;
    // echo "$key は $value 回出てきました<br>";
  echo  "<tr>";
  echo      "<th>".$num."位</th>";
  echo      "<td>".$MWrank[$i][0]."</td>";
  echo      "<td class='center'>".$MWrank[$i][1]."</td>";
  echo      "<td>".$MWrank[$i][2]."</td>";
  echo      "<td class='center'>".$MWrank[$i][3]."</td>";
  echo  "</tr>";

$i++;

}


?>
     </tbody>
</table>
    </body>
</html>