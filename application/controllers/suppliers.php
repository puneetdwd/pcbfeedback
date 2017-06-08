<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Suppliers extends Admin_Controller {

    public function __construct() {

        parent::__construct();



        //render template

        $this->template->write('title', 'SQIM | '.$this->user_type.' Dashboard');

        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));

        $this->template->write_view('footer', 'templates/footer');



    }

        

    public function index() {

        $this->is_super_admin();

        

        $data = array();

        $this->load->model('Supplier_model');

        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();



        $this->template->write_view('content', 'suppliers/index', $data);

        $this->template->render();

    }

    

    public function add_supplier($supplier_id = '') {

        $this->is_super_admin();

        

        $data = array();

        $this->load->model('Supplier_model');

        

        if(!empty($supplier_id)) {

            $supplier = $this->Supplier_model->get_supplier($supplier_id);

            if(empty($supplier))

                redirect(base_url().'suppliers');



            $data['supplier'] = $supplier;

        }

        

        if($this->input->post()) {

            $post_data = $this->input->post();

			//print_r($post_data);die();

            $post_data['password'] = 'lge@123';

            $response = $this->Supplier_model->add_supplier($post_data, $supplier_id); 

            if($response) {

                $this->session->set_flashdata('success', 'Supplier successfully '.(($supplier_id) ? 'updated' : 'added').'.');

                redirect(base_url().'suppliers');

            } else {

                $data['error'] = 'Something went wrong, Please try again';

            }

        }

       // print_r($data);die();

        $this->template->write_view('content', 'suppliers/add_supplier', $data);

        $this->template->render();

    }

    

    public function upload_suppliers() {

        $this->is_super_admin();

        

        $data = array();

        $this->load->model('Supplier_model');

        

        if($this->input->post()) {

             

            if(!empty($_FILES['supplier_excel']['name'])) {

                $output = $this->upload_file('supplier_excel', 'suppliers', "assets/uploads/");



                if($output['status'] == 'success') {

                    $res = $this->parse_suppliers($output['file']);

                    

                    if($res) {

                        $this->session->set_flashdata('success', 'Suppliers successfully uploaded.');

                        redirect(base_url().'suppliers');

                    } else {

                        $data['error'] = 'Error while uploading excel';

                    }

                } else {

                    $data['error'] = $output['error'];

                }



            }

        }

        

        $this->template->write_view('content', 'suppliers/upload_suppliers', $data);

        $this->template->render();

    }

    

    public function view() {

        

        $this->load->model('Supplier_model');

        $user = $this->Supplier_model->get_all_inspectors();

        /*if(empty($user)) {

            redirect(base_url().'supplier_dashboard');

        }*/

        $data['users'] = $user;



        $this->template->write_view('content', 'suppliers/view', $data);

        $this->template->render();

    }

	

	public function pcb_view() {

        

        $this->load->model('Supplier_model');

        $user = $this->Supplier_model->get_all_pcbusers();

		

        /*if(empty($user)) {

            redirect(base_url().'supplier_dashboard');

        }*/

		//$data['users'] = '';

        $data['users'] = $user;



        $this->template->write_view('content', 'suppliers/pcb_view', $data);

        $this->template->render();

    }

    

    public function view_inspector($id) {

        

        $this->load->model('Supplier_model');

        $user = $this->Supplier_model->get_inspector($id);

        /*if(empty($user)) {

            redirect(base_url().'supplier_dashboard');

        }*/

        $data['user'] = $user;



        $this->template->write_view('content', 'suppliers/view_supplier_inspector', $data);

        $this->template->render();

    }

    

    public function add_inspector($id = ''){

        

        $data = array();

        

        $this->load->model('Supplier_model');

        

        if(!empty($id)) {

            $user = $this->Supplier_model->get_inspector($id);

            

            if(!$user)

                redirect(base_url().'supplier_dashboard');



            $data['user'] = $user;

            

        }

        

        if($this->input->post()) {

            $this->load->library('form_validation');



            $validate = $this->form_validation;

            //$validate->set_rules('supplier_id', 'Supplier', 'required|xss_clean');

            $validate->set_rules('name', 'Name', 'trim|required|xss_clean');

            $validate->set_rules('email', 'Email', 'trim|required|xss_clean');



            if($validate->run() === TRUE) {

                $post_data = $this->input->post();



                $exists = $this->Supplier_model->is_supplier_inspector_exists($post_data['email'], $id);

                if(!$exists){

                    $post_data['supplier_id'] = $this->id;

                    $user_id = $this->Supplier_model->update_supplier_inspector($post_data, $id);

                    if($user_id) {



                        $this->session->set_flashdata('success', 'Inspector successfully added.');

                        redirect(base_url().'suppliers/view');

                    } else {

                        $data['error'] = 'Something went wrong, Please try again.';

                    }



                } else {

                    $data['error'] = 'Email already exists.';

                }



            } else {

                $data['error'] = validation_errors();

            }

        }



        $this->template->write_view('content', 'suppliers/add_supplier_inspector', $data);

        $this->template->render();

    }

	

	

	public function add_pcb_user($id = ''){

        

        $data = array();

        

        $this->load->model('Supplier_model');

        

        if(!empty($id)) {

            $user = $this->Supplier_model->get_pcb_user($id);

            

            if(!$user)

                redirect(base_url().'supplier_dashboard');



            $data['user'] = $user;

            

        }

        

        if($this->input->post()) {

            $this->load->library('form_validation');



            $validate = $this->form_validation;

            //$validate->set_rules('supplier_id', 'Supplier', 'required|xss_clean');

            $validate->set_rules('name', 'Name', 'trim|required|xss_clean');

            $validate->set_rules('email', 'Email', 'trim|required|xss_clean');



            if($validate->run() === TRUE) {

                $post_data = $this->input->post();

//print_r($post_data);die();

                $exists = $this->Supplier_model->is_supplier_pcb_user_exists($post_data['email'], $id);

                if(!$exists){

                    $post_data['supplier_id'] = $this->id;

                    $user_id = $this->Supplier_model->update_supplier_pcb_user($post_data, $id);

                    if($user_id) {



                        $this->session->set_flashdata('success', 'PCB user successfully added.');

                        redirect(base_url().'suppliers/pcb_view');

                    } else {

                        $data['error'] = 'Something went wrong, Please try again.';

                    }



                } else {

                    $data['error'] = 'Email already exists.';

                }



            } else {

                $data['error'] = validation_errors();

            }

        }



        $this->template->write_view('content', 'suppliers/add_supplier_pcb_user', $data);

        $this->template->render();

    }



    public function status($supplier_id, $status) {

        $this->is_admin_user();

        $this->load->model('Supplier_model');

        

        $up_data = array();

        $up_data['is_active'] = ($status == 'active') ? 1 : 0;

        

        if($status == 'active') { 

            $password = strtoupper(random_string('alnum', 8));

            $up_data['password'] = $password;

        }

        

        

        if($this->Supplier_model->add_supplier($up_data, $supplier_id)) {

            

            if($status) {

                $supplier = $this->Supplier_model->get_supplier($supplier_id);

                $subject = "SQIM Credentials";

                $message = "Dear ".$supplier['name']." ,<br><br>

                Welcome to SQIM, you can login using your email address as username and the password is ".$password." Please change the after login.";

                

                $to = $supplier['email'];

                //$this->sendMail($to, $subject, $message);

            }

            

            $this->session->set_flashdata('success', 'Supplier marked as '.$status);

        } else {

            $this->session->set_flashdata('error', 'Something went wrong, Please try again.');

        }



        redirect(base_url().'suppliers');

    }

    

    public function sp_mappings() {

        $data = array();

        $this->load->model('Product_model');

        $data['products'] = $this->Product_model->get_all_products();

        $data['parts'] = $this->Product_model->get_all_distinct_part_name($this->product_id);

        

        //echo "<pre>"; print_r($data['parts']); exit;

        

        $this->load->model('Supplier_model');

        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();

        

        $filters = $this->input->post() ? $this->input->post() : array() ;

        if($this->input->post()){

            

            $data['part_nums'] = $this->Product_model->get_all_part_numbers_by_part_name($this->input->post('part_name'));

            $data['sp_mappings'] = $this->Supplier_model->get_all_sp_mappings($filters);

        }else{

            $data['part_nums'] = '';

            $data['sp_mappings'] = '';

        }

        

        //echo $this->db->last_query(); exit;



        $this->template->write_view('content', 'suppliers/sp_mappings', $data);

        $this->template->render();

    }

    

    public function add_sp_mapping($sp_mapping_id = '') {

        $data = array();

        $this->load->model('Supplier_model');

        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();

        

        $this->load->model('Product_model');

        $data['products'] = $this->Product_model->get_all_products();

        

        if(!empty($sp_mappings_id)) {

            $sp_mapping = $this->Supplier_model->get_sp_mapping($sp_mapping_id);

            if(empty($sp_mapping))

                redirect(base_url().'sp_mappings');



            $data['sp_mapping'] = $sp_mapping;

        }

        

        if($this->input->post()) {

            $post_data = $this->input->post();

            

            $response = $this->Supplier_model->add_sp_mapping($post_data, $sp_mapping_id); 

            if($response) {

                $this->session->set_flashdata('success', 'Supplier-Part Mapping successfully '.(($sp_mapping_id) ? 'updated' : 'added').'.');

                redirect(base_url().'suppliers/sp_mappings');

            } else {

                $data['error'] = 'Something went wrong, Please try again';

            }

        }

        

        $this->template->write_view('content', 'suppliers/add_sp_mapping', $data);

        $this->template->render();

    }

    

    private function parse_suppliers($file_name) {

        $this->load->library('excel');

        //read file from path

        $objPHPExcel = PHPExcel_IOFactory::load($file_name);

        

        //get only the Cell Collection

        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);

        

        if(empty($arr) || !isset($arr[1])) {

            return FALSE;

        }

        

        $this->load->model('Supplier_model');

        $suppliers = array();

        foreach($arr as $no => $row) {

            if($no == 1)

                continue;

            

            if(!trim($row['A']))

                continue;

            

            $temp = array();

            $temp['supplier_no']    = trim($row['A']);

            $temp['full_name']      = trim($row['B']);

            $temp['name']           = trim($row['C']);

            $temp['email']          = trim($row['D']);

            

            $cost = $this->config->item('hash_cost');

            $temp['password'] = password_hash(SALT .'lge@123', PASSWORD_BCRYPT, array('cost' => $cost));

            

            $temp['created']        = date("Y-m-d H:i:s");

            

            $exists = $this->Supplier_model->get_supplier_by_code($temp['supplier_no']);

            if($exists) {

                $this->Supplier_model->add_supplier($temp, $exists['id']);

            } else {

                $suppliers[]        = $temp;

            }

        }



        if($suppliers) {

            $this->Supplier_model->insert_suppliers($suppliers);

        }

        

        return TRUE;

    }

    

    public function inspector_status($id, $status) {

        $this->load->model('Supplier_model');

        if($this->Supplier_model->change_inspector_status($id, $status)) {

            $this->session->set_flashdata('success', 'User marked as '.$status);

        } else {

            $this->session->set_flashdata('error', 'Something went wrong, Please try again.');

        }



        redirect(base_url().'suppliers/view');

    }

	public function pcb_save_data() {

		$postData=$this->input->post();

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->insertPCBUserData($postData);

		

    }

	public function supplier_save_data() {

		$postData=$this->input->post();

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->insertSupplierUserData($postData);

		

    }

	

	public function lg_user_save_data() {

		$postData=$this->input->post();

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->insertLGUserData($postData);

		

    }

	

	public function lg_repair_user_save_data() {

		$postData=$this->input->post();

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->insertLGRepairUserData($postData);

		

    }

	public function get_all_pcb_data() {

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_all_pcb_data();

		echo json_encode($responseData);

    }

	

	public function get_all_supplier_data() {

		$this->load->model('Supplier_model');
         //die('d');
		$responsePrefix=$this->Supplier_model->get_all_supplier_data_prefix($this->session->userdata('id')); 
		foreach ($responsePrefix as $responsePrefixs) 
		{
			$pref = $responsePrefix['suffixVal'];
		}
		 
		$responseData=$this->Supplier_model->get_all_supplier_data($pref);

		echo json_encode($responseData);

    }

       public function get_selected_all_supplier_data() {

		$this->load->model('Supplier_model');
//die('d');
        $responsePrefix=$this->Supplier_model->get_all_supplier_data_prefix($this->session->userdata('id')); 
		foreach ($responsePrefix as $responsePrefixs) 
		{
			$pref = $responsePrefix['suffixVal'];
		}
		
		$responseData=$this->Supplier_model->get_selected_all_supplier_data($pref);

		echo json_encode($responseData);

    }
	

	public function get_lg_data() {

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_lg_data();

		echo json_encode($responseData);

    }

	public function get_all_lg_user_data() {

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_all_lg_user_data();

		echo json_encode($responseData);

    }
	
	public function get_all_user_data_total() {

	
                $this->load->model('Supplier_model');
		$responseData=$this->Supplier_model->get_all_user_data_total();
                  
		echo json_encode($responseData);

    }
	

	public function get_selected_lg_user_data() {

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_selected_lg_user_data();

		echo json_encode($responseData);

    }

	public function get_all_lg_repair_user_data() {

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_all_lg_repair_user_data();

		echo json_encode($responseData);

    }

	public function upload_supplier_image($serialno) {

		

		/*print_r($_POST);

		print_r($this->session->userdata);   

		print_r($_FILES);*/

		$this->load->model('Supplier_model');

		$target_dir = "upload/images/LG/".$this->session->userdata('user_type')."/".$this->session->userdata('id')."/".$serialno."/report/";

		//$target_file = $target_dir . basename($_FILES["file"]["name"]);

		$uploadedfile_basename=basename($_FILES["file"]["name"]);

		$uploadedfile_filtered=str_replace(array('-', ',',' ','(',')','[',']','{','}','<','>','?','/',':','+','\\'), '' , $uploadedfile_basename);

		$filename=time().$uploadedfile_filtered;

		$target_file = $target_dir . $filename;

		$uploadOk = 1;

		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if(isset($_FILES["file"])){

			$check = $_FILES["file"]["size"];

			if($check !== false) {

				//echo "File is an image - " . $check["mime"] . ".";

				$uploadOk = 1;

			} else {

				//echo "File is not an image.";

				$uploadOk = 0;

			}	

		}

		if (file_exists($target_file)) {

			//echo "Sorry, file already exists.";

			$uploadOk = 0;

		}

		// Check file size

		if ($_FILES["file"]["size"] > 500000) {

			//echo "Sorry, your file is too large.";

			$uploadOk = 0;

		}

		// Allow certain file formats

		if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"

		|| $imageFileType == "gif" ) {

			//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

			$uploadOk = 0;

		}
//echo $uploadOk;die();
		if ($uploadOk == 0) {

			echo json_encode($uploadOk);

			//echo "Sorry, your file was not uploaded.";

			// if everything is ok, try to upload file

		} else {

			if (!file_exists($target_dir)) {

				mkdir($target_dir, 0777, true);

			}   

			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

				

				//$filename=$_FILES["file"]["name"];

				$uid=$this->session->userdata('id');

				$uType=$this->session->userdata('user_type');

				$responseData=$this->Supplier_model->upload_supplier_report_image($filename,$serialno,$uid);

				//echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

				if($responseData){

					echo json_encode($uploadOk);

				}

				else{

					$uploadOk=0;

					echo json_encode($uploadOk);

				}

			} else {

				echo json_encode($uploadOk);

				//echo "Sorry, there was an error uploading your file.";

			}

		}

    }

	

	public function upload_repair_user_image($serialno) {

		

		/*print_r($_POST);

		print_r($this->session->userdata);   

		print_r($_FILES);*/

		$this->load->model('Supplier_model');

		$target_dir = "upload/images/LGREPAIR/".$serialno."/photo/";

		$uploadedfile_basename=basename($_FILES["file"]["name"]);

		$uploadedfile_filtered=str_replace(array('-', ',',' ','(',')','[',']','{','}','<','>','?','/',':','+','\\'), '' , $uploadedfile_basename);

		$filename=time().$uploadedfile_filtered;

		$target_file = $target_dir . $filename;

		$uploadOk = 1;

		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if(isset($_FILES["file"])){

			$check = $_FILES["file"]["size"];

			if($check !== false) {

				//echo "File is an image - " . $check["mime"] . ".";

				$uploadOk = 1;

			} else {

				//echo "File is not an image.";

				$uploadOk = 0;

			}	

		}

		if (file_exists($target_file)) {

			//echo "Sorry, file already exists.";

			$uploadOk = 0;

		}

		// Check file size

		if ($_FILES["file"]["size"] > 500000) {

			//echo "Sorry, your file is too large.";

			$uploadOk = 0;

		}

		// Allow certain file formats

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"

		&& $imageFileType != "gif" ) {

			//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

			$uploadOk = 0;

		}

		if ($uploadOk == 0) {

			echo json_encode($uploadOk);

			//echo "Sorry, your file was not uploaded.";

			// if everything is ok, try to upload file

		} else {

			if (!file_exists($target_dir)) {

				mkdir($target_dir, 0777, true);

			}   

			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

				$uid=$this->session->userdata('id');

				$uType=$this->session->userdata('user_type');

				$responseData=$this->Supplier_model->upload_lg_repair_report_image($filename,$serialno,$uid,$uType);

				//echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

				if($responseData){

					echo json_encode($uploadOk);

				}

				else{

					$uploadOk=0;

					echo json_encode($uploadOk);

				}

			} else {

				echo json_encode($uploadOk);

				//echo "Sorry, there was an error uploading your file.";

			}

		}

    }

	

	public function get_uploaded_photo($serialno){

		$this->load->model('Supplier_model');

		$responseData=$this->Supplier_model->get_uploaded_photo($serialno);

		echo json_encode($responseData);

	}

	

	public function get_supplier_uploaded_photo($serialno){

		$this->load->model('Supplier_model');

		$uid=$this->session->userdata('id');

		$responseData=$this->Supplier_model->get_supplier_uploaded_photo($serialno,$uid);

		echo json_encode($responseData);

	}
	
	
	public function delete_supplier_report($serialno,$reportName){
		$this->load->model('Supplier_model');
		$uid=$this->session->userdata('id');
		$target_dir = "upload/images/LG/".$this->session->userdata('user_type')."/".$this->session->userdata('id')."/".$serialno."/report/";
		$fullpath=$target_dir.$reportName;
		$deleteOk=1;
		
		if (file_exists($fullpath)) {
			$deleteOk=1;
			//
		  } else {
			  $deleteOk=0;
		  }
		  if($deleteOk==0){
			 // die('not deleted 21');
			echo json_encode($deleteOk);  
		  }
		  else{
			 if(unlink($fullpath)){
				$responseData=$this->Supplier_model->delete_supplier_report($serialno,$uid,$reportName);
				if($responseData){
					$deleteOk=1;	
					echo json_encode($deleteOk); 
				}
				else{
					$deleteOk=0;
					echo json_encode($deleteOk); 	
				}
			} 
			 else{
				 $deleteOk=0;
				 echo json_encode($deleteOk);  
				//die('not deleted');	 
			}
			 
		  }
		//$postdata=$this->input->post();
		//$responseData=$this->Supplier_model->delete_supplier_report($serialno,$uid,$reportName);

		//echo json_encode($responseData);

	}

}