// use LINE\LINEBot\RichMenuBuilder; 
// use LINE\LINEBot\HTTPClient;


$API_URL = 'https://api.line.me/v2/bot/richmenu';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$CH_SECRET = 'e33ac5e982da548d1c1984ac6a97a69e';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv($ACCESS_TOKEN));
$bot = new LINE\LINEBot($httpClient, ['channelSecret' => getenv($CH_SECRET)]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$richmenu_post_body = {"size": {"width": 2500,"height": 1686},"selected": true,"name": "Controller","chatBarText": "index",
"areabuilders": [
    {
      "bounds" : {
        "x": 0,
        "y": 0,
        "width": 1254,
        "height": 850
      },
      "action": {
        "type": "postback",
        "text": "ดูสินค้า",
        "data": "Data 1"
      }
    },
    {
      "bounds": {
        "x": 0,
        "y": 850,
        "width": 1258,
        "height": 831
      },
      "action": {
        "type": "postback",
        "text": "Promotion",
        "data": "Data 3"
      }
    },
    {
      "bounds": {
        "x": 1254,
        "y": 0,
        "width": 1246,
        "height": 850
      },
      "action": {
        "type": "postback",
        "text": "สินค้าที่บันทึกไว้",
        "data": "Data 3"
      }
    },
    {
      "bounds": {
        "x": 1258,
        "y": 850,
        "width": 1242,
        "height": 835
      },
      "action": {
        "type": "postback",
        "text": "เช็คสถานะ",
        "data": "Data 4"
      }
    }
  ]
};

//$richmenu = new RichMenuBuilder($sizeBuilder,$selected,$name,$chatbartext,$areabuilders);
$send_richmenu = create_richmenu($API_URL, $post_header,$richmenu_post_body);

function create_richmenu($url, $post_header, $post_body)
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
