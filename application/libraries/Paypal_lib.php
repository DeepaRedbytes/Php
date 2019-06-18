<?php
class Paypal_lib {

    protected $_errors = array();
    //sandbox account details
    protected $_credentials = array(
       'USER' => 'weshop.application_api1.gmail.com',
       'PWD' => '9EFEYB5G94YEHREN',
       'SIGNATURE' => 'AIuok.v1Tlerzwb6C4jIMG.mSlx0Au-J7fgnpy0wFpL4tVp5AG4UZg8I',
    );

    //live account details
    // protected $_credentials = array(
    //   'USER' => 'weshop.application_api1.gmail.com',
    //   'PWD' => 'RK6YVF7VKHEAQ3G3',
    //   'SIGNATURE' => 'AwrsEWIaqw3RY3uakkOc-IjEBf4AA8wyaUu76m.S9Fl7RUVoeEAL8OQS',
    // );
    //sandbox url
    protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';

    //live url
    //protected $_endPoint = 'https://api-3t.paypal.com/nvp';
    protected $_version = '74.0';


    public function request($method,$params = array()) {
      $this->_errors = array();
      if( empty($method)): 
        $this->_errors = array('API method is missing');
        return false;
      endif;

      $requestParams = [
		       'METHOD' => $method,
		       'VERSION' => $this ->_version
		       ] + $this->_credentials;
           // print_r($requestParams);
           // print_r($params);
      $request = http_build_query($requestParams + $params);
      $ch = curl_init();
      curl_setopt($ch,CURLOPT_URL, $this->_endPoint);
      curl_setopt($ch,CURLOPT_VERBOSE, 1);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_POST,1);
      curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
      $response = curl_exec($ch);
      if (curl_errno($ch)):
        $this->_errors = curl_error($ch);
        curl_close($ch);
        return false;
      else:
        curl_close($ch);
        $responseArray = array();
        parse_str($response,$responseArray); 
        return $responseArray;
      endif;
   }
}