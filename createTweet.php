<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

include 'includes/Requests.php';

$conKey = "y9mYc4xyFQbnf9gE1W5xcWmKG";
$consumerSecret = "YesgfUZnDgqHD96ZlbtBaNVYYFi8qkc88JHuRiy4gKSPky4Req";
$access_token = "4910647469-x4UUeag8MWNNDZfyBVWvNO4lOWbQksSVricoSId";
$access_token_secret = "EhsBiv7RbjUklacoalqdT4A4CmLn4I7mPUasxMIVV9Moo";

$connection = new TwitterOAuth($conKey, $consumerSecret, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");
$connection->setTimeouts(10, 50);


// Get parameters from URL
$sentences = [];
$word = $_GET["word"];
$meaning = $_GET["meaning"];
$example = $_GET["example"];	
if (isset($word) && isset($meaning)){
	parseDefinition($meaning);
	for ($i = 0; $i < count($sentences); $i++){
		
		$parameters = [
		'status' => $sentences[$i],
		];
		$result = $connection->post('statuses/update', $parameters);
	}
	
}

function parseDefinition($def){
	global $sentences;
	global $word;
    $index = 0;
    $wordsArr = explode(" ", $def);
    $sentence = "";
    $length = 135;
    for ($i = 0; $i < count($wordsArr); $i++){
        if (!isset($sentences[$index])){
            $sentences[$index] = ''.$word.' - '.$wordsArr[$i].'';
        }else{
            // Add the new words size to the calc before adding to sentence
            // plus 1 for the space you are also going to add
             if (strlen($sentences[$index]) + strlen($wordsArr[$i]) + 1 <= $length){
                $sentence = $sentences[$index] . " " . $wordsArr[$i];
                $sentences[$index] = $sentence;
            }else{
                $index ++;
                $sentence = $wordsArr[$i];
                $sentences[$index] = $sentence;
            }
        }
    }
	numberTweets();
	var_dump($sentences);
}

function numberTweets(){
	global $sentences;
	$index = 1;
	if (count($sentences) > 1) {
		for ($i = 0; $i < count($sentences) ; $i++){
			$sentences[$i] = ''.$sentences[$i].' '.$index.'/'.count($sentences).'';
			$index ++;
		}
	}
}


?>