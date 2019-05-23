<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');

class Login extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
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

	function index_post(){

    //$input = $this->post();
    $check_auth_client = $this->check_auth_client();
    if($check_auth_client == true){ 

      $input=$this->input->post();
      $collection = $this->connection->community->user;
      
      //if(!isset($input['socialId'])){ 
          $finddata = $collection->findOne(array('email'=>$input['email']));

          
          if($finddata != ''){ 

            if($finddata['status'] == 0) { 
              $output = ['result' => false, 'status' => '404', 'message' => 'You are currently inactive please contact customer care']; 
              $this->response($output); die; 
            }
          
            $result = $collection->findOneAndUpdate(array('email'=>$input['email']), array('$set'=> array('login_type'=>$input['login_type'], 'device_token'=>$input['device_token'], 'device_type'=>$input['device_type'])));
          }else{  
            $input['status'] = 1;
            $insert=$collection->insertOne($input);
            $result = $collection->findOne(array('_id'=> $insert->getInsertedId()));     
          }
      // }else{ 
      //     $finddata = $collection->findOne(array('socialId'=>$input['socialId']));
      //     if($finddata != ''){ 
      //       $result = $collection->findOneAndUpdate(array('socialId'=>$input['socialId']), array('$set'=> array('login_type'=>$input['login_type'], 'device_token'=>$input['device_token'], 'device_type'=>$input['device_type'])));
      //     }else{ 
      //       $insert=$collection->insertOne($input);
      //       $result = $collection->findOne(array('_id'=> $insert->getInsertedId()));     
      //     }
      // }

      $result['id'] = (string)$result['_id']; 
      unset($result['_id']);
      $output = ['result' => true, 'status' => '200', 'message' => 'Success', "data"=>$result];      
      $this->response($output); die;
    }
  }
}
