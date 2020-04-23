<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Home');
		if (!$this->session->userdata('is_login')) {
			redirect('Auth/logout','refresh');
		}
	}


	public function index()
	{
		
		$data['header'] = $this->load->view('Home/V_Header', '', true);
		$data['footer'] = $this->load->view('Home/V_Footer', '', true);
		$data['role_id'] = $this->session->userdata('role_id');
		$this->load->view('Home/V_Index', $data);
	}

	public function get_menu()
	{
		$menu_header = $this->M_Home->get_menu($this->session->userdata('role_id'));
		$navigasi = array();
		if ($menu_header) {
			foreach ($menu_header as $mh) {
				$result = array();
				$result['id'] = $mh->MENU_ID;
				$result['text'] = $mh->MENU_NAME;
				$result['iconCls'] = 'icon-ess-menu';
				if($mh->IS_DETAIL == 'N'){
					$result['state'] = 'close';				
					$result['attributes'] = array('url'=>base_url($mh->URL),'width'=>'','height'=>'');
				}else{
					$result['state'] = 'open';
					$result['children'] = $this->get_detail_menu($mh->MENU_ID);
				}
				array_push($navigasi,$result);
			}
		}
		echo json_encode($navigasi);
	}

	public function get_detail_menu($menu_id)
	{
		$menu_detail = $this->M_Home->get_menu_child($menu_id);
		$navigasi = array();
		if ($menu_detail) {
			foreach ($menu_detail as $mh) {
				$result = array();
				$result['id'] = $mh->MENU_DETAIL_ID;
				$result['text'] = $mh->MENU_DETAIL_NAME;
				$result['iconCls'] = 'icon-ess-menu-detail';
				$result['attributes'] = array('url'=>base_url($mh->URL),'width'=>'','height'=>'');
				array_push($navigasi,$result);
			}
		}
		return $navigasi;
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */