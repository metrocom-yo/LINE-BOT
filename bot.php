<?php
// include composer autoload
require_once 'vendor/autoload.php';

$access_token = 'OBndRkQEmWPqffF0HTvXjhbX0W5XUt2cqYfTv46lbblXx0+H5H1oaJseLWjmGPeLujCTXLjxk6+kEplq9FVZCEykT57s6OW+59fKQo9929dS0VbPzM3u5QH152w9+irinIPDtCYTCZL7yd8WsdDLdAdB04t89/1O/w1cDnyilFU=';

//
///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;


// Get POST body content
$content = file_get_contents('php://input');

// Parse JSON
$events = json_decode($content, true);

// Validate parsed JSON data
if (!is_null($events['events'])) {

  // Loop through each event
  foreach ($events['events'] as $event) {

  // Reply only when message sent is in 'text' format
  if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

    // Get text sent
    $text = $event['message']['text'];

    // Get replyToken
    $replyToken = $event['replyToken'];

  if(substr($text,0,4)=='node'){
    $textgo = trim(str_replace('node','',$text));
    $url 	= "http://ro6map.3bb.co.th/webservice/bot_node.php?input=$textgo";
    $output = file_get_contents($url);
    $messages =       [		'type' => 'text',
                          'text' => $output
                      ];

  }else if(iconv_substr($text,0,5,"UTF-8")=="เบอร์"){
    $textgo = trim(str_replace("เบอร์","",$text));
    $url 	= "http://ro7.triplet.co.th/support/app/webservice/bot_emp.php?input=$textgo";
    $output = file_get_contents($url);
    $messages =       [		'type' => 'text',
                          'text' => $output
                      ];
  }else if($text=='เฌอปราง'){

    $messages =       [		'type' => 'text',
                          'text' => 'คิดถึงนะจ๊ะตั้งใจทำงานหละ'
                      ];
  }else{

    $messages =       [		'type' => 'text',
                          'text' => $text
                      ];
  }


    // Build message to reply back
    //$messages = [				'type' => 'text',				'text' => $text			];

    // Make a POST Request to Messaging API to reply to sender
    $url = 'https://api.line.me/v2/bot/message/reply';
    $data = ['replyToken' => $replyToken,'messages' => [$messages],	];
    $post = json_encode($data);
    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    echo $result . "";
    }
  }
}

    echo "OK";
?>
