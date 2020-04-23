<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Home extends CI_Model {

	public function get_menu($role_id)
	{
		$statement = 'SELECT * FROM sys_menu WHERE "ROLE_ID" = ? ORDER BY "MENU_ID" ';
		return $this->db->query($statement, array($role_id))->result();
	}

	public function get_menu_child($menu_id)
	{
		$statement = 'SELECT * FROM sys_menu_detail WHERE "MENU_ID" = ? ORDER BY "MENU_DETAIL_ID"';
		return $this->db->query($statement, array($menu_id))->result();
	}

}

/* End of file M_Home.php */
/* Location: ./application/models/M_Home.php */