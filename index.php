<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>PHPサンプル</title>
</head>
<body>
<p>
<?php
 
	// 自分のkintoneの設定
	define("API_TOKEN", "VMwH52cdbrcDRXTPxuaYW27ex3bMg0Q54qBJhQqq"); 
	define("SUB_DOMAIN", "acrovision90"); 
	define("APP_NO", "16"); 


	//サーバ送信するHTTPヘッダを設定
	$options = array(
	    'http'=>array(
	        'method'=>'GET',
	        'header'=> "X-Cybozu-API-Token:". API_TOKEN ."\r\n"
	    )
	);
	//コンテキストを生成
	$context = stream_context_create( $options );
	// サーバに接続してデータを貰う
	$contents = file_get_contents( 'https://'. SUB_DOMAIN .'.cybozu.com/k/v1/records.json?app='. APP_NO , FALSE, $context );

	//var_dump($http_response_header); //ヘッダ表示
	
	//JSON形式からArrayに変換
	$data = json_decode($contents, true);

	//表示は単純なテーブルで
	$str  = "<table border='1'>";
	$str .= "<tr>";
	$str .= "<th>レコード番号</th>";
	$str .= "<th>作成日時</th>";
	$str .= "<th>作成者</th>";	
	$str .= "<th>名前</th>";
	$str .= "</tr>";
	
	for($i=0; $i<count($data['records']); $i++){
		$str .= "<tr>";
		$str .= sprintf("<td>%s</td>", $data['records'][$i]['レコード番号']['value']);
		$str .= sprintf("<td>%s</td>", $data['records'][$i]['作成日時']['value']);
		$str .= sprintf("<td>%s</td>", $data['records'][$i]['作成者']['value']['name']);
		$str .= sprintf("<td>%s</td>", $data['records'][$i]['名前']['value']);
		$str .= "</tr>";		
	}
	$str .= "</table>";
	
	//画面に出力
	echo $str;
?>

</p>
</body>
</html>