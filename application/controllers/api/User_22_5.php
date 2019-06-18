<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');

class User extends REST_Controller {

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


  public function addFavourite_post(){

      $check_auth_client = $this->check_auth_client();
      if($check_auth_client == true){    
        $data = $this->input->post();
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('typeId', 'typeId', 'required');
        $this->form_validation->set_rules('userId', 'userId', 'required');
        $this->form_validation->set_rules('type', 'type', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');

        if($this->form_validation->run() == TRUE){

            $collection = $this->connection->community->favourite;
            $isfavourite = $this->isfavourite($data['userId'], $data['typeId']);
         
            if($isfavourite){
              $result = $collection->deleteOne(array('userId'=>$data['userId'],'typeId'=>$data['typeId']));
              $this->response(array("message"=> "successfully removed", "status"=>true), 202);
            }else{
              $dt = new DateTime();
              $data["created_at"]= $dt->format('Y-m-d H:i:s');
              $data["favourite"]= true;
             
              $result = $collection->insertOne($data);
              $this->response(array("message"=> "successfully added to favourite", "status"=>true), 200);
            }
            
        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }
      } 
  }

  public function myFavourites_get(){

      $check_auth_client = $this->check_auth_client();
      if($check_auth_client == true){    
        $data = $this->input->get();
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('userId', 'userId', 'required');
      
        if($this->form_validation->run() == TRUE){
            $array = array();
            $collection = $this->connection->community->favourite;
            $result = $collection->find(array('userId'=> $data['userId']));

            foreach ($result as $value) {
             $idArray = (array)$value['_id'];
             $value['_id'] = $idArray['oid'];
             unset($value['_id']);
             array_push($array, $value);
            }
            $this->response($array,200);
            
        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }
      } 
  }


  function isfavourite($userId, $typeId){
      $collection = $this->connection->community->favourite;
      $result =$collection->find(array('userId' => $userId,  'typeId'=> $typeId ));
      $array = array();
         foreach ($result as $value) {           
           array_push($array, $value);
         }
           if(empty($array)){
              return false;
           }else{
              return true;
           }

  }





}