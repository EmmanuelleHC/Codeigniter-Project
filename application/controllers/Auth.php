<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Auth');
	}

	public function index()
	{
		$data['header'] = $this->load->view('Auth/V_Header', '', true);
		$data['footer'] = $this->load->view('Auth/V_Footer', '', true);
		$this->load->view('Auth/V_Login', $data);
	}

	public function create_sess()
	{
		$data = $this->input->post();
		if ($data) {

			if($data['nik']!='' && $data['password'] !=''){
				if ($this->M_Auth->get_data_sess($data['nik'], $data['password'])) {

				$user_data = $this->M_Auth->get_data_sess($data['nik'], $data['password']);
				$array = array(
					'is_login' => true,
					'user_id' => $user_data->USER_ID,
					'nik' => $user_data->NIK,
					'username' => $user_data->USERNAME,
					'role_id' => $user_data->ROLE_ID,
					'branch_id' => $user_data->BRANCH_ID,
					'branch_code' => $user_data->BRANCH_CODE,
					'active_flag' => $user_data->ACTIVE_FLAG,
					'reset_flag' => $user_data->RESET_FLAG,
					'branch_name' => $user_data->BRANCH_NAME
				);

				if ($user_data->ACTIVE_FLAG == 'N') {
					$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Inactive user.</p>');
					redirect(base_url().'Auth','refresh');
				}

				$this->session->set_userdata($array);
				if ($user_data->RESET_FLAG == 'Y') {
					redirect(base_url().'Home','refresh');
				}else{
					redirect(base_url().'Auth/reset_password','refresh');
				}
			} else {
				$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Invalid Username or Password.</p>');
				redirect(base_url().'Auth','refresh');
				}
			}else{
				$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Invalid Username or Password.</p>');
				redirect(base_url().'Auth','refresh');
			}
			
		} else {
			$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Invalid Username or Password.</p>');
			redirect(base_url().'Auth','refresh');
		}
	}

	public function reset_password()
	{
		$data['header'] = $this->load->view('Auth/V_Header', '', true);
		$data['footer'] = $this->load->view('Auth/V_Footer', '', true);
		$this->load->view('Auth/V_Reset_pass', $data);
	}

	public function update_newpass()
	{
		$data = $this->input->post();
		if ($data) {
			$cek_pass = $this->M_Auth->check_pass($data['curr_password'],$this->session->userdata('user_id'));
			if ($cek_pass > 0) {
				if ($data['new_password'] == $data['re_password']) {
					if (strlen($data['new_password']) > 5) {
						if ($this->M_Auth->change_password($data['new_password'],$this->session->userdata('user_id')) > 0) {
							$this->session->set_userdata('reset_flag','Y');
							redirect(base_url().'Home','refresh');
						} else {
							$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Change password failed.</p>');
							redirect(base_url().'Auth/reset_password','refresh');
						}
					}else{
						$this->session->set_flashdata('msg', '<p align="center" style="color:red;">New Password must longer than 5 characters.</p>');
						redirect(base_url().'Auth/reset_password','refresh');
					}
				}else{
					$this->session->set_flashdata('msg', '<p align="center" style="color:red;">New Password and Re-type doesn\'t match.</p>');
					redirect(base_url().'Auth/reset_password','refresh');
				}
			}else{
				$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Invalid current password.</p>');
				redirect(base_url().'Auth/reset_password','refresh');
			}
		} else {
			$this->session->set_flashdata('msg', '<p align="center" style="color:red;">Change password failed.</p>');
			redirect(base_url().'Auth/reset_password','refresh');
		}
	}

	public function logout()
	{
		if ($this->session->userdata('is_login')) {
			$this->session->sess_destroy();
			redirect(base_url().'Auth','refresh');
		}
		else redirect(base_url().'Auth','refresh');
	}



}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */