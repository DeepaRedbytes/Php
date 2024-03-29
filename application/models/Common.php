<?php
require 'vendor/autoload.php';
class Common extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
	}
	 

    var $client_service = "frontend-client";
    var $auth_key       = "restapi";

     public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
         
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
          return true;
        } else {  
          $this->response(array('status' => 404,'message' => 'Unauthorized.'),401);
        }
    }

    public function auth(){
    $users_id  = $this->input->get_request_header('User-ID', TRUE);
    $token     = $this->input->get_request_header('Authorization', TRUE);
    $q  = $this->db->select('expired_at')->from('users_authentication')->where('user_id',$users_id)->get()->row();
    if($q == ""){
        return array('status' => 401,'message' => 'Unauthorized.');
    }else{
        $updated_at = date('Y-m-d H:i:s');
        $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
        $this->db->where('user_id',$users_id)->update('users_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
        return array('status' => 200,'message' => 'Authorized.');
    }
  }


     

    function getCategoryDetails($cateID){
	    $collection = $this->connection->community->category;
        $result = $collection->find(array('_id'=> new MongoDB\BSON\ObjectId($cateID)));
        //$product_array = array();
        //foreach ($result as $doc) {
            // $id_array = (array)$doc['_id'];
            // $saller_array = (array)$doc['saller'];
            // $category_array = (array)$doc['category'];
            // $subCategory_array = (array)$doc['subCategory'];
            //$doc['_id'] = $id_array['oid'];
            //$doc['saller'] = $saller_array['oid'];
            $doc['category'] = $result['category'];
            //$doc['subCategory'] = $subCategory_array['oid'];
            //$product_array = $doc;
        //}
        return $doc;
	 }

    public function updateReadFlag($table, $flag){
        $collection = $this->connection->community->$table;
        $result = $collection->updateMany([], array('$set'=> array('read'=>$flag)));
        return true;
    }

    public function checkPaymentStatus($typeId){
        $trailfav = $this->connection->community->payment->findOne(["typeId"=> new MongoDB\BSON\ObjectId($typeId)]);
        if(empty($trailfav)) { return 'No initiated'; }
        else { return $trailfav['payStatus']; }
    }
}
