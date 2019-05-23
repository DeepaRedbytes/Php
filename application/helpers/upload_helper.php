<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('uploadDocument')){
	function uploadDocument($tutCertificationDoc, $field_name, $config){
		$CI = & get_instance();
                $CI->load->library('upload', $config);
                $CI->upload->initialize($config);

                $result = '';
                if(!$CI->upload->do_upload($field_name)){
        	       $result = $CI->upload->display_errors();
        	       $result = array('', $result);
                }else{
                	$uploadsData = $CI->upload->data();
                	$result = array('1',$uploadsData['orig_name']);
                }
                return $result;
	}
}
if(!function_exists('uploadDocumentMultiple')){
    function uploadDocumentMultiple($files, $field_name, $config){
        
            $CI = & get_instance();
            $CI->load->library('upload', $config);
            
            $ffmpeg         = "/usr/bin/ffmpeg";

            $file_name = $config['file_name'];
            $result = array();

            foreach($files['name'] AS $key => $image){
                $_FILES[$field_name."[]"]['name']= $files['name'][$key];
                $_FILES[$field_name."[]"]['type']= $files['type'][$key];
                $_FILES[$field_name."[]"]['tmp_name']= $files['tmp_name'][$key];
                $_FILES[$field_name."[]"]['error']= $files['error'][$key];
                $_FILES[$field_name."[]"]['size']= $files['size'][$key];
                $config['file_name']        = $key.'_'.$file_name;
//echo'<pre>';print_r($config);die;
                $CI->upload->initialize($config);
                if($CI->upload->do_upload($field_name."[]")){
                    $uploadsData = $CI->upload->data();
                    
                    if($field_name == 'video'){
                        $videoFile      = $uploadsData['full_path'];
                        $thumbnail      = $uploadsData['file_path']."/thumbnail/".$uploadsData['raw_name'].".jpg";
                        $cmd = "$ffmpeg -i $videoFile -r 0.25 $thumbnail";
                        //$cmd            = "$ffmpeg -i $videoFile -ss 00:00:01 -vframes 1 -vf scale=180:320 $thumbnail 2>&1 &";
                        exec($cmd);
                        $result[] = array('1',$uploadsData['orig_name'],$uploadsData['raw_name']);
                    }else{
                        $result[] = array('1',$uploadsData['orig_name']);
                    }  
                }else{
                    if(count($result) > 0){
                            foreach($result AS $res){
                                    unlink($config['upload_path'].$res['1']);
                                    if($field_name == 'video'){
                                        unlink($config['upload_path'].'thumbnail/'.$res['2'].".jpg");
                                    }
                            }
                    }
                    $err = $CI->upload->display_errors();
                    $error_result = array('', $err);
                    return $error_result;
                }

            }
            return $result;
    }
}

if(!function_exists('sendEmailMailer')){
    function sendEmailMailer($mailCont){
        $CI = &get_instance();
        $CI->load->library("PhpMailerLib");
        $mail = $CI->phpmailerlib->load();

        $subject    = $mailCont['subject'];
        $body       = $mailCont['bodycon'];
        $to         = $mailCont['tomail'];

        try{
            $mail->isSMTP();
            //$mail->SMTPDebug = 2;
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(EMAIL_FROM, FROM_NAME);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
//echo'<pre>';print_R($mail);die;
            if(!$mail->Send()){
                $result = '0';
            }else{
                $result = '1';
            }
        }catch(Exception $e){
            $result = '0';
        }
        return $result;die;
    }
}
