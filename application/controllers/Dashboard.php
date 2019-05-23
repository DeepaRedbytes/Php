<?php defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('upload');
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
        if(!$this->session->userdata['user']){
	        redirect('login');
	    }
    }

	public function index(){
		
		$categoryCount = $this->connection->community->category->find();
		$data['categoryCount'] = count(iterator_to_array($categoryCount));

		$advertisementCount = $this->connection->community->advertisement->find();
		$data['advertisementCount'] = count(iterator_to_array($advertisementCount));

		$eventCount = $this->connection->community->event->find();
		$data['eventCount'] = count(iterator_to_array($eventCount));

		$userCount = $this->connection->community->user->find();
		$data['userCount'] = count(iterator_to_array($userCount));

		$serviceCount = $this->connection->community->service->find();
		$data['serviceCount'] = count(iterator_to_array($serviceCount));

		$this->load->view('dashboard',$data);
	}
}
