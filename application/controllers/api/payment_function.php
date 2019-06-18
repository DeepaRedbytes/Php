  $config['braintree_merchant_id'] = 'bd86v9tsnbkp4w2k';
  $config['braintree_public_key']  = 'fyspxq83hqw4yg27';
  $config['braintree_private_key'] = 'd471e40cdfc0bd249fb67e9896803700';
  $config['braintree_environment'] = 'sandbox'; 



  https://sandbox.braintreegateway.com

username: goclub_testing
password: goclub1234


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
      
        if($this->form_validation->run() == TRUE){

          $date = new DateTime();
          $todaysdate = $date->format('Y-m-d');
          $now = time();
          $strtdate = strtotime($data['publishing_startdate']);
          $datediff_day = $strtdate - $now;
          $totalDays_day= round($datediff_day / (60 * 60 * 24));
          $array = array();

          if($totalDays_day < 2){
            $this->response(array("message"=> "please choose 48 hours later date from now", "result"=>false), 200);
          }

          $collection = $this->connection->community->payment;
            $findData = $collection->find(array('userId'=> new MongoDB\BSON\ObjectId($data['userId'])));
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
               $this->response(array("message"=> "free trial used", "result"=>false, "service"=>$service, "event"=>$event, "advertisement"=>$ad), 200);die;
            }

          $enddate =  strtotime($data['publishing_enddate']);// or your date as well
          $startdate = strtotime($data['publishing_startdate']);
          $datediff = $enddate - $startdate;
          $totalDays= round($datediff / (60 * 60 * 24));

          if($totalDays > 7){
          $this->response(array("message"=> "you cannot choose more than 7 days for freetrial", "result"=>false), 200);
          }

          $data['freetrial'] = 1;
          $data['typeId'] = new MongoDB\BSON\ObjectId($data['typeId']);
          $data['userId'] = new MongoDB\BSON\ObjectId($data['userId']);
           
          $result = $collection->insertOne($data);

          $this->response(array("message"=> "your freetrial has been activated", "result"=>true), 200);


        }else{
          $error = $this->validation_errors();
          $this->response($error,422);
        }


      }
  }