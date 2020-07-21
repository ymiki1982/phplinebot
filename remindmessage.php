<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$id = getenv('SEND_ID');

date_default_timezone_set('Asia/Tokyo');

$today = date("Y/m/d");
if(strtotime("2020/7/19") <= strtotime($today) && strtotime($today) <= strtotime("2020/7/21")){
  $textRemindMs = "1錠のむにゃ";
}else if(strtotime("2020/7/22") <= strtotime($today) && strtotime($today) <= strtotime("2020/7/24")){
  $textRemindMs = "2錠のむにゃ";
}else if(strtotime("2020/7/25") <= strtotime($today) && strtotime($today) <= strtotime("2020/7/27")){
  $textRemindMs = "3錠のむにゃ";
}else if(date("H") == "22"){

    $arrayRemind = array(
		  "drugs飲むにゃー",
		  "this ia drug time miaw!",
		  "お薬の時間だよー",
		  "いま おくすり のむ とき にゃ",
		  "はーい、おくすりの時間ですよー"
    );
    
    $indexArray = rand(0,count($arrayRemind)-1);
    $textRemindMs = $arrayRemind[$indexArray];   

}else{
    exit;
}

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textRemindMs);
$response = $bot->pushMessage($id, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

 ?>
