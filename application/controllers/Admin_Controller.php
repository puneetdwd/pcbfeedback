<?php
/** 
* My Controller Class 
* 
* @package IACT
* @filename My_Controller.php
* @category My_Controller
**/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {

    function __construct($auth = false, $access = '') {
       
        parent::__construct();
        if($auth) {
            $this->is_logged();
        }

        if($access === 'Admin') {
            $this->is_admin_user();
        } else if($access === 'Dashboard') {
            $this->is_dashboard_user();
        } else if($access === 'Audit') {
            $this->is_audit_user();
        } else if($access === 'Supplier') {
            $this->is_supplier();
        } else if($access === 'Supplier Inspector') {
            $this->is_supplier_inspector();
        }


        $this->id = $this->session->userdata('id');
        $this->name = $this->session->userdata('name');
        $this->username = $this->session->userdata('username');
        $this->email = $this->session->userdata('email');
        $this->user_type = $this->session->userdata('user_type');
        $this->product_id = $this->session->userdata('product_id');
        $this->supplier_id = $this->session->userdata('supplier_id');

    }

    /**
     * @method: is_logged()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is logged in or not
     */
    function is_logged() {
        
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        
        if($ipaddress == '202.154.175.50'){
            
        }else if(!$this->session->userdata('is_logged_in')) {
            redirect(base_url().'login');
        }
    }
    
    
    function get_server_ip() {                                      // Function to get the client IP address
        $ipaddress = '';
        /*if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];*/
		if(isset($_SERVER['SERVER_ADDR']))
			$ipaddress = $_SERVER['SERVER_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    
    function is_supplier() {
        if($this->session->userdata('user_type') !== 'Supplier') {
            redirect(base_url().'supplier_login');
        }
    }
    
    function is_supplier_inspector() {
        if(!$this->session->userdata('is_logged_in')) {
            redirect(base_url().'supplier_login');
        }
    }

    /**
     * @method: is_super_admin()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is super admin
     */
    function is_super_admin() {
        if(!$this->session->userdata('is_super_admin')) {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }
    }

    /**
     * @method: is_admin_user()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user has Admin access
     */
    function is_admin_user() {
        if($this->session->userdata('user_type') !== 'Admin') {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }

    }

    /**
     * @method: is_lg_inspector()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is LG Inspector or not
     */
    function is_lg_inspector() {
        if($this->session->userdata('user_type') !== 'LG Inspector') {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }

    }

    function pr($var) {
        echo "<pre>";
        print_r($var);
        exit;
    }
    
    function create_sample_qty($checkpoint_id, $part_id, $prod_lot_qty) {
        $sample = 0;
        $this->load->model('Sampling_model');
        
        $config = $this->Sampling_model->get_specific_config($this->product_id, $checkpoint_id, $part_id);
        if(empty($config)) {
            $config = $this->Sampling_model->get_specific_config($this->product_id, $checkpoint_id, null);
        }
        if(empty($config)) {
            $config = $this->Sampling_model->get_specific_config($this->product_id, null, $part_id);
        }
        if(empty($config)) {
            $config = $this->Sampling_model->get_specific_config($this->product_id, null, null);
        }
        
        if(!empty($config)) {
            
            if($config['sampling_type'] == 'Auto') {
                $no_of_samples = $this->Sampling_model->get_no_of_samples_auto($prod_lot_qty, $config['inspection_level'], $config['acceptable_quality']);
                $sample = $no_of_samples;
            }
        
            if($config['sampling_type'] == 'User Defined') {
                $no_of_samples = $this->Sampling_model->get_no_of_samples($config['id'], $prod_lot_qty);
                $sample = $no_of_samples;
            }
            
            if($config['sampling_type'] == 'C=0') {
                $no_of_samples = $this->Sampling_model->get_no_of_samples_c0($prod_lot_qty, $config['acceptable_quality']);
                $sample = $no_of_samples;
            }
            
            if($config['sampling_type'] == 'Fixed') {
                $sample = $config['sample_qty'];
            }
            
            if(($sample > $prod_lot_qty) || ($sample == 0)) {
                $sample = $prod_lot_qty;
            }
        }
        
        return $sample;
    }
    
    function upload_file($file_field, $file_name, $upload_path, $file_types = 'xls|xlsx') {
        if(!is_dir($upload_path)) {
            mkdir($upload_path);
        }
            
        $config['upload_path'] = $upload_path;
        if($file_field !== 'sampling_excel' && $file_field !== 'automate_excel') {
            $config['file_name'] = $file_name.'-'.random_string('alnum', 6);
        } else {
            $config['file_name'] = $file_name;
        }
        
        $config['allowed_types'] = $file_types;
        $config['overwrite'] = True;

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload($file_field)) {

            if(!$this->upload->is_allowed_filetype()) {
                $error = "The file type you are attempting to upload is not allowed.";
            } else {
                $error = $this->upload->display_errors();
            }

            $result = array(
                'status' => 'error',
                'error' => $error
            );

        } else {
            $upload_data = $this->upload->data();
            $result = array(
                'status' => 'success',
                'file' => $upload_path.$upload_data['file_name']
            );
        }
        
        return $result;
    }
    
    function upload_photo($field, $upload_path, $filename) {
        $response = array('status' => 'error', 'error' => 'Invalid parameters');

        if(!empty($_FILES[$field]['name']) && !empty($upload_path)) {
            //upload wallpaper.

            if(!is_dir($upload_path)) {
                mkdir($upload_path);
            }

            $config['upload_path'] = $upload_path;
            if(!empty($filename)) {
                $config['file_name'] = $filename;
            }
            $config['allowed_types'] = 'png|jpg|JPG|jpeg|';
            $config['overwrite'] = True;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload($field)) {
                $response['status'] = 'error';

                if(!$this->upload->is_allowed_filetype()) {
                    $response['error'] = "The file type you are attempting to upload is not allowed.";
                } else {
                    $response['error'] = $this->upload->display_errors();
                }

            } else {
                $upload_data = $this->upload->data();
                $response = array(
                    'status' => 'success',
                    'file' => $upload_path.$upload_data['file_name']
                );
            }

        }

        return $response;
    }
    
    function sendMail($to, $subject, $message, $bcc = '', $attachment = '', $cc = '') {
        $this->load->library('email');
        $this->email->clear(TRUE);
        
        $this->email->from('noreply@lge.com', 'LG OQIS');
        $this->email->to($to);
        $this->email->subject($subject);
        
        if(!empty($bcc)) {
            $this->email->bcc($bcc);
        }
        
        if(!empty($cc)) {
            $this->email->cc($cc);
        }
        
        if(!empty($attachment)) {
            $this->email->attach($attachment);
        }

        $this->email->message($message);

        return $this->email->send();
    }
    
    public function send_sms($to, $sms) {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        $message = urlencode($sms);

        /* //Prepare you post parameters
        $postData = array(
            'user' => 'Lgelectronic',
            'password' => 'Sid2014!',
            'sender' => $senderId,
            'SMSText' => $message,
            'GSM' => $to
        ); */

        //API URL
        $url="http://193.105.74.58/api/v3/sendsms/plain?user=".$user."&password=".$password."&sender=".$sender."&SMSText=".$message."&GSM=".$to;
        //echo $url;
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $output = curl_exec($ch);

        $flag = true;
        //Print error if any
        if(curl_errno($ch))
        {
            $flag = false;
        }
        //echo $flag;exit;
        curl_close($ch);
        return $flag;
    }
    
    public function send_sms_redirect($to, $sms) {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        $message = urlencode($sms);

        /* //Prepare you post parameters
        $postData = array(
            'user' => 'Lgelectronic',
            'password' => 'Sid2014!',
            'sender' => $senderId,
            'SMSText' => $message,
            'GSM' => $to
        ); */

        //API URL
        $url="http://193.105.74.58/api/v3/sendsms/plain?user=".$user."&password=".$password."&sender=".$sender."&SMSText=".$message."&GSM=".$to;
        //echo $url;
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $output = curl_exec($ch);

        $flag = true;
        //Print error if any
        if(curl_errno($ch))
        {
            $flag = false;
        }
        //echo $flag;exit;
        curl_close($ch);
        //return $flag;
        redirect($_SERVER['HTTP_REFERER']);
    }
}