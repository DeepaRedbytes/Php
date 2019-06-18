<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');
//require (APPPATH.'libraries/PaypalExpressCheckout.php');
require (APPPATH.'libraries/Paypal_lib.php');

class Payment extends REST_Controller {

  function __construct() {
      parent::__construct();
      $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
      $this->load->model('CommonModel','general');
      //$this->load->library("braintree_lib");
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



  public function index_post(){
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

            if($data['payType'] == 0){
              $freetrial_array = array('duration'=> $data['duration'],
                                'publishing_startdate'=> $data['publishing_startdate'],
                                'publishing_enddate'=> $data['publishing_enddate'],
                                'userId'=> $data['userId'],
                                'typeId'=> $data['typeId'],
                                'type'=> $data['type'],
                                'transactionId'=> '',
                                'amount'=> 0,
                                'payType'=> 0,
                                'payStatus'=> 'Free Trail'
                                      );      
              $result = $collection->insertOne($freetrial_array);
              $this->response(array("message"=> "your freetrial has been activated", "result"=>true), 200);
            }elseif($data['payType'] == 1){

              if($data['devideType'] == 'android'){
                $returnUrl = "http://157.230.85.237/cs/index.php/api/payment/successAnd";
                $cancelUrl = "http://157.230.85.237/cs/index.php/api/payment/cancelAnd";
              }elseif($data['devideType'] == 'ios'){
                $returnUrl = "http://157.230.85.237/cs/index.php/api/payment/successIos";
                $cancelUrl = "http://157.230.85.237/cs/index.php/api/payment/cancelIos";
              }

              $newAmount = 0.89 * $data['amount']; //die; 
              $orderParams =  ['RETURNURL' => $returnUrl, 
                                'CANCELURL' => $cancelUrl,
                                'PAYMENTACTION' =>'Sale',
                                'AMT' => $newAmount,
                                'CURRENCYCODE' => 'EUR',
                                'ALLOWNOTE' => "0",
                                'PAYMENTACTION' => 'Sale'
                              ];      

              $obj    =   new Paypal_lib();
              $result   =   $obj->request('SetExpressCheckout',$orderParams);

              if($result['ACK'] == 'Success'){
                $data_array = array(
                                'duration'=> $data['duration'],
                                'publishing_startdate' => $data['publishing_startdate'],
                                'publishing_enddate' => $data['publishing_enddate'],
                                'payment_method'=> 'PayPal',
                                'transactionId'=> '',
                                'amount'=> $data['amount'],
                                'userId' => $data['userId'],
                                'typeId' => $data['typeId'],
                                'type' => $data['type'],
                                'payType' => 1,
                                'payStatus' => 'Pending'
                              );

                $query = $collection->insertOne($data_array);
                $insertedId = (string)$query->getInsertedId(); 
                $result['paymentID'] = $insertedId;
                $this->response($result,200); exit();
              }elseif ($result['ACK'] == 'Failure') {
                $this->response($result,200); exit();
              }
            }
        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }
      }
    }




    public function make_payment_post(){  
      $data = $this->input->post();
      $pp = new Paypal_lib();
      $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$data['token']));
      if(!empty($payerdetails)){
        $requestParams = array('TOKEN'=>$data['token'], 
                    'PAYERID'=>$data['PayerID'], 
                    'PAYMENTREQUEST_0_PAYMENTACTION'=>'sale',
                    'AMT'=>$payerdetails['PAYMENTREQUEST_0_AMT'],
                    'CURRENCYCODE'=>$payerdetails['PAYMENTREQUEST_0_CURRENCYCODE']
                  );
        $transaction = $pp->request('DoExpressCheckoutPayment',$requestParams);
        //print_r($transaction);  die;

        if($transaction['PAYMENTSTATUS'] == 'Completed'){
          $udata["transactionId"]= $transaction['PAYMENTINFO_0_TRANSACTIONID'];
          $udata["payStatus"]= 'Completed';
          $collection = $this->connection->community->payment;
          $result=$collection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($data["paymentID"])), array('$set'=>$udata));
          $output = ['result' => true, 'message' => 'Payment done it will publish once it got verified by admin. You can view the post on my post section.'];
        } 
        else {
          $output = ['result' => false, 'message' => 'Try again'];               
        }   
        $this->response($output, 200); die;          
      }
    }


    public function successIos_get(){          
      $this->load->view('paypal/successIos'); 
    }

    public function successAnd_get(){           
      $this->load->view('paypal/successAnd'); 
    }

    public function cancelIos_get(){
        $this->load->view('paypal/cancelIos');
    }
    public function cancelAnd_get(){
        $this->load->view('paypal/cancelAnd');
    }

    public function paymentCancel_post(){  
      $data = $this->input->post();          
      $udata["payStatus"]= 'Canceled';
      $collection = $this->connection->community->payment;
      $result=$collection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($data["paymentID"])), array('$set'=>$udata));
      $output = ['result' => true, 'message' => 'Payment has been cancled from the user side. You still can view the post on my post section.'];     
      $this->response($output, 200); die;          
    }
}