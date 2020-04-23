<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model {



	//bank management

	public function get_data_master_bank($page,$rows)
	{
		$page = ($page - 1) * $rows;
		$statement = 'SELECT * FROM ulok_master_bank ORDER BY "BANK_ID"';
		$result['total'] = $this->db->query($statement,array())->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement)->result();
    	return $result;

	}

	public function insert_master_bank($bank_name)
	{
		$statement = 'INSERT INTO ULOK_MASTER_BANK("BANK_NAME","CREATED_DATE","CREATED_BY","LAST_UPDATE_DATE","LAST_UPDATE_BY") VALUES(?,CURRENT_DATE,?,CURRENT_TIMESTAMP,?)';
		$this->db->query($statement, array($bank_name,$this->session->userdata('user_id'),$this->session->userdata('user_id')));
		return $this->db->affected_rows();
	}

	public function update_master_bank($bank_name,$bank_id)
	{
		$statement = 'UPDATE ULOK_MASTER_BANK SET "BANK_NAME" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "BANK_ID" = ?';
		$this->db->query($statement, array($bank_name,$bank_id));
		return $this->db->affected_rows();
	}

	public function delete_master_bank($bank_id)
	{
		$statement='DELETE FROM public.ulok_master_bank where "BANK_ID" = ?';
		$this->db->query($statement,$bank_id);
    	return $this->db->affected_rows();
	}
	public function count_data_table_master_bank()
	{
		$statement='SELECT count(*) as hitung FROM ulok_master_bank ';
		return $this->db->query($statement)->row();
	}

	//end bank management
	public function get_data_master_menu($page,$rows)
	{
		$page = ($page - 1) * $rows;
		$statement='SELECT * FROM SYS_MASTER_MENU ORDER BY "MASTER_MENU_ID"';
		$result['total'] = $this->db->query($statement,array())->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement)->result();
    	return $result;
	}


		public function get_data_master_menu2()
	{
	
		$statement='SELECT * FROM SYS_MASTER_MENU ORDER BY "MASTER_MENU_ID"';
    	$result= $this->db->query($statement)->result();
    	return $result;
	}

	public function delete_master_wilayah()
	{
		$statement='DELETE FROM public.sys_master_wilayah';
		$this->db->query($statement);
    	return $this->db->affected_rows();
	}
	public function insert_master_wilayah($province,$city_kab_name,$kec_sub_district,$kel_village,$postal_code)
	{
	
		$statement='INSERT INTO public.sys_master_wilayah("PROVINCE", "CITY_KAB_NAME","KEC_SUB_DISTRICT", "KEL_VILLAGE", "POSTAL_CODE", "CREATED_DATE")
    		VALUES (?, ?, ?, ?, ?, CURRENT_DATE)';
    	$this->db->query($statement, array($province,$city_kab_name,$kec_sub_district,$kel_village,$postal_code));
    	return $this->db->affected_rows();
	}


	public function count_data_table_master_menu()
	{
		$statement='SELECT count(*) as hitung FROM SYS_MASTER_MENU ';
		return $this->db->query($statement)->row();
	}
	public function save_data_master_menu($id, $name, $desc, $url, $attr)
	{
		if ($id != '') {
			$statement = 'UPDATE SYS_MASTER_MENU SET "MENU_NAME" = ?, "MENU_DESC" = ?, "URL" = ?, "ATTR_ID" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "MASTER_MENU_ID" = ?';
			$this->db->query($statement, array($name, $desc, $url, $attr, $id));
		} else {
			$statement = 'INSERT INTO SYS_MASTER_MENU("MENU_NAME", "MENU_DESC", "URL", "ATTR_ID", "CREATE_DATE", "LAST_UPDATE_DATE") VALUES(?,?,?,?,CURRENT_DATE,CURRENT_TIMESTAMP)';
			$this->db->query($statement, array($name, $desc, $url, $attr));
		}
		return $this->db->affected_rows();
	}

	public function get_data_menu($page,$rows)
	{
		$page = ($page - 1) * $rows;
		$statement = 'SELECT SM.*, SR."ROLE_NAME" FROM SYS_MENU SM, SYS_ROLE SR WHERE SM."ROLE_ID" = SR."ROLE_ID" ORDER BY SM."MENU_ID"';
		$result['total'] = $this->db->query($statement,array())->num_rows();
        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        $result['rows'] = $this->db->query($statement,array())->result();
        return $result;
	}



	public function count_data_table_menu(){
		
		$statement = 'SELECT count(SM."MENU_ID") as hitung FROM SYS_MENU SM ';
		return $this->db->query($statement)->row();
	}
	public function get_data_menu_detail($menu_id)
	{
		$statement = 'SELECT SMD.*, SM."MENU_NAME", SM."ROLE_ID", SR."ROLE_NAME" FROM SYS_MENU_DETAIL SMD, SYS_MENU SM, SYS_ROLE SR WHERE SMD."MENU_ID" = SM."MENU_ID" AND SM."ROLE_ID" = SR."ROLE_ID" AND SM."MENU_ID" = ? ORDER BY SMD."MENU_DETAIL_ID"';
		return $this->db->query($statement, array($menu_id))->result();
	}

	public function save_data_detail_menu($det_id, $menu_id, $master_id)
	{
		$statement_cek='SELECT count(*) as "hitung" FROM sys_menu_detail where "MENU_ID"= ? AND "MASTER_MENU_ID"=?';
		if($this->db->query($statement_cek, array($menu_id,$master_id))->row()->hitung=='0'){
			if ($det_id != '') {
			$statement = 'UPDATE SYS_MENU_DETAIL SET "MENU_ID" = ?, "MASTER_MENU_ID" = ?, "MENU_DETAIL_NAME" = (SELECT "MENU_NAME" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "MENU_DETAIL_DESC" = (SELECT "MENU_DESC" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "URL" = (SELECT "URL" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "ATTR_ID" = (SELECT "ATTR_ID" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "MENU_DETAIL_ID" = ?';
			$this->db->query($statement, array($menu_id, $master_id, $master_id, $master_id, $master_id, $master_id, $det_id));
			return $this->db->affected_rows();
			} else {
			$statement = 'INSERT INTO SYS_MENU_DETAIL ("MENU_ID", "MASTER_MENU_ID", "MENU_DETAIL_NAME", "MENU_DETAIL_DESC", "URL", "ATTR_ID", "CREATE_DATE", "LAST_UPDATE_DATE") VALUES (?,?,(SELECT "MENU_NAME" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "MENU_DESC" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "URL" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "ATTR_ID" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),CURRENT_DATE,CURRENT_TIMESTAMP)';
			$this->db->query($statement, array($menu_id, $master_id, $master_id, $master_id, $master_id, $master_id));
			return $this->db->affected_rows();
			}
		}
		
	}

	public function delete_menu_detail($det_id)
	{
		$statement = 'DELETE FROM SYS_MENU_DETAIL WHERE "MENU_DETAIL_ID" = ?';
		$this->db->query($statement, array($det_id));
		return $this->db->affected_rows();
	}

	public function get_data_role()
	{
		if($this->session->userdata('role_id')=='3' || $this->session->userdata('role_id')=='7'  ){
				$statement = 'SELECT * FROM SYS_ROLE where "ROLE_ID" !=1 AND "ROLE_ID" !=6 ORDER BY "ROLE_ID"';
		}else{
				$statement = 'SELECT * FROM SYS_ROLE ORDER BY "ROLE_ID"';
		}
	
		return $this->db->query($statement)->result();
	}

	public function delete_menu($menu_id)
	{
		$statement = 'DELETE FROM SYS_MENU_DETAIL WHERE "MENU_ID" = ?';
		$statement_2 = 'DELETE FROM SYS_MENU WHERE "MENU_ID" = ?';
		$this->db->query($statement, array($menu_id));
		$this->db->query($statement_2, array($menu_id));
		return $this->db->affected_rows();
	}

	public function insert_data_menu($menu_id, $role_id, $is_detail, $name, $desc, $master_id)
	{
		if ($is_detail == 'Y') {
			$statement = 'INSERT INTO SYS_MENU ("ROLE_ID", "MENU_NAME", "MENU_DESC", "IS_DETAIL", "CREATE_DATE", "LAST_UPDATE_DATE") VALUES(?,?,?,?,CURRENT_DATE,CURRENT_TIMESTAMP)';
			$this->db->query($statement, array($role_id,$name,$desc,$is_detail));
		} else {
			$statement = 'INSERT INTO SYS_MENU ("ROLE_ID", "MASTER_MENU_ID", "MENU_NAME", "MENU_DESC", "URL", "ATTR_ID", "IS_DETAIL", "CREATE_DATE", "LAST_UPDATE_DATE") VALUES(?,?,(SELECT "MENU_NAME" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "MENU_DESC" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "URL" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),(SELECT "ATTR_ID" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?),?,CURRENT_DATE,CURRENT_TIMESTAMP)';
			$this->db->query($statement, array($role_id,$master_id,$master_id,$master_id,$master_id,$master_id,$is_detail));
		}
		return $this->db->affected_rows();
	}

	public function update_data_menu($menu_id, $role_id, $is_detail, $name, $desc, $master_id)
	{
		if ($is_detail == 'Y') {
			$statement = 'UPDATE SYS_MENU SET "ROLE_ID" = ?, "MENU_NAME" = ?, "MENU_DESC" = ?, "URL" = NULL, "ATTR_ID" = NULL, "IS_DETAIL" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP, "MASTER_MENU_ID" = NULL WHERE "MENU_ID" = ?';
			$this->db->query($statement, array($role_id, $name, $desc, $is_detail, $menu_id));
		} else {
			$statement = 'DELETE FROM SYS_MENU_DETAIL WHERE "MENU_ID" = ?';
			$this->db->query($statement, array($menu_id));
			$statement_2 = 'UPDATE SYS_MENU SET "ROLE_ID" = ?, "MENU_NAME" = (SELECT "MENU_NAME" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "MENU_DESC" = (SELECT "MENU_DESC" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "URL" = (SELECT "URL" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "ATTR_ID" = (SELECT "ATTR_ID" FROM SYS_MASTER_MENU WHERE "MASTER_MENU_ID" = ?), "IS_DETAIL" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP, "MASTER_MENU_ID" = ? WHERE "MENU_ID" = ?';
			$this->db->query($statement_2, array($role_id, $master_id, $master_id, $master_id, $master_id, $is_detail, $master_id, $menu_id));
		}
		return $this->db->affected_rows();
	}

	public function get_data_master_role($page,$rows)
	{

		$page = ($page - 1) * $rows;
		$statement = 'SELECT * FROM SYS_ROLE ORDER BY "ROLE_ID"';
		$result['total'] = $this->db->query($statement,array())->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement)->result();
    	return $result;

	
	}


	public function count_data_table_master_role()
	{

		$statement='SELECT count(*) as hitung FROM public.sys_role';
		return $this->db->query($statement)->row();
	}

	public function insert_master_role($role_name, $role_desc)
	{
		$statement = 'INSERT INTO SYS_ROLE("ROLE_NAME", "ROLE_DESC", "CREATE_DATE", "LAST_UPDATE_DATE") VALUES(?,?,CURRENT_DATE,CURRENT_TIMESTAMP)';
		$this->db->query($statement, array($role_name, $role_desc));
		return $this->db->affected_rows();
	}

	public function update_master_role($role_id, $role_name, $role_desc)
	{
		$statement = 'UPDATE SYS_ROLE SET "ROLE_NAME" = ?, "ROLE_DESC" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "ROLE_ID" = ?';
		$this->db->query($statement, array($role_name, $role_desc, $role_id));
		return $this->db->affected_rows();
	}

	public function get_data_master_user($page,$rows,$wheretambahan)
	{
		$page = ($page - 1) * $rows;
		if($this->session->userdata('role_id')=='3'  ){

			$statement = 'SELECT SU.*, SR."ROLE_NAME", UB."BRANCH_CODE"||\' - \'||UB."BRANCH_NAME" "BRANCH" FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" AND ( SU."ROLE_ID" !=1 and SU."ROLE_ID" !=6)   '.$wheretambahan.'  ORDER BY SU."USER_ID"';

		}else if($this->session->userdata('role_id')==1){

			$statement ='SELECT SU.*, SR."ROLE_NAME", UB."BRANCH_CODE"||\' - \'||UB."BRANCH_NAME" "BRANCH" FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" '.$wheretambahan.'  ORDER BY SU."USER_ID"';
		}else{
			$statement = 'SELECT SU.*, SR."ROLE_NAME", UB."BRANCH_CODE"||\' - \'||UB."BRANCH_NAME" "BRANCH" FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB,ulok_region_branch as URB,ulok_master_region UMR WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" AND URB."BRANCH_ID"=SU."BRANCH_ID" AND URB."BRANCH_ID"=UB."BRANCH_ID" AND UMR."REGION_ID"=URB."REGION_ID"   '.$wheretambahan.'  ORDER BY SU."USER_ID"';
		}
		
		
        $result['total'] = $this->db->query($statement,array())->num_rows();
        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        $result['rows'] = $this->db->query($statement,array())->result();
        return $result;

	}

	public function activated_user($user_id, $flag)
	{
		$statement = 'UPDATE SYS_USER SET "ACTIVE_FLAG" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "USER_ID" = ?';
		$this->db->query($statement, array($flag, $user_id));
		return $this->db->affected_rows();
	}

	public function reset_password($user_id)
	{
		$statement = 'UPDATE SYS_USER SET "PASSWORD" = MD5(\'12345\'), "RESET_FLAG" = \'N\', "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP WHERE "USER_ID" = ?';
		$this->db->query($statement, array($user_id));
		return $this->db->affected_rows();
	}

	public function get_data_branch()
	{

		if($this->session->userdata('role_id') =='1' || $this->session->userdata('role_id')=='3' || $this->session->userdata('role_id')=='6'){
			$statement = 'SELECT *, "BRANCH_CODE"||\' - \'||"BRANCH_NAME" "BRANCH" FROM ULOK_MASTER_BRANCH ORDER BY "BRANCH_CODE"';
			return $this->db->query($statement)->result();
		}else{
			$statement = 'SELECT *, "BRANCH_CODE"||\' - \'||"BRANCH_NAME" "BRANCH" FROM ULOK_MASTER_BRANCH where "BRANCH_NAME" != \'HO\' ORDER BY "BRANCH_CODE"';
			return $this->db->query($statement)->result();
		}

	}

	public function update_data_user($user_id, $branch_id, $role_id, $nik, $email,$username,$nama)
	{

		if($branch_id==''){
			$branch_id=NULL;
		}
		$statement = 'UPDATE SYS_USER SET "BRANCH_ID" = ?, "BRANCH_CODE" = (SELECT "BRANCH_CODE" FROM ULOK_MASTER_BRANCH WHERE "BRANCH_ID" = ?), "ROLE_ID" = ?, "NIK" = ?, "EMAIL"=? ,"USERNAME" = ?, "LAST_UPDATE_DATE" = CURRENT_TIMESTAMP,"NAMA"=? ,"REGION_ID"= (select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?)WHERE "USER_ID" = ?';
		$this->db->query($statement, array($branch_id, $branch_id, $role_id, $nik,$email,$username,$nama,$branch_id,$user_id));
		return $this->db->affected_rows();
	}

	public function insert_data_user($branch_id, $role_id, $nik,$email,$username,$nama)
	{

		if($branch_id==''){
			$branch_id=NULL;
		}
		$statement_cek='SELECT count(*) as hitung FROM SYS_USER WHERE "NIK" = ?';

		if($this->db->query($statement_cek,$nik)->row()->hitung==0){
				$statement = 'INSERT INTO SYS_USER("NIK", "USERNAME", "PASSWORD", "ROLE_ID", "BRANCH_ID", "BRANCH_CODE", "ACTIVE_DATE", "ACTIVE_FLAG", "RESET_FLAG", "CREATE_DATE", "LAST_UPDATE_DATE","EMAIL","NAMA","REGION_ID") VALUES (?,?,MD5(\'12345\'),?,?,(SELECT "BRANCH_CODE" FROM ULOK_MASTER_BRANCH WHERE "BRANCH_ID" = ?),CURRENT_DATE,\'Y\',\'N\',CURRENT_DATE,CURRENT_TIMESTAMP,?,?,(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" =?))';
				$this->db->query($statement, array($nik,$username,$role_id,$branch_id,$branch_id,$email,$nama,$branch_id));
				return $this->db->affected_rows();
		}else{
			return 0;
			
		}

		
	}

	//region
	public function insert_master_region($region_code,$region_name)
	{
		$statement = 'INSERT INTO public.ulok_master_region("REGION_CODE", "REGION_NAME", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY")VALUES ( ?, ?, CURRENT_TIMESTAMP, ?,CURRENT_TIMESTAMP, ?)';
		$this->db->query($statement, array($region_code,$region_name,$this->session->userdata('user_id'),$this->session->userdata('user_id')));
		return $this->db->affected_rows();
	}

	public function count_data_table_master_region()
	{

		$statement='SELECT count(*) as hitung FROM public.ulok_master_region';
		return $this->db->query($statement)->row();
	}
	public function count_data_table_master_user($wheretambahan)
	{

		if($this->session->userdata('role_id')=='3'  ){

	
			$statement = 'SELECT count(*) as hitung FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" AND ( SU."ROLE_ID" !=1 and SU."ROLE_ID" !=6)   '.$wheretambahan.' ';

		}else if($this->session->userdata('role_id')=='1'){
			$statement ='SELECT count(*) as hitung FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" '.$wheretambahan.'  ';
		}else
		{
			$statement = 'SELECT count(*) as hitung FROM SYS_USER SU, SYS_ROLE SR, ULOK_MASTER_BRANCH UB,ulok_region_branch as URB,ulok_master_region UMR WHERE SU."ROLE_ID" = SR."ROLE_ID" AND SU."BRANCH_ID" = UB."BRANCH_ID" AND URB."BRANCH_ID"=SU."BRANCH_ID" AND URB."BRANCH_ID"=UB."BRANCH_ID" AND UMR."REGION_ID"=URB."REGION_ID"   '.$wheretambahan.'  ';
		}
	

		return $this->db->query($statement)->row();
	}


	public function get_data_master_region($page,$rows)
	{
		 $page = ($page - 1) * $rows;
    	$statement='SELECT "REGION_ID", "REGION_CODE", "REGION_NAME", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY" FROM public.ulok_master_region';
        $result['total'] = $this->db->query($statement,array())->num_rows();
        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        $result['rows'] = $this->db->query($statement,array())->result();
        return $result;
	}

	public function count_data_table_master_region_branch()
	{
		$statement='SELECT count(*) as hitung FROM public.ulok_region_branch';
		return $this->db->query($statement)->row();
	}
	public function get_data_master_region_branch($page,$rows)
	{
		$page = ($page - 1) * $rows;
    	$statement='SELECT urb."REGION_BRANCH_ID",umr."REGION_NAME",umb."BRANCH_NAME" from ulok_master_region as umr join ulok_region_branch as urb on umr."REGION_ID"=urb."REGION_ID" join ulok_master_branch as umb on urb."BRANCH_ID"=umb."BRANCH_ID"';
        $result['total'] = $this->db->query($statement,array())->num_rows();
        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        $result['rows'] = $this->db->query($statement,array())->result();
        return $result;
	}
	public function get_data_region()
	{
		$statement = 'SELECT *, "REGION_CODE"||\' - \'||"REGION_NAME" "REGION" FROM ULOK_MASTER_REGION ORDER BY "REGION_CODE"';
		return $this->db->query($statement)->result();
	}
	public function delete_region($region_id)
	{
		$statement='DELETE FROM ulok_master_region where "REGION_ID" = ? ';
		$this->db->query($statement, array($region_id));
		return $this->db->affected_rows();

	}
	public function cek_region($region_id)
	{
		$statement='SELECT count(*)  AS  hitung from ulok_region_branch where "REGION_ID"=?';
		return $this->db->query($statement,$region_id)->row();
	}
	public function insert_region_branch($region,$branch)
	{
		$statement = 'INSERT INTO public.ulok_region_branch("REGION_ID", "BRANCH_ID", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY")VALUES ( ?, ?, CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP, ?)';
		$this->db->query($statement, array($region,$branch,$this->session->userdata('user_id'),$this->session->userdata('user_id')));
		return $this->db->affected_rows();
	}

    public function delete_region_branch($region_branch_id)
	{
		$statement='DELETE FROM ulok_region_branch where "REGION_BRANCH_ID"=?';
		$this->db->query($statement, array($region_branch_id));
		return $this->db->affected_rows();

	}

	public function update_region_branch($region,$branch,$region_branch_id)
	{
		$statement='UPDATE public.ulok_region_branch SET "REGION_ID"=?, "BRANCH_ID"=(SELECT "BRANCH_ID" from ulok_master_branch where "BRANCH_NAME" = ?), "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? WHERE  "REGION_BRANCH_ID"=? ';
 		$this->db->query($statement, array(intval($region),$branch,$this->session->userdata('user_id'),$region_branch_id));
		return $this->db->affected_rows();

	}

	public function validate_update_master_region($region_code,$region_name,$region_id)
	{
		$statement='SELECT COUNT(*) as hitung FROM ulok_master_region where ("REGION_CODE"=? or "REGION_NAME" =  ? ) AND "REGION_ID"!= ?';
		return $this->db->query($statement,array($region_code,$region_name,$region_id))->row();

	}
	public function update_master_region($region_code,$region_name,$region_id)
	{
		$statement='UPDATE public.ulok_master_region SET  "REGION_CODE"=?, "REGION_NAME"=?, "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? WHERE "REGION_ID"=?';
		$this->db->query($statement, array($region_code,$region_name,$this->session->userdata('user_id'),$region_id));
		return $this->db->affected_rows();
	
	}

	public function get_data_branch_available()
	{
		$statement = 'SELECT "BRANCH_ID", "BRANCH_CODE"||\' - \'||"BRANCH_NAME" "BRANCH" FROM ULOK_MASTER_BRANCH  WHERE
		 "BRANCH_ID" NOT IN (SELECT "BRANCH_ID" from ulok_region_branch) AND "BRANCH_NAME" !=\'HO\'';
		return $this->db->query($statement)->result();
	}

}

/* End of file M_Admin.php */
/* Location: ./application/models/M_Admin.php */