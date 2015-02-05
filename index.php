<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>PHPサンプル</title>
</head>
<body>
<p>
<?php
 
// HTTP_Request2
require_once 'HTTP/Request2.php';
 
// 認証設定
$subDomain = "acrovision90";
$loginName = "goto.masaki@acrovision.jp";
$password = "goto0126";
$apiToken = "VMwH52cdbrcDRXTPxuaYW27ex3bMg0Q54qBJhQqq";

 
// アプリID
$appId = 16;
$record = 16;
 
// リクエストヘッダ
$header = array(
    "Host: " . $subDomain . ".cybozu.com:443",
    "Content-Type: application/json",
    "X-Cybozu-API-Token: ".$apiToken
);
 
try {
    // リクエスト作成
    $request = new HTTP_Request2();
    $request->setHeader($header);
    $request->setUrl("https://" . $subDomain . ".cybozu.com/k/v1/record.json");
    $request->setMethod(HTTP_Request2::METHOD_GET);
    $request->setBody(json_encode(array("app" => $appId)));
    $request->setBody(json_encode(array("id" => 16)));

    $request->setConfig(array(
      'ssl_verify_host' => false,
      'ssl_verify_peer' => false
    ));
 
    // レスポンス取得
   $response = $request->send();

// HTTP_Request2のエラーを表示
} catch (HTTP_Request2_Exception $e) {
    die($e->getMessage());
// それ以外のエラーを表示
} catch (Exception $e) {
    die($e->getMessage());
}
 
// エラー時
if ($response->getStatus() != "200") {
  echo sprintf("status: %s\n", $response->getStatus());
  echo sprintf("cybozu error: %s\n", $response->getHeader('x-cybozu-error'));
  echo sprintf("body: \n%s\n", $response->getBody());
  die;
}
 
$data = json_decode($response->getBody(), true);
var_dump($data);

?>

</p>
</body>
</html>