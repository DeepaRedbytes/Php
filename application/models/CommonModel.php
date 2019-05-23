<?php
require 'vendor/autoload.php';
class CommonModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
	}

    

    // public function auth(){
    //     $users_id  = $this->input->get_request_header('User-ID', TRUE);
    //     $token     = $this->input->get_request_header('Authorization', TRUE);
    //     $q  = $this->db->select('expired_at')->from('users_authentication')->where('user_id',$users_id)->get()->row();
    //     if($q == ""){
    //         return array('status' => 401,'message' => 'Unauthorized.');
    //     }else{
    //         $updated_at = date('Y-m-d H:i:s');
    //         $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
    //         $this->db->where('user_id',$users_id)->update('users_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
    //         return array('status' => 200,'message' => 'Authorized.');
    //     }
    // }


     

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
}
