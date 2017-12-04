<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$id = getenv('SEND_ID');

$arrayRemind = array(
  "葉酸タイムニャ!",
  "葉酸忘れてニャいかな?",
  "にゃーにゃーよーさんにゃー",
  "さてと、葉酸飲むかニャ",
  "茜さん、葉酸の時間ニャー"
);

$indexArray = rand(0,count($arrayRemind)-1);
$textRemindMs = $arrayRemind[$indexArray];

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textRemindMs);
$response = $bot->pushMessage($id, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

 ?>
