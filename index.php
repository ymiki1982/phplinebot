<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}

foreach ($events as $event) {
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }

  if ($event->getText() == "id"){

  //id返信
    $response = "IDは、\n".$event->displayName();

  }else{

    $response = $event->getText();

    //chatplus返信
//    $renponse = talk_api_chat($event->getText());
    
    
    //talkapi返信
//    $renponse = talk_api_chat($event->getText());

    //docomo返信
//    $response = chat($event->getText());

  }

  $bot->replyText($event->getReplyToken(), $response . "\nにゃんだな");

}

//talkapiから雑談データ取得
function talkapi($text) {
return $text;
//    try{
//    $api_key = 'DZZA5t2r80senER7U1PQDPVnKyA83x3M';
//    $api_url = 'https://api.a3rt.recruit-tech.co.jp/talk/v1/smalltalk';
//    //送信データ
//    $req_body = array(
//        'apikey' => $api_key,
//        'query' => $text
//    );
//    
//    $headers = array(
//    'Content-Type: application/json; charset=UTF-8',
//    );
//    
//    $options = array(
//    'http'=>array(
//    'method' => 'POST',
//    'header' => implode("\r\n", $headers),
//    'content' => json_encode($req_body),
//    )
//    );
//
//    $stream = stream_context_create($options);
//
//    $res = json_decode(file_get_contents($api_url, false, $stream));
//    if ($res == 0) {
//    $t = $res->results;
//        return $t->reply;
//    }else{
//        return 'err';
//    }
//    }catch( Exception $ex ){
//        return $ex->getMessage();
//    }
}

//ドコモの雑談APIから雑談データを取得
function chat($text) {
    // docomo chatAPI

    $context_file = dirname(__FILE__).'/context.txt';
    $api_key = '734863314f674a4c7264535a3479565a2f326e6b59624852366c6c6c387370374e736830666d424e4d5333';
    $api_url = sprintf('https://api.apigw.smt.docomo.ne.jp/dialogue/v1/dialogue?APIKEY=%s', $api_key);

// 送信データ
$req_body = array(
  "language"=>"ja-JP",
  "botId"=>"Chatting",
  "appId"=>"8861e057-a35d-491b-9829-bf52829552ba",
  "voiceText"=>$text,
   "clientData" => array(
   "option"=> array(
     "nickname"=>"茜",
     "nicknameY"=>"あかね",
     "sex"=>"女",
     "bloodtype"=>"B",
     "birthdateY"=>"1981",
     "birthdateM"=>"12",
     "birthdateD"=>"19",
     "age"=>"36",
     "constellations"=>"双子座",
     "place"=>"東京",
     "mode"=>"dialog"
     )
   ),
  "appRecvTime" => date("Y/m/d H:i:s"),
  "appSendTime" => date("Y/m/d H:i:s")
);

    if ( file_exists($context_file) ) {
      $req_body['context'] = file_get_contents($context_file);
    }

    $headers = array(
        'Content-Type: application/json; charset=UTF-8',
    );
    $options = array(
        'http'=>array(
            'method'  => 'POST',
            'header'  => implode("\r\n", $headers),
            'content' => json_encode($req_body),
            )
        );
    $stream = stream_context_create($options);
    $res = json_decode(file_get_contents($api_url, false, $stream));

    if (isset($res->context)) {
      file_put_contents($context_file, $res->context);
    }

    return $res->utt;

}

 ?>
