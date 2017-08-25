<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$id = getenv('SEND_ID');

$arrayRemind = array(
  "おくすりにゃんにゃんにゃん",
  "KUSURIタイムにゃ",
  "おーい、お薬",
  "薬にゃー",
  "飲もうぜ、薬！"
);

$indexArray = rand(0,count($arrayRemind)-1);
$textRemindMs = $arrayRemind[$indexArray];

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textRemindMs);
$response = $bot->pushMessage($id, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

 ?>
