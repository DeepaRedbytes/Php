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













              //if($data['device_type'] == 'android'){
          // $orderParams      = 
          //   ['RETURNURL' => "http://157.230.85.237/cs/index.php/api/payment/success",  
          //      'CANCELURL' => "http://157.230.85.237/cs/index.php/api/payment/cancel"
          //     ];
        // }elseif($data['device_type'] == 'ios'){
        //      $requestParams      = 
        //     ['RETURNURL' => "https://weshopandco.com/Weshop/index.php/Paypal/iossuccess",  
        //        'CANCELURL' => "https://weshopandco.com/Weshop/index.php/Paypal/cancel"
        //       ];
        // }


      

        



        $orderParams =  ['RETURNURL' => "http://157.230.85.237/cs/index.php/api/payment/success", 
        'CANCELURL' => "http://157.230.85.237/cs/index.php/api/payment/cancel",
        'PAYMENTACTION' =>'Sale',
                      'AMT' => 5,
                   'CURRENCYCODE' => 'USD',
                   'ALLOWNOTE' => "0",
                   'PAYMENTACTION' => 'Sale'
                  ];

      

        $obj    =   new Paypal_lib();
        $result   =   $obj->request('SetExpressCheckout',$orderParams);

        $this->response($result,200);
        exit();

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

      $pp = new Paypal_lib();

      $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$data['token']));
      if(!empty($payerdetails)){
        $requestParams = array('TOKEN'=>$data['token'], 
                    'PAYERID'=>$data['PayerID'], 
                    'PAYMENTACTION'=>'sale',
                    'AMT'=>5,
                    'CURRENCYCODE'=>'USD'
                  );
         




          $transaction = $pp->request('DoExpressCheckoutPayment',$requestParams);

          print_r($transaction); die; 

          

}






            // $gateway = new PaypalGateway();

        

            // $gateway->returnUrl = "http://157.230.85.237/cs/index.php/api/payment/success";
            // $gateway->cancelUrl = "http://157.230.85.237/cs/index.php/api/payment/cancel";

            // $paypal = new PaypalExpressCheckout($gateway);


            // $transaction = $paypal->doPayment('EC-19L33717VK2435604', 'FXTXUGBBRH9KG', '');
            // print_r($transaction); die; 









      $pp = new Paypal_lib();
      $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$data['token']));
      print_r($payerdetails);die;


      if(!empty($payerdetails)){
        if($payerdetails['ACK'] == 'Success'){


          $requestParams = array('token'=>$data['token'], 
                    'PAYERID'=>$data['payerID'], 
                    'PAYMENTREQUEST_0_PAYMENTACTION'=>'sale',
                    // $payerdetails['PAYMENTREQUEST_0_PAYMENTACTION'],
                    'PAYMENTREQUEST_0_AMT'=>$payerdetails['PAYMENTREQUEST_0_AMT'],
                    'PAYMENTREQUEST_0_CURRENCYCODE'=>$payerdetails['PAYMENTREQUEST_0_CURRENCYCODE']
                  );
         
          $r = $pp->request('DoExpressCheckoutPayment',$requestParams);


          

        }
      }


      print_r($data); die;

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
      $pp = new Paypal_lib();
      $payerdetails = $pp->request('GetExpressCheckoutDetails',array('token'=>$payerInfo['token']));
      $data['token']          = $payerInfo['token'];
      $data['PayerID']        = $payerInfo['PayerID'];        
      $this->load->view('paypal/success'); 
    }

public function cancel_get(){
        // Load payment failed view
        $this->load->view('paypal/cancel');
    }



}