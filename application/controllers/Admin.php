<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Home');
		$this->load->model('M_Admin');
		if ($this->session->userdata('role_id') != 1 && !$this->session->userdata('is_login')) {
			redirect('Auth/logout','refresh');
		}
	}

	public function index()
	{
		
	}
	public function download_file_template()
	{

		$file_name = 'template.csv';
		$file_url = './uploads/bkt_trf/' . $file_name;
		if(file_exists($file_url)){
		
			header('Content-Type :application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"".$file_name."\""); 
			//readfile($file_url);
			//exit;
		}else{
		
		}
		/*
		exit;*/
	}
		public function insert_master_wilayah()
 	{

 		$config['upload_path'] = './uploads/bkt_trf/';
		$config['allowed_types']        = 'csv';
		$config['max_size']             = 50000;
		$newfilename = 'MASTER_WILAYAH.csv';
 		if(file_exists("./uploads/bkt_trf/".$_FILES["csv_file"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["csv_file"]["name"]);

            }else if(file_exists("./uploads/bkt_trf/".$newfilename)){
            	unlink("./uploads/bkt_trf/".$newfilename);
            }
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('csv_file')){
			$error = array('error' => $this->upload->display_errors());
			echo "masuk sini";
			
		}else{
			$data = array('upload_data' => $this->upload->data());
			
		
		}
		
     	if(file_exists("./uploads/bkt_trf/".$newfilename)){
     		$file = fopen("./uploads/bkt_trf/" . $newfilename, 'r');
        	$row=1;
         	$this->M_Admin->delete_master_wilayah();
      		while (($getData = fgetcsv($file, 10000, ";")) != FALSE)
	        {
 				
 			   if($row == 1){ 
 			   		$row++; 
 			   		continue;
 			   }else{

 			  		 $result=$this->M_Admin->insert_master_wilayah($getData[0],$getData[1],$getData[2],$getData[3],$getData[4]);
 			  		 $row++;
 			   }
                 
	         }
			
	         fclose($file);	
		
  		 	 echo json_encode($result);
     	}else{
     		echo "Data File tidak ada / Gagal Upload";
     	}
        
 	}


 	public function inquiry_master_bank()
 	{

		$this->load->view('Admin/V_Master_bank');	
 	}


 	public function get_data_master_bank()
	{

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $rs = $this->M_Admin->count_data_table_master_bank();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_bank($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
	}
	

	public function delete_master_bank()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->delete_master_bank($data['bank_id']);
		} else {
			echo 0;
		}
	}

	public function save_master_bank()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if ($data['bank_id'] != '') {
				echo $this->M_Admin->update_master_bank($data['bank_name'],$data['bank_id']);
			} else {
				echo $this->M_Admin->insert_master_bank($data['bank_name']);
			}
		} else {
			echo 0;
		}
	}
	public function master_menu()
	{
		$data = '';
		$this->load->view('Admin/V_Master_menu', $data);
	}

	public function get_data_master_menu()
	{
		

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $rs = $this->M_Admin->count_data_table_master_menu();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_menu($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
	}

	public function get_data_master_menu2()
	{
		

		$result =$this->M_Admin->get_data_master_menu2();
		echo json_encode($result);
     
        
	}

	public function save_data_master_menu()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			$result = $this->M_Admin->save_data_master_menu($data['id'], $data['name'], $data['desc'], $data['url'], $data['attr']);
			echo $result;
		} else {
			echo 0;
		}
	}

	public function menu_manage()
	{
		$data = '';
		$this->load->view('Admin/V_Manage_menu', $data);
	}

	public function address_management()
	{
		$data = '';
		$this->load->view('Admin/V_Manage_address', $data);
	}


	public function get_data_menu()
	{


		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $rs = $this->M_Admin->count_data_table_menu();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_menu($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
		//$result = $this->M_Admin->get_data_menu();
		//echo json_encode($result);
	}

	public function get_data_menu_detail($menu_id)
	{
		$result = '';
		if ($menu_id != 'X') {
			$result = $this->M_Admin->get_data_menu_detail($menu_id);
		}
		echo json_encode($result);
	}

	public function save_data_detail_menu()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->save_data_detail_menu($data['det_id'], $data['menu_id'], $data['master_id']);
		} else {
			echo 0;
		}
	}

	public function delete_menu_detail()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->delete_menu_detail($data['det_id']);
		} else {
			echo 0;
		}
	}

	public function get_data_role()
	{
		$result = $this->M_Admin->get_data_role();
		echo json_encode($result);
	}

	public function delete_menu()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->delete_menu($data['menu_id']);
		} else {
			echo 0;
		}
	}

	public function save_data_menu()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if ($data['menu_id'] != '') {
				echo $this->M_Admin->update_data_menu($data['menu_id'], $data['role_id'], $data['is_detail'], $data['name'], $data['desc'], $data['master_id']);
			} else {
				echo $this->M_Admin->insert_data_menu($data['menu_id'], $data['role_id'], $data['is_detail'], $data['name'], $data['desc'], $data['master_id']);
			}
		} else {
			echo 0;
		}
	}

	public function role_manage()
	{
		$data = '';
		$this->load->view('Admin/V_Master_role', $data);
	}

	public function get_data_master_role()
	{
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $rs = $this->M_Admin->count_data_table_master_role();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_role($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
	}


	public function save_master_role()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if ($data['role_id'] != '') {
				echo $this->M_Admin->update_master_role($data['role_id'], $data['role_name'], $data['role_desc']);
			} else {
				echo $this->M_Admin->insert_master_role($data['role_name'], $data['role_desc']);
			}
		} else {
			echo 0;
		}
	}

	public function user_manage()
	{
		$data = '';
		$this->load->view('Admin/V_Master_user', $data);
	}


	public function get_data_master_user()
	{
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;


        $nik= isset($_POST['nik']) ? $_POST['nik'] : '';
        $username= isset($_POST['username']) ? $_POST['username'] : '';
        $cabang= isset($_POST['cabang']) ? $_POST['cabang'] : '';
        $role= isset($_POST['role']) ? $_POST['role'] : '';

        if($nik ==''){
        	$where_nik=null;
        }else{
            $where_nik='AND SU."NIK" LIKE (\'%'.$nik.'%\')';
        }

        if($username==''){
        	$where_nama=null;
        }else{
        	
            $where_nama='AND UPPER(SU."USERNAME") LIKE upper(\'%'.$username.'%\')';
        }

        if($cabang ==''){
        	$where_cabang=null;
        }else{
            $where_cabang='AND SU."BRANCH_ID" = \''.$cabang.'\'';
        }


        if($role ==''){
        	$where_role=null;
        }else{
            $where_role='AND SU."ROLE_ID" = \''.$role.'\'';
        }
        $wheretambahan=$where_nik.' '.$where_nama.' '.$where_cabang.' '.$where_role;
        $rs = $this->M_Admin->count_data_table_master_user($wheretambahan);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_user($page,$rows,$wheretambahan);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);

	}


	   public function  get_data_log_no_bbt()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;

        $tgl_bbt= isset($_POST['tgl_log_no_bbt']) ? $_POST['tgl_log_no_bbt'] : '';
       
        if($tgl_bbt == ""){
            $where_tgl_bbt_ulok=null;
            $where_tgl_bbt_to=null;
        }else{
            $where_tgl_bbt_ulok='AND utx."LAST_UPDATE_DATE"::date = \''.$tgl_bbt.'\'';
            $where_tgl_bbt_to='AND utx."LAST_UPDATE_DATE"::date = \''.$tgl_bbt.'\'';
        }



        $rs = $this->M_Ulok->count_data_table_log_no_bbt($where_tgl_bbt_ulok,$where_tgl_bbt_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_log_no_bbt($page,$rows,$where_tgl_bbt_ulok,$where_tgl_bbt_to);
        $items = array();

                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }
	public function activated_user()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			$data['flag'] = $data['flag'] == 'Y' ? 'N' : 'Y';
			echo $this->M_Admin->activated_user($data['user_id'], $data['flag']);
		} else {
			echo 0;
		}
	}

	public function reset_password()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->reset_password($data['user_id']);
		} else {
			echo 0;
		}
	}


	public function get_data_branch()
	{
		$result = $this->M_Admin->get_data_branch();
		echo json_encode($result);
	}




	public function save_user()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
			if ($data['user_id'] != '') {
				echo $this->M_Admin->update_data_user($data['user_id'], $data['branch_id'], $data['role_id'], $data['nik'],$data['email'],$data['username'],$data['nama']);
			} else {
				echo $this->M_Admin->insert_data_user($data['branch_id'], $data['role_id'], $data['nik'],$data['email'],$data['username'],$data['nama']);
			}
		} else {
			echo 0;
		}
	}
	//region
	public function region_manage()
	{
		$this->load->view('Admin/V_Master_region');
	}
	public function save_master_region()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
				if($data['region_id'] ==''){
					echo $this->M_Admin->insert_master_region($data['region_code'], $data['region_name']);
				}else{
					if($this->M_Admin->validate_update_master_region($data['region_code'],$data['region_name'],$data['region_id'])->hitung=='0')
					{
						echo $this->M_Admin->update_master_region($data['region_code'], $data['region_name'],$data['region_id']);
				
					}else{
						echo 0;
					}
				}
		} else {
			echo 0;
		}
	}
	public function get_data_master_region()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $rs = $this->M_Admin->count_data_table_master_region();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_region($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);

	}
	public function get_data_master_region_branch()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $rs = $this->M_Admin->count_data_table_master_region_branch();
        $result["total"] = $rs->hitung;
        $rs = $this->M_Admin->get_data_master_region_branch($page,$rows);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
	}

	public function get_data_region()
	{
		$result = $this->M_Admin->get_data_region();
		echo json_encode($result);
	}

	public function delete_region()
	{
		
		if ($this->input->post()) {
			$data = $this->input->post();

			if($this->M_Admin->cek_region($data['region_id'])->hitung=='0'){
				echo $this->M_Admin->delete_region($data['region_id']);	
			}else{
				echo 0;
			}
			
		} else {
			echo 0;
		}
	}
	public function get_data_branch_available()
	{
		$result = $this->M_Admin->get_data_branch_available();
		echo json_encode($result);
	}
	public function save_region_branch()
	{
		if ($this->input->post()) {
			$data = $this->input->post();
				if($data['region_branch_id']==''){
					echo $this->M_Admin->insert_region_branch($data['region'], $data['branch']);		
				} else{

					echo $this->M_Admin->update_region_branch($data['region'],$data['branch'],$data['region_branch_id']);
				}
			
		} else {
			echo 0;
		}
	}
	public function delete_region_branch()
	{
		
		if ($this->input->post()) {
			$data = $this->input->post();
			echo $this->M_Admin->delete_region_branch($data['region_branch_id']);		
		} else {
			echo 0;
		}
	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */