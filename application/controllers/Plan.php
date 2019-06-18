<?php
require 'vendor/autoload.php';

class Plan extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('upload');
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
        if(!$this->session->userdata['user']){
	        redirect('login');
	    }
    }

	public function index()	{

		$result = $this->connection->community->plan->find([], array('sort' => ['type' => 1]));
        $plans=array();
        foreach ($result as $value) {
            $id_array = (array)$value['_id'];
            $value['id'] = $id_array['oid'];
            array_push($plans, $value);
		}
        $data['plan_details'] = $plans;
		$this->load->view('plan',$data);
	}

    public function edit($id){
        $result = $this->connection->community->plan->findOne(array('_id'=>new MongoDB\BSON\ObjectId($id)));
        $result['id']= (string)$result['_id'];
        $data['plan'] = $result;
        
        if(isset($_POST['save_plan_btn'])){
            $post =$this->input->post();
            $array = array('planname'=>$post['planname'],
                                'type'=>$post['type'],
                                'price'=>$post['price'],
                                'day'=>$post['day']
                                );
            $collection= $this->connection->community->plan;
            $collection->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($id)), array('$set'=>$array));
            $this->session->set_flashdata('plan','plan updated successfully.');
            redirect('plan');
        }
        $this->load->view('plan_edit',$data);
    }

    public function deleteEntry() {
        $data = $this->input->post();
        $event = $this->connection->community->plan; 
        $result=$event->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
        echo 1; die;
    }


    public function create(){

        if(isset($_POST['create_plan_btn'])){
            $post =$this->input->post();
            $array = array('planname'=>$post['planname'],
                                'type'=>$post['type'],
                                'price'=>$post['price'],
                                'day'=>$post['day']
                                );
            $collection= $this->connection->community->plan;
            $collection->insertOne($array);
            $this->session->set_flashdata('plan','plan created successfully.');

            redirect('plan');
        }
        $this->load->view('plan_create.php');
    }


}