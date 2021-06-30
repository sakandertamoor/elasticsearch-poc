<?php 

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

$params = array();
/*$params['body']  = array(
  'name' => 'Tamoor Sakander',
  'age' => 31,
  'badges' => 0,
  'pokeCar' => 'Ferrai' 
);
*/
$params['index'] = 'codedevelopers';
$params['type'] = 'developers';
//$params['id'] = 'Dev-0013';
//$params['body']['query']['match_all']= [];

$response = $client->search($params);
//$response = $client->get($params);
//$response = $client->index($params);
print_r($response);
?>