<?php
require 'vendor/autoload.php';

class Category extends CI_Controller {

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
		$result = $this->connection->community->category->find([],$options);
        $category=array();
        foreach ($result as $value) {
            $id_array = (array)$value['_id'];
            $doc['id'] = $id_array['oid'];
            $doc['category'] = $value['category'];
            $doc['description'] = $value['description'];
            $doc['status'] = $value['status'];
            $doc['image'] = $value['image'];
            array_push($category, $doc);
		}
		$data['categoryList'] = $category;
		$this->load->view('category',$data);
	}

	public function create()	{
		$category = $this->connection->community->category;
		$data = $this->input->post();
		if(empty($data)){
	      //$data['title'] = 'Create Category';
			$dataGet = $this->input->get();
			if(empty($dataGet)) { 
				$result['categoryDetail'] = ''; 
			} 
			else { 
				$catID = $dataGet['id'];
				$result['categoryDetail'] = $category->findOne(["_id"=> new MongoDB\BSON\ObjectId($catID)]);  
			}			
	      	$this->load->view('category_create',$result);
	    }else{ 
	    	//print_r($data); die; 
			$categoryID = $data['cat_id'];
			//$array["category"] = $data['category'];
			//$array["description"] =$data['description'];
			//$array["status"] = $data['status'];

			if($data['status'] == 'false') { $data['status'] = 0; } else  { $data['status'] = 1; }

			$target_file = '';
	    	if(!empty($categoryID)){	
	        	$detailcategory = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($categoryID)]); 
	        	$target_file = $detailcategory['image']; 
	    	}
			if(file_exists($_FILES["file_photo"]["tmp_name"])){
                $target_dir = "uploads/category/";
                $target_file = $target_dir . basename($_FILES["file_photo"]["name"]);
                move_uploaded_file($_FILES["file_photo"]["tmp_name"], $target_file);
            }
            $data["image"] = $target_file;
            unset($data["cat_id"]);
            //print_r($data); print_r($_FILES); echo $target_file; die;			
	      	if(empty($categoryID)){	 
	      	    $dt = new DateTime();
	      	    $data["created_at"]= $dt->format('Y-m-d H:i:s');
				$responce = $category->insertOne($data);
				$this->session->set_flashdata('category','Category added successfully.'); 
		        //$this->load->view('category');
		        redirect('category');
	      	}else{
		      	$result=$category->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($categoryID)), array('$set'=>$data));
		      	//print_r($result); die;
		      	$this->session->set_flashdata('category','Category updated successfully.'); 
		        //$this->load->view('category');
		        redirect('category');
			}
		}
	}

	public function statusUpdate() {
		$data = $this->input->post();
		if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
		$category = $this->connection->community->category; 
		$result=$category->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));	
	}

	public function deleteEntry() {
		$data = $this->input->post();
		$category = $this->connection->community->category; 
		$result=$category->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
		echo 1; die;
	}
}
