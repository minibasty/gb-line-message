<?php
// URL API LINE
$API_URL = 'https://api.line.me/v2/bot/message/';
// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'vwZwFMgCgqA203Q0LGzvLGEONYYHr5d9MkhE3anYGz+iN8rKNwYMVYLGaXvFjpw94kCIsKoRQo6gWyP+6IVSQ33j9/IaA/O/0+8EvjbNfT2CTwGKpBd48LwRVFexOgbRtBdPpXrr5/UbFc/RUQ1HtgdB04t89/1O/w1cDnyilFU=';
// ใส่ Channel Secret
$CHANNEL_SECRET = 'c674a0cd44f9089e3985242719ae1f78';

// Set HEADER
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
// Get request content
$request = file_get_contents('php://input');
// Decode JSON to Array
$request_array = json_decode($request, true);


if (sizeof($request_array['events']) > 0) {
  foreach ($request_array['events'] as $event) {

    $reply_message = '';
    $reply_token = $event['replyToken'];
    $text = $event['source']['userId'];
    $data = [
       'replyToken' => $reply_token,
       'messages' => [['type' => 'text', 'text' => $text ]]
    ];
    $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
    $send_result = send_reply_message($API_URL . '/reply', $POST_HEADER, $post_body);
    echo "Result: " . $post_body . "\r\n";
  }
}

function send_reply_message($url, $post_header, $post_body)
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $result = curl_exec($ch);
  curl_close($ch);

  return $result;
}

