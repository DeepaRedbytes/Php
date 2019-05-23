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

	public function index_get(){
		$key = $this->input->get('key');
		$coll_array = ["event", "service", "advertisement"];
		$collection = $this->connection->community;
		$res = [];
		foreach ($coll_array as $array) {
		 	if($array == "service"){
		 		$result = $collection->$array->find(array("name"=> new MongoDB\BSON\Regex($key,
		 			'i')));
		 	}else{
		 		$result = $collection->$array->find(array("title"=> new MongoDB\BSON\Regex($key, 'i')));	 		
		 	}
		 	foreach ($result as $value) {
		 		$value['collection'] = $array;
				array_push($res,$value);
	 		}
		}
		$this->response($res);
	}
}