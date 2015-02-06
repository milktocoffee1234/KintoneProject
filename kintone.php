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
 
// アプリID
$appId = 16;
 
// リクエストヘッダ
 $header = array(
    "Host: " . $subDomain . ".cybozu.com:443",
    "Content-Type: application/json",
    "X-Cybozu-Authorization: " . base64_encode($loginName . ':' . $password)
);

try {
    // リクエスト作成
    $request = new HTTP_Request2();
    $request->setHeader($header);
    $request->setUrl("https://" . $subDomain . ".cybozu.com/k/v1/record.json");
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setBody(json_encode(array("app" => $appId,
    									"record" => array(
    										"名前" => array(
    												"value" => $_POST["name"]
    										),
    										"内容" => array(
    												"value" => $_POST["textform"]
    										)
    									)
    									)));
    $request->setConfig(array(
      'ssl_verify_host' => false,
      'ssl_verify_peer' => false
    ));
 
    // レスポンス取得
    $response = $request->send();

    echo "アップロードできました";
 
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

?>

</p>
</body>
</html>