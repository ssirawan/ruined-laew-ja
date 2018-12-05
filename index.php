<?php
$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ( $event['type'] == 'message' ) 
  {
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
	$car = array("'1'","1","1","ค้นหารถ","รถ","หารถ","ยี่ห้อรถ");
	$tel = array("tel","เบอร์","หาเบอร์","2","'2'","โทร","เบอร์โทร");
	$check = 0;
	
	foreach ($car as $value)
	{
		if($text == $value)
		{
			$check=1;
		}
		else 
			foreach ($tel as $value)
			{
				if($text == $value)
				{
					$check=2;
				}
			}
	}
	
	if($check =1)
	{
		$reply_message = 'ตอนนี้มีรถอยู่ในระบบจำนวน 20 คัน';
	}
	elseif($check =2)
	{
		$reply_message = 'อู่คุณวิชัย 023334444';
	}
		
	else
		$reply_message = 'พิมพ์ "1" เมื่อต้องการค้นหารถ <br>
						   พิมพ์ "2" เมื่อต้องการค้นหาเบอร์ติดต่อของบริษัท<br>
						   พิมพ์ "3" เมื่อต้องการตรวจสอบการเงิน';
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}
echo "OK";
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
?>
