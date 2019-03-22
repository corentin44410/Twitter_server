<?php
// Scripts à importer
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');
require_once('test.php');

//On récupère le paramètre de recherche
// print_r($_GET);
$param = $_GET['param'];

// print_r($param);

// Propriétés
$accessKey = '07006bb5156e4476846f4c7a2666692a';
$host = 'https://francecentral.api.cognitive.microsoft.com';
$path = '/text/analytics/v2.0/sentiment';

//ACCES TWITTER DO NOT DELETE !
$settings = array(
'oauth_access_token' => "1106090009998909441-NYSQhv05IC5sPBsxUNiFzCeGGLK2qK",
'oauth_access_token_secret' => "EFPzNlNRFJUCMPoG35toUFRBLawjfrEgj2cNQBYSnfAFT",
'consumer_key' => "ZynPDSyUGJtozHAJThqnRf8yE",
'consumer_secret' => "40waBjhjPEkotATCfi9OTAQsepmNuu7p9wTmEvpinZ6uggSuja"
);

// moyenne_tweets($sujet){

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = 'q='.$param.'&include_entities=true&with_twitter_user_id=true&result_type=mixed&tweet_mode=extended';  //tweet_mode: 'extended'
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$json_result = $twitter->setGetfield($getfield)
                      ->buildOauth($url, $requestMethod)
                      ->performRequest();
                       
//echo $json_result;

// $json_result = file_get_contents('tweets.json');
$json_result = json_decode($json_result);


$data = array ('documents' => array());
$data2 = array ('documents' => array());

$i = 0;
while ($i<15){
    $message = $json_result->statuses[$i]->full_text;
   // echo "<br>";
    $rt = explode(" ",$message,2);
    if($rt[0] == "RT"){
        //gestion des RT /!\ si on ne considère pas sa, on aura des problèmes de tweets tronqués
        $message = $json_result->statuses[$i]->retweeted_status->full_text;
    }
    $location = $json_result->statuses[$i]->user->location;
    $username = $json_result->statuses[$i]->user->name;
    $photo = $json_result->statuses[$i]->user->profile_image_url;
    array_push($data['documents'],array ( 'id' => $i, 'language' => 'fr', 'text' =>  $message));
    array_push($data2['documents'],array ( 'id' => $i, 'language' => 'fr', 'text' =>  $message, 'username' => $username, 'photo' => $photo, 'location' => $location, 'happy_note' => ''));
    $i = $i + 1;
}

$sentiment = GetSentiment($host, $path, $accessKey, $data);
$sentimentjson = json_encode($sentiment);

// $sentiment = json_decode($sentiment,true);
$array = json_decode(json_encode($sentiment), true);

// print_r($array);

$i = 0;
for($i = 0; $i<sizeof($data2['documents']); $i++){
    $data2['documents'][$i]['happy_note'] = $array['documents'][$i]['score'];
}


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

echo json_encode($data2);

//}

?>