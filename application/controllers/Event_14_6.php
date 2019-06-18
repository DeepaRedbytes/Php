<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Event extends CI_Controller {

	 public function __construct() {
	  	parent::__construct();
	   	$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
	   	$this->load->model('Common');	
	   	if(!$this->session->userdata['user']){
	        redirect('login');
	    }  
    }

	public function index() {

		$update = $this->Common->updateReadFlag('event', 0);
		$user_data = $this->session->all_userdata(); 
		//$adminID = '5ca48fd13c2a7975433a7fd2'; 
		//print_r($user_data);
		//$adminID = $user_data['user']['_id']; 
		$Query = [];
		$QueryAdmin = [];
      	//if(isset($adminID)) { 
			//$QueryAdmin = array('created_by' => ($adminID)); 
        	$QueryAdmin = array('is_admin' => 1); 
        	$Query = array('is_admin' => 0); 
      	//} 
		
		$options = ['sort' => ['created_at' => -1]];
		$result = $this->connection->community->event->find($Query, $options);
        $eventList=array();
        foreach ($result as $value) {
            $doc['id'] = (string)$value['_id']; 
            $doc['title'] = $value['title'];
            $doc['description'] = $value['description']; 
			//$doc['type'] = $value['type'];
            $doc['thumbnail'] = $value['thumbnail'];
            $doc['start_date'] = $value['start_date'];
            $doc['price'] = $value['price'];
            $detailuser = $this->connection->community->user->findOne(["_id"=> new MongoDB\BSON\ObjectId($value['created_by'])]); 

            $detailcat = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($value['category'])]); 
      		$doc['category_name'] = $detailcat['category'];

        	$doc['user_name'] = $detailuser['user_name']; 
            $doc['status'] = $value['status'];
            array_push($eventList, $doc);
		}
		$data['eventList'] = $eventList;
		
		$resultAdmin = $this->connection->community->event->find($QueryAdmin, $options);
        $eventListAdmin = array();
        foreach ($resultAdmin as $valueAdmin) {
            $docAdmin['id'] = (string)$valueAdmin['_id']; 
            $docAdmin['title'] = $valueAdmin['title'];
            $docAdmin['description'] = $valueAdmin['description']; 
			//$docAdmin['type'] = $valueAdmin['type'];
            $docAdmin['thumbnail'] = $valueAdmin['thumbnail'];
            $docAdmin['start_date'] = $valueAdmin['start_date'];
            $detailcat = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($valueAdmin['category'])]); 
      		$docAdmin['category_name'] = $detailcat['category'];
            $docAdmin['status'] = $valueAdmin['status'];
            array_push($eventListAdmin, $docAdmin);
		}
		$data['eventListAdmin'] = $eventListAdmin;

		$this->load->view('event',$data);
	}

	public function create() {
		$event = $this->connection->community->event;

		$category = $this->connection->community->category->find();
	    $category_array = array();
	    foreach ($category as $value) {
	       $cat['id'] = (string)$value['_id']; 
	       $cat['category'] = $value['category'];
	       array_push($category_array, $cat);
	    }
	    $result['category_array'] = $category_array;

		$data = $this->input->post();
		if(empty($data)){
			$dataGet = $this->input->get();
			if(empty($dataGet)) { 
				$result['eventDetail'] = ''; 
			} 
			else { 
				$evntID = $dataGet['id'];
				$result['eventDetail'] = $event->findOne(["_id"=> new MongoDB\BSON\ObjectId($evntID)]);  
			}			
	      	$this->load->view('event_create',$result);
	    }else{ 

	    	$eventID = $data['eventID'];
	    	$data['thumbnail'] = '';
	    	$data['banner_image'] = '';	    	
	    	$data['created_by'] = $_SESSION['user']['_id'];
	    	$data['is_admin'] = 1;
	    	$data['category'] = new MongoDB\BSON\ObjectId($data['category']);

	    	if(!empty($eventID)){	
	        	$detailevent = $this->connection->community->event->findOne(["_id"=> new MongoDB\BSON\ObjectId($eventID)]); 
	        	$data['thumbnail'] = $detailevent['thumbnail']; 
	        	$data['banner_image'] = $detailevent['banner_image']; 
	        	$data['created_by'] = $detailevent['created_by'];
	        	$data['is_admin'] = $detailevent['is_admin'];
	    	}

	    	define('UPLOAD_DIR', 'uploads/ads/');
	        if(!empty($data['hidden_image'])) {          
	          $image_parts = explode(";base64,", $data['hidden_image']);
	          $image_type_aux = explode("image/", $image_parts[0]);
	          $image_type = $image_type_aux[1];
	          $image_base64 = base64_decode($image_parts[1]);
	          $file = UPLOAD_DIR . uniqid() . '.'.$image_type;
	          file_put_contents($file, $image_base64);
	          $data['thumbnail'] = $file;  //die; 
	        }

	        if(!empty($data['hidden_image_banner'])) {
	          $image_parts_banner = explode(";base64,", $data['hidden_image_banner']);
	          $image_type_aux_banner = explode("image/", $image_parts_banner[0]);
	          $image_type_banner = $image_type_aux_banner[1];
	          $image_base64_banner = base64_decode($image_parts_banner[1]);
	          $file_banner = UPLOAD_DIR . uniqid() . '.'.$image_type_banner;
	          file_put_contents($file_banner, $image_base64_banner);
	          $data['banner_image'] = $file_banner;  //die; 
	        }



			// if(file_exists($_FILES["thumbnail"]["tmp_name"])){
		 //    	$config['upload_path'] = "uploads/event/";
		 //        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';	      
		 //        $config['file_name'] = time();
		 //        $this->load->library('upload', $config);	        
		 //        $this->upload->initialize($config);     
	  //           if($this->upload->do_upload('thumbnail')){               
	  //               $data['thumbnail'] = 'uploads/event/'.$this->upload->data()['file_name'];
	  //           } 
	  //       }

			// if(file_exists($_FILES["banner_image"]["tmp_name"])){ 
		 //    	$config['upload_path'] = "uploads/event/";
		 //        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';	      
		 //        $config['file_name'] = time();
		 //        $this->load->library('upload', $config);	        
		 //        $this->upload->initialize($config);     
	  //           if($this->upload->do_upload('banner_image')){   // echo 555;             
	  //               $data['banner_image'] = 'uploads/event/'.$this->upload->data()['file_name'];
	  //           } 
	  //       }

	        if($data['price'] == ''){ $data['price'] = 0; }
	        if(!empty($data['status'])){ $data['status'] = 1; }
	   		else{ $data['status'] = 0; }   		

	   		unset($data['eventID']);
	   		unset($data['hidden_image']);
      		unset($data['hidden_image_banner']);
	   		$dt = new DateTime();
	   		
	      	if(empty($eventID)){
            	$data["created_at"]= $dt->format('Y-m-d H:i:s');  
				$responce = $event->insertOne($data);
				$this->session->set_flashdata('event','Event added successfully.'); 
		        redirect('event');
	       	}else{
	       		$data["updated_at"]= $dt->format('Y-m-d H:i:s');
		      	$result=$event->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($eventID)), array('$set'=>$data));
		      	$this->session->set_flashdata('event','Event updated successfully.'); 
		        redirect('event');
			}
		}
	}

	public function statusUpdate() {
		$data = $this->input->post();
		if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
		$event = $this->connection->community->event; 
		$result=$event->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));	
	}

	public function deleteEntry() {
		$data = $this->input->post();
		$event = $this->connection->community->event; 
		$result=$event->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
		echo 1; die;
	}
}