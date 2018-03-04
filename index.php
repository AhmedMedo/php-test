<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "494840231-jWRuvx3gEE8hSBD7k9oxN5Wx6Ly3MJ0vpybqoMHS",
    'oauth_access_token_secret' => "KtjxK3xHWV0BonE8u9WuXQFyayaTQUDrqRPtEHZsbmfcC",
    'consumer_key' => "zWaysEqtKy4jplUwmeYQAOtQE",
    'consumer_secret' => "G1xF4YBjzvYFSKPfTf2O3SBMlKGgg9IhlH6FrO93ecCsXwIgno"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
// $url = 'https://api.twitter.com/1.1/blocks/create.json';
// $requestMethod = 'POST';

// /** POST fields required by the URL above. See relevant docs as above **/
// $postfields = array(
//     'screen_name' => 'usernameToBlock', 
//     'skip_status' => '1'
// );

// /** Perform a POST request and echo the response **/
// $twitter = new TwitterAPIExchange($settings);
// echo $twitter->buildOauth($url, $requestMethod)
//              ->setPostfields($postfields)
//              ->performRequest();

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=%egy&result_type=popular&count=10';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$results= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
//echo $results;
$values=json_decode($results);
//print_r($values);
// echo count($values['statuses']).'<br>';
// //print_r($values);
$max_id= $values->statuses[0]->id;
echo $max_id.'<br>';
//print_r($values);
echo "------------------------------------New query-------------------------------";
echo '<br>';
echo "we will load more results in the new query by getting the max id form previous result";
echo '<br>';
//new qursy after the last one
$getfield .='&max_id='.$max_id;
echo "get fields is" .$getfield.'<br>';
$new_results=$twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
//print_r(json_decode($new_results,JSON_PRETTY_PRINT));
$new_values = json_decode($new_results);
$count = count($values->statuses) + count($new_values->statuses);
echo "<br>";
echo "Total tweets for two queries are : " . $count;