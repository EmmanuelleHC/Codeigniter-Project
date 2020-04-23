<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Ulok extends CI_Model {

	public function get_data_bank_all()
	{
		$statement = 'SELECT * FROM ulok_master_bank ORDER BY "BANK_ID"';
		return $this->db->query($statement)->result();
	}

	public function get_data_cabang_all()
	{
		
		if($this->session->userdata('role_id')=='1' or $this->session->userdata('role_id')=='3'){
			$statement='SELECT "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch WHERE "BRANCH_NAME" !=\'HO\'';	
			return $this->db->query($statement)->result();
		}else if($this->session->userdata('role_id')=='4'  ){

			$statement='SELECT umb."BRANCH_ID",umb."BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch  AS umb join ulok_region_branch as urb on urb."BRANCH_ID"= umb."BRANCH_ID" WHERE umb."BRANCH_NAME" !=\'HO\' and urb."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" =?) ';	
			return $this->db->query($statement,$this->session->userdata('branch_id'))->result();

		}else{
			$statement='SELECT "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch WHERE "BRANCH_ID" = ?' ;
			return $this->db->query($statement,$this->session->userdata('branch_id'))->result();
		}
	}

	public function get_data_cabang_all_w_HO()
	{
			$statement='SELECT "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch ';	
			return $this->db->query($statement)->result();
	}

	public function get_data_cabang_all_lpdu()
	{
		
		if($this->session->userdata('role_id')=='1'){
			$statement='SELECT 0  as "BRANCH_ID",\'ALL\' AS "BRANCH" union select "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM ulok_master_branch WHERE "BRANCH_NAME" !=\'HO\' ORDER BY "BRANCH_ID"';
			return $this->db->query($statement)->result();
		}else if($this->session->userdata('role_id')=='3' ){
			$statement='SELECT 0  as "BRANCH_ID",\'ALL\' AS "BRANCH" union select "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM ulok_master_branch WHERE "BRANCH_NAME" !=\'HO\' ORDER BY "BRANCH_ID"';
			return $this->db->query($statement)->result();
		}else if($this->session->userdata('role_id')=='4'  ){

			$statement='SELECT umb."BRANCH_ID",umb."BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch  AS umb join ulok_region_branch as urb on urb."BRANCH_ID"= umb."BRANCH_ID" WHERE umb."BRANCH_NAME" !=\'HO\' and urb."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" =?) ';	
			return $this->db->query($statement,$this->session->userdata('branch_id'))->result();

		}else{
			$statement='SELECT "BRANCH_ID","BRANCH_NAME" AS "BRANCH" FROM  ulok_master_branch WHERE "BRANCH_ID" = ?' ;
			return $this->db->query($statement,$this->session->userdata('branch_id'))->result();
		}
	}
	public function get_data_role()
	{
		$statement='SELECT "ROLE_NAME","ROLE_ID" from sys_role';
		return $this->db->query($statement)->result();
	}
	public function get_data_region_all()
	{
		$statement='SELECT "REGION_ID",/* CONCAT("BRANCH_CODE", ,"BRANCH_NAME")*/ "REGION_NAME" FROM  ulok_master_region';
		return $this->db->query($statement)->result();
	}

	public function getCodeOTP($user_id,$now,$tipe_form){
		$statement='SELECT * FROM sys_ref_num_otp as s where s."USER_ID" = ? and s."USABLE_FLAG" =\'Y\' and ? BETWEEN s."ACTIVE_DATE" and s."INACTIVE_DATE"  and s."TIPE_FORM"=?  ORDER BY s."ACTIVE_DATE" DESC LIMIT 1 ';
		$result['hasil']= $this->db->query($statement,array($user_id,$now,$tipe_form))->row();
		$result['jumlah']= $this->db->query($statement,array($user_id,$now,$tipe_form))->num_rows();
		return $result;
	}



		public function get_all_kab_name($province)
	{
		$statement='select DISTINCT("CITY_KAB_NAME") FROM sys_master_wilayah WHERE "PROVINCE" = ?  ORDER BY "CITY_KAB_NAME" ASC';
    	$result= $this->db->query($statement,array(urldecode($province)))->result();
    	return $result;
     
        	
	}

		public function get_all_kec_name($kabupaten)
	{
		$statement='select DISTINCT("KEC_SUB_DISTRICT") FROM sys_master_wilayah WHERE "CITY_KAB_NAME" = ?  ORDER BY "KEC_SUB_DISTRICT" ASC';
    	$result= $this->db->query($statement,array(urldecode($kabupaten)))->result();
    	return $result;
     
        	
	}
		public function get_all_kel_name($kecamatan)
	{
		$statement='select DISTINCT("KEL_VILLAGE") FROM sys_master_wilayah WHERE "KEC_SUB_DISTRICT" = ?  ORDER BY "KEL_VILLAGE" ASC';
    	$result= $this->db->query($statement,array(urldecode($kecamatan)))->result();
    	return $result;
     
        	
	}

		public function get_all_kdpos($kelurahan)
	{
		$statement='select DISTINCT("POSTAL_CODE") FROM sys_master_wilayah WHERE "KEL_VILLAGE" = ?  ORDER BY "POSTAL_CODE" ASC';
    	$result= $this->db->query($statement,array(urldecode($kelurahan)))->result();
    	return $result;
     
        	
	}

		public function get_all_province()
	{
		$statement='select DISTINCT("PROVINCE") FROM sys_master_wilayah  ORDER BY "PROVINCE" ASC';
    	$result= $this->db->query($statement)->result();
    	return $result;
     
        	
	}
//START BAPP


	  public function get_data_bapp($page,$rows,$where_bapp = NULL)
    {
    	if($this->session->userdata('role_id')=='4'){
    			$page = ($page - 1) * $rows;
    			$statement='SELECT bapp."BAPP_ID",bapp."BAPP_FORM_NUM" AS "BAPP_NUM",bapp."TGL_BAPP",uf."ULOK_FORM_NUM" as "FORM_NUM" FROM ulok_bapp as bapp join ulok_form as uf on  bapp."ULOK_ID"=uf."ULOK_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=uf."BRANCH_ID" where bapp."TIPE_FORM"=\'ULOK\' and uf."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"=?)  '.$where_bapp.'    UNION SELECT bapp."BAPP_ID",bapp."BAPP_FORM_NUM",bapp."TGL_BAPP",tf."TO_FORM_NUM" as "FORM_NUM" FROM ulok_bapp as bapp join to_form  as tf on bapp."ULOK_ID"=tf."TO_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID" = tf."BRANCH_ID" where bapp."TIPE_FORM"=\'TO\' and tf."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"=?)  '.$where_bapp.'   order by "BAPP_ID" desc ';
				$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->num_rows();
        		$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        		$result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->result();
    	}else{
    		$page = ($page - 1) * $rows;
    			$statement='SELECT bapp."BAPP_ID",bapp."BAPP_FORM_NUM" AS "BAPP_NUM",bapp."TGL_BAPP",uf."ULOK_FORM_NUM" as "FORM_NUM" FROM ulok_bapp as bapp join ulok_form as uf on  bapp."ULOK_ID"=uf."ULOK_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=uf."BRANCH_ID" where bapp."TIPE_FORM"=\'ULOK\'   '.$where_bapp.'    UNION SELECT bapp."BAPP_ID",bapp."BAPP_FORM_NUM",bapp."TGL_BAPP",tf."TO_FORM_NUM" as "FORM_NUM" FROM ulok_bapp as bapp join to_form  as tf on bapp."ULOK_ID"=tf."TO_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID" = tf."BRANCH_ID" where bapp."TIPE_FORM"=\'TO\'   '.$where_bapp.'   order by "BAPP_ID" desc ';
				$result['total'] = $this->db->query($statement,array())->num_rows();
        		$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        		$result['rows'] = $this->db->query($statement,array())->result();
    	}
    
        return $result;
    }


    public function getDataBapp($bapp_id)
    {
    	$statement_cek='SELECT "TIPE_FORM" as "tipe_form" FROM ulok_bapp where "BAPP_ID" = ?';
    	$hasil=$this->db->query($statement_cek,$bapp_id)->row();
    	$role_id=5;
    	if($hasil->tipe_form=='ULOK'){
    	
    	$statement='select  DISTINCT branch."BRANCH_NAME",bapp."BAPP_FORM_NUM" AS "BAPP_FORM_NUM",to_char(bapp."TGL_BAPP", \'day\')as "HARI_BAPP",TO_CHAR(bapp."TGL_BAPP",\'YYYY-MM-DD\') AS "TGL_BAPP",(select concat(su."NIK",\'-\',su."NAMA") as "NAMA"  FROM sys_user as su where su."BRANCH_ID"=uf."BRANCH_ID" and su."ROLE_ID"= ?  ),uf."ULOK_FORM_NUM" as "FORM_NUM",uf."ULOK_AMOUNT_SWIPE" AS "AMOUNT_SWIPE" from ulok_bapp as bapp join ulok_form as uf on uf."ULOK_FORM_ID"=bapp."ULOK_ID" join sys_user as su on su."BRANCH_ID"=uf."BRANCH_ID"  join ulok_master_branch as branch on  branch."BRANCH_ID"= uf."BRANCH_ID" where bapp."BAPP_ID" = ? AND bapp."TIPE_FORM"=\'ULOK\' LIMIT 1';
		return $this->db->query($statement,array($role_id,$bapp_id))->row();
    	}else{
    	$statement='Select  DISTINCT branch."BRANCH_NAME",bapp."BAPP_FORM_NUM" AS "BAPP_FORM_NUM",to_char(bapp."TGL_BAPP", \'day\')as "HARI_BAPP",TO_CHAR(bapp."TGL_BAPP",\'YYYY-MM-DD\') AS "TGL_BAPP",(select concat(su."NIK",\'-\',su."NAMA") as "NAMA"  from sys_user as su where su."BRANCH_ID"=tf."BRANCH_ID" AND su."ROLE_ID"=? ),tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_AMOUNT_SWIPE" AS "AMOUNT_SWIPE" from ulok_bapp as bapp join to_form as tf on tf."TO_FORM_ID"=bapp."ULOK_ID" join sys_user as su on su."BRANCH_ID"=tf."BRANCH_ID"  join ulok_master_branch as branch on  branch."BRANCH_ID"= tf."BRANCH_ID" where bapp."BAPP_ID" = ? AND bapp."TIPE_FORM"=\'TO\' LIMIT 1';
		return $this->db->query($statement,array($role_id,$bapp_id))->row();
    	}
    }



      public function count_data_table_bapp($where_bapp)
    {   
    	if($this->session->userdata('role_id')=='4'){
    		$statement='select (SELECT COUNT(bapp."BAPP_ID") FROM ulok_bapp as bapp join ulok_form  as uf on bapp."ULOK_ID"=uf."ULOK_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=uf."BRANCH_ID" where bapp."TIPE_FORM"=\'ULOK\' and uf."REGION_ID"=(select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"=?)  '.$where_bapp.'   )+(SELECT COUNT(bapp."BAPP_ID") FROM ulok_bapp as bapp join to_form as tf on bapp."ULOK_ID"=tf."TO_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=tf."BRANCH_ID"  where bapp."TIPE_FORM"=\'TO\' and tf."REGION_ID"=(select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" =?)  '.$where_bapp.'     ) as "hitung"';
				return $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->row();
    			
    	}else{
    		$statement='select (SELECT COUNT(bapp."BAPP_ID") FROM ulok_bapp as bapp join ulok_form  as uf on bapp."ULOK_ID"=uf."ULOK_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=uf."BRANCH_ID" where bapp."TIPE_FORM"=\'ULOK\'   '.$where_bapp.'   )+(SELECT COUNT(bapp."BAPP_ID") FROM ulok_bapp as bapp join to_form as tf on bapp."ULOK_ID"=tf."TO_FORM_ID" join ulok_master_branch as umb on umb."BRANCH_ID"=tf."BRANCH_ID"  where bapp."TIPE_FORM"=\'TO\'   '.$where_bapp.'     ) as "hitung"';
				return $this->db->query($statement)->row();	
    	}
    
    	
          
    }

    public function cek_ulok_bapp($form_num,$tipe_form){
    	$statement='SELECT * FROM ulok_bapp where "ULOK_ID"=( SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM" = ?) and"TIPE_FORM"= ?';
    	$this->db->query($statement, array($form_num,$tipe_form))->num_rows();

    }
    public function insert_ulok_bapp($ulok_form_num,$tipe_form)
    {

    	$start=1;
		$statement='select COUNT("CURRENT_VALUE") as hitung from sys_sequences where "CATEGORY_NAME"=\'BAPP\'';
		$result1 = $this->db->query($statement)->row()->hitung;
		if($result1==0){
			$start=1;
			$stmt_insert ='INSERT INTO public.sys_sequences("CATEGORY_NAME", "SEQ_YEAR","CURRENT_VALUE", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY")VALUES ( \'BAPP\', date_part(\'YEAR\', now()::date), ?,CURRENT_TIMESTAMP,?, CURRENT_TIMESTAMP, ?)';
				$this->db->query($stmt_insert, array($start, $this->session->userdata('user_id'),$this->session->userdata('user_id')));
			 $this->db->affected_rows();

			$statement2='SELECT CONCAT(\'BAPP/\',(date_part(\'year\',now()::date)),\'/\',RIGHT(CONCAT(\'0000\',coalesce("CURRENT_VALUE",\'000\')),5) )num FROM sys_sequences where "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "CATEGORY_NAME"=\'BAPP\'';
			$result = $this->db->query($statement2)->row();

			$stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'BAPP\'), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'BAPP\'';
			$this->db->query($stmt_update, array($this->session->userdata('user_id')));
			$this->db->affected_rows();
		}else if($result1==1){
				$statement2='SELECT CONCAT(\'BAPP/\',(date_part(\'year\',now()::date)),\'/\',RIGHT(CONCAT(\'0000\',coalesce("CURRENT_VALUE",\'000\')),5) )num FROM sys_sequences where "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "CATEGORY_NAME"=\'BAPP\'';
			 	$result = $this->db->query($statement2)->row();
			$stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'BAPP\'), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'BAPP\'';
				$this->db->query($stmt_update, array($this->session->userdata('user_id')));
			 	$this->db->affected_rows();
			 
		}	
		if($tipe_form=='ULOK'){
	

    	$statement='INSERT INTO public.ulok_bapp("BAPP_FORM_NUM", "TGL_BAPP", "ULOK_ID", "TIPE_FORM","CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE,( SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM" = ?), ?, CURRENT_TIMESTAMP, ?)';
        $this->db->query($statement, array($result->num,$ulok_form_num,$tipe_form,$this->session->userdata('user_id')));
        $this->db->affected_rows();	
        $inserted_id=$this->db->insert_id();

		 return $inserted_id;
    	}else{
    		$statement='INSERT INTO public.ulok_bapp("BAPP_FORM_NUM", "TGL_BAPP", "ULOK_ID", "TIPE_FORM","CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE,( SELECT "TO_FORM_ID" FROM to_form where "TO_FORM_NUM" = ?), ?, CURRENT_TIMESTAMP, ?)';
        $this->db->query($statement, array($result->num,$ulok_form_num,$tipe_form,$this->session->userdata('user_id')));
        $this->db->affected_rows();	
        $inserted_id=$this->db->insert_id();

		 return $inserted_id;
    	}	
   

    }
	//END BAPP
		public function count_data_lpdu($cabang,$region,$periode)
	{
		if($cabang ==''){

		
			$statement4='SELECT(SELECT count(uf."ULOK_FORM_ID") FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"  JOIN ulok_region_branch as urb on urb."BRANCH_ID"= utx."BRANCH_ID" where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS"=\'N\' AND urb."REGION_ID"=? AND utx."LPDU_ID" is NULL)+(SELECT count(tf."TO_FORM_ID") FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" JOIN ulok_region_branch as urb on urb."BRANCH_ID"= utx."BRANCH_ID" where utx."TIPE_FORM"=\'TO\' AND utx."STATUS"=\'N\' AND urb."REGION_ID"=? AND utx."LPDU_ID" is NULL) as "hitung" ';
			$list=$this->db->query($statement4, array($region,$region))->row();
				
			
		}else if($region =='' && $cabang !='0'){
				$statement2='SELECT(SELECT count(uf."ULOK_FORM_ID") FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS"=\'N\' AND uf."BRANCH_ID"=? AND utx."LPDU_ID" is NULL)+(SELECT count(tf."TO_FORM_ID") FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\' AND tf."BRANCH_ID"=?  AND utx."STATUS"=\'N\' AND utx."LPDU_ID" is NULL) as "hitung" ';
				$list=$this->db->query($statement2, array($cabang,$cabang))->row();

				
			
		}else if($region=='' && $cabang =='0'){
			$statement2='SELECT(SELECT count(uf."ULOK_FORM_ID") FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS"=\'N\'  AND utx."LPDU_ID" is NULL)+(SELECT count(tf."TO_FORM_ID") FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\' AND utx."STATUS"=\'N\' AND utx."LPDU_ID" is NULL) as "hitung" ';
				$list=$this->db->query($statement2, array())->row();
		}
		return $list;
	}


	public function count_data_lpdu_ulok($lpdu_id){

			$statement='SELECT count("ULOK_TRX_ID") AS "hitung" from ulok_trx where "LPDU_ID"=? and "TIPE_FORM"=\'ULOK\'';	
			return $this->db->query($statement, array($lpdu_id))->row();
	}


	public function count_data_lpdu_to($lpdu_id){

			$statement='SELECT count("ULOK_TRX_ID") AS "hitung" from ulok_trx where "LPDU_ID"=? and "TIPE_FORM"=\'TO\'';	
			return $this->db->query($statement, array($lpdu_id))->row();
	}


	public function count_data_lduk_ulok($lduk_id){

			$statement='SELECT count("ULOK_TRX_ID") AS "hitung" from ulok_trx where "LDUK_ID"=? and "TIPE_FORM"=\'ULOK\'';	
			return $this->db->query($statement, array($lduk_id))->row();
	}




	public function count_data_lduk_to($lduk_id){

			$statement='SELECT count("ULOK_TRX_ID") AS "hitung" from ulok_trx where "LDUK_ID"=? and "TIPE_FORM"=\'TO\'';	
			return $this->db->query($statement, array($lduk_id))->row();
	}

	public function generate_lpdu($cabang,$region,$periode,$form_num)
	{
		if($cabang==''){
			$statement = 'INSERT INTO public.ulok_lpdu("LPDU_FORM_NUM", "TGL_LPDU",  "REGION_ID", "PERIODE","CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE, ?,?,CURRENT_TIMESTAMP, ?) ';
			$this->db->query($statement, array($form_num,  $region,$periode,$this->session->userdata('user_id')));
			$inserted_id= $this->db->insert_id();
			$statement2='SELECT "BRANCH_ID" FROM ulok_region_branch where "REGION_ID"= ?';
			$list_cabang=$this->db->query($statement2, array($region))->result();

			foreach ($list_cabang as $listnya_cabang) {
			$statement4='SELECT uf."ULOK_FORM_ID" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND uf."BRANCH_ID"=? AND utx."LPDU_ID" is NULL';
			$list=$this->db->query($statement4, array($listnya_cabang->BRANCH_ID))->result();
			$statement5='SELECT tf."TO_FORM_ID" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\' AND tf."BRANCH_ID"=?  AND utx."LPDU_ID" is NULL';
			$list_to=$this->db->query($statement5, array($listnya_cabang->BRANCH_ID))->result();

				foreach ($list as $list_ulok_form_id) {
					$statement3='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'ULOK\'';
					$this->db->query($statement3, array($inserted_id,$this->session->userdata('user_id'),intval($list_ulok_form_id->ULOK_FORM_ID)));
				}	

				foreach ($list_to as $list_to_form_id) {
					$statement6='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'TO\'';
					$this->db->query($statement6, array($inserted_id,$this->session->userdata('user_id'),intval($list_to_form_id->TO_FORM_ID)));
				}	
			}
		}
		if($region=='' && $cabang!='0'){
			$statement = 'INSERT INTO public.ulok_lpdu ("LPDU_FORM_NUM", "TGL_LPDU","BRANCH_ID","PERIODE", "CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE, ?,?, CURRENT_TIMESTAMP, ?) ';

			$this->db->query($statement, array($form_num,$cabang,$periode,$this->session->userdata('user_id')));
			$inserted_id= $this->db->insert_id();
			$statement2='SELECT uf."ULOK_FORM_ID" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND uf."BRANCH_ID"=? AND utx."LPDU_ID" is NULL';
			$list=$this->db->query($statement2, array($cabang))->result();

			$statement4='SELECT tf."TO_FORM_ID" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\' AND tf."BRANCH_ID"=? AND utx."LPDU_ID" is NULL';
			$list_to=$this->db->query($statement4, array($cabang))->result();
			
			foreach ($list as $list_ulok_form_id) {
			$statement3='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'ULOK\'';
				$this->db->query($statement3, array($inserted_id,$this->session->userdata('user_id'),intval($list_ulok_form_id->ULOK_FORM_ID)));
			}

			foreach ($list_to as $list_to_form_id) {
			$statement5='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'TO\'';
				$this->db->query($statement5, array($inserted_id,$this->session->userdata('user_id'),intval($list_to_form_id->TO_FORM_ID)));
			}
			
		}
		if($cabang=='0'){
			$statement = 'INSERT INTO public.ulok_lpdu ("LPDU_FORM_NUM", "TGL_LPDU","BRANCH_ID","PERIODE", "CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE, ?,?, CURRENT_TIMESTAMP, ?) ';

			$this->db->query($statement, array($form_num,$cabang,$periode,$this->session->userdata('user_id')));
			$inserted_id= $this->db->insert_id();
			$statement2='SELECT uf."ULOK_FORM_ID" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS"=\'N\' AND utx."LPDU_ID" is NULL';
			$list=$this->db->query($statement2)->result();

			$statement4='SELECT tf."TO_FORM_ID" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\'  AND utx."STATUS"=\'N\' AND utx."LPDU_ID" is NULL';
			$list_to=$this->db->query($statement4, array($cabang))->result();
			
			foreach ($list as $list_ulok_form_id) {
			$statement3='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'ULOK\'';
				$this->db->query($statement3, array($inserted_id,$this->session->userdata('user_id'),intval($list_ulok_form_id->ULOK_FORM_ID)));
			}

			foreach ($list_to as $list_to_form_id) {
			$statement5='UPDATE public.ulok_trx SET "LPDU_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'TO\'';
				$this->db->query($statement5, array($inserted_id,$this->session->userdata('user_id'),intval($list_to_form_id->TO_FORM_ID)));
			}
			
		}
	
		 $this->db->affected_rows();
		 return $inserted_id;
	}
	public function generate_lduk($cabang,$region,$periode,$form_num)
    {
        if($cabang==''){
            $statement = 'INSERT INTO public.ulok_lduk("LDUK_FORM_NUM", "TGL_LDUK",  "REGION_ID", "PERIODE","CREATED_DATE", "LAST_UPDATE_BY")VALUES ( ?, CURRENT_DATE, ?,?,CURRENT_TIMESTAMP, ?) ';
            $this->db->query($statement, array($form_num,  $region,$periode,$this->session->userdata('user_id')));
            $inserted_id= $this->db->insert_id();
            $statement2='SELECT "BRANCH_ID" FROM ulok_region_branch where "REGION_ID"= ?';
            $list_cabang=$this->db->query($statement2, array($region))->result();

            foreach ($list_cabang as $listnya_cabang) {
            $statement4='SELECT uf."ULOK_FORM_ID" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' AND uf."BRANCH_ID"=? AND utx."STATUS_HO"= \'FINAL-NOK\' AND us."SURVEY_HASIL"=\'NOK\' AND utx."LDUK_ID" is NULL';

            $list=$this->db->query($statement4, array($listnya_cabang->BRANCH_ID))->result();
            
            $statement5='SELECT tf."TO_FORM_ID" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM" =\'TO\' AND tf."BRANCH_ID"=? AND utx."STATUS_HO"=\'FINAL-NOK\' AND utx."LDUK_ID" is NULL';

            $list_to=$this->db->query($statement5, array($listnya_cabang->BRANCH_ID))->result();

                foreach ($list as $list_ulok_form_id) {
                    $statement3='UPDATE public.ulok_trx SET "LDUK_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'ULOK\'';
                    $this->db->query($statement3, array($inserted_id,$this->session->userdata('user_id'),intval($list_ulok_form_id->ULOK_FORM_ID)));
                }   

                foreach ($list_to as $list_to_form_id) {
                    $statement6='UPDATE public.ulok_trx SET "LDUK_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'TO\'';
                    $this->db->query($statement6, array($inserted_id,$this->session->userdata('user_id'),intval($list_to_form_id->TO_FORM_ID)));
                }   
            }
        }
        if($region==''){
            $statement = 'INSERT INTO public.ulok_lduk ("LDUK_FORM_NUM", "TGL_LDUK","BRANCH_ID","PERIODE", "CREATED_DATE", "LAST_UPDATE_BY","REGION_ID")VALUES ( ?, CURRENT_DATE, ?,?, CURRENT_TIMESTAMP, ?,(SELECT "REGION_ID"  FROM ulok_region_branch WHERE "BRANCH_ID"=?)) ';

            $this->db->query($statement, array($form_num,$cabang,$periode,$this->session->userdata('user_id'),$cabang));
            $inserted_id= $this->db->insert_id();

            $statement2='SELECT uf."ULOK_FORM_ID" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\'  AND uf."BRANCH_ID"=?  AND utx."STATUS_HO"=\'FINAL-NOK\' AND us."SURVEY_HASIL"=\'NOK\' AND utx."LDUK_ID" is NULL';
            $list=$this->db->query($statement2, array($cabang))->result();

            $statement4='SELECT tf."TO_FORM_ID" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" join ulok_survey as us on us."ULOK_FORM_ID"= utx."FORM_ID" where utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\' AND utx."STATUS_HO"=\'FINAL-NOK\' AND tf."BRANCH_ID"=?  AND utx."LDUK_ID" is NULL';
            $list_to=$this->db->query($statement4, array($cabang))->result();
            
            foreach ($list as $list_ulok_form_id) {
            $statement3='UPDATE public.ulok_trx SET "LDUK_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'ULOK\'';
                $this->db->query($statement3, array($inserted_id,$this->session->userdata('user_id'),intval($list_ulok_form_id->ULOK_FORM_ID)));
            }

            foreach ($list_to as $list_to_form_id) {
            $statement5='UPDATE public.ulok_trx SET "LDUK_ID"=?, "LAST_UPDATE_DATE"=CURRENT_DATE, "LAST_UPDATE_BY"=? WHERE  "FORM_ID"=? AND  "TIPE_FORM"=\'TO\'';
                $this->db->query($statement5, array($inserted_id,$this->session->userdata('user_id'),intval($list_to_form_id->TO_FORM_ID)));
            }
            
        }
    
         $this->db->affected_rows();
         return $inserted_id;
    }

        public function count_data_lduk($cabang,$region,$periode)
    {
        if($cabang ==''){

        
            $statement4='SELECT(SELECT count(uf."ULOK_FORM_ID") FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"  JOIN ulok_region_branch as urb on urb."BRANCH_ID"= utx."BRANCH_ID" where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS_HO"=\'FINAL-NOK\' AND urb."REGION_ID"=? AND utx."LDUK_ID" is NULL)+(SELECT count(tf."TO_FORM_ID") FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" JOIN ulok_region_branch as urb on urb."BRANCH_ID"= utx."BRANCH_ID" where utx."TIPE_FORM"=\'TO\' AND utx."STATUS_HO"=\'FINAL-NOK\' AND urb."REGION_ID"=? AND utx."LDUK_ID" is NULL) as "hitung" ';
            $list=$this->db->query($statement4, array($region,$region))->row();
                
            
        }else if($cabang !=''){
                $statement2='SELECT(SELECT count(uf."ULOK_FORM_ID") FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'ULOK\' AND utx."STATUS_HO"=\'FINAL-NOK\' AND uf."BRANCH_ID"=? AND utx."LDUK_ID" is NULL)+(SELECT count(tf."TO_FORM_ID") FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID"where utx."TIPE_FORM"=\'TO\' AND tf."BRANCH_ID"=?  AND utx."STATUS_HO"=\'FINAL-NOK\' AND utx."LDUK_ID" is NULL) as "hitung" ';
                $list=$this->db->query($statement2, array($cabang,$cabang))->row();

                
            
        }
        return $list;
    }


    

	public function get_year_period()
	{

		$statement='select date_part(\'year\', "TRX_DATE") as "PERIOD_NAME" from ulok_trx group by date_part(\'year\', "TRX_DATE") ';
		return $this->db->query($statement)->result();
	}
	public function update_data_form_ulok($data)
	{
		$tanggal_form= substr($data['show-ulok-tgl-form'],6,4).'-'.substr($data['show-ulok-tgl-form'],3,2).'-'.substr($data['show-ulok-tgl'],0,2);
		$b_tgl= substr($data['show-ulok-tgl'],6,4).'-'.substr($data['show-ulok-tgl'],3,2).'-'.substr($data['show-ulok-tgl'],0,2);

			if($data['show-ulok-jumlah-unit']){
				$jumlah_unit=$data['show-ulok-jumlah-unit'];
			}else{

				$jumlah_unit=null;
			}
			if($data['show-ulok-jumlah-lantai']){
				$jumlah_lantai=$data['show-ulok-jumlah-lantai'];
			}else{
				$jumlah_lantai=null;
			}
			if($data['show-ulok-lahan-parkir-lain']){
				$lahan_parkir_lain=	$data['show-ulok-lahan-parkir-lain'];
			}else{
				$lahan_parkir_lain=null;
			}
			if($data['show-ulok-status-lokasi-lain']){
				$status_lokasi_lain=$data['show-ulok-status-lokasi-lain'];
			}else{
				$status_lokasi_lain=null;
			}
			if($data['show-ulok-dok-milik-lain']){
				$dok_milik_lain=$data['show-ulok-dok-milik-lain'];
			}else{
				$dok_milik_lain=null;
			}
			if($data['show-ulok-izin-untuk-lain']){
				$izin_untuk_lain=$data['show-ulok-izin-untuk-lain'];
			}else{

				$izin_untuk_lain=null;
			}
			if($data['show-ulok-idm-dekat-ada']){
				$idm_dekat_ada=$data['show-ulok-idm-dekat-ada'];
			}else{
				$idm_dekat_ada=null;
			}
			if($data['show-ulok-pasar-ada']){
				$pasar_ada=$data['show-ulok-pasar-ada'];
			}else{
				$pasar_ada=null;
			}
			if($data['show-ulok-minimarket-ada']){
				$minimarket_ada=$data['show-ulok-minimarket-ada'];
			}else{

				$minimarket_ada=null;
			}
			if($data['show-ulok-bentuk-lok-lain']){
				$bentuk_lok_lain=$data['show-ulok-bentuk-lok-lain'];
			}else{
				$bentuk_lok_lain=null;
			}
		    if($data['show-ulok-kredit']){
		    	$kartukredit=$data['show-ulok-kredit'];
		    }else{

		    	$kartukredit=null;
		    }
		    if($data['show-ulok-narek-pengirim']){
		    	$nama_pengirim=$data['show-ulok-narek-pengirim'];
		    }else{
		    	$nama_pengirim=null;
		    }
			$stmt_form='UPDATE public.ulok_form SET "ULOK_BANK_ID"=?,"ULOK_FORM_DATE"=?, "NAMA"=?, "ALAMAT"=?, "KELURAHAN"=?, "KECAMATAN"=?,"KODYA_KAB"=?, "KODE_POS"=?, "TELP"=?, "EMAIL"=?, "NPWP"=?, "ULOK_ALAMAT"=?,"ULOK_KELURAHAN"=?, "ULOK_KECAMATAN"=?, "ULOK_KODYA_KAB"=?, "ULOK_KODE_POS"=?, "ULOK_BENTUK"=?, "ULOK_UKURAN_PJG"=?, "ULOK_UKURAN_LBR"=?, "ULOK_JML_UNIT"=?,"ULOK_JML_LT"=?, "ULOK_LHN_PKR"=?, "ULOK_LHN_PKR_LN"=?, "ULOK_STATUS_LOK"=?,"ULOK_STATUS_LOK_LN"=?, "ULOK_DOK"=?, "ULOK_DOK_LN"=?, "ULOK_IZIN_BGN"=?, "ULOK_IZIN_UTK"=?, "ULOK_IZIN_UTK_LN"=?, "ULOK_IDM_TDK"=?, "ULOK_IDM_TDK_LN"=?, "ULOK_PASAR"=?, "ULOK_PASAR_LN"=?, "ULOK_MINIMARKET"=?, "ULOK_MINIMARKET_LN"=?, "ULOK_LAMPIRAN"=?, "ULOK_TIPE_BAYAR"=?, "ULOK_AMOUNT"=?, "ULOK_BAYAR_DATE"=?, "ULOK_NO_REK"=?, "ULOK_NAMA_REK"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?,"NO_KTP"=?, "SUMBER_ULOK"=?, "ULOK_CABANG_BANK"=?, "ULOK_AMOUNT_SWIPE"=?, "ULOK_RT_RW"=?, "RT/RW"=?,"ULOK_BENTUK_LOK_LAIN"=?,"ULOK_KARTU_KREDIT"=?,"PROVINSI"=?,"ULOK_PROVINSI"=?,"ULOK_AN_PENGIRIM"=? WHERE "ULOK_FORM_NUM"=? ';
			$result = $this->db->query($stmt_form, array($data['show-ulok-bank'], $tanggal_form, $data['show-ulok-nama-lengkap'], $data['show-ulok-alamat-lengkap'], $data['show-ulok-kelurahan'], $data['show-ulok-kecamatan'], $data['show-ulok-kodya'], $data['show-ulok-kode-pos'], $data['show-ulok-telp'], $data['show-ulok-email'], $data['show-ulok-npwp'], $data['show-ulok-alamat-lok'], $data['show-ulok-kelurahan-lok'], $data['show-ulok-kecamatan-lok'], $data['show-ulok-kodya-lok'], $data['show-ulok-kode-pos-lok'], $data['show-ulok-bentuk-lok'], $data['show-ulok-ukuran-panjang'], $data['show-ulok-ukuran-lebar'], $jumlah_unit, $jumlah_lantai, $data['show-ulok-lahan-parkir'], $lahan_parkir_lain, $data['show-ulok-status-lokasi'], $status_lokasi_lain, $data['show-ulok-dok-milik'], $dok_milik_lain, $data['show-ulok-izin-bangun'], $data['show-ulok-izin-untuk'], $izin_untuk_lain, $data['show-ulok-idm-dekat'], $idm_dekat_ada, $data['show-ulok-pasar'], $pasar_ada, $data['show-ulok-minimarket'], $minimarket_ada, $data['show-ulok-denah'], $data['show-ulok-tipe'], $data['show-ulok-jumlah-masukrek'], $b_tgl, $data['show-ulok-norek'], $data['show-ulok-narek'], $this->session->userdata('user_id'), $data['show-ulok-noktp'],$data['show-ulok-sumber-ulok'],$data['show-ulok-cabang-bank'],$data['show-ulok-jumlah-swipe'],$data['show-ulok-rt-rw-lok'],$data['show-ulok-rt-rw'],$bentuk_lok_lain,$kartukredit,$data['show-ulok-provinsi'],$data['show-ulok-provinsi-lok'],$nama_pengirim,$data['show-ulok-form-no-1']));

			if ($result>0) {
				$tipe_form='ULOK';
				$stmt_trx = 'UPDATE public.ulok_trx SET "BANK_ID"=?,"TRX_DATE"=?, "TRX_NO_REK"=?, "TRX_NAMA_REK"=?, "TRX_AMOUNT"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) and "TIPE_FORM"=?';
				$this->db->query($stmt_trx, array($data['show-ulok-bank'], $b_tgl, $data['show-ulok-norek'], $data['show-ulok-narek'], $data['show-ulok-jumlah-masukrek'], $this->session->userdata('user_id'),$data['show-ulok-form-no-1'],$tipe_form));

				
			}
		
		return $this->db->affected_rows();;
	}
	public function update_data_form_to($data)
    {
        $tanggal_form= substr($data['show-tgl-to-form'],6,4).'-'.substr($data['show-tgl-to-form'],3,2).'-'.substr($data['show-tgl-to-form'],0,2);
        $b_tgl= substr($data['show-tgl-to'],6,4).'-'.substr($data['show-tgl-to'],3,2).'-'.substr($data['show-tgl-to'],0,2);
        if($data['show-to-kredit']){
        	$kartukredit=$data['show-to-kredit'];
        }else{
        	$kartukredit=null;
        }
        if($data['show-alamat-to']){
        	$alamat_lok=$data['show-alamat-to'];
        }else{
        	$alamat_lok=null;
        }
        if($data['show-rt-rw-toko-to']){
        	$rtrw_lok=$data['show-rt-rw-toko-to'];
        }else{
        	$rtrw_lok=null;
        }
        if($data['show-provinsi-to-lok']){
        	$provinsi_lok=$data['show-provinsi-to-lok'];
        }else{
        	$provinsi_lok=null;
        }
      	if($data['show-kodya-to-lok']){
      			$kodya_lok=$data['show-kodya-to-lok'];
      	}else{
      			$kodya_lok=null;
      	}
      	if($data['show-kecamatan-to-lok']){
      		$kecamatan_lok=$data['show-kecamatan-to-lok'];
      	}else{
      		$kecamatan_lok=null;
      	}
      	if($data['show-kelurahan-to-lok']){
      		$kelurahan_lok=$data['show-kelurahan-to-lok'];
      	}else{
      		$kelurahan_lok=null;
      	}
      	if($data['show-kode-pos-to-lok']){
      		$kodepos_lok=$data['show-kode-pos-to-lok'];
      	}else{
      		$kodepos_lok=null;
      	}
      	if($data['show-narek-to-pengirim']){
      		$narek_pengirim=$data['show-narek-to-pengirim'];
      	}else{
      		$narek_pengirim=null;
      	}

            $stmt_form=' UPDATE public.to_form SET "TO_BANK_ID"=?,  "TO_FORM_DATE"=? , "NO_KTP"=?, "NAMA"=?, "ALAMAT"=?, "KELURAHAN"=?, 
       "KECAMATAN"=?, "KODYA_KAB"=?, "KODE_POS"=?, "TELP"=?, "EMAIL"=?, 
       "NPWP"=?, "TO_ALAMAT"=?, "TO_KODE_TOKO"=?, "TO_NAMA_TOKO"=? , 
        "TO_GOOD_WILL"=? , 
       "TO_PPN"=?, "TO_TOTAL"=?, "TO_TIPE_BAYAR"=?, "TO_AMOUNT"=?, "TO_AMOUNT_SWIPE"=?, 
       "TO_BAYAR_DATE"=? ,"TO_NO_REK"=?, "TO_NAMA_REK"=?, "TO_CABANG_BANK"=?, 
        "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? , 
        "TO_RT_RW"=?, "RT/RW"=? , "TO_KARTU_KREDIT"=? , 
       "PROVINSI"=?, "TO_PROVINSI"=? , "TO_KODYA_KAB"=?, "TO_KECAMATAN"=?, "TO_KELURAHAN"=?, 
       "TO_KODE_POS"=?,"TO_AN_PENGIRIM"=? WHERE "TO_FORM_NUM"=?';

            $result = $this->db->query($stmt_form, array($data['show-bank-to'],$tanggal_form,$data['show-noktp-to'],$data['show-nama-lengkap-to'],$data['show-alamat-lengkap-to'],$data['show-kelurahan-to'],$data['show-kecamatan-to'],$data['show-kodya-to'],$data['show-kode-pos-to'],$data['show-telp-to'],$data['show-email-to'],$data['show-npwp-to'],$alamat_lok,$data['show-kode-toko-to'],$data['show-nama-toko-to'],$data['show-goodwill-to'],$data['show-ppn-to'],$data['show-total-to'],$data['show-tipe-to'],$data['show-jumlah-masukrek-to'],$data['show-jumlah-swipe-to'],$b_tgl,$data['show-norek-to'],$data['show-narek-to'],$data['show-cabang-bank-to'],$this->session->userdata('user_id'),$rtrw_lok,$data['show-rt-rw-to'],$kartukredit,$data['show-provinsi-to'],$provinsi_lok,$kodya_lok,$kecamatan_lok,$kelurahan_lok,$kodepos_lok,$narek_pengirim,$data['show-form-to-no-1']));
            
            if ($result>0) {
                $tipe_form='TO';
                $stmt_trx = 'UPDATE public.ulok_trx SET "BANK_ID"=?, "TRX_DATE"=?, "TRX_NO_REK"=?, "TRX_NAMA_REK"=?, "TRX_AMOUNT"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) and "TIPE_FORM"=?';
                $this->db->query($stmt_trx, array($data['show-bank-to'],  $b_tgl,$data['show-norek-to'],$data['show-narek-to'],$data['show-jumlah-masukrek-to'],$this->session->userdata('user_id'),$data['show-form-to-no-1'],$tipe_form));

                
            }
        
        return $this->db->affected_rows();;
    }
	public function save_data_form_ulok($data)
	{	
			$tanggal_form= substr($data['f-tgl-form'],6,4).'-'.substr($data['f-tgl-form'],3,2).'-'.substr($data['f-tgl-form'],0,2);
			$b_tgl= substr($data['b-tgl'],6,4).'-'.substr($data['b-tgl'],3,2).'-'.substr($data['b-tgl'],0,2);

			if($data['l-jumlah-unit']){
				$jumlah_unit=$data['l-jumlah-unit'];
			}else{

				$jumlah_unit=null;
			}
			if($data['l-jumlah-lantai']){
				$jumlah_lantai=$data['l-jumlah-lantai'];
			}else{
				$jumlah_lantai=null;
			}
			if($data['l-lahan-parkir-lain']){
				$lahan_parkir_lain=	$data['l-lahan-parkir-lain'];
			}else{
				$lahan_parkir_lain=null;
			}
			if($data['l-status-lokasi-lain']){
				$status_lokasi_lain=$data['l-status-lokasi-lain'];
			}else{
				$status_lokasi_lain=null;
			}
			if($data['l-dok-milik-lain']){
				$dok_milik_lain=$data['l-dok-milik-lain'];
			}else{
				$dok_milik_lain=null;
			}
			if($data['l-izin-untuk-lain']){
				$izin_untuk_lain=$data['l-izin-untuk-lain'];
			}else{

				$izin_untuk_lain=null;
			}
			if($data['l-idm-dekat-ada']){
				$idm_dekat_ada=$data['l-idm-dekat-ada'];
			}else{
				$idm_dekat_ada=null;
			}
			if($data['l-pasar-ada']){
				$pasar_ada=$data['l-pasar-ada'];
			}else{
				$pasar_ada=null;
			}
			if($data['l-minimarket-ada']){
				$minimarket_ada=$data['l-minimarket-ada'];
			}else{

				$minimarket_ada=null;
			}
			if($data['l-bentuk-lok-lain']){
				$bentuk_lok_lain=$data['l-bentuk-lok-lain'];
			}else{
				$bentuk_lok_lain=null;
			}
			if($data['b-narek-pengirim']){
				$nama_pengirim=$data['b-narek-pengirim'];
			}else{
				$nama_pengirim=null;
			}
		 	if($data['b-kredit']){
		 		$kartukredit=$data['b-kredit'];

		 	}else{
		 		$kartukredit=null;
		 	}
		
			$stmt_form='INSERT INTO ulok_form( "ULOK_BANK_ID", "BRANCH_ID", "ULOK_FORM_NUM", "ULOK_FORM_DATE", "NAMA", "ALAMAT", "KELURAHAN", "KECAMATAN","KODYA_KAB", "KODE_POS", "TELP", "EMAIL", "NPWP", "ULOK_ALAMAT", "ULOK_KELURAHAN", "ULOK_KECAMATAN", "ULOK_KODYA_KAB", "ULOK_KODE_POS", "ULOK_BENTUK", "ULOK_UKURAN_PJG", "ULOK_UKURAN_LBR", "ULOK_JML_UNIT", "ULOK_JML_LT", "ULOK_LHN_PKR", "ULOK_LHN_PKR_LN", "ULOK_STATUS_LOK", "ULOK_STATUS_LOK_LN", "ULOK_DOK", "ULOK_DOK_LN", "ULOK_IZIN_BGN", "ULOK_IZIN_UTK", "ULOK_IZIN_UTK_LN", "ULOK_IDM_TDK", "ULOK_IDM_TDK_LN", "ULOK_PASAR", "ULOK_PASAR_LN", "ULOK_MINIMARKET", "ULOK_MINIMARKET_LN", "ULOK_LAMPIRAN","ULOK_TIPE_BAYAR", "ULOK_AMOUNT", "ULOK_BAYAR_DATE", "ULOK_NO_REK", "ULOK_NAMA_REK", "CREATED_BY","LAST_UPDATE_BY","NO_KTP", "SUMBER_ULOK", "ULOK_CABANG_BANK", "ULOK_AMOUNT_SWIPE", "ULOK_RT_RW", "RT/RW","ULOK_BENTUK_LOK_LAIN","ULOK_KARTU_KREDIT","PROVINSI","ULOK_PROVINSI","ULOK_AN_PENGIRIM","REGION_ID")VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?))';



			$result = $this->db->query($stmt_form, array($data['b-bank'], $this->session->userdata('branch_id'), $data['form-num'], $tanggal_form, $data['f-nama-lengkap'], $data['f-alamat-lengkap'], $data['f-kelurahan'], $data['f-kecamatan'], $data['f-kodya'], $data['f-kode-pos'], $data['f-telp'], $data['f-email'], $data['f-npwp'], $data['l-alamat'], $data['l-kelurahan'], $data['l-kecamatan'], $data['l-kodya'], $data['l-kode-pos'], $data['l-bentuk-lok'], $data['l-ukuran-panjang'], $data['l-ukuran-lebar'], $jumlah_unit, $jumlah_lantai, $data['l-lahan-parkir'], $lahan_parkir_lain, $data['l-status-lokasi'], $status_lokasi_lain, $data['l-dok-milik'], $dok_milik_lain, $data['l-izin-bangun'], $data['l-izin-untuk'], $izin_untuk_lain, $data['l-idm-dekat'], $idm_dekat_ada, $data['l-pasar'], $pasar_ada, $data['l-minimarket'], $minimarket_ada, $data['l-denah'], $data['b-tipe'], $data['b-jumlah-masukrek'], $b_tgl, $data['b-norek'], $data['b-narek'], $this->session->userdata('user_id'), $this->session->userdata('user_id'),$data['f-noktp'],$data['f-sumber-ulok'],$data['b-cabang-bank'],$data['b-jumlah-swipe'],$data['l-rt-rw'],$data['f-rt-rw'],$data['l-bentuk-lok-lain'],$kartukredit,$data['f-provinsi'],$data['l-provinsi'],$nama_pengirim,$this->session->userdata('branch_id')));
			 $inserted_id= $this->db->insert_id();

			if ($inserted_id) {
				$tipe_form='ULOK';
				$stmt_trx = 'INSERT INTO ulok_trx ("FORM_ID", "BANK_ID", "BRANCH_ID", "TRX_DATE", "TRX_NO_REK", "TRX_NAMA_REK", "TRX_AMOUNT", "STATUS", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","TIPE_FORM") VALUES(?, ?, ?, ?, ?, ?, ?, \'N\', now(), ?, now(), ?,?)';
				$this->db->query($stmt_trx, array($inserted_id, $data['b-bank'], $this->session->userdata('branch_id'), $b_tgl, $data['b-norek'], $data['b-narek'], $data['b-jumlah-masukrek'], $this->session->userdata('user_id'), $this->session->userdata('user_id'),$tipe_form));

				$stmt_surv = 'INSERT INTO ulok_survey ("ULOK_FORM_ID", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","TIPE_FORM") VALUES(?, now(), ?, now(), ?,?)';
				$this->db->query($stmt_surv, array($inserted_id, $this->session->userdata('user_id'), $this->session->userdata('user_id'),$tipe_form));
			}
		
		return $inserted_id;
	}
	public function save_data_form_to_toko($data)
    {   $tanggal_form= substr($data['f-tgl-to-form'],6,4).'-'.substr($data['f-tgl-to-form'],3,2).'-'.substr($data['f-tgl-to-form'],0,2);
        $b_tgl= substr($data['b-tgl-to'],6,4).'-'.substr($data['b-tgl-to'],3,2).'-'.substr($data['b-tgl-to'],0,2);
        if($data['b-kredit-to']){
        	$b_kredit=$data['b-kredit-to'];
        }else{
        	$b_kredit=null;
        }
        if($data['b-narek-to-pengirim']){
        	$narek_pengirim=$data['b-narek-to-pengirim'];
        }else{
        	$narek_pengirim=null;
        }
            $stmt_form='INSERT INTO to_form ("TO_BANK_ID", "BRANCH_ID", "TO_FORM_NUM", "TO_FORM_DATE","NO_KTP", "NAMA", "ALAMAT", "KELURAHAN", "KECAMATAN", "KODYA_KAB", "KODE_POS", "TELP","EMAIL","NPWP","TO_ALAMAT", "TO_KODE_TOKO","TO_NAMA_TOKO", "TO_ACTUAL_INVESTMENT", "TO_GOOD_WILL","TO_PPN","TO_TOTAL","TO_TIPE_BAYAR","TO_AMOUNT", "TO_AMOUNT_SWIPE", "TO_BAYAR_DATE", "TO_NO_REK", "TO_NAMA_REK","TO_CABANG_BANK","CREATED_BY","LAST_UPDATE_BY","TO_RT_RW","RT/RW","TO_KARTU_KREDIT","PROVINSI","TO_PROVINSI","TO_KODYA_KAB","TO_KECAMATAN","TO_KELURAHAN","TO_KODE_POS","TO_AN_PENGIRIM","REGION_ID")VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?))RETURNING "TO_FORM_ID" ';

            $result = $this->db->query($stmt_form, array($data['b-bank-to'], $this->session->userdata('branch_id'), $data['form-num-to'], $tanggal_form,$data['f-noktp-to'], $data['f-nama-lengkap-to'], $data['f-alamat-lengkap-to'], $data['f-kelurahan-to'], $data['f-kecamatan-to'], $data['f-kodya-to'], $data['f-kode-pos-to'], $data['f-telp-to'], $data['f-email-to'], $data['f-npwp-to'], $data['l-alamat-to'], $data['l-kode-toko-to'], $data['l-nama-toko-to'],$data['l-actual-investment-to'], $data['l-goodwill-to'], $data['l-ppn-to'], $data['l-total-to'], $data['b-tipe-to'], $data['b-jumlah-masukrek-to'], $data['b-jumlah-swipe-to'], $b_tgl, $data['b-norek-to'], $data['b-narek-to'], $data['b-cabang-bank-to'], $this->session->userdata('user_id'), $this->session->userdata('user_id'), $data['l-rt-rw-to'],$data['f-rt-rw-to'],$b_kredit,$data['f-provinsi-to'],$data['l-provinsi-to'],$data['l-kodya-to'],$data['l-kecamatan-to'],$data['l-kelurahan-to'],$data['l-kode-pos-to'],$narek_pengirim,$this->session->userdata('branch_id')))->row();
            $inserted_id= $this->db->insert_id();
            if ($inserted_id) {
                $tipe_form='TO';
                $stmt_trx = 'INSERT INTO ulok_trx ("FORM_ID", "BANK_ID", "BRANCH_ID", "TRX_DATE", "TRX_NO_REK", "TRX_NAMA_REK", "TRX_AMOUNT", "STATUS", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","TIPE_FORM") VALUES(?, ?, ?, ?, ?, ?, ?, \'N\', now(), ?, now(), ?,?)';
                $this->db->query($stmt_trx, array($inserted_id, $data['b-bank-to'], $this->session->userdata('branch_id'), $b_tgl, $data['b-norek-to'], $data['b-narek-to'], $data['b-jumlah-masukrek-to'], $this->session->userdata('user_id'), $this->session->userdata('user_id'),$tipe_form));

                $stmt_surv = 'INSERT INTO ulok_survey ("ULOK_FORM_ID", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","TIPE_FORM") VALUES(?, now(), ?, now(), ?,?)';
				$this->db->query($stmt_surv, array($inserted_id, $this->session->userdata('user_id'), $this->session->userdata('user_id'),$tipe_form));
               

            }
        
        return $inserted_id;
    }
/*
	public function save_data_form_ulok($data)
	{
		if ($data['f-form-id'] != '') {
			$file_path = $data['file_path'] != '' ? '\''.$data['file_path'].'\'' : '"FILE_BUKTI_TRF"';
			$stmt_form = 'UPDATE ulok_form SET "ULOK_BANK_ID" = ?, "ULOK_FORM_DATE" = ?, "NAMA" = ?, "ALAMAT" = ?, "KELURAHAN" = ?, "KECAMATAN" = ?, "KODYA_KAB" = ?, "KODE_POS" = ?, "TELP" = ?, "EMAIL" = ?, "NPWP" = ?, "ULOK_ALAMAT" = ?, "ULOK_KELURAHAN" = ?, "ULOK_KECAMATAN" = ?, "ULOK_KODYA_KAB" = ?, "ULOK_KODE_POS" = ?, "ULOK_BENTUK" = ?, "ULOK_UKURAN_PJG" = ?, "ULOK_UKURAN_LBR" = ?, "ULOK_JML_UNIT" = ?, "ULOK_JML_LT" = ?, "ULOK_LHN_PKR" = ?, "ULOK_LHN_PKR_LN" = ?, "ULOK_STATUS_LOK" = ?, "ULOK_STATUS_LOK_LN" = ?, "ULOK_DOK" = ?, "ULOK_DOK_LN" = ?, "ULOK_IZIN_BGN" = ?, "ULOK_IZIN_UTK" = ?, "ULOK_IZIN_UTK_LN" = ?, "ULOK_IDM_TDK" = ?, "ULOK_IDM_TDK_LN" = ?, "ULOK_PASAR" = ?, "ULOK_PASAR_LN" = ?, "ULOK_MINIMARKET" = ?, "ULOK_MINIMARKET_LN" = ?, "ULOK_LAMPIRAN" = ?, "ULOK_TIPE_BAYAR" = ?, "ULOK_AMOUNT" = ?, "ULOK_BAYAR_DATE" = ?, "ULOK_NO_REK" = ?, "ULOK_NAMA_REK" = ?, "LAST_UPDATE_DATE" = now(), "LAST_UPDATE_BY" = ?, "FILE_BUKTI_TRF" = '.$file_path.' WHERE "ULOK_FORM_ID" = ?';
			$this->db->query($stmt_form, array($data['b-bank'], $data['f-tgl-form'], $data['f-nama-lengkap'], $data['f-alamat-lengkap'], $data['f-kelurahan'], $data['f-kecamatan'], $data['f-kodya'], $data['f-kode-pos'], $data['f-telp'], $data['f-email'], $data['f-npwp'], $data['l-alamat'], $data['l-kelurahan'], $data['l-kecamatan'], $data['l-kodya'], $data['l-kode-pos'], $data['l-bentuk-lok'], $data['l-ukuran-panjang'], $data['l-ukuran-lebar'], $data['l-jumlah-unit'], $data['l-jumlah-lantai'], $data['l-lahan-parkir'], $data['l-lahan-parkir-lain'], $data['l-status-lokasi'], $data['l-status-lokasi-lain'], $data['l-dok-milik'], $data['l-dok-milik-lain'], $data['l-izin-bangun'], $data['l-izin-untuk'], $data['l-izin-untuk-lain'], $data['l-idm-dekat'], $data['l-idm-dekat-ada'], $data['l-pasar'], $data['l-pasar-ada'], $data['l-minimarket'], $data['l-minimarket-ada'], $data['l-denah'], $data['b-tipe'], $data['b-jumlah'], $data['b-tgl'], $data['b-norek'], $data['b-narek'], $this->session->userdata('user_id'), $data['f-form-id']));

			if ($this->db->affected_rows() > 0) {
				$stmt_trx = 'UPDATE ulok_trx SET "BANK_ID" = ?, "BRANCH_ID" = ?, "TRX_DATE" = ?, "TRX_NO_REK" = ?, "TRX_NAMA_REK" = ?, "TRX_AMOUNT" = ?, "LAST_UPDATE_DATE" = now(), "LAST_UPDATE_BY" = ? WHERE "ULOK_TRX_ID" = ? AND "ULOK_FORM_ID" = ?';
				$this->db->query($stmt_trx, array($result->ULOK_FORM_ID, $data['b-bank'], $this->session->userdata('branch_id'), $data['b-tgl'], $data['b-norek'], $data['b-narek'], $data['b-jumlah'], $this->session->userdata('user_id'), $data['f-trx-id'], $data['f-form-id']));
			}
		} else {
			$stmt_form = 'INSERT INTO ulok_form ("ULOK_BANK_ID", "BRANCH_ID", "ULOK_FORM_NUM", "ULOK_FORM_DATE", "NAMA", "ALAMAT", "KELURAHAN", "KECAMATAN", "KODYA_KAB", "KODE_POS", "TELP", "EMAIL", "NPWP", "ULOK_ALAMAT", "ULOK_KELURAHAN", "ULOK_KECAMATAN", "ULOK_KODYA_KAB", "ULOK_KODE_POS", "ULOK_BENTUK", "ULOK_UKURAN_PJG", "ULOK_UKURAN_LBR", "ULOK_JML_UNIT", "ULOK_JML_LT", "ULOK_LHN_PKR", "ULOK_LHN_PKR_LN", "ULOK_STATUS_LOK", "ULOK_STATUS_LOK_LN", "ULOK_DOK", "ULOK_DOK_LN", "ULOK_IZIN_BGN", "ULOK_IZIN_UTK", "ULOK_IZIN_UTK_LN", "ULOK_IDM_TDK", "ULOK_IDM_TDK_LN", "ULOK_PASAR", "ULOK_PASAR_LN", "ULOK_MINIMARKET", "ULOK_MINIMARKET_LN", "ULOK_LAMPIRAN", "ULOK_TIPE_BAYAR", "ULOK_AMOUNT", "ULOK_BAYAR_DATE", "ULOK_NO_REK", "ULOK_NAMA_REK", "CREATED_BY", "LAST_UPDATE_BY", "FILE_BUKTI_TRF") VALUES (?, ?, ?||nextval(\'form_num\'), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING "ULOK_FORM_ID"';
			$result = $this->db->query($stmt_form, array($data['b-bank'], $this->session->userdata('branch_id'), $data['f-form-no'], $data['f-tgl-form'], $data['f-nama-lengkap'], $data['f-alamat-lengkap'], $data['f-kelurahan'], $data['f-kecamatan'], $data['f-kodya'], $data['f-kode-pos'], $data['f-telp'], $data['f-email'], $data['f-npwp'], $data['l-alamat'], $data['l-kelurahan'], $data['l-kecamatan'], $data['l-kodya'], $data['l-kode-pos'], $data['l-bentuk-lok'], $data['l-ukuran-panjang'], $data['l-ukuran-lebar'], $data['l-jumlah-unit'], $data['l-jumlah-lantai'], $data['l-lahan-parkir'], $data['l-lahan-parkir-lain'], $data['l-status-lokasi'], $data['l-status-lokasi-lain'], $data['l-dok-milik'], $data['l-dok-milik-lain'], $data['l-izin-bangun'], $data['l-izin-untuk'], $data['l-izin-untuk-lain'], $data['l-idm-dekat'], $data['l-idm-dekat-ada'], $data['l-pasar'], $data['l-pasar-ada'], $data['l-minimarket'], $data['l-minimarket-ada'], $data['l-denah'], $data['b-tipe'], $data['b-jumlah'], $data['b-tgl'], $data['b-norek'], $data['b-narek'], $this->session->userdata('user_id'), $this->session->userdata('user_id'), $data['file_path']))->row();

			if ($result) {
				$stmt_trx = 'INSERT INTO ulok_trx ("ULOK_FORM_ID", "BANK_ID", "BRANCH_ID", "TRX_DATE", "TRX_NO_REK", "TRX_NAMA_REK", "TRX_AMOUNT", "STATUS", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY") VALUES(?, ?, ?, ?, ?, ?, ?, \'N\', now(), ?, now(), ?)';
				$this->db->query($stmt_trx, array($result->ULOK_FORM_ID, $data['b-bank'], $this->session->userdata('branch_id'), $data['b-tgl'], $data['b-norek'], $data['b-narek'], $data['b-jumlah'], $this->session->userdata('user_id'), $this->session->userdata('user_id')));

				$stmt_surv = 'INSERT INTO ulok_survey ("ULOK_FORM_ID", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY") VALUES(?, now(), ?, now(), ?)';
				$this->db->query($stmt_surv, array($result->ULOK_FORM_ID, $this->session->userdata('user_id'), $this->session->userdata('user_id')));
			}
		}
		return $this->db->affected_rows();
	}
*/
	public function get_nextval_form_num($branch_id)
	{
		$start=1;
		$statement='select COUNT("CURRENT_VALUE") as hitung from sys_sequences where "CATEGORY_NAME"=\'ULOK\'  AND  "BRANCH_ID" =?';
		$result1 = $this->db->query($statement,array($branch_id))->row()->hitung;
		if($result1==0){
			$start=1;
			$stmt_insert ='INSERT INTO public.sys_sequences("CATEGORY_NAME", "SEQ_YEAR", "SEQ_MONTH", "BRANCH_ID", "CURRENT_VALUE", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY")VALUES ( \'ULOK\', date_part(\'YEAR\', now()::date), date_part(\'month\', now()::date), ?,?, CURRENT_TIMESTAMP, ?, CURRENT_DATE,  ?)';
				$this->db->query($stmt_insert, array($branch_id,$start, $this->session->userdata('user_id'),$this->session->userdata('user_id')));
			 $this->db->affected_rows();
			 $statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=?  and "CATEGORY_NAME"=\'ULOK\'';
			 $result = $this->db->query($statement2,$branch_id)->row();
			 $stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'ULOK\' AND "BRANCH_ID" = ?), "SEQ_MONTH" = date_part(\'month\', now()::date), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'ULOK\' AND "BRANCH_ID"=?';
			$this->db->query($stmt_update, array($branch_id,$this->session->userdata('user_id'),$branch_id));
			 $this->db->affected_rows();
		}else if($result1==1){
				$statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=? AND  "CATEGORY_NAME"=\'ULOK\'';
			 	$result = $this->db->query($statement2,$branch_id)->row();
			$stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'ULOK\' AND "BRANCH_ID" = ?), "SEQ_MONTH" = date_part(\'month\', now()::date), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'ULOK\' AND "BRANCH_ID"=?';
				$this->db->query($stmt_update, array($branch_id,$this->session->userdata('user_id'),$branch_id));
			 $this->db->affected_rows();
			 
		}

	
		
		return $result->num;
	//	return $result;
	}
	public function get_nextval_lpdu_form_num()
	{
		$statement='SELECT RIGHT(CONCAT(\'00\',coalesce(COUNT("LPDU_ID"),\'0\')+1),3) num FROM ulok_lpdu  where (date_part(\'month\',"CREATED_DATE"))=(date_part(\'month\',now()::date)) AND (date_part(\'year\',"CREATED_DATE"))=(date_part(\'year\',now()::date))';
		
		$result = $this->db->query($statement)->row();
		return $result->num;	

		
	}
		public function get_nextval_lduk_form_num()
	{
		$statement='SELECT RIGHT(CONCAT(\'00\',coalesce(COUNT("LDUK_ID"),\'0\')+1),3) num FROM ulok_lduk  where (date_part(\'month\',"CREATED_DATE"))=(date_part(\'month\',now()::date)) AND (date_part(\'year\',"CREATED_DATE"))=(date_part(\'year\',now()::date))';
		
		$result = $this->db->query($statement)->row();
		return $result->num;	

		
	}

	public function get_nextval_to_form_num_now($branch_id)
	{

		$statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=? and  "CATEGORY_NAME"=\'TO\' ' ;
		$result = $this->db->query($statement2,$branch_id)->row();

	
		
		return $result->num;
	
	}
	public function get_nextval_form_num_now($branch_id)
	{

		$statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=? and  "CATEGORY_NAME"=\'ULOK\' ' ;
		$result = $this->db->query($statement2,$branch_id)->row();

	
		
		return $result->num;
	
	}

	public function get_nextval_to_form_num($branch_id)
	{
		$start=1;
		$statement='select COUNT("CURRENT_VALUE") as hitung from sys_sequences where "CATEGORY_NAME"=\'TO\'  AND  "BRANCH_ID" =?';
		$result1 = $this->db->query($statement,array($branch_id))->row()->hitung;
		if($result1==0){
			$start=1;
			$stmt_insert ='INSERT INTO public.sys_sequences("CATEGORY_NAME", "SEQ_YEAR", "SEQ_MONTH", "BRANCH_ID", "CURRENT_VALUE", "CREATED_DATE", "CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY")VALUES ( \'TO\', date_part(\'YEAR\', now()::date), date_part(\'month\', now()::date), ?,?, CURRENT_TIMESTAMP, ?, CURRENT_DATE,  ?)';
				$this->db->query($stmt_insert, array($branch_id,$start, $this->session->userdata('user_id'),$this->session->userdata('user_id')));
			 $this->db->affected_rows();
			 $statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=? and  "CATEGORY_NAME"=\'TO\'';
			 $result = $this->db->query($statement2,$branch_id)->row();
			 $stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'TO\' AND "BRANCH_ID" = ?), "SEQ_MONTH" = date_part(\'month\', now()::date), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'TO\' AND "BRANCH_ID"=?';
			$this->db->query($stmt_update, array($branch_id,$this->session->userdata('user_id'),$branch_id));
			 $this->db->affected_rows();
		}else if($result1==1){
				$statement2='SELECT RIGHT(CONCAT(\'00\',coalesce("CURRENT_VALUE",\'0\')),3) num FROM sys_sequences where "SEQ_MONTH"=(date_part(\'month\',now()::date)) AND "SEQ_YEAR"=(date_part(\'year\',now()::date)) AND "BRANCH_ID"=? and  "CATEGORY_NAME"=\'TO\' ' ;
			 	$result = $this->db->query($statement2,$branch_id)->row();
			$stmt_update ='UPDATE public.sys_sequences SET "CURRENT_VALUE"=(select ("CURRENT_VALUE"+1) as hitung from sys_sequences where "CATEGORY_NAME"=\'TO\' AND "BRANCH_ID" = ?), "SEQ_MONTH" = date_part(\'month\', now()::date), "SEQ_YEAR" = date_part(\'year\', now()::date),"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "CATEGORY_NAME"=\'TO\' AND "BRANCH_ID"=?';
				$this->db->query($stmt_update, array($branch_id,$this->session->userdata('user_id'),$branch_id));
			 $this->db->affected_rows();
			 
		}

	
		
		return $result->num;
	
	}
	public function get_data_trx_cab($page,$rows,$wheretambahan = NULL)
	{	$page = ($page - 1) * $rows;
		if($this->session->userdata('role_id')=='1' or $this->session->userdata('role_id')=='3'){
			$statement='SELECT uf.*, uf."ULOK_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."ULOK_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT",(SELECT "LPDU_FORM_NUM" FROM ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_FORM_NUM",(SELECT "LDUK_FORM_NUM" FROM ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_FORM_NUM" FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\''.$wheretambahan.' order by uf."ULOK_FORM_ID" DESC';

		$result['total'] = $this->db->query($statement,array())->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement)->result();
    		return $result;
		}else if($this->session->userdata('role_id')=='4'){
			
			$statement='SELECT uf.*, uf."ULOK_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."ULOK_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT" ,(SELECT "LPDU_FORM_NUM" FROM ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_FORM_NUM",(SELECT "LDUK_FORM_NUM" FROM ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_FORM_NUM" FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\' AND uf."REGION_ID" =(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"=?) '.$wheretambahan.' order by uf."BRANCH_ID",uf."ULOK_FORM_ID" DESC';
				$result['total'] = $this->db->query($statement,$this->session->userdata('branch_id'))->num_rows();
    			$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    			$result['rows'] = $this->db->query($statement,$this->session->userdata('branch_id'))->result();

			
			return $result;

	
		}else{
			$statement='SELECT uf.*, uf."ULOK_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."ULOK_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT" ,(SELECT "LPDU_FORM_NUM" FROM ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_FORM_NUM",(SELECT "LDUK_FORM_NUM" FROM ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_FORM_NUM" FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\' AND uf."BRANCH_ID" =? '.$wheretambahan.' order by uf."ULOK_FORM_ID" DESC';

		$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->result();
    	return $result;
		}
		
		
	}

	public function get_data_trx_to_toko($page,$rows,$wheretambahan = NULL)
	{
		
    	$page = ($page - 1) * $rows;

		if($this->session->userdata('role_id')=='1' or $this->session->userdata('role_id')=='3' ){
			$statement='SELECT uf.*, uf."TO_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."TO_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT",(select "LPDU_FORM_NUM" from ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_NUM",(select "LDUK_FORM_NUM" from ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_NUM" FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\' '.$wheretambahan.' ORDER BY uf."TO_FORM_ID" DESC';

		$result['total'] = $this->db->query($statement,array())->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement)->result();
    		
		}else if($this->session->userdata('role_id')=='4'){
			$statement='SELECT uf.*, uf."TO_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."TO_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT",(select "LPDU_FORM_NUM" from ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_NUM",(select "LDUK_FORM_NUM" from ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_NUM" FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\' and uf."REGION_ID"=( SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ? ) '.$wheretambahan.' ORDER BY uf."TO_FORM_ID" DESC ';

		$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->result();
		}else{
			$statement='SELECT uf.*, uf."TO_FORM_NUM" AS "FORM_NUM",utx."ULOK_TRX_ID" AS "ULOK_TRX_ID",umb."BANK_NAME",utx."TRX_DATE",utx."TRX_NO_REK", utx."TRX_NAMA_REK",uf."TO_AMOUNT_SWIPE" as "TRX_AMOUNT",utx."STATUS",utx."BBT_NUM", utx."BBT_DATE",utx."BBT_AMOUNT", utx."BBK_NUM",utx."BBK_DATE", utx."BBK_AMOUNT",(select "LPDU_FORM_NUM" from ulok_lpdu where "LPDU_ID"=utx."LPDU_ID") as "LPDU_NUM",(select "LDUK_FORM_NUM" from ulok_lduk where "LDUK_ID"=utx."LDUK_ID") as "LDUK_NUM" FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\' and utx."BRANCH_ID"= ? '.$wheretambahan.' ORDER BY uf."TO_FORM_ID" DESC ';

		$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->num_rows();
    	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
    	$result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->result();
    		
		}
		return $result;
	}
	 public function get_data_survey_ulok($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
    	if($this->session->userdata('role_id')=='4'){
    		//jika RFM
    		 	$statement='SELECT 2 AS "SORT_ID", uf."ULOK_FORM_NUM" as "FORM_NUM",us."ULOK_FORM_ID" as "FORM_ID",uf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM"from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE ( utx."STATUS" = \'F-NOK\' or utx."STATUS" = \'F-OK\') and utx."TIPE_FORM" = \'ULOK\' and us."TIPE_FORM"=\'ULOK\' AND uf."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?)  '.$wheretambahan_ulok.' union SELECT 1 AS "SORT_ID", tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_FORM_ID" as "FORM_ID",tf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and us."TIPE_FORM"=\'TO\' AND tf."REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?)'.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC ';

		        $result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->result();

        		return $result;
   		
    	}else if($this->session->userdata('role_id')=='2'){
    		//jika franchise cbg 
    		 	$statement='SELECT 2 as "SORT_ID" , uf."ULOK_FORM_NUM" as "FORM_NUM",us."ULOK_FORM_ID" as "FORM_ID",uf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM" =\'ULOK\' and us."TIPE_FORM"=\'ULOK\' and (utx."STATUS"=\'EMAIL\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\') and utx."BRANCH_ID"=? '.$wheretambahan_ulok.' union SELECT 1 as "SORT_ID",tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_FORM_ID" as "FORM_ID",tf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and us."TIPE_FORM"=\'TO\' and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\') and utx."BRANCH_ID"=?'.$wheretambahan_to.'order by "SORT_ID","FORM_ID" DESC ';
    		 	$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->result();

        		return $result;
   
   	 	}else if( $this->session->userdata('role_id')=='5' ){
    		//franchise mgr cbg
    		 	$statement='SELECT 2 as "SORT_ID",uf."ULOK_FORM_NUM" as "FORM_NUM",us."ULOK_FORM_ID" as "FORM_ID",uf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM" =\'ULOK\' and us."TIPE_FORM"=\'ULOK\'and (utx."STATUS"=\'OK\' OR utx."STATUS"= \'NOK\' ) and utx."BRANCH_ID"=? '.$wheretambahan_ulok.' union SELECT 1 as "SORT_ID" ,tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_FORM_ID" as "FORM_ID",tf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and us."TIPE_FORM"=\'TO\'and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\') and utx."BRANCH_ID"=?'.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC';
    		 	$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->result();

        		return $result;
   
   	 	}else if($this->session->userdata('role_id')=='1'){
   	 		//jika admin
   	 				$statement='SELECT 2 as "SORT_ID" ,uf."ULOK_FORM_NUM" as "FORM_NUM",us."ULOK_FORM_ID" as "FORM_ID",uf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM" =\'ULOK\' and us."TIPE_FORM"=\'ULOK\''.$wheretambahan_ulok.'  union SELECT 1 as "SORT_ID" ,tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_FORM_ID" as "FORM_ID",tf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and us."TIPE_FORM"=\'TO\''.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC';
    		 	$result['total'] = $this->db->query($statement)->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement)->result();
   				   
        		return $result;
   	 	}else if($this->session->userdata('role_id')=='3'){
   				$statement='SELECT 2 as "SORT_ID" , uf."ULOK_FORM_NUM" as "FORM_NUM",us."ULOK_FORM_ID" as "FORM_ID",uf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM" =\'ULOK\' and us."TIPE_FORM"=\'ULOK\' and (utx."STATUS"=\'EMAIL\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\') '.$wheretambahan_ulok.' union SELECT 1 as "SORT_ID",tf."TO_FORM_NUM" as "FORM_NUM",tf."TO_FORM_ID" as "FORM_ID",tf."NAMA",utx."STATUS" as "STATUS_CABANG",utx."STATUS_HO",us."TGL_SURVEY",utx."TIPE_FORM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and us."TIPE_FORM"=\'TO\' and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\') '.$wheretambahan_to.'order by "SORT_ID","FORM_ID" DESC ';
    		 	$result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;	 		
   	 	}

        
    }

    public function get_data_log_status($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
        if($this->session->userdata('role_id')=='4'){
            //jika RFM
                $statement='(SELECT DISTINCT(uf."ULOK_FORM_NUM") as "FORM_NUM"  from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=uf."ULOK_FORM_ID" WHERE ( utx."TIPE_FORM" = \'ULOK\' and  ul."TIPE_FORM" = \'ULOK\' '.$wheretambahan_ulok.') ) union (SELECT DISTINCT(tf."TO_FORM_NUM") as "FORM_NUM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and ul."TIPE_FORM"=\'TO\''.$wheretambahan_to.')';

                $result['total'] = $this->db->query($statement,array())->num_rows();
                $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
                $result['rows'] = $this->db->query($statement,array())->result();
               
        
        }else if($this->session->userdata('role_id')=='2' ||  $this->session->userdata('role_id')=='5' ){
            //jika franchise cbg  and mgr cabang
                $statement='(SELECT DISTINCT(uf."ULOK_FORM_NUM") as "FORM_NUM"  from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=uf."ULOK_FORM_ID" WHERE ( utx."TIPE_FORM" = \'ULOK\' and  ul."TIPE_FORM" = \'ULOK\' and utx."BRANCH_ID" = ?) '.$wheretambahan_ulok.' ) union (SELECT  DISTINCT(tf."TO_FORM_NUM") as "FORM_NUM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=utx."FORM_ID" WHERE utx."BRANCH_ID" =? and  utx."TIPE_FORM" =\'TO\' and ul."TIPE_FORM"=\'TO\''.$wheretambahan_to. ')';
                $result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->num_rows();
                $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
                $result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->result();
               
   
        }else if($this->session->userdata('role_id')=='1' || $this->session->userdata('role_id')=='3' ){
            //jika admin
                $statement='(SELECT DISTINCT(uf."ULOK_FORM_NUM") as "FORM_NUM"  from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=uf."ULOK_FORM_ID" WHERE ( utx."TIPE_FORM" = \'ULOK\' and  ul."TIPE_FORM" = \'ULOK\') '.$wheretambahan_ulok.' ) union (SELECT DISTINCT( tf."TO_FORM_NUM") as "FORM_NUM" from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_log_status as ul on ul."FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" =\'TO\' and ul."TIPE_FORM"=\'TO\''.$wheretambahan_to.'  )';
                $result['total'] = $this->db->query($statement)->num_rows();
                $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
                $result['rows'] = $this->db->query($statement)->result();
                 
   
        }
   
       return $result;
        
    }

    public function insert_log_status($form_num,$tipe_form,$status,$jenis_status)
    {
    	if($tipe_form=='ULOK'){

    	if($status!=''){

    		$statement='INSERT INTO public.ulok_log_status("FORM_ID", "TIPE_FORM", "STATUS", "JENIS_STATUS", "CREATED_DATE", "CREATED_BY")VALUES (( SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM" = ?), ?, ?, ?, CURRENT_TIMESTAMP, ?)';

    		$this->db->query($statement, array($form_num,$tipe_form,$status,$jenis_status,$this->session->userdata('user_id')));
    			
    		}	
    	}else if($tipe_form=='TO'){
    	if($status !=''){

    		$statement='INSERT INTO public.ulok_log_status("FORM_ID", "TIPE_FORM", "STATUS", "JENIS_STATUS", "CREATED_DATE", "CREATED_BY")VALUES (( SELECT "TO_FORM_ID" FROM to_form where "TO_FORM_NUM" = ?), ?, ?, ?, CURRENT_TIMESTAMP, ?)';

    		$this->db->query($statement, array($form_num,$tipe_form,$status,$jenis_status,$this->session->userdata('user_id')));
    			
    		}
    	}
    	return $this->db->affected_rows();
    }
        public function insert_log_status_by_form_id($form_id,$tipe_form,$status,$jenis_status)
    {
    	if($tipe_form=='ULOK'){
    		if($status !=''){

    			$statement='INSERT INTO public.ulok_log_status("FORM_ID", "TIPE_FORM", "STATUS", "JENIS_STATUS", "CREATED_DATE", "CREATED_BY")VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)';
    			$this->db->query($statement, array($form_id,$tipe_form,$status,$jenis_status,$this->session->userdata('user_id')));
    				
    		}
    	}else if($tipe_form=='TO'){
    		if($status !=''){
    			$statement='INSERT INTO public.ulok_log_status("FORM_ID", "TIPE_FORM", "STATUS", "JENIS_STATUS", "CREATED_DATE", "CREATED_BY")VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, ?)';
    			$this->db->query($statement, array($form_id,$tipe_form,$status,$jenis_status,$this->session->userdata('user_id')));
    				
    		}
    	
    	}
    	return $this->db->affected_rows();
    }

    public function update_ulok_survey($tgl_survey,$hasil_survey,$alasan_survey,$tgl_penyampai_survey,$form_id,$tipe_form)
    {
    	if($alasan_survey==''){
    		if($tgl_survey==null){
    			if($tipe_form=='ULOK'){
    				$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "KETERANGAN"= NULL,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=NULL, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM" =?) AND "TIPE_FORM"=?';	
    				$this->db->query($statement, array($hasil_survey,$this->session->userdata('user_id'),$tgl_penyampai_survey,$form_id,$tipe_form));  
    			}else if($tipe_form=='TO'){
    					$statement2='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "KETERANGAN"= NULL,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=NULL, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(SELECT "TO_FORM_ID" from to_form where "TO_FORM_NUM" =?) AND "TIPE_FORM"=?';	
    				$this->db->query($statement2, array($hasil_survey,$this->session->userdata('user_id'),$tgl_penyampai_survey,$form_id,$tipe_form));  
    			}
    			 
    		}else{
    			if($tipe_form=='ULOK'){
    			$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?,  "KETERANGAN"= NULL,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=?, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM"=?';	
    			$this->db->query($statement, array($hasil_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));  
    			}else if($tipe_form=='TO'){
    					$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "KETERANGAN"= NULL,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=?, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(select "TO_FORM_ID" from to_form where "TO_FORM_NUM" =?) AND "TIPE_FORM"=?';	
    					$this->db->query($statement, array($hasil_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));  

    			}
    		 
    		}
    			
    		 	
    	}else{
    		if($tgl_survey==null){
    			if($tipe_form=='ULOK'){
    				$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "KETERANGAN"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=NULL, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(select "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM"=?';
	    			$this->db->query($statement, array($hasil_survey,$alasan_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));
    			}else if($tipe_form=='TO'){
    				$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?,"KETERANGAN"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=NULL, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(select "TO_FORM_ID" from to_form where "TO_FORM_ID"=?) AND "TIPE_FORM"=?';
	    			$this->db->query($statement, array($hasil_survey,$alasan_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));
    			}
    			

    		}else{
    			if($tipe_form=='ULOK'){

	    			$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?,"KETERANGAN"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=?, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(select "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM"=?';
 		   			$this->db->query($statement, array($hasil_survey,$alasan_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));
	
    			}else if($tipe_form=='TO'){

	    			$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "KETERANGAN"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "TGL_SURVEY"=?, "TGL_PENYAMPAI_SURVEY"=? WHERE  "ULOK_FORM_ID"=(select "TO_FORM_ID" from to_form where "TO_FORM_NUM" = ?) AND "TIPE_FORM"=?';
 		   			$this->db->query($statement, array($hasil_survey,$alasan_survey,$this->session->userdata('user_id'),$tgl_survey,$tgl_penyampai_survey,$form_id,$tipe_form));
	
    			}
    		}
    		    	}
    	return $this->db->affected_rows();
    }
       public function update_ulok_trx($status_cabang,$status_ulok,$alasan_status_ulok,$tipe_form,$form_id)
    {
    	if($status_cabang==''){
    		$status_cabang='HANGUS';
    	}
    	if($alasan_status_ulok=="" ){
    		if($tipe_form=='ULOK'){
    			$statement='UPDATE public.ulok_trx SET "STATUS"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "STATUS_ULOK"=?, "KET_STATUS_ULOK"=NULL,"TGL_STATUS_ULOK"=CURRENT_DATE WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM" =?) AND "TIPE_FORM"=?';	
    			$this->db->query($statement, array($status_cabang,$this->session->userdata('user_id'),$status_ulok,$form_id,$tipe_form)); 
    		}else if($tipe_form=='TO'){
    			$statement='UPDATE public.ulok_trx SET "STATUS"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "STATUS_ULOK"=?, "KET_STATUS_ULOK"=NULL,"TGL_STATUS_ULOK"=CURRENT_DATE WHERE "FORM_ID"=(SELECT "TO_FORM_ID" from to_form where "TO_FORM_NUM" =?) AND "TIPE_FORM"=?';	
    			$this->db->query($statement, array($status_cabang,$this->session->userdata('user_id'),$status_ulok,$form_id,$tipe_form)); 
    		}
    		   	
    	}else if($alasan_status_ulok!="" ){
    		if($tipe_form=='ULOK'){
    		
    		$statement='UPDATE public.ulok_trx SET "STATUS"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "STATUS_ULOK"=?, "KET_STATUS_ULOK"=?,"TGL_STATUS_ULOK"=CURRENT_DATE WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM"=?';
    		$this->db->query($statement, array($status_cabang,$this->session->userdata('user_id'),$status_ulok,$alasan_status_ulok,$form_id,$tipe_form));
    		}else if($tipe_form=='TO'){

    		$statement='UPDATE public.ulok_trx SET "STATUS"=?,"LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?, "STATUS_ULOK"=?, "KET_STATUS_ULOK"=?,"TGL_STATUS_ULOK"=CURRENT_DATE WHERE "FORM_ID"=(SELECT "TO_FORM_ID" FROM to_form where "TO_FORM_NUM"=?) AND "TIPE_FORM"=?';
    		$this->db->query($statement, array($status_cabang,$this->session->userdata('user_id'),$status_ulok,$alasan_status_ulok,$form_id,$tipe_form));
    		}
    	}
    	return $this->db->affected_rows();
    }

     public function update_ulok_trx_status_cbg($status,$form_id,$tipe_form)
    {
    	if($status=='S-OK'){
    		$status_cbg='F-OK';
    	}else if($status=='S-NOK'){
    		$status_cbg='F-NOK';
    	}else if($status=='OK'){
    		$status_cbg='F-OK';
    	}else if($status=='NOK'){
    		$status_cbg='F-NOK';
    	}
        $statement='UPDATE public.ulok_trx SET  "STATUS"=?,"LAST_UPDATE_DATE"= CURRENT_TIMESTAMP , "LAST_UPDATE_BY"=?,  "TGL_STATUS"= CURRENT_DATE WHERE "FORM_ID"=? AND "TIPE_FORM"=?';
    	$this->db->query($statement, array($status_cbg,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	return $this->db->affected_rows();
    }

    public function update_ulok_trx_status_HO_cabang($alasan_reject,$status,$status,$form_id,$tipe_form)
    {
    	if($tipe_form=='ULOK'){
    		$statement='UPDATE public.ulok_trx SET  "ALASAN_REJECT"=?,"STATUS"=?,"STATUS_HO"=? ,"LAST_UPDATE_DATE"= CURRENT_TIMESTAMP , "LAST_UPDATE_BY"=?,  "TGL_STATUS"= CURRENT_DATE WHERE "FORM_ID"=(select "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM"=?';
    		$this->db->query($statement, array($alasan_reject,$status,$status,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	}else if($tipe_form=='TO'){
    		$statement='UPDATE public.ulok_trx SET  "ALASAN_REJECT"=?,"STATUS"=?,"STATUS_HO"=? ,"LAST_UPDATE_DATE"= CURRENT_TIMESTAMP , "LAST_UPDATE_BY"=?,  "TGL_STATUS"= CURRENT_DATE WHERE "FORM_ID"=(select "TO_FORM_ID" from to_form where "TO_FORM_NUM"=?) AND "TIPE_FORM"=?';
    		$this->db->query($statement, array($alasan_reject,$status,$status,$this->session->userdata('user_id'),$form_id,$tipe_form));

    	}
      
    	return $this->db->affected_rows();
    }
    public function update_ulok_trx_status_cbg_frc_manager($status,$form_id,$tipe_form)
    {
    	if($status=='S-OK'){
    		$status_cbg='F-OK';
    	}else if($status=='S-NOK'){
    		$status_cbg='F-NOK';
    	}
        $statement='UPDATE public.ulok_trx SET  "STATUS"=?,"LAST_UPDATE_DATE"= CURRENT_TIMESTAMP , "LAST_UPDATE_BY"=?,  "TGL_STATUS"= CURRENT_DATE WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM"= ?) AND "TIPE_FORM"=?';
    	$this->db->query($statement, array($status_cbg,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	return $this->db->affected_rows();
    }
     public function update_ulok_trx_status_HO($status,$form_id,$tipe_form)
    {
        $statement='UPDATE public.ulok_trx SET  "STATUS_HO"=?,"LAST_UPDATE_DATE"= CURRENT_TIMESTAMP , "LAST_UPDATE_BY"=?,  "TGL_STATUS_HO"= CURRENT_DATE WHERE "FORM_ID"=? AND "TIPE_FORM"=?';
    	$this->db->query($statement, array($status,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	return $this->db->affected_rows();
    }
    public function update_ulok_survey_by_frc_mgr($hasil_survey,$alasan_survey,$tgl_penyampai_survey,$form_id,$tipe_form)
    {
    	if($hasil_survey=='OK'){
    	
    	 $statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "TGL_PENYAMPAI_SURVEY"=?, "KETERANGAN"=NULL, "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "ULOK_FORM_ID"=(SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM"= ?) AND "TIPE_FORM"=? ';
    	$this->db->query($statement, array($hasil_survey,$tgl_penyampai_survey,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	return $this->db->affected_rows();
    	}else if($hasil_survey=='NOK'){
    		
    	 	$statement='UPDATE public.ulok_survey SET "SURVEY_HASIL"=?, "TGL_PENYAMPAI_SURVEY"=?, "KETERANGAN" = ?, "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP,"LAST_UPDATE_BY"=? WHERE "ULOK_FORM_ID"=(SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM"=?) AND "TIPE_FORM" =? ';
    		$this->db->query($statement, array($hasil_survey,$tgl_penyampai_survey,$alasan_survey,$this->session->userdata('user_id'),$form_id,$tipe_form));
    		return $this->db->affected_rows();
    	}
    	
    }
    

    public function  get_survey_data_ulok_specific($form_id,$tipe_form)
    {
    	$statement=	'SELECT us."TGL_SURVEY",us."SURVEY_HASIL",us."KETERANGAN",us."TGL_PENYAMPAI_SURVEY",utx."STATUS_ULOK",utx."KET_STATUS_ULOK",utx."TIPE_FORM" ,utx."STATUS", utx."STATUS_HO" FROM public.ulok_survey as us join public.ulok_trx as utx on us."ULOK_FORM_ID"=utx."FORM_ID" WHERE us."ULOK_FORM_ID"= ? AND UTX."TIPE_FORM" = ?';
    	$result=$this->db->query($statement, array($form_id,$tipe_form))->result();
    	return $result;

    }

	public function get_data_trx_cab_where_ulok_trx_id($ulok_trx_id)
	{
		$tipe_form='ULOK';
		$statement='SELECT  utx."ULOK_TRX_ID" AS "ULOK_TRX_ID", uf."ULOK_FORM_NUM" AS "FORM_NUM",uf."NAMA" AS "NAMA" , umb."BANK_NAME",utx."TRX_DATE", utx."TRX_NO_REK", utx."TRX_NAMA_REK", utx."TRX_AMOUNT",utx."STATUS", utx."BBT_NUM", utx."BBT_DATE", utx."BBT_AMOUNT", utx."BBK_NUM", utx."BBK_DATE", utx."BBK_AMOUNT"FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID"  WHERE utx."TIPE_FORM"=? and utx."ULOK_TRX_ID"=? ';
		$result= $this->db->query($statement,array($tipe_form,$ulok_trx_id))->result();
		return $result;
	}

	public function get_data_ulok_form_where_ulok_form_num($ulok_form_num) 
	{
		$statement='SELECT * from public.ulok_form  where "ULOK_FORM_NUM" = ? ';
		$result= $this->db->query($statement,array($ulok_form_num));
		return $result->row();
	}
	public function get_data_form_to_where_to_form_num($to_form_num) 
	{
		$statement='SELECT * from public.to_form  where "TO_FORM_NUM" = ? ';
		$result= $this->db->query($statement,array($to_form_num));
		return $result->row();
	}
	public function get_file_uploaded($ulok_form_num,$tipe_form)
	{
		if($tipe_form=='ULOK' || $tipe_form=='ULOK_SURVEY'){
			$statement='SELECT "FILE_BUKTI_TRF" from ulok_master_file WHERE "FORM_ID"=(SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM" = ? ) AND "TIPE_FORM" = ?';
			$result= $this->db->query($statement,array($ulok_form_num,$tipe_form))->result();
			
		}else if($tipe_form=='TO' || $tipe_form=='TO_SURVEY'){
			$statement='SELECT "FILE_BUKTI_TRF" from ulok_master_file WHERE "FORM_ID"=(SELECT "TO_FORM_ID" from to_form where "TO_FORM_NUM" = ? ) AND "TIPE_FORM" = ?';
			$result= $this->db->query($statement,array($ulok_form_num,$tipe_form))->result();
		}
		return $result;
	}

	public function get_report_ulok_form_where_ulok_form_num($form_num)
	{
		$statement='SELECT umb."BRANCH_NAME",uf."ULOK_FORM_DATE",uf."NO_KTP",uf."ULOK_BENTUK_LOK_LAIN",uf."NAMA",uf."ALAMAT",uf."RT/RW" as "rtrw",uf."KELURAHAN",uf."KECAMATAN",uf."KODYA_KAB",uf."KODE_POS",uf."TELP",uf."EMAIL",uf."NPWP",(select "BANK_NAME" from public.ulok_master_bank where "BANK_ID"= uf."ULOK_BANK_ID"),uf."ULOK_CABANG_BANK",uf."ULOK_NO_REK",uf."ULOK_NAMA_REK",uf."ULOK_ALAMAT",uf."ULOK_RT_RW",uf."ULOK_KELURAHAN",uf."ULOK_KODYA_KAB",uf."KODE_POS",uf."ULOK_KECAMATAN",uf."TELP",uf."SUMBER_ULOK",uf."ULOK_BENTUK",uf."ULOK_UKURAN_LBR",uf."ULOK_UKURAN_PJG",uf."ULOK_JML_LT",uf."ULOK_JML_UNIT",uf."ULOK_LHN_PKR",uf."ULOK_LHN_PKR_LN",uf."ULOK_KODE_POS",uf."ULOK_STATUS_LOK",uf."ULOK_STATUS_LOK_LN",uf."ULOK_DOK",uf."ULOK_DOK",uf."ULOK_DOK_LN",uf."ULOK_IZIN_BGN",uf."ULOK_IZIN_UTK",uf."ULOK_IDM_TDK",uf."ULOK_IDM_TDK_LN",uf."ULOK_PASAR",uf."ULOK_PASAR_LN",uf."ULOK_MINIMARKET",uf."ULOK_MINIMARKET_LN",uf."ULOK_LAMPIRAN",uf."ULOK_TIPE_BAYAR",uf."ULOK_BAYAR_DATE",uf."ULOK_AMOUNT",uf."ULOK_AMOUNT_SWIPE",uf."ULOK_KARTU_KREDIT",uf."PROVINSI",uf."ULOK_PROVINSI",umb."BRANCH_NICK" from public.ulok_form  as uf join public.ulok_master_branch as umb on uf."BRANCH_ID"=umb."BRANCH_ID" where uf."ULOK_FORM_NUM" = ?';
		$result= $this->db->query($statement,array($form_num));
		return $result->row();
	}
		public function get_data_to_form_where_to_form_num($to_form_num) 
	{
		$statement='SELECT tf."TO_FORM_ID",tf."TO_FORM_NUM",umb."BRANCH_NAME",tf."TO_FORM_DATE",tf."NO_KTP",tf."NAMA",tf."PROVINSI",tf."TO_PROVINSI",tf."TO_KODYA_KAB",tf."TO_KECAMATAN",tf."TO_KELURAHAN",tf."TO_KODE_POS",tf."ALAMAT",tf."RT/RW" as rtrw ,tf."TO_RT_RW" ,tf."KELURAHAN" ,tf."KECAMATAN",tf."KODYA_KAB" ,tf."KODE_POS",tf."TELP",tf."EMAIL",tf."NPWP",tf."TO_KARTU_KREDIT",(select "BANK_NAME" from public.ulok_master_bank where "BANK_ID"= tf."TO_BANK_ID")as "BANK_NAME",tf."TO_CABANG_BANK",tf."TO_NO_REK",tf."TO_NAMA_REK",tf."TO_KODE_TOKO",tf."TO_NAMA_TOKO",tf."TO_ALAMAT",tf."TO_NILAI_INVESTASI",tf."TO_ACTUAL_INVESTMENT",tf."TO_GOOD_WILL",tf."TO_PPN",tf."TO_TOTAL",tf."TO_AMOUNT",tf."TO_RT_RW",tf."TO_AMOUNT_SWIPE",tf."TO_BAYAR_DATE",tf."TO_TIPE_BAYAR",tf."TO_KARTU_KREDIT",umb."BRANCH_NICK" from public.to_form as tf join public.ulok_master_branch as umb on tf."BRANCH_ID"=umb."BRANCH_ID"  where "TO_FORM_NUM" = ? ';
		$result= $this->db->query($statement,array($to_form_num));
		return $result->row();
	}
	/*BACK UP
	public function get_report_lpdu_where_branch($cabang,$periode)
	{
		$statement='SELECT (select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID"),(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID"),uf."NAMA",uf."ULOK_TIPE_BAYAR",uf."ULOK_BAYAR_DATE",(select "BANK_NAME" from ulok_master_bank where "BANK_ID"=uf."ULOK_BANK_ID"),uf."ULOK_FORM_NUM",(select "ACCOUNT_NUMBER" from ulok_master_bank where "BANK_ID"=uf."ULOK_BANK_ID"),utx."BBT_NUM",utx."BBT_DATE",utx."BBT_AMOUNT" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'ULOK\' AND utx."BRANCH_ID"=? and TO_CHAR(uf."ULOK_FORM_DATE",\'MM-YYYY\')=? and utx."STATUS"=\'N\' ';
		$result= $this->db->query($statement,array($branch_id,$periode));
		return $result->row();
	}
	*/
	public function get_report_lpdu_where($where)
	{
		$statement='SELECT (select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID"),(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID") as "BRANCH_NAME",uf."NAMA",uf."ULOK_TIPE_BAYAR",uf."ULOK_BAYAR_DATE",uf."ULOK_KARTU_KREDIT" as "BANK_NAME",uf."ULOK_FORM_NUM",(select "ACCOUNT_NUMBER" from ulok_master_bank where "BANK_ID"=uf."ULOK_BANK_ID"),utx."BBT_NUM",utx."BBT_DATE",utx."BBT_AMOUNT" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'ULOK\''.' '.$where.'    ORDER BY uf."BRANCH_ID",uf."ULOK_FORM_ID"  asc';
		$result= $this->db->query($statement);
		return $result->result();
	}
	public function get_report_lduk_where($where)
	{
		$statement='SELECT (select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID"),(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=uf."BRANCH_ID"),uf."NAMA",uf."ULOK_TIPE_BAYAR",uf."ULOK_BAYAR_DATE",uf."ULOK_FORM_NUM",concat( (select "ACCOUNT_NUMBER" from ulok_master_bank where "BANK_ID"=uf."ULOK_BANK_ID"),\'-\',(select "BANK_NAME" from ulok_master_bank where "BANK_ID"=uf."ULOK_BANK_ID")) as "AKUN_BANK",utx."BBT_NUM",utx."BBT_DATE",utx."BBT_AMOUNT",utx."BBK_NUM",utx."BBK_DATE",utx."BBK_AMOUNT" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"= us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' and  us."SURVEY_HASIL"=\'NOK\''.' '.$where.'     ORDER BY uf."ULOK_FORM_ID" asc ';
		$result= $this->db->query($statement);
		return $result->result();
	}
		public function get_sum_report_lduk_where($where)
	{
		$statement='SELECT  COALESCE(sum("BBK_AMOUNT"),0) as "TOTAL_BBK", COALESCE(sum("BBT_AMOUNT"),0) as "TOTAL_BBT" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"= us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' and  us."SURVEY_HASIL"=\'NOK\''.' '.$where.' ';
		$result= $this->db->query($statement);
		return $result->row();
	}
	public function get_report_lpdu_to_where($where_to)
	{
		$statement='SELECT (select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=tf."BRANCH_ID"),(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=tf."BRANCH_ID") as "BRANCH_NAME",tf."NAMA",tf."TO_TIPE_BAYAR",tf."TO_BAYAR_DATE",tf."TO_KARTU_KREDIT" as "BANK_NAME",tf."TO_FORM_NUM",(select "ACCOUNT_NUMBER" from ulok_master_bank where "BANK_ID"=tf."TO_BANK_ID"),utx."BBT_NUM",utx."BBT_DATE",utx."BBT_AMOUNT" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'TO\''.' '.$where_to.'  ORDER BY tf."BRANCH_ID",tf."TO_FORM_ID" ASC';
		$result= $this->db->query($statement);
		return $result->result();
	}
	public function get_report_lduk_to_where($where_to)
	{
		$statement='SELECT (select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=tf."BRANCH_ID"),(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=tf."BRANCH_ID"),tf."NAMA",tf."TO_TIPE_BAYAR",tf."TO_BAYAR_DATE",tf."TO_FORM_NUM",concat( (select "ACCOUNT_NUMBER" from ulok_master_bank where "BANK_ID"=tf."TO_BANK_ID"),\'-\',(select "BANK_NAME" from ulok_master_bank where "BANK_ID"=tf."TO_BANK_ID")) as "AKUN_BANK",utx."BBT_NUM",utx."BBT_DATE",utx."BBT_AMOUNT",utx."BBK_NUM",utx."BBK_DATE",utx."BBK_AMOUNT" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"= us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\''.' '.$where_to.' ORDER BY tf."TO_FORM_ID" asc';
		$result= $this->db->query($statement);
		return $result->result();
	}
	public function get_sum_report_lduk_to_where($where_to)
	{
		$statement='SELECT COALESCE(sum("BBK_AMOUNT"),0) as "TOTAL_BBK",coalesce(sum("BBT_AMOUNT"),0) as "TOTAL_BBT" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" join ulok_survey as us on utx."FORM_ID"= us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\''.' '.$where_to.' ';
		$result= $this->db->query($statement);
		return $result->row();
	}
		public function get_region_name($region)
	{
		$statement='SELECT "REGION_NAME","REGION_CODE" from ulok_master_region where "REGION_ID"=?';
		$result= $this->db->query($statement,$region);
		return $result->row();
	}
	public function get_branch_from_region($region)
	{
		$statement='select "BRANCH_ID",(select "BRANCH_CODE" from ulok_master_branch where "BRANCH_ID"=urb."BRANCH_ID")as "BRANCH_CODE",(select "BRANCH_NAME" from ulok_master_branch where "BRANCH_ID"=urb."BRANCH_ID") as "BRANCH_NAME" from ulok_region_branch as urb  where urb."REGION_ID"=?';
		$result= $this->db->query($statement,$region);
		return $result->result();
	}

	public function get_data_listing_status_to($cabang,$periode) 
    {
        $statement='SELECT utx."STATUS",utx."STATUS_ULOK",tf."NAMA",tf."TO_FORM_NUM",tf."TO_BAYAR_DATE","TO_FORM_NUM" from ulok_trx as utx join to_form as tf on utx."FORM_ID"=tf."TO_FORM_ID"  where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and TO_CHAR(tf."TO_BAYAR_DATE",\'MM-YYYY\') <= ?';
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }
    public function get_data_listing_status_ulok($cabang,$periode)
    {	
    	$statement='SELECT utx."STATUS",uf."NAMA",uf."ULOK_FORM_NUM",uf."ULOK_BAYAR_DATE",uf."ULOK_FORM_NUM",us."SURVEY_HASIL" AS "SURVEY_HASIL",utx."STATUS_ULOK"from ulok_trx as utx join ulok_form as uf on utx."FORM_ID"=uf."ULOK_FORM_ID" join ulok_survey as us on uf."ULOK_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and TO_CHAR(uf."ULOK_BAYAR_DATE",\'MM-YYYY\') <= ?';
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }

    public function count_listing_status_ulok($cabang,$periode)
    {	
    	$statement='SELECT count(uf."ULOK_FORM_NUM")  as "hitung" from ulok_trx as utx join ulok_form as uf on utx."FORM_ID"=uf."ULOK_FORM_ID" join ulok_survey as us on uf."ULOK_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and TO_CHAR(uf."ULOK_BAYAR_DATE",\'MM-YYYY\') <= ?';
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->row();
    }

    public function count_listing_status_to($cabang,$periode)
    {	
    	$statement='SELECT count(tf."TO_FORM_NUM")  as "hitung" from ulok_trx as utx join to_form as tf on utx."FORM_ID"=tf."TO_FORM_ID" join ulok_survey as us on tf."TO_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and TO_CHAR(tf."TO_BAYAR_DATE",\'MM-YYYY\') <= ?';
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->row();
    }

    public function get_data_lmdo_ulok($cabang,$periode)
    {	
    	$statement='SELECT  uf."NAMA",uf."ULOK_FORM_NUM",uf."ULOK_BAYAR_DATE",uf."ULOK_KARTU_KREDIT",uf."ULOK_AN_PENGIRIM",utx."BBT_NUM",utx."BBT_AMOUNT",utx."BBT_DATE",utx."BBK_NUM",utx."BBK_AMOUNT",utx."BBK_DATE",utx."STATUS_ULOK",utx."KET_STATUS_ULOK"from ulok_trx as utx join ulok_form as uf on utx."FORM_ID"=uf."ULOK_FORM_ID" join ulok_survey as us on uf."ULOK_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and TO_CHAR(uf."ULOK_BAYAR_DATE",\'MM-YYYY\') <=?' ;
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }

    public function count_data_lmdo($cabang,$periode)
    {
    		$statement='select (SELECT  count(uf."NAMA") as "hitung" from ulok_trx as utx join ulok_form as uf on utx."FORM_ID"=uf."ULOK_FORM_ID" join ulok_survey as us on uf."ULOK_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and TO_CHAR(uf."ULOK_BAYAR_DATE",\'MM-YYYY\') <=?)+(SELECT  count(tf."NAMA") as "hitung" from ulok_trx as utx join to_form as tf on utx."FORM_ID"=tf."TO_FORM_ID" join ulok_survey as us on tf."TO_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and TO_CHAR(tf."TO_BAYAR_DATE",\'MM-YYYY\') <=?) as "hitung"' ;
        $result= $this->db->query($statement,array($cabang,$periode,$cabang,$periode));
        return $result->row();
    }

    public function count_data_lmdo_ulok($cabang,$periode)
    {	
    	$statement='SELECT  count(uf."NAMA") as "hitung" from ulok_trx as utx join ulok_form as uf on utx."FORM_ID"=uf."ULOK_FORM_ID" join ulok_survey as us on uf."ULOK_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and TO_CHAR(uf."ULOK_BAYAR_DATE",\'MM-YYYY\') <=?' ;
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }

       public function get_data_lmdo_to($cabang,$periode)
    {	
    	$statement='SELECT  tf."NAMA",tf."TO_FORM_NUM",tf."TO_BAYAR_DATE",tf."TO_KARTU_KREDIT",tf."TO_AN_PENGIRIM",utx."BBT_NUM",utx."BBT_AMOUNT",utx."BBT_DATE",utx."BBK_NUM",utx."BBK_AMOUNT",utx."BBK_DATE",utx."STATUS_ULOK",utx."KET_STATUS_ULOK"from ulok_trx as utx join to_form as tf on utx."FORM_ID"=tf."TO_FORM_ID" join ulok_survey as us on tf."TO_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and TO_CHAR(tf."TO_BAYAR_DATE",\'MM-YYYY\') <=?' ;
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }

public function count_data_lmdo_to($cabang,$periode)
    {	
    	$statement='SELECT  count(tf."NAMA") as "hitung" from ulok_trx as utx join to_form as tf on utx."FORM_ID"=tf."TO_FORM_ID" join ulok_survey as us on tf."TO_FORM_ID"=us."ULOK_FORM_ID" where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and TO_CHAR(tf."TO_BAYAR_DATE",\'MM-YYYY\') <=?' ;
        $result= $this->db->query($statement,array($cabang,$periode));
        return $result->result();
    }
    public function get_data_lpdu($page,$rows,$wheretambahan = NULL)
    {
    	$page = ($page - 1) * $rows;
    	$statement='SELECT "LPDU_ID","LPDU_FORM_NUM" as "LPDU_NUM","TGL_LPDU",to_char(to_date("PERIODE",\'MM-YYYY\'),\'MON-YYYY\') AS "PERIODE",(SELECT "BRANCH_NAME" FROM ulok_master_branch where "BRANCH_ID"= ulok_lpdu."BRANCH_ID") as "BRANCH_NAME",(SELECT "REGION_NAME" from ulok_master_region where "REGION_ID"= ulok_lpdu."REGION_ID") as "REGION_NAME" from ulok_lpdu where "LPDU_ID" > 0'.' '.$wheretambahan.' order by "LPDU_ID" DESC';
		$result['total'] = $this->db->query($statement,array())->num_rows();
        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        $result['rows'] = $this->db->query($statement,array())->result();
        return $result;
    }

    public function get_data_lduk($page,$rows,$wheretambahan = NULL)
    {
    	if($this->session->userdata('role_id')==4){
    			$page = ($page - 1) * $rows;
    			$statement='SELECT "LDUK_ID","LDUK_FORM_NUM" as "LDUK_NUM","TGL_LDUK","PERIODE",
    				(SELECT "BRANCH_NAME" FROM ulok_master_branch where "BRANCH_ID"= ulok_lduk."BRANCH_ID") as "BRANCH_NAME"
					,(SELECT "REGION_NAME" from ulok_master_region where "REGION_ID"= ulok_lduk."REGION_ID") as "REGION_NAME"from ulok_lduk where "REGION_ID"=(select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?)'.' '.$wheretambahan.'order by "LDUK_ID" DESC';
				$result['total'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->num_rows();
        		$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        		$result['rows'] = $this->db->query($statement,array($this->session->userdata('branch_id')))->result();
    	}else {
    		    $page = ($page - 1) * $rows;
    			$statement='SELECT "LDUK_ID","LDUK_FORM_NUM" as "LDUK_NUM","TGL_LDUK","PERIODE",
    				(SELECT "BRANCH_NAME" FROM ulok_master_branch where "BRANCH_ID"= ulok_lduk."BRANCH_ID") as "BRANCH_NAME"
					,(SELECT "REGION_NAME" from ulok_master_region where "REGION_ID"= ulok_lduk."REGION_ID") as "REGION_NAME" from ulok_lduk where "LDUK_ID" > 0'.' '.$wheretambahan.'order by "LDUK_ID" DESC';
				$result['total'] = $this->db->query($statement,array())->num_rows();
        		$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        		$result['rows'] = $this->db->query($statement,array())->result();
    	}

        return $result;
    }
	public function get_branch_name($branch_code)
	{
		$statement='SELECT "BRANCH_NAME"  FROM ulok_master_branch where "BRANCH_CODE" = btrim(?) ';
		$result= $this->db->query($statement,$branch_code)->row();
		if($result){
			return $result->BRANCH_NAME;
		} else{
			return 0;
		}
	}
	public function get_branch_nick($branch_code)
	{
		$statement='SELECT "BRANCH_NICK"  FROM ulok_master_branch where "BRANCH_CODE" = btrim(?) ';
		$result= $this->db->query($statement,$branch_code)->row();
		if($result){
			return $result->BRANCH_NICK;
		} else{
			return 0;
		}
	}
		public function get_branch_name_code($branch_id)
	{
		$statement='SELECT "BRANCH_ID","BRANCH_NAME","BRANCH_CODE"  FROM ulok_master_branch where "BRANCH_ID" = ? ';
		$result= $this->db->query($statement,$branch_id)->row();
		return $result;
	}
		public function get_all_branch_name_code()
	{
		$statement='SELECT "BRANCH_ID","BRANCH_NAME","BRANCH_CODE"  FROM ulok_master_branch ';
		$result= $this->db->query($statement)->result();
		return $result;
	}
		public function get_branch_id($branch_name)
	
	{
		$statement='SELECT "BRANCH_ID"  FROM ulok_master_branch where "BRANCH_NAME" = ? ';
		$result= $this->db->query($statement,$branch_name)->row();
		return $result;
	}

		public function get_report_lpdu_detail($lpdu)
	{
		$statement='SELECT "REGION_ID","BRANCH_ID","TGL_LPDU"  FROM ulok_lpdu where "LPDU_FORM_NUM" = ? ';
		$result= $this->db->query($statement,$lpdu)->row();
		return $result;
	}
		public function get_report_lduk_detail($lduk)
	{
		$statement='SELECT "REGION_ID","BRANCH_ID","TGL_LDUK"  FROM ulok_lduk where "LDUK_FORM_NUM" = ? ';
		$result= $this->db->query($statement,$lduk)->row();
		return $result;
	}
		public function count_amount_of_file($form_num)
	{
		$statement='SELECT COUNT("MASTER_FILE_ID") as "JUMLAH" from ulok_master_file where "FORM_NUM"= ?';
		$result= $this->db->query($statement,$form_num)->row();
		return $result;	
	}
		public function count_amount_of_file_survey($form_num,$tipe_form)
	{
		$statement='SELECT COUNT("MASTER_FILE_ID") as "JUMLAH" from ulok_master_file where "FORM_NUM"= ? and "TIPE_FORM"= ?';
		$result= $this->db->query($statement,array($form_num,$tipe_form))->row();
		return $result;	
	}

	public function count_get_detail_log_status($form_num){
		$statement='select(select count(*) from ulok_log_status  where "FORM_ID" = (SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM"= ?))+(select count(*) from ulok_log_status  where "FORM_ID" = (SELECT "TO_FORM_ID" FROM to_form where "TO_FORM_NUM"= ?)) as "hitung" ';
		return $this->db->query($statement,array($form_num,$form_num))->row();
	}
	public function count_data_table_trx_to_toko($wheretambahan= NULL){
		$tipe_form='TO';
		if($this->session->userdata('role_id')=='1' || $this->session->userdata('role_id')=='3' ){
			$statement='SELECT count(uf."TO_FORM_NUM") as hitung  FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\''.$wheretambahan.'';
			return $this->db->query($statement)->row();
		}else if($this->session->userdata('role_id')=='4'){
			$statement='SELECT count(uf."TO_FORM_NUM") as hitung  FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\' AND uf."REGION_ID" = (SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?) '.$wheretambahan.'';
			return $this->db->query($statement,$this->session->userdata('branch_id'))->row();
		}else{
			$statement='SELECT count(uf."TO_FORM_NUM") as hitung  FROM  public.to_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."TO_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."TO_BANK_ID" WHERE utx."TIPE_FORM" = \'TO\' AND utx."BRANCH_ID" = ? '.$wheretambahan.'';
			return $this->db->query($statement,$this->session->userdata('branch_id'))->row();
		}
	}
	public function count_data_table_trx_ulok_toko($wheretambahan= NULL){
		if($this->session->userdata('role_id')=='1' || $this->session->userdata('role_id')=='3' ){
			$statement='SELECT count(uf."ULOK_FORM_NUM") as hitung  FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\' '.$wheretambahan.'';
				return $this->db->query($statement)->row();
		}else if($this->session->userdata('role_id')=='4'){
			$statement='SELECT count(uf."ULOK_FORM_NUM") as hitung  FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\' AND uf."REGION_ID"= (SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" = ?)  '.$wheretambahan.'';
				return $this->db->query($statement,$this->session->userdata('branch_id'))->row();
		}else{
				$statement='SELECT count(uf."ULOK_FORM_NUM") as hitung  FROM  public.ulok_form uf join public.ulok_trx utx  on utx."FORM_ID"=uf."ULOK_FORM_ID" join public.ulok_master_bank umb on umb."BANK_ID"=uf."ULOK_BANK_ID" WHERE utx."TIPE_FORM" = \'ULOK\' AND uf."BRANCH_ID"= ? '.$wheretambahan.'';
				return $this->db->query($statement,$this->session->userdata('branch_id'))->row();
		}
	
	}
		public function count_data_table_lpdu($wheretambahan= NULL){
		$statement='select count(*) as hitung  from ulok_lpdu  where "LPDU_ID" > 0 '.$wheretambahan.'';
		return $this->db->query($statement)->row();
	}

		public function count_data_table_lduk($wheretambahan= NULL){

		if($this->session->userdata('role_id')=='4'){
			$statement='select count(*) as hitung  from ulok_lduk  where "REGION_ID"=(SELECT "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?)  '.$wheretambahan.'';
			return $this->db->query($statement,$this->session->userdata('branch_id'))->row();
		

		}else{
			$statement='select count(*) as hitung  from ulok_lduk  where "LDUK_ID" > 0 '.$wheretambahan.'';
			return $this->db->query($statement)->row();
		}
	
	}

		 public function count_data_survey_ulok($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   if($this->session->userdata('role_id')=='4'){
    	//RFM
    		$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE (utx."STATUS" = \'F-NOK\'  or utx."STATUS" = \'F-OK\')  AND us."TIPE_FORM"=\'ULOK\' AND utx."TIPE_FORM"=\'ULOK\' and uf."REGION_ID" =(select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID"= ?) '.$wheretambahan_ulok.')+( SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND us."TIPE_FORM"=\'TO\' AND tf."REGION_ID" =(select "REGION_ID" FROM ulok_region_branch where "BRANCH_ID" = ?) '.$wheretambahan_to.'  ) as "hitung"';
			return $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->row();
    	}else if($this->session->userdata('role_id')=='2' ){
    		$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."BRANCH_ID" = ? and (utx."STATUS"=\'EMAIL\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"=\'OK\' OR utx."STATUS"= \'NOK\')  AND utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\''.$wheretambahan_ulok.')+(SELECT count(tf."TO_FORM_NUM")from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE  utx."BRANCH_ID" = ? AND utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\'  and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\')  '.$wheretambahan_to.') as "hitung"';
			return $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->row(); 
    	}else if($this->session->userdata('role_id')=='5' ){
    		$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."BRANCH_ID" = ? AND utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' and (utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\'  OR utx."STATUS"=\'OK\' OR utx."STATUS"= \'NOK\') '.$wheretambahan_ulok.')+(SELECT count(tf."TO_FORM_NUM")from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE  utx."BRANCH_ID" = ? AND utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\' and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\')'.$wheretambahan_to.') as "hitung"';
			return $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->row();


    	}else if($this->session->userdata('role_id')=='1'){
    		$statement='select (SELECT count(uf."ULOK_FORM_NUM")  from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' '.$wheretambahan_ulok.')+(SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\' '.$wheretambahan_to.') as "hitung"';
			return $this->db->query($statement)->row(); 
    	}else if($this->session->userdata('role_id')=='3'){
    		$statement='select (SELECT count(uf."ULOK_FORM_NUM")  from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=uf."ULOK_FORM_ID" WHERE utx."TIPE_FORM"=\'ULOK\' AND us."TIPE_FORM"=\'ULOK\' and (utx."STATUS"=\'EMAIL\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\') '.$wheretambahan_ulok.')+(SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" join public.ulok_survey as us on us."ULOK_FORM_ID"=tf."TO_FORM_ID" WHERE utx."TIPE_FORM"=\'TO\' AND us."TIPE_FORM"=\'TO\' and (utx."STATUS"=\'BBT\' OR utx."STATUS"=\'S-OK\' OR utx."STATUS"= \'S-NOK\' OR utx."STATUS"= \'NOK\' OR utx."STATUS"= \'OK\')'.$wheretambahan_to.') as "hitung"';

			return $this->db->query($statement)->row(); 
    	}
          
    }
	 public function get_data_detail_log_status($page,$rows,$form_num)
    {
    	$page = ($page - 1) * $rows;
    	$result['total']=0;
    	$result['rows']='';
    	if(substr($form_num,0,2)=='TO'){
    		$statement=	'( select ul."STATUS",ul."JENIS_STATUS",ul."CREATED_DATE",tf."TO_FORM_NUM" as "FORM_NUM" ,us."USERNAME" from ulok_log_status as ul join to_form as tf on ul."FORM_ID"=tf."TO_FORM_ID"  join  sys_user as us on us."USER_ID"=ul."CREATED_BY"  WHERE ul."FORM_ID"=(SELECT tf."TO_FORM_ID" from to_form as tf where tf."TO_FORM_NUM"=?) and ul."TIPE_FORM" = \'TO\' order by ul."CREATED_DATE" DESC,ul."JENIS_STATUS" asc)';
    		$result['total'] = $this->db->query($statement,array($form_num))->num_rows();
       	 	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        	$result['rows'] = $this->db->query($statement,array($form_num))->result();
    	}else if(substr($form_num,0,4)=='ULOK'){
    		$statement=	'(select ul."STATUS",ul."JENIS_STATUS",ul."CREATED_DATE",uf."ULOK_FORM_NUM" as "FORM_NUM",us."USERNAME" from ulok_log_status as ul join ulok_form as uf on ul."FORM_ID"=uf."ULOK_FORM_ID"  join  sys_user as us on us."USER_ID"=ul."CREATED_BY" WHERE ul."FORM_ID"=(SELECT uf."ULOK_FORM_ID" from ulok_form as uf where uf."ULOK_FORM_NUM"=?) AND ul."TIPE_FORM" = \'ULOK\' ORDER BY ul."CREATED_DATE" DESC ,ul."JENIS_STATUS" asc )';
    		$result['total'] = $this->db->query($statement,array($form_num))->num_rows();
       	 	$statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
        	$result['rows'] = $this->db->query($statement,array($form_num))->result();
    	}
    	

        return $result;
    }

    public function count_data_table_log_status($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   if($this->session->userdata('role_id')=='4'){
            //RFM
            $statement='select (select count(DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" JOIN ulok_form as uf on uf."ULOK_FORM_ID"=ul."FORM_ID" WHERE utx."TIPE_FORM"=\'ULOK\' and ul."TIPE_FORM"= \'ULOK\''.$wheretambahan_ulok.')+( select count(DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" join to_form as tf on tf."TO_FORM_ID"=ul."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND ul."TIPE_FORM"=\'TO\' '.$wheretambahan_to.'  ) as "hitung"';
            return $this->db->query($statement)->row();
        }else if($this->session->userdata('role_id')=='5'  || $this->session->userdata('role_id')=='2' ){
            // franchise mgr cabang
            $statement='select (select count(DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" join ulok_form as uf on uf."ULOK_FORM_ID"=ul."FORM_ID" WHERE utx."BRANCH_ID"=? and  utx."TIPE_FORM"=\'ULOK\' and ul."TIPE_FORM"= \'ULOK\' '.$wheretambahan_ulok.')+( select count(DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" join to_form as tf on tf."TO_FORM_ID"=ul."FORM_ID" WHERE utx."BRANCH_ID"=? and utx."TIPE_FORM" = \'TO\' AND ul."TIPE_FORM"=\'TO\'  '.$wheretambahan_to.'  ) as "hitung"';
            return $this->db->query($statement,array($this->session->userdata('branch_id'),$this->session->userdata('branch_id')))->row();
        }else if($this->session->userdata('role_id')=='1' || $this->session->userdata('role_id')=='3'){
            //admin dan org HO
            $statement='select (select count(DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" join ulok_form as uf on uf."ULOK_FORM_ID"=ul."FORM_ID" WHERE utx."TIPE_FORM"=\'ULOK\' and ul."TIPE_FORM"= \'ULOK\' '.$wheretambahan_ulok.')+( select  count( DISTINCT ul."FORM_ID") FROM ulok_log_status as ul  join ulok_trx as utx on utx."FORM_ID"= ul."FORM_ID" join to_form as tf on tf."TO_FORM_ID"=ul."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND ul."TIPE_FORM"=\'TO\'  '.$wheretambahan_to.'  ) as "hitung"';
            return $this->db->query($statement)->row(); 
        }
          
    }
    public function update_status_cbg($ulok_form_num,$status_awal,$status_akhir,$tipe_form)
    {
    	if($tipe_form=='ULOK'){
    			$statement = 'UPDATE public.ulok_trx
   					  SET "STATUS"=? ,"TGL_STATUS"=CURRENT_DATE,
         			  "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?
 					  WHERE  "TIPE_FORM" LIKE \'ULOK\' and "FORM_ID" =
 					  (SELECT "ULOK_FORM_ID" FROM ulok_form where "ULOK_FORM_NUM" = ?) and "STATUS" = ?';
				$this->db->query($statement, array($status_akhir,$this->session->userdata('user_id'),$ulok_form_num,$status_awal));
    			return $this->db->affected_rows();
    	}else if($tipe_form=='TO'){
    		  $statement = 'UPDATE public.ulok_trx
   					  SET "STATUS"=? ,"TGL_STATUS"=CURRENT_DATE,
         			  "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=?
 					  WHERE  "TIPE_FORM" LIKE \'TO\' and "FORM_ID" =
 					  (SELECT "TO_FORM_ID" FROM to_form where "TO_FORM_NUM" = ?) and "STATUS" = ?';
				$this->db->query($statement, array($status_akhir,$this->session->userdata('user_id'),$ulok_form_num,$status_awal));
    			return $this->db->affected_rows();
    	}
    
    }

    public function get_form_num_from_lpdu($cabang,$periode)
    {
    	if($cabang != '0'){
    		$statement='SELECT uf."ULOK_FORM_NUM",utx."TIPE_FORM" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and uf."BRANCH_ID"=? and utx."STATUS"=\'N\' UNION SELECT tf."TO_FORM_NUM" AS "ULOK_FORM_NUM",utx."TIPE_FORM" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'TO\' and tf."BRANCH_ID"=? and utx."STATUS"=\'N\'  ';
    		return $this->db->query($statement,array($cabang,$cabang))->result();
    	}else if($cabang=='0'){
    		$statement='SELECT uf."ULOK_FORM_NUM",utx."TIPE_FORM" FROM ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'ULOK\' and utx."STATUS"=\'N\' UNION SELECT tf."TO_FORM_NUM" AS "ULOK_FORM_NUM",utx."TIPE_FORM" FROM to_form as tf join ulok_trx as utx on tf."TO_FORM_ID" = utx."FORM_ID" where utx."TIPE_FORM"=\'TO\' and utx."STATUS"=\'N\'  ';
    		return $this->db->query($statement)->result();
    	}
    }

     public function get_lduk_id($lduk_form_num)
    {
    	$statement='SELECT "LDUK_ID" from ulok_lduk where "LDUK_FORM_NUM" = ?';
    	return $this->db->query($statement,array($lduk_form_num))->row()->LDUK_ID;
    }
  
    public function get_lpdu_id($lpdu_form_num)
    {
    	$statement='SELECT "LPDU_ID" from ulok_lpdu where "LPDU_FORM_NUM" = ?';
    	return $this->db->query($statement,array($lpdu_form_num))->row()->LPDU_ID;
    }
    public function get_all_file_id($tipe_form,$form_num)
    {
    	$statement='SELECT "MASTER_FILE_ID" FROM ulok_master_file where "TIPE_FORM"=? and "FORM_NUM"=?';
    	return $this->db->query($statement,array($tipe_form,$form_num))->result();
    	
    }
	public function getEmailOTPApp($username){
		$statement='SELECT "EMAIL" FROM sys_user where "USERNAME" = ?';
		return $this->db->query($statement,$username)->row()->EMAIL;
	}
	public function insertNewOTP($user_id,$ref_num,$otp_num,$active_date,$inactive_date,$tipe_form){
		$statement='UPDATE sys_ref_num_otp set "USABLE_FLAG" = \'N\' WHERE "USER_ID" = ?';
		$this->db->query($statement, array($user_id));
    	$this->db->affected_rows();
    	$statement1='INSERT INTO sys_ref_num_otp("USER_ID","REF_NUM","OTP_NUM","ACTIVE_DATE","INACTIVE_DATE","USABLE_FLAG","TIPE_FORM") values(?,?,?,?,?,\'Y\',?)';
    	$this->db->query($statement1, array($user_id,$ref_num,$otp_num,$active_date,$inactive_date,$tipe_form));
    	return $this->db->affected_rows();
    	
    }
 	public function validatePinOTP($user_id,$ref_num,$pin,$now,$tipe_form){
		$otp_num = hash('SHA512',$pin);
		$statement='select "ID" from sys_ref_num_otp where "USER_ID" = ?  and "REF_NUM" = ? and "OTP_NUM" = ? and "USABLE_FLAG" = \'Y\' and ? BETWEEN "ACTIVE_DATE" AND "INACTIVE_DATE" and trim("TIPE_FORM") =? ';

    	$result=$this->db->query($statement, array($user_id,$ref_num,$otp_num,$now,$tipe_form))->row();

    	$result_baris=$this->db->query($statement, array($user_id,$ref_num,$otp_num,$now,$tipe_form))->num_rows();
    	
		if($result_baris !='0'){
			$statement2='update sys_ref_num_otp set "USABLE_FLAG" = \'N\' where "ID" = ?';
			$ID=$result->ID;
    		$this->db->query($statement2, array($ID));
    		return $this->db->affected_rows();
		}
		
	}
	public function insert_ulok_master_file($form_id,$file_bukti_trf,$tipe_form){
		if($tipe_form=='ULOK' || $tipe_form=='ULOK_SURVEY'){
		$statement='INSERT INTO public.ulok_master_file("FORM_ID", "TIPE_FORM", "FILE_BUKTI_TRF","CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","FORM_NUM")VALUES ( (SELECT "ULOK_FORM_ID" from ulok_form where "ULOK_FORM_NUM"=?), ?, ?,?,CURRENT_TIMESTAMP, ?,?)';
		$this->db->query($statement, array($form_id,$tipe_form,$file_bukti_trf,$this->session->userdata('user_id'),$this->session->userdata('user_id'),$form_id));
    	return $this->db->affected_rows();
		}else if($tipe_form=='TO' || $tipe_form=='TO_SURVEY'){
		$statement='INSERT INTO public.ulok_master_file("FORM_ID", "TIPE_FORM", "FILE_BUKTI_TRF","CREATED_BY", "LAST_UPDATE_DATE", "LAST_UPDATE_BY","FORM_NUM")VALUES ( (SELECT "TO_FORM_ID" from to_form where "TO_FORM_NUM"=?), ?, ?,?,CURRENT_TIMESTAMP, ?,?)';
		$this->db->query($statement, array($form_id,$tipe_form,$file_bukti_trf,$this->session->userdata('user_id'),$this->session->userdata('user_id'),$form_id));
    	return $this->db->affected_rows();
		}
	
	}
	public function update_ulok_master_file($form_id,$tipe_form,$master_file_id){
		$statement='UPDATE public.ulok_master_file SET  "FORM_ID"=?, "LAST_UPDATE_DATE"=CURRENT_TIMESTAMP, "LAST_UPDATE_BY"=? WHERE "TIPE_FORM"=? and "MASTER_FILE_ID"=?';
		$this->db->query($statement, array($form_id,$this->session->userdata('user_id'),$tipe_form,$master_file_id));
    	return $this->db->affected_rows();

	}
	public function get_data_from_lduk($lduk){
		$statement='SELECT "FORM_ID","TIPE_FORM" from ulok_trx where "LDUK_ID"=(select "LDUK_ID" from ulok_lduk where "LDUK_FORM_NUM" = ?);';
    	return $this->db->query($statement,array($lduk))->result();
	}
	public function get_data_from_lpdu($lpdu){
		$statement='SELECT "FORM_ID","TIPE_FORM" from ulok_trx where "LPDU_ID"=(select "LPDU_ID" from ulok_lpdu where "LPDU_FORM_NUM" = ?);';
    	return $this->db->query($statement,array($lpdu))->result();
	}
	public function delete_ulok_master_file($form_num,$file_bukti_trf,$tipe_form)
	{
		if($tipe_form=='ULOK' || $tipe_form =='ULOK_SURVEY'){
			$statement='DELETE FROM public.ulok_master_file WHERE "TIPE_FORM"=? and "FORM_ID" = (SELECT "ULOK_FORM_ID" FROM ulok_form WHERE "ULOK_FORM_NUM" = ? ) AND "FILE_BUKTI_TRF" = ?';
			$this->db->query($statement, array($tipe_form,$form_num,$file_bukti_trf));
    		return $this->db->affected_rows();
		}else if($tipe_form=='TO' || $tipe_form=='TO_SURVEY'){
			$statement='DELETE FROM public.ulok_master_file WHERE "TIPE_FORM"=? and "FORM_ID" = (SELECT "TO_FORM_ID" FROM to_form WHERE "TO_FORM_NUM" = ? ) AND "FILE_BUKTI_TRF" = ?';
			$this->db->query($statement, array($tipe_form,$form_num,$file_bukti_trf));
    		return $this->db->affected_rows();
		}
	
	}

	//

	public function get_data_log_bbt($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
    	
    	$statement='SELECT  1 as "SORT_ID" ,uf."ULOK_FORM_ID" as "FORM_ID",uf."ULOK_FORM_NUM" as "FORM_NUM",utx."BBT_NUM"as "BBT_NUM" ,utx."BBT_DATE" as "BBT_DATE",utx."BBT_AMOUNT" as "BBT_AMOUNT" from ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" where "BBT_NUM" IS NOT NULL AND "BBT_DATE" IS NOT NULL AND "BBT_AMOUNT" >0  '.$wheretambahan_ulok.' union select 2 as "SORT_ID",tf."TO_FORM_ID" as "FORM_ID",tf."TO_FORM_NUM" as "FORM_NUM" ,utx."BBT_NUM" as "BBT_NUM",utx."BBT_DATE" AS "BBT_DATE",utx."BBT_AMOUNT" as "BBT_AMOUNT" from to_form as tf join ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID"  where "BBT_NUM" IS NOT NULL AND "BBT_DATE" IS NOT NULL AND "BBT_AMOUNT" >0 '.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC';

		        $result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;
        
    }

    public function count_data_table_log_bbt($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   
    	$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" WHERE  utx."TIPE_FORM" = \'ULOK\' and utx."BBT_NUM" IS NOT NULL AND utx."BBT_DATE" is not null and utx."BBT_AMOUNT" >0 '.$wheretambahan_ulok.')+( SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND utx."BBT_NUM" is not null and utx."BBT_DATE" is not null and utx."BBT_AMOUNT" >0  '.$wheretambahan_to.'  ) as "hitung"';
		return $this->db->query($statement)->row();
    	
          
    }


	public function get_data_log_no_bbt($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
    	
    	$statement='SELECT  1 as "SORT_ID" ,uf."ULOK_FORM_ID" as "FORM_ID",uf."ULOK_FORM_NUM" as "FORM_NUM" from ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" where "BBT_NUM" IS NULL AND "BBT_DATE" IS NULL '.$wheretambahan_ulok.' union select 2 as "SORT_ID",tf."TO_FORM_ID" as "FORM_ID",tf."TO_FORM_NUM" as "FORM_NUM" from to_form as tf join ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID"  where "BBT_NUM" IS NULL AND "BBT_DATE" IS NULL  '.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC';

		        $result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;
        
    }

    public function count_data_table_log_no_bbt($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   
    	$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" WHERE  utx."TIPE_FORM" = \'ULOK\' and utx."BBT_NUM" IS  NULL AND utx."BBT_DATE" is null  '.$wheretambahan_ulok.')+( SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND utx."BBT_NUM" is  null and utx."BBT_DATE" is  null  '.$wheretambahan_to.'  ) as "hitung"';
		return $this->db->query($statement)->row();
    	
          
    }

    public function get_data_log_bbk($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
    	
    	$statement='SELECT  1 as "SORT_ID" ,uf."ULOK_FORM_ID" as "FORM_ID",uf."ULOK_FORM_NUM" as "FORM_NUM",utx."BBK_NUM"as "BBK_NUM" ,utx."BBK_DATE" as "BBK_DATE",utx."BBK_AMOUNT" as "BBK_AMOUNT" from ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" where "BBK_NUM" IS NOT NULL AND "BBK_DATE" IS NOT NULL AND "BBK_AMOUNT" >0'.$wheretambahan_ulok.' union select 2 as "SORT_ID",tf."TO_FORM_ID" as "FORM_ID",tf."TO_FORM_NUM" as "FORM_NUM" ,utx."BBK_NUM" as "BBK_NUM",utx."BBK_DATE" AS "BBK_DATE",utx."BBK_AMOUNT" as "BBK_AMOUNT" from to_form as tf join ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID"  where "BBK_NUM" IS NOT NULL AND "BBK_DATE" IS NOT NULL AND "BBK_AMOUNT" >0   '.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC ';

		        $result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;
        
    }

    public function count_data_table_log_bbk($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   
    	$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" WHERE  utx."TIPE_FORM" = \'ULOK\' and utx."BBK_NUM" IS NOT NULL AND utx."BBK_DATE" is not null and utx."BBK_AMOUNT" >0   '.$wheretambahan_ulok.')+( SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\' AND utx."BBK_NUM" is not null and utx."BBK_DATE" is not null and utx."BBK_AMOUNT" >0  '.$wheretambahan_to.'  ) as "hitung"';
		return $this->db->query($statement)->row();
    	
          
    }

    public function get_data_log_no_bbk($page,$rows,$wheretambahan_ulok = NULL,$wheretambahan_to=NULL)

    {   $page = ($page - 1) * $rows;
    	
    	$statement='SELECT  1 as "SORT_ID" ,uf."ULOK_FORM_ID" as "FORM_ID",uf."ULOK_FORM_NUM" as "FORM_NUM" from ulok_form as uf join ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" where utx."BBT_NUM" is not null and  "BBK_NUM" IS NULL AND "BBK_DATE" IS NULL  '.$wheretambahan_ulok.' union select 2 as "SORT_ID",tf."TO_FORM_ID" as "FORM_ID",tf."TO_FORM_NUM" as "FORM_NUM" from to_form as tf join ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID"  where utx."BBT_NUM" is not null and  "BBK_NUM" IS NULL AND "BBK_DATE" IS NULL  '.$wheretambahan_to.' order by "SORT_ID","FORM_ID" DESC ';

		        $result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;
        
    }

    public function count_data_table_log_no_bbk($wheretambahan_ulok = NULL,$wheretambahan_to=NULL)
    {   
    	$statement='select (SELECT count(uf."ULOK_FORM_NUM") from public.ulok_form as uf join public.ulok_trx as utx on uf."ULOK_FORM_ID"=utx."FORM_ID" WHERE  utx."TIPE_FORM" = \'ULOK\' and utx."BBT_NUM" is not null and  utx."BBK_NUM" IS  NULL AND utx."BBK_DATE" is null  '.$wheretambahan_ulok.')+( SELECT count(tf."TO_FORM_NUM") from public.to_form as tf join public.ulok_trx as utx on tf."TO_FORM_ID"=utx."FORM_ID" WHERE utx."TIPE_FORM" = \'TO\'  and utx."BBT_NUM" is not null  AND utx."BBK_NUM" is  null and utx."BBK_DATE" is  null '.$wheretambahan_to.'  ) as "hitung"';
		return $this->db->query($statement)->row();
    	
          
    }
//start finalisasi to
   public function count_data_finalisasi_to($wheretambahan_to=NULL)
    {   
    	$statement='select count(tf."TO_FORM_NUM") as  "hitung" from to_form as tf join ulok_trx as utx on utx."FORM_ID"=tf."TO_FORM_ID" where utx."STATUS_ULOK"=\'NOK\' and utx."STATUS"=\'NOK\'  '.$wheretambahan_to.' ';
		return $this->db->query($statement)->row();
    	
          
    }

    public function updateStatusFinalisasiTO($status_cabang,$status_ho,$form_id) {
    	$tipe_form='TO';
    	$statement='UPDATE ulok_trx set "STATUS"=?, "STATUS_HO" = ?,"TGL_STATUS_HO" =CURRENT_DATE,"LAST_UPDATE_DATE"=CURRENT_DATE,"LAST_UPDATE_BY"=? WHERE "FORM_ID"=? AND "TIPE_FORM" = ?';
    	$this->db->query($statement, array($status_cabang,$status_ho,$this->session->userdata('user_id'),$form_id,$tipe_form));
    	return $this->db->affected_rows();
    }

    public function get_data_finalisasi_to($page,$rows,$wheretambahan_to=NULL)
    {
    	 $page = ($page - 1) * $rows;
    	
    	$statement='select tf."TO_FORM_ID" as "FORM_ID",tf."TO_FORM_NUM" ,utx."STATUS" as "STATUS_CABANG" from to_form as tf join ulok_trx as utx on utx."FORM_ID"=tf."TO_FORM_ID" where utx."STATUS_ULOK"=\'NOK\' and utx."STATUS"=\'NOK\'   '.$wheretambahan_to.' ORDER BY tf."TO_FORM_ID" desc';

		        $result['total'] = $this->db->query($statement,array())->num_rows();
		        $statement .= ' LIMIT '.$rows.' OFFSET '.$page.'';
		        $result['rows'] = $this->db->query($statement,array())->result();

        		return $result;
    }

//end finalisasi to



}

/* End of file M_Ulok.php */
/* Location: ./application/models/M_Ulok.php */