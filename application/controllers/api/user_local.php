<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');

class User extends REST_Controller {

  function __construct() {
      parent::__construct();
      $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
      $this->load->model('CommonModel','general');
      $this->load->library("braintree_lib");
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
              $result = $collection->deleteOne(array('userId'=>new MongoDB\BSON\ObjectId($data['userId']),'typeId'=>new MongoDB\BSON\ObjectId($data['typeId'])));
              $this->response(array("message"=> "Successfully removed", "status"=>true), 202);
            }else{
              $dt = new DateTime();
              $data["created_at"]= $dt->format('Y-m-d H:i:s');
              $data["favourite"]= true;
              //echo $data["typeId"]; die;
              $table = $data["type"];
              $detail = $this->connection->community->$table->findOne(array('_id'=>new MongoDB\BSON\ObjectId($data['typeId'])));
              $data["banner_image"] = $detail['banner_image'];
              if($table == 'service') { 
                $data["location"] = $detail['address'];
                $data["language"] = '';
              } else {
                $data["location"] = $detail['venue'];
                $data["language"] = $detail['language'];
              }

              $detailcat = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($detail['category'])]); 
              $data['category'] = $detailcat['category'];

              $data['typeId'] = new MongoDB\BSON\ObjectId($data['typeId']);
              $data['userId'] = new MongoDB\BSON\ObjectId($data['userId']);
             
              $result = $collection->insertOne($data);
              $this->response(array("message"=> "Successfully added to favourite", "status"=>true), 200);
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
            $result = $collection->find(array('userId'=> new MongoDB\BSON\ObjectId($data['userId'])));

            foreach ($result as $value) {
              $idArray = (array)$value['_id'];
              $value['_id'] = $idArray['oid'];
              $value['detailId'] = (string)$value['typeId'];

              $table = $value['type'];
              $detail = $this->connection->community->$table->findOne(array('_id'=>new MongoDB\BSON\ObjectId($value['detailId']), 'status'=>1));
              if(empty($detail)){
                $value['available'] = 0;                
              }
              else{
                $value['available'] = 1;
              }

              unset($value['_id']);
              unset($value['typeId']);
              unset($value['userId']);
              array_push($array, $value);
            }
            $output = ['result' => true, 'message' => 'Success' , "favourite"=>$array];
            $this->response($output, 200); die;
            
        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }
      } 
  }


  function isfavourite($userId, $typeId){
      $collection = $this->connection->community->favourite;
      $result =$collection->find(array('userId' => new MongoDB\BSON\ObjectId($userId),  'typeId'=> new MongoDB\BSON\ObjectId($typeId )));
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

  public function payment_post(){
      $check_auth_client = $this->check_auth_client();
      if($check_auth_client == true){  
          $data = $this->input->post();
          $this->form_validation->set_data($data);
          $this->form_validation->set_rules('userId', 'userId', 'required');
          $this->form_validation->set_rules('publishing_startdate', 'publishing_startdate', 'required');
          $this->form_validation->set_rules('publishing_enddate', 'publishing_enddate', 'required');
          $this->form_validation->set_rules('typeId', 'typeId', 'required');
          $this->form_validation->set_rules('type', 'type', 'required');
          $this->form_validation->set_rules('payType', 'payType', 'required');
      
        if($this->form_validation->run() == TRUE){

          $collection = $this->connection->community->payment;
          $data['typeId'] = new MongoDB\BSON\ObjectId($data['typeId']);
          $data['userId'] = new MongoDB\BSON\ObjectId($data['userId']);

          if($data['payType'] == 'free'){
              $array = array();
              $findData = $collection->find(array('userId'=> $data['userId']));
                foreach ($findData as $value) {
                 array_push($array, $value['type']);
                }
                  $service = 1;
                  $event = 1;
                  $ad = 1;
                  if(in_array("service", $array)){
                      $service = 0;
                  }
                  if(in_array("event", $array)){
                      $event = 0;
                  }
                  if(in_array("advertisement", $array)){
                      $ad = 0;
                  }

                if(in_array($data['type'],$array)){
                   $this->response(array("message"=> "free trial used", "result"=>false, "service"=>$service, "event"=>$event, "advertisement"=>$ad), 200);
                }
              $data['freetrial'] = 1;         
              $result = $collection->insertOne($data);
              $this->response(array("message"=> "your freetrial has been activated", "result"=>true), 200);
          }elseif($data['payType'] == 'paid'){
             
                
                if(isset($data['NONCE'])){

                    $nonceFromTheClient = trim($data['NONCE']); 
                    $amount             = trim($data['amount']); 

                    $result = Braintree_Transaction::sale([
                      'amount' => $amount,
                      'paymentMethodNonce' => $nonceFromTheClient,
                      'options' => ['submitForSettlement' => true ]
                    ]);
                    if ($result->success) {
                            $data_array = array(
                                                'totalDays'=> $data['totalDays'],
                                                'publishing_startdate' => $data['publishing_startdate'],
                                                'publishing_enddate' => $data['publishing_enddate'],
                                                'payment_method'=> $data['payment_method'],
                                                'txnId'=> $result->transaction->id,
                                                'amount'=> $amount,
                                                'freetrial' => 0
                                                );
                            $query = $collection->updateOne(array('userId'=>$data['userId'],'typeId'=>$data['typeId'], array('$set'=>$data_array)));
                        $response = array('result' => true, 'message' => 'transaction success', 'txnId'=>$result->transaction->id);   
                    }elseif($result->transaction) {
                      $response = array('result' => false, 'error_code' => 1, 'message' => 'Error processing transaction');
                    }
                  // else{
                  //   $response = array('result' => false, 'error_code' => 2, 'message' => 'Validation errors');
                  // }
                // }else{
                //   $response   = array('result' => false, 'error_code' => 3,'message' => 'Data Empty');
                // }
                }else{
                     $token = $this->braintree_lib->create_client_token();
                      if(empty($token)){  
                      $response = array('result'=>false, 'message'=>'Error While Retrieving Token');
                      }else{
                        $response = array('result'=>true, 'message'=>'Server Generated Token', 'token'=>$token);
                      }
                }

            $this->response($response,200);
          }

        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }


      }
  }


  public function generateToken_post(){

      $method = $_SERVER['REQUEST_METHOD'];
      if($method = 'POST'){
        $check_auth_client = $this->check_auth_client();
        if($check_auth_client == true){
          $token = $this->braintree_lib->create_client_token();
            if(empty($token)){                                // error creating token
            $this->output
            ->set_output(json_encode(array('status' => 400,'message' => 'Error While Retrieving Token')));
            }else{
              $this->output
              ->set_content_type('application/json')
            ->set_output(json_encode(array('status' => 200,'message' => 'Server Generated Token','data'=>$token)));
            }
        }
      }
  }





}