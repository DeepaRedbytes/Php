<?php defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
class Advertisement extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->connection =  new MongoDB\Client("mongodb://localhost:27017");
		 $this->load->library('upload');
	}

  public function index() {


    // $user_data = $this->session->all_userdata(); 
    // $adminID = '5ca48fd13c2a7975433a7fd2'; 
    // $Query = [];
    // $QueryAdmin = [];
    //     if(isset($adminID)) { 
    //       $QueryAdmin = array('created_by' => ($adminID)); 
    //       $Query = array('created_by' <> ($adminID)); 
    //     } 

    $Query = [];
    $QueryAdmin = [];
    //if(isset($adminID)) { 
      //$QueryAdmin = array('created_by' => ($adminID)); 
    $QueryAdmin = array('is_admin' => 1); 
    $Query = array('is_admin' => 0);       
    
    $options = ['sort' => ['start_date' => 1]];
    $result = $this->connection->community->advertisement->find($Query, $options);
        $adList=array();
        foreach ($result as $value) {
            $doc['id'] = (string)$value['_id']; 
            $doc['title'] = $value['title'];
            $doc['description'] = $value['description']; 
            //$doc['type'] = $value['type'];
            $doc['thumbnail'] = $value['thumbnail'];
            $doc['start_date'] = $value['start_date'];
            //$doc['publist_start_date'] = $value['publist_start_date'];
            $doc['status'] = $value['status'];
            $detailuser = $this->connection->community->user->findOne(["_id"=> new MongoDB\BSON\ObjectId($value['created_by'])]); 
            $doc['user_name'] = $detailuser['user_name'];

            $detailcat = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($value['category'])]); 
            $doc['category_name'] = $detailcat['category'];

            array_push($adList, $doc);
    }
    $data['adList'] = $adList;
    
    $resultAdmin = $this->connection->community->advertisement->find($QueryAdmin, $options);
        $adListAdmin = array();
        foreach ($resultAdmin as $valueAdmin) {
            $docAdmin['id'] = (string)$valueAdmin['_id']; 
            $docAdmin['title'] = $valueAdmin['title'];
            $docAdmin['description'] = $valueAdmin['description']; 
            //$docAdmin['type'] = $valueAdmin['type'];
            $docAdmin['thumbnail'] = $valueAdmin['thumbnail'];
            $docAdmin['start_date'] = $valueAdmin['start_date'];
            //$docAdmin['publist_start_date'] = $valueAdmin['publist_start_date'];
            $docAdmin['status'] = $valueAdmin['status'];

            $detailcat = $this->connection->community->category->findOne(["_id"=> new MongoDB\BSON\ObjectId($valueAdmin['category'])]); 
            $docAdmin['category_name'] = $detailcat['category'];

            array_push($adListAdmin, $docAdmin);
    }
    $data['adListAdmin'] = $adListAdmin;

    $this->load->view('advertisement',$data);



		// $result = $this->connection->community->advertisement->find();
  //   $ads=array();
  //   foreach ($result as $value) {
  //       $id_array = (array)$value['_id'];
  //       $value['id'] = $id_array['oid'];
  //       array_push($ads, $value);
		// }
		// $data['ads_list'] = $ads;
  //   $this->load->view('advertisement',$data);
  }


  	public function create() {
      $advertisement = $this->connection->community->advertisement;

      $category = $this->connection->community->category->find();
      $category_array = array();
      foreach ($category as $value) {
         $cat['id'] = (string)$value['_id']; 
         $cat['category'] = $value['category'];
         array_push($category_array, $cat);
      }
      $result['category_array'] = $category_array;

      $data = $this->input->post();
      if(empty($data)){
        $dataGet = $this->input->get();
        if(empty($dataGet)) { 
          $result['adDetail'] = ''; 
        } 
        else { 
          $evntID = $dataGet['id'];
          $result['adDetail'] = $advertisement->findOne(["_id"=> new MongoDB\BSON\ObjectId($evntID)]);  
        }     
            $this->load->view('ad_create',$result);
        }else{ 

          $adID = $data['adID'];
          $data['thumbnail'] = '';
          $data['banner_image'] = '';        

          $data['created_by'] = $_SESSION['user']['_id'];
          $data['is_admin'] = 1;
          if(!empty($adID)){ 
              $detailadd = $this->connection->community->advertisement->findOne(["_id"=> new MongoDB\BSON\ObjectId($adID)]); 
              $data['thumbnail'] = $detailadd['thumbnail']; 
              $data['banner_image'] = $detailadd['banner_image']; 
              $data['created_by'] = $detailadd['created_by'];
              $data['is_admin'] = $detailadd['is_admin'];
          }

        // echo '<pre>';
        //print_r($data); die;

        // $image = $data['hidden_image'];
        // $image_parts = explode(";base64,", $image);
        // $image_type_aux = explode("/", $image_parts[0]);
        
        // $image_base64 = base64_decode($image_parts[1]); //die; 
        //$file = $temp_dir."/".$yourFileNAME.'.'.$image_type;
        define('UPLOAD_DIR', 'uploads/ads/');
        if(!empty($data['hidden_image'])) {          
          $image_parts = explode(";base64,", $data['hidden_image']);
          $image_type_aux = explode("image/", $image_parts[0]);
          $image_type = $image_type_aux[1];
          $image_base64 = base64_decode($image_parts[1]);
          $file = UPLOAD_DIR . uniqid() . '.'.$image_type;
          file_put_contents($file, $image_base64);
          $data['thumbnail'] = $file;  //die; 
        }

        if(!empty($data['hidden_image_banner'])) {
          $image_parts_banner = explode(";base64,", $data['hidden_image_banner']);
          $image_type_aux_banner = explode("image/", $image_parts_banner[0]);
          $image_type_banner = $image_type_aux_banner[1];
          $image_base64_banner = base64_decode($image_parts_banner[1]);
          $file_banner = UPLOAD_DIR . uniqid() . '.'.$image_type_banner;
          file_put_contents($file_banner, $image_base64_banner);
          $data['banner_image'] = $file_banner;  //die; 
        }
        //echo $data['banner_image']; die; 

                             

        // //if(file_exists($_FILES["thumbnail"]["tmp_name"])){
        //   $config['upload_path'] = "uploads/ads/";
        //   $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        //   $config['file_name'] = time();
        //   $this->load->library('upload', $config);          
        //   $this->upload->initialize($config);     
        //   if($this->upload->do_upload($image_base64)){               
        //       $data['thumbnail'] = 'uploads/ads/'.$this->upload->data()['file_name'];
        //   } 
        // //}
        //     echo $data['thumbnail']; die; 



        // if(file_exists($_FILES["banner_image"]["tmp_name"])){ 
        //     $config['upload_path'] = "uploads/ads/";
        //       $config['allowed_types'] = 'gif|jpg|png|JPEG|JPG|jpeg';       
        //       $config['file_name'] = time();
        //       $this->load->library('upload', $config);          
        //       $this->upload->initialize($config);     
        //         if($this->upload->do_upload('banner_image')){   // echo 555;             
        //             $data['banner_image'] = 'uploads/ads/'.$this->upload->data()['file_name'];
        //         } 
        //     }

        if($data['price'] == ''){ $data['price'] = 0; }
        if(!empty($data['status'])){ $data['status'] = 1; }
        else{ $data['status'] = 0; }

        unset($data['adID']);
        unset($data['hidden_image']);
        unset($data['hidden_image_banner']);
        $dt = new DateTime();

        if(empty($adID)){
          $data["created_at"]= $dt->format('Y-m-d H:i:s');  
          $responce = $advertisement->insertOne($data);
          $this->session->set_flashdata('advertisement','Advertisement added successfully.'); 
          redirect('advertisement');
        }else{
          $data["updated_at"]= $dt->format('Y-m-d H:i:s');
          $result=$advertisement->updateOne(array('_id'=>new MongoDB\BSON\ObjectId($adID)), array('$set'=>$data));
          $this->session->set_flashdata('advertisement','Advertisement updated successfully.'); 
          redirect('advertisement');
      }
    }
  }

  public function statusUpdate() {
    $data = $this->input->post();
    if($data['mode'] == 'false') { $mode = 0; } else  { $mode = 1; }
    $event = $this->connection->community->advertisement; 
    $result=$event->updateOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])), array('$set'=>array('status'=>$mode)));  
  }

  public function deleteEntry() {
    $data = $this->input->post();
    $event = $this->connection->community->advertisement; 
    $result=$event->deleteOne(array('_id'=> new MongoDB\BSON\ObjectId($data['trid'])));
    echo 1; die;
  }


}