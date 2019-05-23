<?php
require 'vendor/autoload.php';

class Faq extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('upload');
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
        if(!$this->session->userdata['user']){
	        redirect('login');
	    }
    }

	public function index()	{
		$options = ['sort' => ['created_at' => -1]];
		$result = $this->connection->community->faq->find([], $options);
        $faq=array();
        foreach ($result as $value) {
            $id_array = (array)$value['_id'];
            $doc['id'] = $id_array['oid'];
            $doc['question'] = $value['question'];
            $doc['answer'] = $value['answer'];
            array_push($faq, $doc);
		}
		$data['faqList'] = $faq;
		$this->load->view('faq',$data);
	}

	public function create()	{
		$faq = $this->connection->community->faq;
		$data = $this->input->post();
		if(empty($data)){
			$dataGet = $this->input->get();
			if(empty($dataGet)) { 
				$result['faqDetail'] = ''; 
			} 
			else { 
				$faqID = $dataGet['id'];
				$result['faqDetail'] = $faq->findOne(["_id"=> new MongoDB\BSON\ObjectId($faqID)]);  
			}			
	      	$this->load->view('faq_create',$result);
	    }else{ 
			$faqID = $data['faqID'];
			$array["question"] = $data['question'];
			$array["answer"] =$data['answer'];
			//$array["status"] = $data['status'];
			
			$dt = new DateTime();
			$array["created_at"]= $dt->format('Y-m-d H:i:s');      
	      	if(empty($faqID)){	      	
				$responce = $faq->insertOne($array);
				$this->session->set_flashdata('faq','Faq added successfully.'); 
		        redirect('faq');
	      	}else{
		      	$result=$faq->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($faqID)), array('$set'=>$array));
		      	$this->session->set_flashdata('faq','Faq updated successfully.'); 
		        redirect('faq');
			}
		}
	}

	// public function statusUpdate() {
	// 	$data = $this->input->post();
	// 	if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
	// 	$faq = $this->connection->community->faq; 
	// 	$result=$faq->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));	
	// }

	public function deleteEntry() {
		$data = $this->input->post();
		$faq = $this->connection->community->faq; 
		$result=$faq->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
		echo 1; die;
	}
}
