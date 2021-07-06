<?php 

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

/*Indexing Documents*/


///*************************************************/
$params = array();
$params['body']  = array(
  'name' => 'Sakander Tamoor',
  'age' => 27,
  'badges' => 8 
);

$params['index'] = 'developers';
$params['type']  = 'developer_trainer';

$result = $client->index($params);

print_r($result);

/***************************************************/

//When indexing documents, we’re not limited to a single-dimensional array. We can also index multi-dimensional ones:


$params = array();
$params['body']  = array(
  'name' => 'Misty',
  'age' => 13,
  'badges' => 0,
  'pokemon' => array(
    'psyduck' => array(
      'type' => 'water',
      'moves' => array(
        'Water Gun' => array(
          'pp' => 25,
          'power' => 40
        )
      ) 
    )
  ) 
);

$params['index'] = 'developers';
$params['type']  = 'developer_trainer';
$params['id'] = '1A-002';

$result = $client->index($params);

print_r($result);

/***********************************///


//Get

$params = array();
$params['index'] = 'developers';
$params['type'] = 'developer_trainer';
$params['id'] = '1A-001';

$result = $client->get($params);
print_r($result);

/***********************************///

//Search with Specific Fields

$params['index'] = 'developers';
$params['type'] = 'developer_trainer';
$params['body']['query']['match']['age'] = 27;

$result = $client->search($params);
print_r($result);

/**************************************//



//Searching with Arrays
$params['index'] = 'developers';
$params['type'] = 'developer_trainer';

$params['body']['query']['bool']['must']['terms']['age'] = array(10, 15);
$result = $client->search($params);
print_r($result);
//This method only accepts one-dimensional arrays.

//****************************************************************************//

//Filtered Search/
$params['index'] = 'developers';
$params['type'] = 'developer_trainer';
$params['body']['query']['filtered']['filter']['range']['age']['gte'] = 11;
$params['body']['query']['filtered']['filter']['range']['age']['lte'] = 20;
$result = $client->search($params);
print_r($result);


//****************************************************************************//


//Updating a Document

$params = array();
$params['index'] = 'developers';
$params['type'] = 'developer_trainer';
$params['id'] = '1A-001';
$result = $client->get($params);


$result['_source']['age'] = 21; //update existing field with new value

//add new field
$result['_source']['developers'] = array(
  'Onix' => array(
    'type' => 'rock',
    'moves' => array(
      'Rock Slide' => array(
        'power' => 100,
        'pp' => 40
      ),
      'Earthquake' => array(
        'power' => 200,
        'pp' => 100
      )
    )
  )
);

$params['body']['doc'] = $result['_source'];

$result = $client->update($params);

//**************************************************************//


//Deleting a Document
$params = array();
$params['index'] = 'developers';
$params['type'] = 'developer_trainer';
$params['id'] = '1A-001';

$result = $client->delete($params);
//**************************************************************//

?>