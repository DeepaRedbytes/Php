<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class User extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->helper('upload');
        $this->connection =  new MongoDB\Client("mongodb://localhost:27017");
        if(!$this->session->userdata['user'])
        {
            redirect('login');
        }  
    }

	public function index()	{
		$result = $this->connection->community->user->find();
        $users=array();
        foreach ($result as $value) {
            $user['id'] = (string)$value['_id']; 
            $user['user_name'] = $value['user_name'];
            $user['email'] = $value['email'];
            $user['login_type'] = $value['login_type'];
            $user['profile_image'] = $value['profile_image'];
            $user['status'] = $value['status'];
            array_push($users, $user);
		}
        $data['userList'] = $users;
		$this->load->view('user',$data);
	}

    public function statusUpdate() {
        $data = $this->input->post();
        if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
        $user = $this->connection->community->user; 
        $result=$user->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));  
    }
}
