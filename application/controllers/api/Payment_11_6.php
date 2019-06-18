<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');
require (APPPATH.'libraries/PaypalExpressCheckout.php');

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

          if($data['payType'] == 0){
              $array = array();
              $findData = $collection->find(array('userId'=> $data['userId'], 'type'=>$data['type']));
                foreach ($findData as $value) {
                 array_push($array, $value);
                }
                  
                  if(!empty($array)){
                     $this->response(array("message"=> "free trial used", "result"=>false), 200);
                  } 
                  $freetrial_array = array('duration'=> $data['duration'],
                                           'publishing_startdate'=> $data['publishing_startdate'],
                                            'publishing_enddate'=> $data['publishing_enddate'],
                                            'userId'=> $data['userId'],
                                            'typeId'=> $data['typeId'],
                                            'type'=> $data['type'],
                                            'txnId'=> '',
                                            'amount'=> 0,
                                            'payType'=> 0
                                          );      
                  $result = $collection->insertOne($freetrial_array);
                  $this->response(array("message"=> "your freetrial has been activated", "result"=>true), 200);
          }elseif($data['payType'] == 1){









              $gateway = new PaypalGateway();
              $gateway->apiUsername = "weshop.application_api1.gmail.com";
              $gateway->apiPassword = "9EFEYB5G94YEHREN";
              $gateway->apiSignature = "AIuok.v1Tlerzwb6C4jIMG.mSlx0Au-J7fgnpy0wFpL4tVp5AG4UZg8I";
              $gateway->testMode = true;

              // Return (success) and cancel url setup

              //if($data['device_type'] == 'android'){
                $gateway->returnUrl =  "https://weshopandco.com/Weshop/index.php/Paypal/andsuccess"; 
                $gateway->cancelUrl = "https://weshopandco.com/Weshop/index.php/Paypal/cancel";
              // }elseif($data['device_type'] == 'ios'){
              //   $gateway->returnUrl = "https://weshopandco.com/Weshop/index.php/Paypal/iossuccess";  
              //   $gateway->cancelUrl "https://weshopandco.com/Weshop/index.php/Paypal/cancel";
              // }

              $paypal = new PaypalExpressCheckout($gateway);

              //print_r($paypal); die;

              $shipping = false;

              if (!isset($resultData)) {
                  $resultData = Array();
              }

              if (isset($_GET['action'])) {
                  $action = $_GET['action'];

                  //print_r($_GET['action']); die;
              }








switch ($_GET['action']) {
    case "": // Index page, here you should be redirected to Paypal
        $r = $paypal->doExpressCheckout(123.45, 'Test service', 'inv123', 'USD', $shipping, $resultData);
        //print_r($r); die;
        break;
    
    case "success": // Paypal says everything's fine, do the charge (user redirected to $gateway->returnUrl)
        if ($transaction = $paypal->doPayment($_GET['token'], $_GET['PayerID'], $resultData)) {
      echo "Success! Transaction ID: ".$transaction['TRANSACTIONID'];
    } else {
        echo "Debugging what went wrong: ";
        print_r($resultData);
      }
    break;

    case "refund":
        $transactionId = '9SU82364E9556505C';
        if ($paypal->doRefund($transactionId, 'inv123', false, 0, 'USD', '', $resultData))
            echo 'Refunded: '.$resultData['GROSSREFUNDAMT']; else {
                echo "Debugging what went wrong: ";
                print_r($resultData);
            }
        break;
    
    case "cancel": // User canceled and returned to your store (to $gateway->cancelUrl)
        echo "User canceled";
        break;
}









             
                
                // if(isset($data['NONCE'])){

                //     $nonceFromTheClient = trim($data['NONCE']); 
                //     $amount             = trim($data['amount']); 
                //     $result = Braintree_Transaction::sale([
                //       'amount' => $amount,
                //       'paymentMethodNonce' => $nonceFromTheClient,
                //       'options' => ['submitForSettlement' => true ]
                //     ]);

                //     //print_r($result); die;

                //     if ($result->success) {
                //         $data_array = array(
                //                             'duration'=> $data['duration'],
                //                             'publishing_startdate' => $data['publishing_startdate'],
                //                             'publishing_enddate' => $data['publishing_enddate'],
                //                             'payment_method'=> 'PayPal',
                //                             'txnId'=> $result->transaction->id,
                //                             'amount'=> $amount,
                //                             'userId' => $data['userId'],
                //                             'typeId' => $data['typeId'],
                //                             'type' => $data['type'],
                //                             'payType' => 1
                //                                 );
                //         $query = $collection->insertOne($data_array);
                //         $response = array('result' => true, 'message' => 'Your post has created successfully, it will publish once it got verified by admin. You can view the post on my post section.', 'txnId'=>$result->transaction->id);   
                //     }elseif($result->transaction) {
                //       $response = array('result' => false, 'error_code' => 1, 'message' => 'Error processing transaction');
                //           // print_r("\n  code: " . $result->transaction->processorResponseCode);
                //           // print_r("\n  text: " . $result->transaction->processorResponseText);
                //     }else{
                //       $response = array('result' => false, 'error_code' => 2, 'message' => $result->message);
                //        // print_r($result->errors->deepAll());
                //   }
                // }else{
                //      $token = Braintree_ClientToken::generate();
                //       if(empty($token)){  
                //       $response = array('result'=>false, 'message'=>'Error While Retrieving Token');
                //       }else{
                //         $response = array('result'=>true, 'message'=>'Server Generated Token', 'token'=>$token);
                //       }
                // }

            $this->response($response,200);
          }

        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }


      }
  }





}