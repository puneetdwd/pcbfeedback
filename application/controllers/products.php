<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'SQIM | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();

        $this->template->write_view('content', 'products/index', $data);
        $this->template->render();
    }
    
    public function add_product($product_id = '') {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Product_model');
        
        if(!empty($product_id)) {
            $product = $this->Product_model->get_product($product_id);
            if(empty($product))
                redirect(base_url().'products');

            $data['product'] = $product;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Product_model->add_product($post_data, $product_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Product successfully '.(($product_id) ? 'updated' : 'added').'.');
                redirect(base_url().'products');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_product', $data);
        $this->template->render();
    }

    public function parts() {
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        $data['parts'] = $this->Product_model->get_all_product_parts($this->product_id);

        $this->template->write_view('content', 'products/parts', $data);
        $this->template->render();
    }
    
    public function add_product_part($part_id = '') {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        if(!empty($part_id)) {
            $part = $this->Product_model->get_product_part($this->product_id, $part_id);
            if(empty($part))
                redirect(base_url().'products/parts');

            $data['part'] = $part;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['product_id'] = $product['id'];
            
            $response = $this->Product_model->update_product_part($post_data, $part_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Product part successfully '.(($part_id) ? 'updated' : 'added').'.');
                redirect(base_url().'products/parts');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_product_part', $data);
        $this->template->render();
    }

    public function upload_product_parts() {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($this->product_id);
        if(empty($product))
            redirect(base_url().'products');
        
        $data['product'] = $product;
        
        if($this->input->post()) {
             
            if(!empty($_FILES['parts_excel']['name'])) {
                $output = $this->upload_file('parts_excel', 'product_parts', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_parts($this->product_id, $output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Parts successfully uploaded.');
                        redirect(base_url().'products/parts');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'products/upload_parts', $data);
        $this->template->render();
    }
    
    public function sp_master() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                //$product_id = $this->input->post('product_id');
                $product_id = $this->product_id;
                if(!empty($_FILES['master_excel']['name'])) {
                    $output = $this->upload_file('master_excel', 'sp_master', "assets/masters/");
                    //echo "<pre>"; print_r($output); exit;
                    if($output['status'] == 'success') {
                        //echo "here"; exit;
                        $excel = $this->parse_sp_master($product_id, $output['file']);
                        if($excel) {
                            $this->session->set_flashdata('success', 'Master Successfully uploaded.');
                            redirect(base_url().'suppliers/sp_mappings');
                        } else {
                            $data['error'] = 'Incorrect Excel format. Please check';
                        }
                        
                    } else {
                        //echo "error"; exit;
                        $data['error'] = $output['error'];
                    }

                }
                
            } else {
                $data['error'] = validation_errors();
            }

        }
        
        $this->template->write_view('content', 'products/sp_master', $data);
        $this->template->render();
    }
    
    private function parse_sp_master($product_id, $file_name) {
        //$file_name = 'assets/masters/'.$file_name;
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 4) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $this->load->model('Supplier_model');
        
        $p = '';
        $part_id = '';
        
        $mappings = array();
        
        
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            $row['B'] = str_replace("\n", ' ', $row['B']);
            
            if($p !== trim($row['B']) && !empty($row['B'])) {
                $p = $row['B'];
                
                $exists = $this->Product_model->get_product_part_by_code($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
            }
            
            if(empty($part_id)) {
                continue;
            }
            
            $supplier = array();
            $supplier['supplier_no'] = trim($row['D']);
            $supplier['name'] = trim($row['E']);
            
            $exists = $this->Supplier_model->get_supplier_by_code($supplier['supplier_no']);
            if(empty($exists)) {
                $supplier_id = $this->Supplier_model->add_supplier($supplier, '');
            } else {
                $supplier_id = $exists['id'];
            }
            
            $mapping = array();
            $mapping['supplier_id'] = $supplier_id;
            $mapping['product_id'] = $product_id;
            $mapping['part_id'] = $part_id;
            
            $mappings[] = $mapping;
        }

        if(!empty($mappings)) {
            $this->Supplier_model->insert_sp_mappings($mappings);
            $this->Supplier_model->remove_dups();
        }
        
        return TRUE;
    }
    
    public function delete_product_part($part_id) {
        $this->load->model('Product_model');

        $part = $this->Product_model->get_product_part($this->product_id, $part_id);
        if(empty($part))
            redirect(base_url().'products/parts');
            
        $deleted = $this->Product_model->update_product_part(array('is_deleted' => 1), $part_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Product Part deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'products/parts');
    }

    private function parse_parts($product_id, $file_name) {
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        
        $parts = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            if(!trim($row['A']))
                continue;
            
            $temp = array();
            $temp['product_id']     = $product_id;
            $temp['code']           = trim($row['A']);
            $temp['name']           = trim($row['B']);
            $temp['created']        = date("Y-m-d H:i:s");
            
            $parts[]        = $temp;
        }

        $this->load->model('Product_model');
        $this->Product_model->insert_parts($parts, $product_id);
        
        return TRUE;
    }
    
    public function get_parts_by_product() {
        $data = array('parts' => array());
        
        if($this->input->post('product')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_product_parts($this->input->post('product'));
        }
        
        echo json_encode($data);
    }
    
    public function get_all_product_parts_by_supplier() {
        $data = array('parts' => array());
        
        if($this->input->post('product') && $this->input->post('supplier_id')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->input->post('product'), $this->input->post('supplier_id'));
        }
        
        echo json_encode($data);
    }
    
    public function get_distinct_parts_by_product() {
        $data = array('parts' => array());
        
        if($this->input->post('product')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_distinct_product_parts($this->input->post('product'));
        }
        
        echo json_encode($data);
    }
    
    public function get_part_numbers_by_part_name() {
        $data = array('parts' => array());
        
        if($this->input->post('part_name')) {
            $this->load->model('Product_model');
            $data['part_nums'] = $this->Product_model->get_all_part_numbers_by_part_name($this->input->post('part_name'));
        }
        
        echo json_encode($data);
    }
}