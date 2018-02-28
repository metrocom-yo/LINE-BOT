<?php
$access_token = 'OBndRkQEmWPqffF0HTvXjhbX0W5XUt2cqYfTv46lbblXx0+H5H1oaJseLWjmGPeLujCTXLjxk6+kEplq9FVZCEykT57s6OW+59fKQo9929dS0VbPzM3u5QH152w9+irinIPDtCYTCZL7yd8WsdDLdAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';
$headers = array('Authorization: Bearer ' . $access_token);
$ch = curl_init($url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);curl_close($ch);
echo $result;
?>
