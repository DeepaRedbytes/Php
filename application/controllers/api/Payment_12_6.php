<?php
require 'vendor/autoload.php';
require (APPPATH.'libraries/REST_Controller.php');
require (APPPATH.'libraries/PaypalExpressCheckout.php');
//require (APPPATH.'libraries/Paypal_lib.php');

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

              $gateway->returnUrl = "http://157.230.85.237/cs/index.php/api/payment/success";
              $gateway->cancelUrl = "http://157.230.85.237/cs/index.php/api/payment/cancel";


                // $gateway->returnUrl =  "http://157.230.85.237/cs/index.php/Paypal/andsuccess"; 
                // $gateway->cancelUrl = "http://157.230.85.237/cs/index.php/Paypal/cancel";
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
              }








// switch ($_GET['action']) {
//     case "": // Index page, here you should be redirected to Paypal



        $result = $paypal->doExpressCheckout(1.5, 'Test service', 'inv123', 'USD', $shipping, $resultData);
        //$this->output->set_content_type('application/json')->set_output(json_encode($result)); 
        $this->response($result,200);
        //print_r($result); 
        die;
        if($result['ACK'] == 'Success'){
          $this->output->set_content_type('application/json')->set_output(json_encode($result));   
        }elseif ($result['ACK'] == 'Failure') {
           $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
        exit();





//         //print_r($r); die;
//         break;
    
//     case "success": // Paypal says everything's fine, do the charge (user redirected to $gateway->returnUrl)
//         if ($transaction = $paypal->doPayment($_GET['token'], $_GET['PayerID'], $resultData)) {
//           echo "Success! Transaction ID: ".$transaction['TRANSACTIONID'];
//         } else {
//           echo "Debugging what went wrong: ";
//           print_r($resultData);
//         }
//         break;

//     // case "refund":
//     //     $transactionId = '9SU82364E9556505C';
//     //     if ($paypal->doRefund($transactionId, 'inv123', false, 0, 'USD', '', $resultData))
//     //         echo 'Refunded: '.$resultData['GROSSREFUNDAMT']; else {
//     //             echo "Debugging what went wrong: ";
//     //             print_r($resultData);
//     //         }
//     //     break;
    
//     case "cancel": // User canceled and returned to your store (to $gateway->cancelUrl)
//         echo "User canceled";
//         break;
// }









             
                
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




  public function make_payment_post(){  
      $data = $this->input->post();

      $paypal = new PaypalExpressCheckout($gateway);
      if ($transaction = $paypal->doPayment($data['token'], $data['PayerID'], $resultData)) {
        echo "Success! Transaction ID: ".$transaction['TRANSACTIONID'];
      } else {
        echo "Debugging what went wrong: ";
        print_r($resultData);
      }
      die; 




      $pp = new Paypal_lib();
      $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$data['token']));
       // print_r($payerdetails);die;
      if(!empty($payerdetails)){
        if($payerdetails['ACK'] == 'Success'){
          $customer_id          = trim($data['customer']); 
          $seller_id            = trim($data['saller']);
          $cart_id              = trim($data['cart_id']);
          $amount               = trim($data['amount']);
          $currency_code        = trim($data['currency_code']);
          $product_id           = trim($data['product_id']);
          $product_name         = trim($data['product_name']);

          $requestParams = array('token'=>$data['token'], 
                    'PAYERID'=>$data['payerID'], 
                    'PAYMENTREQUEST_0_PAYMENTACTION'=>'sale',
                    // $payerdetails['PAYMENTREQUEST_0_PAYMENTACTION'],
                    'PAYMENTREQUEST_0_AMT'=>$payerdetails['PAYMENTREQUEST_0_AMT'],
                    'PAYMENTREQUEST_0_CURRENCYCODE'=>$payerdetails['PAYMENTREQUEST_0_CURRENCYCODE']
                  );
         
          $r = $pp->request('DoExpressCheckoutPayment',$requestParams);

          // print_r($r);die;

          if($r['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed'){
                 $data_array = array('customer_id'=>$customer_id,
                              'seller_id'=> $seller_id,
                              'cart_id'=> $cart_id,
                              'txn_id'=> $r['PAYMENTINFO_0_TRANSACTIONID'],
                              'amount'=> $amount,
                              'product_id' => $product_id,
                              'product_name'=> $product_name
                            );

          $collection = $this->connection->weshop->order_payment;
          $query = $collection->insertOne($data_array);
          $insertedId = $query->getInsertedId(); //die;
                        
          $data_array['_id'] = $insertedId;                         
          $id_array = (array)$data_array['_id'];
          $data_array['_id'] = $id_array['oid'];
          if($insertedId != ''){
            $dt = new DateTime();
            $data["created_at"]= $dt->format('Y-m-d H:i:s');
            $data['status'] = "pending";
            $collectioncart=$this->connection->weshop->cart;
            $collection1=$this->connection->weshop->order;
            $collectionSeller=$this->connection->weshop->saller;
            $cursor= $collectioncart->find(array('saller' =>$data['saller'],'customer'=>$data['customer'], 'status' => "Pending", 'cart_id'=> $cart_id));
            $array = array();
            $product_array = array();
            if($cursor != ''){
              foreach ($cursor as $doc) {                                     
                $id_array = (array)$doc['_id'];
                $doc['cart'] = $id_array['oid'];
                $collectionmyproduct = $this->connection->weshop->my_product;
                $my_productdata['product_id'] = $this->my_product($doc['product']);
                $my_product = $collectionmyproduct->insertOne($my_productdata);
                $collectioncart->deleteOne(array('cart_id'=> $doc['cart_id']));
                unset($doc['status']);
                $doc['status'] =  "order";
                unset($doc['_id']);
                unset($doc['created_at']);
                //$doc['product']=$this->Common->getProductDetails($doc['product']);
                // print_r($doc);
                array_push($product_array, $doc);
              }
              $array["created_at"]= $dt->format('Y-m-d H:i:s');
              $array["code"] = random_string('alnum', 5);
              // $array["dateTime"] = $data['dateTime'];
              $array["deliveryMode"] = $data['deliveryMode'];
              $array["deliveryDetails"] = $data['deliveryDetails'];
              $array["customer"] = $data['customer'];
              $array["saller"] = $data['saller'];
              // $array["custInfo"] = $data['custInfo'];
              $array["customerStatus"] ="pending";
              $array["sellerStatus"] ="pending";
              $array["deliveredStatus"] ="pending";
              $array["paymentDetails"] = $data_array['_id'];
              $array["products"] = $product_array;

              $collection1->insertOne($array);
              $message = $data_array['_id'];                            

              $cursor_saller= $collectionSeller->find(array("_id"=>new MongoDB\BSON\ObjectId($data['saller'])));
              $updateseller = $collectionSeller->findOneAndUpdate(array('_id'=>new MongoDB\BSON\ObjectId($data['saller'])), array('$set'=> array('notification_order'=>true)));

              foreach ($cursor_saller as $details) {
                if($details["osType"]=="android"){                 
                  $data["device_token"]= $details["deviceToken"];
                  $data["message"]="New Order";
                  $data['seller'] = $data['saller'];
                  $data['customer'] = $data['customer'];
                  $data['identify']= "newOrder";               
                  $this->Common->android_push($data);
                }else {
                  $data["device_token"]= $details["deviceToken"];
                  $data["message"]="New Order";
                  $data['seller'] = $data['saller'];
                  $data['customer'] = $data['customer'];
                  $data['identify']= "newOrder";
                  $this->Common->ios_seller_push($data);
                }
              }                                    
              $this->output->set_output(json_encode(array('payment_detail' => $message), 201));
            }else{
                $error = "product not available on cart";
                $this->output
                  ->set_output(json_encode(array("error"=>$error), 422));
            }
            //$this->output->set_content_type('application/json')->set_output(json_encode($result));
            
            
            // print_r($r);die;PAYMENTINFO_0_TRANSACTIONID
            $this->output->set_content_type('application/json')->set_output(json_encode($payerdetails));

          }
          }
       

        }elseif ($payerdetails['ACK'] == 'Failure') {
           $this->output->set_content_type('application/json')->set_output(json_encode($payerdetails));
        }
      }else{
        $error = "data not found";
        $this->response(array('error'=>$error));
      }      
    }



  public function success_get(){   
      $payerInfo = $this->input->get();
      // $pp = new Paypal_lib();
      // $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$payerInfo['token']));
      $data['token']          = $payerInfo['token'];
      $data['PayerID']        = $payerInfo['PayerID'];        
      $this->load->view('paypal/success'); 
    }

public function cancel_get(){
        // Load payment failed view
        $this->load->view('paypal/cancel');
    }



}