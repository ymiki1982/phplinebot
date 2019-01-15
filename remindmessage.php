<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$id = getenv('SEND_ID');

$arrayRemind = array(
  "drugs飲むにゃー",
  "this ia drug time miaw!",
  "お薬の時間だよー",
  "いま おくすり のむ とき にゃ",
  "はーい、おくすりの時間ですよー"
);

$indexArray = rand(0,count($arrayRemind)-1);

date_default_timezone_set('Asia/Tokyo');
if (date('a')=='am'){
    $strMs = '鼻シュータイムにゃー!!';
}else{
    $strMs = $arrayRemind[$indexArray];
}

$textRemindMs = $strMs;

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textRemindMs);
$response = $bot->pushMessage($id, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

 ?>
