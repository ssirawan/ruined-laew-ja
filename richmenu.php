use LINEBot\RichMenuBuilder;

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'vEcA9SC+uVHF+zBZZQod5Yp/fS2Xn+lUkqHKi1EE1OGXZjtGJlfwrKfkLFu+wOyVPGomLXbzjZOWaK7MQjJsJ3c0kPBhnDo2vxEdES6a2Kk8PnQNwJRLHbPslhqvzC1xk8lM8HLtnERPSG8oXBLNvwdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$rich_url = 'https://api.line.me/v2/bot/richmenu';


$sizeBuilder = self(1686, 2500);
$selected = true;
$name = 'richmenu';
$chatbartext = 'Bulletin';
$areabuilders = [
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
  ];


$create = __construct($sizeBuilder, $selected, $name, $chatBarText, $areaBuilders);


function __construct($sizeBuilder, $selected, $name, $chatBarText, $areaBuilders)
    {
        $this->sizeBuilder = $sizeBuilder;
        $this->selected = $selected;
        $this->name = $name;
        $this->chatBarText = $chatBarText;
        $this->areaBuilders = $areaBuilders;
    }
function build()
    {
        $areas = [];
        foreach ($this->areaBuilders as $areaBuilder) {
            $areas[] = $areaBuilder->build();
        }
        return [
            'size' => $this->sizeBuilder->build(),
            'selected' => $this->selected,
            'name' => $this->name,
            'chatBarText' => $this->chatBarText,
            'areas' => $areas,
        ];
?>
