<?php

$access_token = 'OBndRkQEmWPqffF0HTvXjhbX0W5XUt2cqYfTv46lbblXx0+H5H1oaJseLWjmGPeLujCTXLjxk6+kEplq9FVZCEykT57s6OW+59fKQo9929dS0VbPzM3u5QH152w9+irinIPDtCYTCZL7yd8WsdDLdAdB04t89/1O/w1cDnyilFU=';

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
                          'text' => 'คิดถึงนะค่ะ ตั้งใจทำงานหละ'
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
