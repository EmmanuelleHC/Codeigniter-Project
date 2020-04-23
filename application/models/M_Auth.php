<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends CI_Model {

	public function get_data_sess($nik, $password)
	{
		//$statement = 'SELECT * FROM sys_user WHERE "NIK" = ? AND "PASSWORD" = ? AND "ACTIVE_FLAG" = \'Y\'';
		$statement='SELECT sys_user.*,ulok_master_branch."BRANCH_NAME" FROM sys_user join ulok_master_branch ON ulok_master_branch."BRANCH_ID"=sys_user."BRANCH_ID" WHERE  sys_user."NIK" = ? AND sys_user."PASSWORD" = ? AND sys_user."ACTIVE_FLAG" = \'Y\' ' ;
		return $this->db->query($statement, array($nik, md5($password)))->row();
	}

	public function check_pass($cur_pass, $user_id)
	{
		$statement = 'SELECT * FROM sys_user WHERE "USER_ID" = ? AND "PASSWORD" = ?';
		return $this->db->query($statement, array($user_id, md5($cur_pass)))->num_rows();
	}

	public function change_password($new_pass, $user_id)
	{
		$statement = 'UPDATE sys_user SET "PASSWORD" = ?, "RESET_FLAG" = \'Y\', "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "USER_ID" = ?';
		$this->db->query($statement, array(md5($new_pass), $user_id));
		return $this->db->affected_rows();
	}

}

/* End of file M_Auth.php */
/* Location: ./application/models/M_Auth.php */