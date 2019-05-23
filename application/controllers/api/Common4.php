<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');

class Common extends REST_Controller {

  function __construct() {
      parent::__construct();
      $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
      $this->load->model('CommonModel','general');
  }


  var $client_service = "community-client";
  var $auth_key       = "restapi";

  public function check_auth_client(){
      $client_service = $this->input->get_request_header('Client-Service', TRUE);
      $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);         
      if($client_service == $this->client_service && $auth_key == $this->auth_key){
        return true;
      } else {  
        $this->response(array('result' => false, 'status' => 404,'message' => 'Unauthorized.'),401);
      }
  }

	function index_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){   
        $options = ['sort' => ['created_at' => -1], 'limit' => 5];   
        $result = $this->connection->community->service->find(array('status'=>1), $options);
        $services=array();
        foreach ($result as $value) {
            $data['id'] = (string)$value['_id']; 
            $data['service'] = $value['name']; 
            $data['desc'] = $value['desc']; 
            $data['thumbnail'] = $value['thumbnail']; 
            array_push($services, $data);
        }

        $options = ['sort' => ['start_date' => -1], 'limit' => 5];
        $result1 = $this->connection->community->event->find(array('status'=>1), $options);
        $eventList=array();
        foreach ($result1 as $value1) {
            $data1['id'] = (string)$value1['_id']; 
            $data1['title'] = $value1['title']; 
            $data1['description'] = $value1['description']; 
            $data1['thumbnail'] = $value1['thumbnail'];
            $data1['venue'] = $value1['venue'];
            array_push($eventList, $data1);
        }

        $output = ['result' => true, 'status' => '400', 'message' => 'Success' , "service"=>$services, "event"=>$eventList];      
        $this->response($output); die;
    }
  }

  function service_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 

      // $set_data = $this->input->get();
      // $userID = $set_data['userID'];
      $Query = [];
      // if(isset($userID)) { 
      //   $Query = array('created_by' =>new MongoDB\BSON\ObjectId($userID)); 
      // } 

      $options = ['sort' => ['created_at' => -1]]; 
      $result = $this->connection->community->service->find($Query, $options);
      $services=array();
      foreach ($result as $value) {
        $value['id'] = (string)$value['_id']; 
        unset($value['_id']);
        unset($value['created_by']);
        array_push($services, $value);
      }
      $output = ['result' => true, 'message' => 'Success' , "service"=>$services];
      $this->response($output, 200); die;
    }
  }

  function serviceDetail_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){    
      $set_data = $this->input->get();
      $this->form_validation->set_data($set_data);
      $this->form_validation->set_rules('serviceID', 'serviceID', 'required');

      if($this->form_validation->run() == TRUE){
        $serviceID = $set_data['serviceID'];
        $collectionService =$this->connection->community->service;
        $detailService = $collectionService->findOne(array('_id'=>new MongoDB\BSON\ObjectId($serviceID)));
        $detailService['id'] = (string)$detailService['_id']; 
        unset($detailService['_id']);
        unset($detailService['created_by']);
        $output = ['result' => true, 'message' => 'Success' , "service"=>$detailService];
        $this->response($output, 200); die;
      }
      $error = $this->validation_errors();
      $output = ['result' => false, 'message' => $error];      
      $this->response($output, 422);
    }
  } 

  public function serviceCreate_post() {
    //echo 111; die;
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 
      $data = $this->input->post();
      $sid = $data['service_id'];
      // if(isset($data['status'])){
      //   $data['status'] = 1;
      // }
      // else {
        $data['status'] = 0;
      //}

      if(!isset($data['highlights'])){
        $data['highlights'] = [];
      }
      if($data['price'] == ""){
        $data['price'] = 0;
      }

      $data['thumbnail'] = '';
      $data['banner_image'] = '';

      if(!empty($sid)){ 
          $detailservice = $this->connection->community->service->findOne(["_id"=> new MongoDB\BSON\ObjectId($sid)]); 
          $data['thumbnail'] = $detailservice['thumbnail']; 
          $data['banner_image'] = $detailservice['banner_image']; 
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
      $data['created_by'] = $_SESSION['user']['_id'];
      unset($data['service_id']);
      if(empty($sid)){
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $serviceCollection->insertOne($data);
          $insertedId = $responce->getInsertedId();          
          $detailService = $serviceCollection->findOne(array('_id'=>new MongoDB\BSON\ObjectId($insertedId)));
          $output = ['result' => true, 'message' => 'Service added successfully' , "service"=>$detailService];
          $this->response($output, 200); die;
      }else{
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$event->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($eventID)), array('$set'=>$data));
          $detailService = $serviceCollection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($sid)), array('$set'=>$data));
          $output = ['result' => true, 'message' => 'Service updated successfully' , "service"=>$detailService];
          $this->response($output, 200); die;
      }
    } 
    $error = $this->validation_errors();
    $output = ['result' => false, 'message' => $error];      
    $this->response($output, 422);
  }

  function event_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 

      // $set_data = $this->input->get();
      // $userID = $set_data['userID'];
      $Query = [];
      // if(isset($userID)) { 
      //   $Query = array('created_by' => ($userID)); 
      // } 

      $options = ['sort' => ['start_date' => -1]];
      $result1 = $this->connection->community->event->find($Query, $options);
      $eventList=array();
      foreach ($result1 as $value1) {          
          $value1['id'] = (string)$value1['_id']; 
          unset($value1['_id']);
          // $data1['title'] = $value1['title']; 
          // $data1['venue'] = $value1['vanue'];
          // $data1['location'] = $value1['location'];
          // $data1['type'] = $value1['type']; 
          // $data1['language'] = $value1['language'];
          // $data1['duration'] = $value1['duration'];
          // $data1['age'] = $value1['age']; 
          // $data1['price'] = $value1['price'];
          // $data1['eventUrl'] = $value1['banner_image'];
          // $data1['paymentmode'] = $value1['title']; 
          // $data1['start_date'] = $value1['description'];
          // $data1['start_time'] = $value1['banner_image'];
          // $data1['end_date'] = $value1['title']; 
          // $data1['end_time'] = $value1['description'];
          // $data1['description'] = $value1['banner_image'];
          // $data1['terms'] = $value1['title']; 
          // $data1['publist_start_date'] = $value1['description'];
          // $data1['publist_end_date'] = $value1['banner_image'];
          // $data1['latitude'] = $value1['title']; 
          // $data1['longitude'] = $value1['longitude'];
          // $data1['thumbnail'] = $value1['thumbnail']; 
          // $data1['banner_image'] = $value1['banner_image'];
          // $data1['status'] = $value1['status'];
          array_push($eventList, $value1);
      }
      $output = ['result' => true, 'message' => 'Success' , "event"=>$eventList];
      $this->response($output, 200); die;
    }
  }

  function eventDetail_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){    
      $set_data = $this->input->get();
      $this->form_validation->set_data($set_data);
      $this->form_validation->set_rules('eventID', 'eventID', 'required');

      if($this->form_validation->run() == TRUE){
        $eventID = $set_data['eventID'];
        $collectionEvent =$this->connection->community->event;
        $detailEvent = $collectionEvent->findOne(array('_id'=>new MongoDB\BSON\ObjectId($eventID)));
        //$detailEvent['id'] = (string)$detailEvent['_id']; 
        $detailEvent['id'] = (string)$detailEvent['_id']; 
        unset($detailEvent['_id']);
        $output = ['result' => true, 'message' => 'Success' , "event"=>$detailEvent];
        $this->response($output, 200); die;
      }
      $error = $this->validation_errors();
      $output = ['result' => false, 'message' => $error];      
      $this->response($output, 422);
    }
  }

  public function eventCreate_post() {
    //echo 111; die;
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){


      $data = $this->input->post();
      $eventID = $data['eventID'];
      $data['thumbnail'] = '';
      $data['banner_image'] = '';

      if(!empty($eventID)){ 
        $detailevent = $this->connection->community->event->findOne(["_id"=> new MongoDB\BSON\ObjectId($eventID)]); 
        $data['thumbnail'] = $detailevent['thumbnail']; 
        $data['banner_image'] = $detailevent['banner_image']; 
      }

      if(file_exists($_FILES["thumbnail"]["tmp_name"])){
        $config['upload_path'] = "uploads/event/";
        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
          if($this->upload->do_upload('thumbnail')){               
              $data['thumbnail'] = 'uploads/event/'.$this->upload->data()['file_name'];
          } 
      }

      if(file_exists($_FILES["banner_image"]["tmp_name"])){ 
        $config['upload_path'] = "uploads/event/";
        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
          if($this->upload->do_upload('banner_image')){   // echo 555;             
              $data['banner_image'] = 'uploads/event/'.$this->upload->data()['file_name'];
          } 
      }

      if($data['price'] == ''){ $data['price'] = 0; }
      if(!empty($data['status'])){ $data['status'] = 1; }
      else{ $data['status'] = 0; }

      $data['created_by'] = (string)$_SESSION['user']['_id'];
      unset($data['eventID']);
      $dt = new DateTime();

      $event = $this->connection->community->event;
      if(empty($eventID)){
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $event->insertOne($data);
          $insertedId = $responce->getInsertedId();          
          $detailEvent = $collectionEvent->findOne(array('_id'=>new MongoDB\BSON\ObjectId($insertedId)));
          $output = ['result' => true, 'message' => 'Event added successfully' , "event"=>$detailEvent];
          $this->response($output, 200); die;
      }else{
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$event->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($eventID)), array('$set'=>$data));
          $detailEvent = $collectionEvent->findOne(array('_id'=>new MongoDB\BSON\ObjectId($eventID)));
          $output = ['result' => true, 'message' => 'Event updated successfully' , "event"=>$detailEvent];
          $this->response($output, 200); die;
      }
    } 
    $error = $this->validation_errors();
    $output = ['result' => false, 'message' => $error];      
    $this->response($output, 422);
  }      
}