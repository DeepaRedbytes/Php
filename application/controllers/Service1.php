<?php defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Service extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
		 $this->load->library('upload');
    if(!$this->session->userdata['user'])
    {
        redirect('login');
    }
	}

  public function index() {
    //$user_data = $this->session->all_userdata(); 
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

    $resultAdmin = $this->connection->community->service->find($QueryAdmin,$options);
    $servicesAdmin=array();
    foreach ($resultAdmin as $valueAdmin) {
      $id_array = (array)$valueAdmin['_id'];
      $valueAdmin['id'] = $id_array['oid'];
      array_push($servicesAdmin, $valueAdmin);
    }
    $data['servicesAdmin'] = $servicesAdmin;
      
		$result = $this->connection->community->service->find($Query,$options);
    $services=array();
    foreach ($result as $value) {
      $id_array = (array)$value['_id'];
      $value['id'] = $id_array['oid'];
      $detailuser = $this->connection->community->user->findOne(["_id"=> new MongoDB\BSON\ObjectId($value['created_by'])]); 
      $value['user_name'] = $detailuser['user_name']; 

      array_push($services, $value);
	  }
		$data['services'] = $services;
  	$this->load->view('service',$data);
	}


  public function create(){
  	$data = $this->input->post();

    $category = $this->connection->community->category->find();
    $category_array = array();
    foreach ($category as $value) {
       $id_array = (array)$value['_id'];
       $value['id'] = $id_array['oid'];
       array_push($category_array, $value);
    }
    $cat['category_array'] = $category_array;
    $serviceCollection = $this->connection->community->service;
		if(empty($data)){
      $getData = $this->input->get();
      if(empty($getData)) { 
        $cat['serviceDetail'] = ''; 
      } else { 
        $serviceID = $getData['id'];
        $cat['serviceDetail'] = $serviceCollection->findOne(["_id"=> new MongoDB\BSON\ObjectId($serviceID)]);  
      }
      $this->load->view('service_create', $cat);
		}else{
      if(isset($data['status'])){ $data['status'] = 1; }
      else { $data['status'] = 0; }

		  if(!isset($data['highlights'])){
        $data['highlights'] = [];
      }
      if($data['price'] == ""){
        $data['price'] = 0;
      }

      $sid = $data['service_id'];
      $data['thumbnail'] = '';
      $data['banner_image'] = '';
      $data['created_by'] = $_SESSION['user']['_id'];
      $data['is_admin'] = 1;

      if(!empty($sid)){ 
          $detailservice = $this->connection->community->service->findOne(["_id"=> new MongoDB\BSON\ObjectId($sid)]); 
          $data['thumbnail'] = $detailservice['thumbnail']; 
          $data['banner_image'] = $detailservice['banner_image']; 
          $data['created_by'] = $detailservice['created_by'];
          $data['is_admin'] = $detailservice['is_admin'];
      }

      if(file_exists($_FILES["thumbnail"]["tmp_name"])){
        $config['upload_path'] = "uploads/service/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
        if($this->upload->do_upload('thumbnail')){               
            $data['thumbnail'] = 'uploads/service/'.$this->upload->data()['file_name'];
        } 
      }

      if(file_exists($_FILES["banner_image"]["tmp_name"])){ 
        $config['upload_path'] = "uploads/service/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
        if($this->upload->do_upload('banner_image')){   // echo 555;             
          $data['banner_image'] = 'uploads/service/'.$this->upload->data()['file_name'];
        } 
      }
      unset($data['service_id']);
      $dt = new DateTime();

      if(empty($sid)){        
        $data["created_at"]= $dt->format('Y-m-d H:i:s');
        $insert = $serviceCollection->insertOne($data);
        $this->session->set_flashdata('service','Service added successfully.'); 
        redirect('service');
      }else{
        $data["updated_at"]= $dt->format('Y-m-d H:i:s');
        $update =$serviceCollection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($sid)), array('$set'=>$data));
        $this->session->set_flashdata('service','Service updated successfully.'); 
        redirect('service');
      }
    }		
  }

  public function statusUpdate() {
    $data = $this->input->post();
    if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
    $service = $this->connection->community->service; 
    $result=$service->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));  
  }

  public function deleteEntry() {
    $data = $this->input->post();
    $service = $this->connection->community->service; 
    $result=$service->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
    echo 1; die;
  }
}