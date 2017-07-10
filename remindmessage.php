<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$id = getenv('SEND_ID');

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("おくすり(鼻プシュ)の時間です。");
$response = $bot->pushMessage($id, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

 ?>
