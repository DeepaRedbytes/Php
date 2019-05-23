<?php
require 'vendor/autoload.php';
class Resource extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('upload');
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
        if(!$this->session->userdata['user']){
	        redirect('login');
	    }
    }

	public function index()	{
		$options = ['sort' => ['created_at' => -1]];
		$result = $this->connection->community->resource->find([], $options);
        $resource=array();
        foreach ($result as $value) {
            $id_array = (array)$value['_id'];
            $doc['id'] = $id_array['oid'];
            $doc['title'] = $value['title'];
            $doc['link'] = $value['link'];
            array_push($resource, $doc);
		}
		$data['resourceList'] = $resource;
		$this->load->view('resource',$data);
	}

	public function create()	{
		$resource = $this->connection->community->resource;
		$data = $this->input->post();
		if(empty($data)){
			$dataGet = $this->input->get();
			if(empty($dataGet)) { 
				$result['resourceDetail'] = ''; 
			} 
			else { 
				$resourceID = $dataGet['id'];
				$result['resourceDetail'] = $resource->findOne(["_id"=> new MongoDB\BSON\ObjectId($resourceID)]);  
			}			
	      	$this->load->view('resource_create',$result);
	    }else{ 
			$resourceID = $data['resourceID'];
			$array["title"] = $data['title'];
			//$array["link"] =$data['link'];


			$array["link"] = '';
	    	if(!empty($resourceID)){	
	        	$detailresource = $this->connection->community->resource->findOne(["_id"=> new MongoDB\BSON\ObjectId($resourceID)]); 
	        	$target_file = $detailresource['link']; 
	    	}
			if(file_exists($_FILES["link"]["tmp_name"])){
                $target_dir = "uploads/resource/";
                $target_file = $target_dir . basename($_FILES["link"]["name"]);
                move_uploaded_file($_FILES["link"]["tmp_name"], $target_file);
            }
            $array["link"] = $target_file; 

			//$array["status"] = $data['status'];
			$dt = new DateTime();
			$array["created_at"]= $dt->format('Y-m-d H:i:s');      
	      	if(empty($resourceID)){	 
				$responce = $resource->insertOne($array);
				$this->session->set_flashdata('resource','Resource added successfully.'); 
		        redirect('resource');
	      	}else{
		      	$result=$resource->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($resourceID)), array('$set'=>$array));
		      	$this->session->set_flashdata('resource','Resource updated successfully.'); 
		        redirect('resource');
			}
		}
	}

	// public function statusUpdate() {
	// 	$data = $this->input->post();
	// 	if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
	// 	$faq = $this->connection->community->faq; 
	// 	$result=$faq->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));	
	// }

	public function deleteEntry() {
		$data = $this->input->post();
		$resource = $this->connection->community->resource; 
		$result=$resource->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
		echo 1; die;
	}
}
