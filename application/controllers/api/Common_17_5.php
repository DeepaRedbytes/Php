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
    //$data = $this->post();

    $get_data = $this->input->get();

    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){   

        // $latitude = '37'; 
        // $longitude = '-122';
        $latitude = $get_data['latitude'];
        $longitude = $get_data['longitude'];

        $Query = [];
        $options = [];
        //$Query = array('status'=>1);
        //$options = ['sort' => ['created_at' => -1], 'limit' => 5]; 

        $result = $this->connection->community->service->find($Query, $options);
        $servicesList=array();
        $services=array();
        foreach ($result as $value) {
          $data['id'] = (string)$value['_id']; 
          $data['service'] = $value['name']; 
          $data['desc'] = $value['desc']; 
          $data['thumbnail'] = $value['thumbnail']; 
          $data["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value['latitude'],4),round($value['longitude'],6), "K"),2);
          array_push($servicesList, $data);
        }
        $service = array_slice(array_values($this->aasort($servicesList,"distance")), 0, 5);

        $result1 = $this->connection->community->event->find($Query, $options);
        $eventList=array();
        $event=array();
        foreach ($result1 as $value1) {
          $data1['id'] = (string)$value1['_id']; 
          $data1['title'] = $value1['title']; 
          $data1['description'] = $value1['description']; 
          $data1['thumbnail'] = $value1['thumbnail'];
          $data1['venue'] = $value1['venue'];
          $data1["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value1['latitude'],4),round($value1['longitude'],6), "K"),2);
          array_push($eventList, $data1);
        }
        $event = array_slice(array_values($this->aasort($eventList,"distance")), 0, 5);

        $result2 = $this->connection->community->advertisement->find($Query, $options);
        $adList=array();
        $add=array();
        foreach ($result2 as $value2) {
          $data2['id'] = (string)$value2['_id']; 
          $data2['title'] = $value2['title']; 
          $data2['description'] = $value2['description']; 
          $data2['thumbnail'] = $value2['thumbnail'];
          $data2['venue'] = $value2['venue'];
          $data2["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value2['latitude'],4),round($value2['longitude'],6), "K"),2);
          array_push($adList, $data2);
        }
        $add = array_slice(array_values($this->aasort($adList,"distance")), 0, 5);

        $output = ['result' => true, 'status' => '400', 'message' => 'Success' , "service"=>$service, "event"=>$event, "advertisement"=>$add];      
        $this->response($output); die;
    }
  }

  function service_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 

      $set_data = $this->input->get();
      $latitude = $set_data['latitude'];
      $longitude = $set_data['longitude'];
      $Query = [];
      //$Query = array('status'=>1);
      if(isset($set_data['userID'])) { 
        $userID = $set_data['userID'];
        //$Query = array('status'=>1);;
        if(isset($userID)) { 
          $Query = array('created_by' =>new MongoDB\BSON\ObjectId($userID)); 
        } 
      }
      $options = ['sort' => ['created_at' => -1]]; 
      $result = $this->connection->community->service->find($Query, $options);
      $services=array();
      $serviceList=array();
      foreach ($result as $value) {
        $value['id'] = (string)$value['_id']; 

        if($value['start_time'] != ""){
          $value['start_time'] = strtolower(str_replace(' ', '', $value['start_time']));
        }
        if($value['end_time'] != ""){
          $value['end_time'] = strtolower(str_replace(' ', '', $value['end_time']));
        }

        $value["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value['latitude'],4),round($value['longitude'],6), "K"),2);
        unset($value['_id']);
        unset($value['created_by']);
        array_push($serviceList, $value);
      }
      $services = array_values($this->aasort($serviceList,"distance"));
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

  function serviceCreate_post() {
    //echo 111; die;
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 
      $data = $this->input->post();
      $sid = $data['service_id'];
      $data['status'] = 0;

      // if(!isset($data['highlights'])){
      $data['highlights'] = [];
      // }
      // else {
      if(!empty($data['highlightString'])){
        $data['highlights'] = explode(',', $data['highlightString']);        
      }
      $data['days'] = [];
      if(!empty($data['dayString'])){
        $data['days'] = explode(',', $data['dayString']);      
      }

      //print_r($data); die;

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

      $data['is_admin'] = 0;
      $data['created_by'] = new MongoDB\BSON\ObjectId($data['created_by']);
      unset($data['service_id']);
      unset($data['dayString']);
      unset($data['highlightString']);
      $dt = new DateTime();
      $serviceCollection = $this->connection->community->service;
      if(empty($sid)){
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $serviceCollection->insertOne($data);
          $insertedId = $responce->getInsertedId();     
          $output = ['result' => true, 'message' => 'Service added successfully' , "service"=>$insertedId];
          $this->response($output, 200); die;
      }else{
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$serviceCollection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($sid)), array('$set'=>$data));
          $output = ['result' => true, 'message' => 'Service updated successfully' , "service"=>$sid];
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

      $set_data = $this->input->get();
      $latitude = $set_data['latitude'];
      $longitude = $set_data['longitude'];
      $Query = [];
      //$Query = array('status'=>1);
      if(isset($set_data['userID'])) { 
        $userID = $set_data['userID'];        
        if(isset($userID)) { 
          $Query = array('created_by' => new MongoDB\BSON\ObjectId($userID));
        } 
      }

      $options = ['sort' => ['start_date' => -1]];
      $result1 = $this->connection->community->event->find($Query, $options);
      $eventList=array();
      $event=array();
      foreach ($result1 as $value1) {          
          $value1['id'] = (string)$value1['_id']; 
          $value1["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value1['latitude'],4),round($value1['longitude'],6), "K"),2);
          unset($value1['_id']);
          unset($value1['created_by']);
          array_push($eventList, $value1);
      }
      $event = array_values($this->aasort($eventList,"distance"));
      $output = ['result' => true, 'message' => 'Success' , "event"=>$event];
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

  function eventCreate_post() {
    //echo 111; die;
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){


      $data = $this->input->post();
      $eventID = $data['eventID'];
      $data['thumbnail'] = '';
      $data['banner_image'] = '';

      if(!empty($eventID)){ 
        $detailevent = $this->connection->community->event->findOne(["_id"=> ($eventID)]); 
        $data['thumbnail'] = $detailevent['thumbnail']; 
        $data['banner_image'] = $detailevent['banner_image']; 
      }

      //$data['thumbnail'] = '';
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

      //$data['banner_image'] = '';
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


      $data['is_admin'] = 0;
      if($data['price'] == ''){ $data['price'] = 0; }
      if(!empty($data['status'])){ $data['status'] = 1; }
      else{ $data['status'] = 0; }

      //$data['created_by'] = (string)$_SESSION['user']['_id'];
      unset($data['eventID']);
      $dt = new DateTime();

      //echo $m4 = new MongoId($data["created_by"]);
      $data['created_by'] = new MongoDB\BSON\ObjectId($data['created_by']);
      //print_r($m4); die;


      //echo $eventID; 
      $event = $this->connection->community->event;
      if(empty($eventID)){ //echo 111; die;
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $event->insertOne($data);
          $insertedId = $responce->getInsertedId();      
          $output = ['result' => true, 'message' => 'Event added successfully' , "event"=>$insertedId]; 
          $this->response($output, 200); die;
      }else{ 
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$event->updateOne(array('_id'=>($eventID)), array('$set'=>$data));
          $output = ['result' => true, 'message' => 'Event updated successfully' , "event"=>$eventID];
          $this->response($output, 200); die;
      }
    } 
    $error = $this->validation_errors();
    $output = ['result' => false, 'message' => $error];      
    $this->response($output, 422);
  }    

  function advertisement_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 

      $set_data = $this->input->get();
      $latitude = $set_data['latitude'];
      $longitude = $set_data['longitude'];
      $Query = [];
      if(isset($set_data['userID'])) { 
        $userID = $set_data['userID'];
        //$Query = array('status'=>1);
        if(isset($userID)) { 
          $Query = array('created_by' => new MongoDB\BSON\ObjectId($userID));
        } 
      }

      $options = ['sort' => ['start_date' => -1]];
      $result1 = $this->connection->community->advertisement->find($Query, $options);
      $add=array();
      $adList=array();
      foreach ($result1 as $value1) {          
          $value1['id'] = (string)$value1['_id']; 
          $value1["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value1['latitude'],4),round($value1['longitude'],6), "K"),2);
          unset($value1['_id']);
          unset($value1['created_by']);
          array_push($adList, $value1);
      }
      $add = array_values($this->aasort($adList,"distance"));
      $output = ['result' => true, 'message' => 'Success' , "advertisement"=>$add];
      $this->response($output, 200); die;
    }
  }

  function advertisementDetail_get(){
    $data = $this->post();
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){    
      $set_data = $this->input->get();
      $this->form_validation->set_data($set_data);
      $this->form_validation->set_rules('adID', 'adID', 'required');

      if($this->form_validation->run() == TRUE){
        $adID = $set_data['adID'];
        $collectionAd =$this->connection->community->advertisement;
        $detailAd = $collectionAd->findOne(array('_id'=>new MongoDB\BSON\ObjectId($adID)));
        $detailAd['id'] = (string)$detailAd['_id']; 
        unset($detailAd['_id']);
        unset($detailAd['created_by']);
        $output = ['result' => true, 'message' => 'Success' , "advertisement"=>$detailAd];
        $this->response($output, 200); die;
      }
      $error = $this->validation_errors();
      $output = ['result' => false, 'message' => $error];      
      $this->response($output, 422);
    }
  }

  function advertisementCreate_post() {
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){

      $data = $this->input->post();
      $adID = $data['adID'];
      $data['thumbnail'] = '';
      $data['banner_image'] = '';
      //print_r($_FILES); die; 
      if(!empty($adID)){ 
        $detailevent = $this->connection->community->Advertisement->findOne(["_id"=> ($adID)]); 
        $data['thumbnail'] = $detailevent['thumbnail']; 
        $data['banner_image'] = $detailevent['banner_image']; 
      }

      if(file_exists($_FILES["thumbnail"]["tmp_name"])){
        $config['upload_path'] = "uploads/ads/";
        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
          if($this->upload->do_upload('thumbnail')){               
              $data['thumbnail'] = 'uploads/ads/'.$this->upload->data()['file_name'];
          } 
      }

      if(file_exists($_FILES["banner_image"]["tmp_name"])){ 
        $config['upload_path'] = "uploads/ads/";
        $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        $config['file_name'] = time();
        $this->load->library('upload', $config);          
        $this->upload->initialize($config);     
          if($this->upload->do_upload('banner_image')){   // echo 555;             
              $data['banner_image'] = 'uploads/ads/'.$this->upload->data()['file_name'];
          } 
      }

      $data['is_admin'] = 0;
      if($data['price'] == ''){ $data['price'] = 0; }
      if(!empty($data['status'])){ $data['status'] = 1; }
      else{ $data['status'] = 0; }
      unset($data['adID']);
      $dt = new DateTime();
      $data['created_by'] = new MongoDB\BSON\ObjectId($data['created_by']);

      $advertisement = $this->connection->community->advertisement;
      if(empty($adID)){ //echo 111; die;
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $advertisement->insertOne($data);
          $insertedId = $responce->getInsertedId();      
          $output = ['result' => true, 'message' => 'Advertisement added successfully' , "ad"=>$insertedId]; 
          $this->response($output, 200); die;
      }else{  //echo 222; die;
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$advertisement->updateOne(array('_id'=>($adID)), array('$set'=>$data));
          $output = ['result' => true, 'message' => 'Advertisement updated successfully' , "ad"=>$adID];
          $this->response($output, 200); die;
      }
    } 
    $error = $this->validation_errors();
    $output = ['result' => false, 'message' => $error];      
    $this->response($output, 422);
  }  

  function faq_get(){
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 
      $options = ['sort' => ['created_at' => -1]];
      $result = $this->connection->community->faq->find([], $options);
      //print_r($result); die; 
      $faqList=array();
      foreach ($result as $value) {  
        $value['question'] = $value['question']." ";
        $value['answer'] = $value['answer']." ";
        unset($value['_id']);            
        array_push($faqList, $value);
      }
      $output = ['result' => true, 'message' => 'Success' , "faq"=>$faqList];
      $this->response($output, 200); die;
    }
  }

  function resource_get(){
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 
      $options = ['sort' => ['created_at' => -1]];
      $result = $this->connection->community->resource->find([], $options);
      $resourceList=array();
      foreach ($result as $value) { 
        $value['title'] = $value['title']." ";   
        unset($value['_id']);            
        array_push($resourceList, $value);
      }
      $output = ['result' => true, 'message' => 'Success' , "resource"=>$resourceList];
      $this->response($output, 200); die;
    }
  }

  function location_get(){
    $get_data = $this->input->get();

    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){   

        // $latitude = '37'; 
        // $longitude = '-122';
        $latitude = $get_data['latitude'];
        $longitude = $get_data['longitude'];

        $Query = [];
        $options = [];
        //$Query = array('status'=>1);
        //$options = ['sort' => ['created_at' => -1], 'limit' => 5]; 

        $result = $this->connection->community->service->find($Query, $options);
        $servicesList=array();
        $services=array();
        foreach ($result as $value) {
          $data['id'] = (string)$value['_id']; 
          $data['service'] = $value['name']; 
          $data['desc'] = $value['desc']; 
          $data['thumbnail'] = $value['thumbnail']; 
          $data['latitude'] = $value['latitude']; 
          $data['longitude'] = $value['longitude']; 
          $data['venue'] = $value['address']; 
          $data["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value['latitude'],4),round($value['longitude'],6), "K"),2);
          array_push($servicesList, $data);
        }
        //$service = array_slice(array_values($this->aasort($servicesList,"distance")), 0, 5);
        $service = array_values($this->aasort($servicesList,"distance"));

        $result1 = $this->connection->community->event->find($Query, $options);
        $eventList=array();
        $event=array();
        foreach ($result1 as $value1) {
          $data1['id'] = (string)$value1['_id']; 
          $data1['title'] = $value1['title']; 
          $data1['description'] = $value1['description']; 
          $data1['thumbnail'] = $value1['thumbnail'];
          $data1['venue'] = $value1['venue'];
          $data1['latitude'] = $value1['latitude']; 
          $data1['longitude'] = $value1['longitude']; 
          $data1["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value1['latitude'],4),round($value1['longitude'],6), "K"),2);
          array_push($eventList, $data1);
        }
        //$event = array_slice(array_values($this->aasort($eventList,"distance")), 0, 5);
        $event = array_values($this->aasort($eventList,"distance"));

        $result2 = $this->connection->community->advertisement->find($Query, $options);
        $adList=array();
        $add=array();
        foreach ($result2 as $value2) {
          $data2['id'] = (string)$value2['_id']; 
          $data2['title'] = $value2['title']; 
          $data2['description'] = $value2['description']; 
          $data2['thumbnail'] = $value2['thumbnail'];
          $data2['venue'] = $value2['venue'];
          $data2['latitude'] = $value2['latitude']; 
          $data2['longitude'] = $value2['longitude']; 
          $data2["distance"] = round($this->distanceCalculate(round($latitude,4), round($longitude,6), round($value2['latitude'],4),round($value2['longitude'],6), "K"),2);
          array_push($adList, $data2);
        }
        $add = array_slice(array_values($this->aasort($adList,"distance")), 0, 5);
        $add = array_values($this->aasort($adList,"distance"));

        $output = ['result' => true, 'status' => '400', 'message' => 'Success', "service"=>$service, "event"=>$event, "advertisement"=>$add];      
        $this->response($output); die;
    }
  }

  function category_get(){
    $check_auth_client = $this->check_auth_client();
    $response = array();
    if($check_auth_client == true){ 
      $result = $this->connection->community->category->find();
      $categoryList=array();
      foreach ($result as $value) {  
        $value['id'] = (string)$value['_id']; 
        $value['category'] = $value['category']." ";
        unset($value['_id']);            
        array_push($categoryList, $value);
      }
      $output = ['result' => true, 'message' => 'Success' , "category"=>$categoryList];
      $this->response($output, 200); die;
    }
  }

  function distanceCalculate($lat1, $lon1, $lat2, $lon2, $unit) {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
          return ($miles * 0.8684);
      } else {
        return $miles;
      }
  }

  function aasort (&$array, $key) {
      $sorter=array();
      $ret=array();
      reset($array);
      foreach ($array as $ii => $va) {
          $sorter[$ii]=$va[$key];
      }
      asort($sorter);
      foreach ($sorter as $ii => $va) {
          $ret[$ii]=$array[$ii];
      }
      return $array=$ret;
  }
}