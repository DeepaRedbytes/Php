<?php defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
	}

  	public function index() {
    	$this->load->view('index');
  	}

  public function adminlogin(){
    $data = $this->input->post();
    $users = $this->connection->community->admin;
    $user = $users->findOne($this->input->post());        	
  	if($user!=null){	 	
  		$this->session->set_userdata('user',$user);       
  		redirect('dashboard');
  	}else{	
  		$this->session->set_flashdata('login', "Invalid credentials");
  		redirect('login');
  	}
  }

 //  	public function dashboard(){
	// 	if($this->session->userdata('user') == null){
	// 		redirect('login');
	// 	}
	// 	$this->load->view('dashboard');
	// }

  // public function loginprocess(){
  //   $data = $this->input->post();

  //   $this->form_validation->set_rules('email', 'Email', 'required', array('required' => 'Username/email is required.'));
  //   $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[15]', array('required' => 'Password is required.', 'min_length' => 'Password must be at least 6 characters in length', 'max_length' => 'Password cannot exceed 15 characters in length.'));

  //   $result = array();
  //   if($this->form_validation->run() == TRUE){
  //     $result = $this->general->adminloginModel($data);
  //   }else{
  //     //echo json_encode(validation_errors());
  //     $error = $this->form_validation->error_string();
  //     $result['status']   = 'error';
  //     $result['message']  = $error;
  //   }
    
  //   echo json_encode($result);
  // }

  function logout(){
    $user_data = $this->session->all_userdata();
    foreach ($user_data as $key => $value) {
        if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
            $this->session->unset_userdata($key);
        }
    }
    $this->session->sess_destroy();
    $result['status']   = 'success';
    //echo json_encode($result);
    redirect('login');
  }

}