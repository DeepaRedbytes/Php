<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');

class Test extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct() {
	    parent::__construct();
	   $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
	  
    }

	public function index_get()
	{
	$value = $this->input->get('key');
	 $coll_array = ["event", "service", "advertisement"];
	 $arrlength = count($coll_array);
	 $collection = $this->connection->community;
	 $alValue = [];
	 $res1 = [];
	 $res2 = [];
	 for ($i=0; $i < $arrlength ; $i++) { 
	 	$coll = $coll_array[$i];
	 	if($coll == "service"){
	 		$result1 = $collection->$coll->find(array("name"=> new MongoDB\BSON\Regex($value)));
	 		foreach ($result1 as $value1) {
	 			array_push($res1,$value1);
	 		}

	 	}else{
	 		$result2 = $collection->$coll->find(array("title"=> new MongoDB\BSON\Regex($value)));
	 		// $res2 = iterator_to_array($result);
	 		foreach ($result2 as $value2) {
	 			array_push($res2,$value2);
	 		}
	 	}

	 	 $data = array_merge($res1, $res2);
	 	


	 	// $newVal = iterator_to_array($result);
	 	// if(!empty($newVal)) { 
	 	// 	$newVal['collection'] = $coll;
			// array_push($alValue, $newVal); 

	 	// }
	 	// $this->response($result);

	 }

	 // echo '<pre>';
	  $this->response($data);
	
    
    
	}
}