<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ulok extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Ulok');
        if (!$this->session->userdata('is_login')) {
            redirect('Auth/logout','refresh');
        }
    }

    public function index()
    {
        
    }


     public function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
 
    public function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }           
        return $hasil;
    }
    //start bapp
    public function inquiry_bapp(){
       $data= '';
       $this->load->view('Ulok/V_inquiry_bapp',$data);
    }

    public function  get_data_list_bapp()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;

        $bapp= isset($_POST['bapp']) ? $_POST['bapp'] : '';
       
        if($this->session->userdata('role_id')=='2' ||$this->session->userdata('role_id')=='5'  ){
            //franchise cabang && franchise mgr cabang
            if($bapp == ""){
                 $where_bapp='AND umb."BRANCH_ID" = '.$this->session->userdata('branch_id').'';
             }else{
                 $where_bapp='AND umb."BRANCH_ID" = '.$this->session->userdata('branch_id').'AND bapp."BAPP_FORM_NUM" LIKE upper(\'%'.$bapp.'%\' )';
             }
        }else if($this->session->userdata('role_id')=='1' ||$this->session->userdata('role_id')=='3'   || $this->session->userdata('role_id')=='6' || $this->session->userdata('role_id')=='7'){

            if($bapp == ""){
                 $where_bapp=null;
             }else{
                 $where_bapp='AND bapp."BAPP_FORM_NUM" LIKE upper(\'%'.$bapp.'%\' )';
             }
        }else if($this->session->userdata('role_id')=='4'){
            if($bapp == ""){
                 $where_bapp=NULL;
             }else{
                 $where_bapp='AND bapp."BAPP_FORM_NUM" LIKE upper(\'%'.$bapp.'%\' )';
             }
        }else{
             if($bapp == ""){
                 $where_bapp='AND umb."BRANCH_ID" = '.$this->session->userdata('branch_id').'';
             }else{
                 $where_bapp='AND umb."BRANCH_ID" = '.$this->session->userdata('branch_id').'AND bapp."BAPP_FORM_NUM" LIKE upper(\'%'.$bapp.'%\' )';
             }
        }
        $rs = $this->M_Ulok->count_data_table_bapp($where_bapp);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_bapp($page,$rows,$where_bapp);
        $items = array();
                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }
    //end bapp

    //start function log bbk dan bbt
    
    public function  get_data_log_bbt()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;

        $tgl_bbt= isset($_POST['tgl_log_bbt']) ? $_POST['tgl_log_bbt'] : '';
       
        if($tgl_bbt == ""){
            $where_tgl_bbt_ulok=null;
            $where_tgl_bbt_to=null;
        }else{
            $where_tgl_bbt_ulok='AND (SELECT utx."LAST_UPDATE_DATE"::date)   = \''.$tgl_bbt.'\'';
            $where_tgl_bbt_to='AND (SELECT utx."LAST_UPDATE_DATE"::date )=  \''.$tgl_bbt.'\' ';
        }
        $rs = $this->M_Ulok->count_data_table_log_bbt($where_tgl_bbt_ulok,$where_tgl_bbt_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_log_bbt($page,$rows,$where_tgl_bbt_ulok,$where_tgl_bbt_to);
        $items = array();
                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }


    public function  get_data_log_bbk()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;

        $tgl_bbk= isset($_POST['tgl_log_bbk']) ? $_POST['tgl_log_bbk'] : '';
       
        if($tgl_bbk == ""){
            $where_tgl_bbk_ulok=null;
            $where_tgl_bbk_to=null;
        }else{
            $where_tgl_bbk_ulok='AND utx."LAST_UPDATE_DATE"::date  = \''.$tgl_bbk.'\'';
            $where_tgl_bbk_to='AND utx."LAST_UPDATE_DATE"::date =  \''.$tgl_bbk.'\' ';
        }
        $rs = $this->M_Ulok->count_data_table_log_bbk($where_tgl_bbk_ulok,$where_tgl_bbk_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_log_bbk($page,$rows,$where_tgl_bbk_ulok,$where_tgl_bbk_to);
        $items = array();

                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }



    public function  get_data_log_no_bbk()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;

        $tgl_bbk= isset($_POST['tgl_log_no_bbk']) ? $_POST['tgl_log_no_bbk'] : '';
       
        if($tgl_bbk == ""){
            $where_tgl_bbk_ulok=null;
            $where_tgl_bbk_to=null;
        }else{
            $where_tgl_bbk_ulok='AND utx."LAST_UPDATE_DATE"::date =  \''.$tgl_bbk.'\'';
            $where_tgl_bbk_to='AND utx."LAST_UPDATE_DATE"::date  = \''.$tgl_bbk.'\' ';
        }
        $rs = $this->M_Ulok->count_data_table_log_no_bbk($where_tgl_bbk_ulok,$where_tgl_bbk_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_log_no_bbk($page,$rows,$where_tgl_bbk_ulok,$where_tgl_bbk_to);
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
    //end



    //start function global

public function indonesian_date ($nama_hari) {
    
    if(trim($nama_hari)=='sunday'){
        $date='Minggu';
    }else if(trim($nama_hari)=='monday'){
        $date='Senin';
    }else if(trim($nama_hari)=='tuesday'){
        $date='Selasa';
    }else if(trim($nama_hari)=='wednesday'){
        $date='Rabu';
    }else if(trim($nama_hari)=='thursday'){
        $date='Kamis';
    }else if(trim($nama_hari)=='friday'){
        $date='Jumat';
    }else if(trim($nama_hari)=='saturday'){
        $date='Sabtu';
    }

    return $date;
}
    
   
    public function get_data_bank_all()
    {
        $result = $this->M_Ulok->get_data_bank_all();
        echo json_encode($result);
    }


    public function get_data_role()
    {
        $result = $this->M_Ulok->get_data_role();
        echo json_encode($result);
    }
    public function get_data_cabang_all()
    {
        $result = $this->M_Ulok->get_data_cabang_all();
        echo json_encode($result);

    }

    public function get_data_cabang_all_w_HO()
    {

        $result = $this->M_Ulok->get_data_cabang_all_w_HO();
        echo json_encode($result);
    }

    public function get_data_cabang_all_lpdu()
    {
        $result = $this->M_Ulok->get_data_cabang_all_lpdu();
        echo json_encode($result);

    }

    

    public function get_branch_from_region()
    {
        $data=$this->input->post();
        $result = $this->M_Ulok->get_branch_from_region($data['region']);
        echo json_encode($result);
    }
   

    public function get_all_kab_name($province)
    {
        $result =$this->M_Ulok->get_all_kab_name($province);
        echo json_encode($result);
    }

    public function get_all_kec_name($kabupaten)
    {
        $result =$this->M_Ulok->get_all_kec_name($kabupaten);
        echo json_encode($result);
    }

    public function get_all_kel_name($kecamatan)
    {
        $result =$this->M_Ulok->get_all_kel_name($kecamatan);
        echo json_encode($result);
    }
    
    public function get_all_province()
    {
        $result =$this->M_Ulok->get_all_province();
        echo json_encode($result);
     
            
    }

    public function get_all_kdpos($kelurahan)
    {
        $result =$this->M_Ulok->get_all_kdpos($kelurahan);
        echo json_encode($result);
     
            
    }
    
    public function get_data_period()
    {

        $table = array("JAN", "FEB", "MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
        $table_num=array("01","02","03","04","05","06","07","08","09","10","11","12");
        $year_period =$this->M_Ulok->get_year_period();
        $arrlength = count($table);
        $yearlength= count($year_period);
        $hasil="";
        $hasil_array=[];
        $i=0;
            for($x=0;$x<$yearlength;$x++){
            for($y=0;$y<$arrlength;$y++){
                $hasil= $table[$y]."-".$year_period[$x]->PERIOD_NAME;
                $hasil_num=$table_num[$y]."-".$year_period[$x]->PERIOD_NAME;
                $hasil_array [$i]["PERIOD_NAME"]= $hasil;
                $hasil_array[$i]["PERIOD_NUM"]=$hasil_num;
                $i++;
            }
        }    
       echo json_encode($hasil_array);
    }

    public function get_data_region()
    {

        $result = $this->M_Ulok->get_data_region_all();
        echo json_encode($result);
    }

   public function cekOldCode(){       
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d H:i:s");     
        $datanya=$this->input->post();
        $user_id = $this->session->userdata('user_id');
        $data = $this->M_Ulok->getCodeOTP($user_id,$now,$datanya['tipe_form']);

        if($data['jumlah']=='0'){
            $control_data['kode_ref'] = '-';
            $control_data['note_text']='';
        }else{ 
            $control_data['kode_ref']=$data['hasil']->REF_NUM;
            $control_data['note_text']='Anda memiliki satu kode yang belum digunakan';         
        }
        echo json_encode($control_data);
    }
    public function romanic_number($integer, $upcase = true) 
    { 
        $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
        $return = ''; 
        while($integer > 0) 
        { 
            foreach($table as $rom=>$arb) 
            { 
                if($integer >= $arb) 
                { 
                    $integer -= $arb; 
                    $return .= $rom; 
                    break; 
                } 
            } 
        } 

        return $return; 
    }
    private function generateRefNum(){
        $x_1 = range('A', 'Z');
        $x_2 = range(0,9);
        
        $otp ='';
        $ref_num = '';
        
        for ($y=0;$y<=11;$y++){
            $rand = rand(1,2);
            
            if($rand == 1){
                $ref_num .= $x_1[rand(0,25)];
            }else{
                $ref_num .= $x_2[rand(0,9)];
            }
        }
        return $ref_num;
    }

    private function generateOTP($str){
        $a = '';
        $before = 0;
        for ($x=1;$x<=6;$x++){  
            $sHash = bin2hex(mhash(MHASH_SHA1,$str, microtime() * 1000000));
            $sSeed = implode(unpack('H*',$sHash),'');
            
            $rand = mt_rand(1,79);
            
            while($rand == $before){
                $rand = mt_rand(1,79);              
            }
            
            $a.= substr($sSeed,$rand,1);
            $before = $rand;
        }
        return $a;
    }
    public function requestNewCode(){
        $data=$this->input->post();
        $user_id = $this->session->userdata('user_id');
        $ref_num = $this->generateRefNum();
        $otp = $this->generateOTP($user_id);        
        date_default_timezone_set('Asia/Jakarta');
        $active_date = date("Y-m-d H:i:s");
        $inactive_date = date("Y-m-d H:i:s",time()+86400);
        
       $this->sendMailLocation($ref_num,$otp,$inactive_date,$data['tipe_form']);
                
        $otp_num = hash('SHA512',$otp);
        $this->M_Ulok->insertNewOTP($user_id,$ref_num,$otp_num,$active_date,$inactive_date,$data['tipe_form']);
        
        $control_data['kode_ref'] =  $ref_num;
        $control_data['note_text']='';
        echo json_encode($control_data);
    }
   
  
    public function submit_otp(){
            $data=$this->input->post();
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set('Asia/Jakarta');
            $now = date("Y-m-d H:i:s");
            $ref_num = $data['ref_num'];
            $pin = $data['input_otp'];
            $tipe_form=$data['tipe_form'];
            
            $result  = $this->M_Ulok->validatePinOTP($user_id,$ref_num,$pin,$now,$tipe_form);
            if($result != 0){
                $control_data['hasil'] = 'success';
            }else{
                $control_data['hasil'] = 'failed';
            }
            echo json_encode($control_data);
            
    }

    public function month_name($integer, $upcase = true) 
    { 
        
        $table = array("","JAN", "FEB", "MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
        $arrlength = count($table);
        $return = ''; 
        for($x = 0; $x < $arrlength; $x++) {
            if($integer == $x){
                $return= $table[$x];
                
                break;
            }else{
               
            }
        }
         

        return $return; 
    }
    
    public function count_amount_of_file()
    {
         $data = $this->input->post();
         $result = $this->M_Ulok->count_amount_of_file($data['form_num']);
         echo json_encode($result);
    }

    


    public function get_file_uploaded()
    {
        $data = $this->input->post();
        $result = $this->M_Ulok->get_file_uploaded($data['form_num'],$data['tipe_form']);
        echo json_encode($result);
    }

    public function insert_ulok_master_file()
    {

        $data = $this->input->post(); 
        $form_num_res= str_replace("-","/",$data['form_num']);
        $result = $this->M_Ulok->insert_ulok_master_file($form_num_res,$data['file_bukti_trf'],$data['tipe_form']);
        echo json_encode($result);

    }
    //end function global
    //start history status
    public function  get_data_log_status()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform= isset($_POST['noform']) ? $_POST['noform'] : '';
       
        if($noform == ""){
            $where_noform_ulok=null;
            $where_noform_to=null;
        }else{
            $where_noform_ulok='AND uf."ULOK_FORM_NUM" LIKE upper(\'%'.$noform.'%\')';
            $where_noform_to='AND tf."TO_FORM_NUM" LIKE upper(\'%'.$noform.'%\' )';
        }
        $rs = $this->M_Ulok->count_data_table_log_status($where_noform_ulok,$where_noform_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_log_status($page,$rows,$where_noform_ulok,$where_noform_to);
        $items = array();

                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }
    
    public function  get_detail_log_status($form_num)
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $form_num_res= str_replace("-","/",''.$form_num);
       
        $rs = $this->M_Ulok->count_get_detail_log_status($form_num_res);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_detail_log_status($page,$rows,$form_num_res);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }
    //end history status

    //start update status
    public function update_data_form_to()
    {
                $data = $this->input->post();
                $branch_id=$this->session->userdata('branch_id');
                $inserted_id = 0;
                $result=0;
                if ($data) {
                    $inserted_id = $this->M_Ulok->update_data_form_to($data);
                    $tipe_form='TO';
                
                }    
                return true;
    }
   
    public function update_status_cbg()
    {
        $data=$this->input->post();
        $jenis_status='STATUS_CABANG';
        $result = $this->M_Ulok->update_status_cbg($data['ulok_form_num'],$data['status_awal'],$data['status_akhir'],$data['tipe_form']);
        $this->M_Ulok->insert_log_status($data['ulok_form_num'],$data['tipe_form'],$data['status_akhir'],$jenis_status);
        echo json_encode($result);
    }


    public function generate_bapp()
    {
        $data=$this->input->post();
        if($this->M_Ulok->cek_ulok_bapp($data['form_num'],$data['tipe_form'])==0){

            $result= $this->M_Ulok->insert_ulok_bapp($data['form_num'],$data['tipe_form']);
            echo json_encode($result);
        }
    }
    public function update_ulok_survey_trx()
    {
        $data=$this->input->post();
        if($data['tgl_penyampai_survey']==''){
                $tgl_penyampai_survey=null;
            }else{
                $tgl_penyampai_survey=$data['tgl_penyampai_survey'];
            }
        $result = $this->M_Ulok->update_ulok_survey($data['tgl_survey'],$data['hasil_survey'],$data['alasan_survey'],$tgl_penyampai_survey,$data['form_id'],$data['tipe_form']);

        if($data['tgl_penyampai_survey'] !=''){

            if($data['tipe_form']=='ULOK'){
                 if($data['hasil_survey']=='OK' && $data['status_ulok']=='OK'){
                $status_cabang='OK';
                   echo "OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']=='NOK'){
                    $status_cabang='NOK';
                       echo "NOK";
                }else if($data['hasil_survey']=='OK' && $data['status_ulok']==''){
                    $status_cabang='S-OK';
                       echo "S-OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']==''){
                    $status_cabang='S-NOK';
                       echo "S-NOK";
                }else if($data['hasil_survey']=='' && $data['status_ulok']==''){
                    $status_cabang='S-OK';
                    echo "S-OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']=='OK'){
                    $status_cabang='OK';
                    echo "OK";
                }else{
                    $status_cabang='HANGUS';
                    echo "HANGUS";
                }
            }else if($data['tipe_form']=='TO'){
                if($data['hasil_survey']=='OK' && $data['status_ulok']=='OK'){
                $status_cabang='OK';
                   echo "OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']=='NOK'){
                    $status_cabang='NOK';
                       echo "NOK";
                }else if($data['hasil_survey']=='OK' && $data['status_ulok']==''){
                    $status_cabang='S-OK';
                       echo "S-OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']==''){
                    $status_cabang='S-NOK';
                       echo "S-NOK";
                }else if($data['hasil_survey']=='' && $data['status_ulok']==''){
                    $status_cabang='S-OK';
                    echo "S-OK";
                }else if($data['hasil_survey']=='NOK' && $data['status_ulok']=='OK'){
                    $status_cabang='OK';
                    echo "OK";
                }else{
                    $status_cabang='NOK';
                    echo "NOK";
                }
            }
           
            $jenis_status='STATUS_SURVEY';
            $this->M_Ulok->insert_log_status($data['form_id'],$data['tipe_form'],$data['hasil_survey'],$jenis_status);
            $jenis_status='STATUS_ULOK';
            $this->M_Ulok->insert_log_status($data['form_id'],$data['tipe_form'],$data['status_ulok'],$jenis_status);
            $jenis_status='STATUS_CABANG';
            $this->M_Ulok->insert_log_status($data['form_id'],$data['tipe_form'],$status_cabang,$jenis_status);
            $result_1 = $this->M_Ulok->update_ulok_trx($status_cabang,$data['status_ulok'],$data['alasan_status_ulok'],$data['tipe_form'],$data['form_id']);   
        }else{

            if($data['tipe_form']=='ULOK'){
                $status_cabang='EMAIL';
            }elseif($data['TIPE_FORM']=='TO'){
                $status_cabang='BBT';
            }
            $result_1 = $this->M_Ulok->update_ulok_trx($status_cabang,$data['status_ulok'],$data['alasan_status_ulok'],$data['tipe_form'],$data['form_id']);   
        }
       // echo json_encode($result_1);   
    }
   
    public function update_ulok_survey_by_frc_mgr()
    {
        $data=$this->input->post();

        if($data['hasil_survey']=='OK'){
            $status_cabang='S-OK';
        }else if($data['hasil_survey']='NOK'){
            $status_cabang='S-NOK';
        }
        if($data['tipe_form']=='ULOK'){

        $result = $this->M_Ulok->update_ulok_survey_by_frc_mgr($data['hasil_survey'],$data['alasan_survey'],$data['tgl_penyampai_survey'],$data['form_id'],$data['tipe_form']);
        $result_1 = $this->M_Ulok->update_ulok_trx_status_cbg_frc_manager($status_cabang,$data['form_id'],$data['tipe_form']);
        $jenis_status='STATUS_SURVEY';
        $this->M_Ulok->insert_log_status($data['form-id'],$data['tipe_form'],$data['hasil_survey'],$jenis_status);
        $jenis_status='STATUS_CABANG';
        $this->M_Ulok->insert_log_status($data['form-id'],$data['tipe_form'],$status_cabang,$jenis_status);  
        
        echo json_encode($result_1);
       }
         
    }
    public function update_ulok_trx_status_cbg()
    {

        $data=$this->input->post();
        $jenis_status='STATUS_CABANG';
        if($data['status']=='OK'){
            $status_cbg='F-OK';
        }else if($data['status']=='NOK'){
            $status_cbg='F-NOK';
        }
        $jenis_status='STATUS_CABANG';
        $this->M_Ulok->insert_log_status_by_form_id($data['form_id'],$data['tipe_form'],$status_cbg,$jenis_status);
        $result = $this->M_Ulok->update_ulok_trx_status_cbg($data['status'],$data['form_id'],$data['tipe_form']);
        echo json_encode($result);
    }

    public function update_ulok_trx_status_HO()
    {
        $data=$this->input->post();
        $result = $this->M_Ulok->update_ulok_trx_status_HO($data['status'],$data['form_id'],$data['tipe_form']);
        $jenis_status='STATUS_HO';
        $this->M_Ulok->insert_log_status_by_form_id($data['form_id'],$data['tipe_form'],$data['status'],$jenis_status);
        echo json_encode($result);
    }

    public function update_ulok_trx_status_HO_cabang()
    {

        $data=$this->input->post();
        $result = $this->M_Ulok->update_ulok_trx_status_HO_cabang($data['alasan_reject'],$data['status_ho'],$data['status_cbg'],$data['form_id'],$data['tipe_form']);
        $jenis_status='STATUS_CABANG';
        $this->M_Ulok->insert_log_status($data['form_id'],$data['tipe_form'],$data['status_cbg'],$jenis_status);
        $jenis_status='STATUS_HO';
        $this->M_Ulok->insert_log_status($data['form_id'],$data['tipe_form'],$data['status_ho'],$jenis_status);
        echo json_encode($result);
    }



    //end update status

    //start inquiry decide status to
     public function finalisasi_to()
    {
       $this->load->view('Ulok/V_finalisasi_to');
    }

      public function get_data_finalisasi_to()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform= isset($_POST['noform']) ? $_POST['noform'] : '';

        if($noform == ""){
            $where_noform_to=null;
        }else{
            $where_noform_to='AND tf."TO_FORM_NUM" LIKE \'%'.$noform.'%\' ';
        }
        if($this->session->userdata('role_id')=='3'){
           
            $where_status_cbg='AND (utx."STATUS" LIKE \'NOK\')    ';
         }        
        $wheretambahan_to=$where_noform_to;
        $rs = $this->M_Ulok->count_data_finalisasi_to($wheretambahan_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_finalisasi_to($page,$rows,$wheretambahan_to);
        $items = array();
                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
        
        
    }


    public function updateStatusFinalisasiTO()
    {
        $tipe_form='TO';
        $data=$this->input->post();
        if($data['status']=='HANGUS'){
            $status_cabang='HANGUS';
            $status_ho='HANGUS';
            $result = $this->M_Ulok->updateStatusFinalisasiTO($status_cabang,$status_ho,$data['form_id']);
            $jenis_status='STATUS_CABANG';
            $this->M_Ulok->insert_log_status($data['form_num'],$tipe_form,$status_cabang,$jenis_status);
            $jenis_status='STATUS_HO';
            $this->M_Ulok->insert_log_status($data['form_num'],$tipe_form,$status_ho,$jenis_status);
      
        }else if($data['status']=='FINAL-NOK'){
            $status_cabang='F-NOK';
            $status_ho='FINAL-NOK';
            $result = $this->M_Ulok->updateStatusFinalisasiTO($status_cabang,$status_ho,$data['form_id']);
            $jenis_status='STATUS_CABANG';
            $this->M_Ulok->insert_log_status($data['form_num'],$tipe_form,$status_cabang,$jenis_status);
            $jenis_status='STATUS_HO';
            $this->M_Ulok->insert_log_status($data['form_num'],$tipe_form,$status_ho,$jenis_status);
        }

     
              echo json_encode($result);
    }
    //end inquiry decide status to
    //start load view
    public function input_data_ulok()
    {
       $data['session_id']= uniqid();
       $this->load->view('Ulok/V_Input_data',$data);
    }


    public function get_running_num()
    {
        $branch_id=$this->session->userdata('branch_id');
        $branch_code=$this->session->userdata('branch_code');
        $data['form_num'] = 'ULOK/'.$this->M_Ulok->get_nextval_form_num($branch_id).'/'.$this->M_Ulok->get_branch_nick($branch_code).'/'.$this->month_name(intval(date('n'))).'/'.date('Y');
        echo "".$data['form_num'];
    }

    public function get_running_num_to()
    {
        $branch_id=$this->session->userdata('branch_id');
        $branch_code=$this->session->userdata('branch_code');
        $data['form_num'] = 'TO/'.$this->M_Ulok->get_nextval_to_form_num($branch_id).'/'.$this->M_Ulok->get_branch_nick($branch_code).'/'.$this->month_name(intval(date('n'))).'/'.date('Y');
        echo "".$data['form_num'];
        

    }
    public function inquiry_ulok_frc_cab()
    {
        $data['role_id'] = $this->session->userdata('role_id');
        $data['branch_id']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_Inquiry_frc_cab', $data);
    }

    public function inquiry_ulok_to_toko()
    {
        $data['role_id'] = $this->session->userdata('role_id');
        $data['branch_id']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_Inquiry_data_to_toko', $data);
    }

     public function inquiry_status()
    {
        $data['session_role']=$this->session->userdata('role_id');
        $data['session_branch']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_Inquiry_status',$data);
    }

    public function inquiry_hasil_survey_ulok_toko()
    {
       $data['role_id'] = $this->session->userdata('role_id');
        $this->load->view('Ulok/V_Inquiry_hasil_survey_ulok_toko',$data);
    }
    

    public function input_data_to_toko()
    {
        $data['session_id']= uniqid();
        $this->load->view('Ulok/V_Input_data_to_toko', $data);
    }

    //end load view
    //start ulok survey
    public function get_survey_data_ulok_specific()
    {

        $data=$this->input->post();
        $result = $this->M_Ulok->get_survey_data_ulok_specific($data['form_id'],$data['tipe_form']);
        echo json_encode($result);   
    }
    public function get_data_survey_ulok()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform= isset($_POST['noform']) ? $_POST['noform'] : '';
        $status_cbg= isset($_POST['status_cbg']) ? $_POST['status_cbg'] : '';
        $tanggal_mulai= isset($_POST['tanggal_mulai']) ? $_POST['tanggal_mulai'] : '';
        $tanggal_akhir= isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
        $tgl_start=$tanggal_mulai;
        $tgl_end= $tanggal_akhir; 

        if($noform == ""){
            $where_noform_ulok=null;
            $where_noform_to=null;
        }else{
            $where_noform_ulok='AND uf."ULOK_FORM_NUM" LIKE \'%'.$noform.'%\' ';
            $where_noform_to='AND tf."TO_FORM_NUM" LIKE \'%'.$noform.'%\' ';
        }
        if($status_cbg == ""){
            $where_status_cbg=null;
        }else{
            $where_status_cbg='AND utx."STATUS" = \''.$status_cbg.'\' ';
        }
        if($tgl_start == "--"  || $tgl_end== "--" ){
            $where_tanggal=null;
        }else if(($tgl_start != "--"  && $tgl_end != "--" ) && ($tgl_start != ""  && $tgl_end != "" )){
            $where_tanggal= 'AND( us."TGL_SURVEY" >= \''.$tgl_start.'\' AND us."TGL_SURVEY" <= \''.$tgl_end.'\')';
        }else {
              $where_tanggal=null;
        }
        if($this->session->userdata('role_id')=='4'){
           
            $where_status_cbg='AND (utx."STATUS" LIKE \'F-NOK\' OR utx."STATUS" LIKE \'F-OK\')    ';
            $wheretambahan_ulok=$where_noform_ulok.' '.$where_status_cbg.' '.$where_tanggal;   
        }else{
            $wheretambahan_ulok=$where_noform_ulok.' '.$where_status_cbg.' '.$where_tanggal;
        
        }        
        $wheretambahan_to=$where_noform_to.' '.$where_status_cbg.' '.$where_tanggal;
        $rs = $this->M_Ulok->count_data_survey_ulok($wheretambahan_ulok,$wheretambahan_to);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_survey_ulok($page,$rows,$wheretambahan_ulok,$wheretambahan_to);
        $items = array();
                foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
        
        
    }

    public function count_amount_of_file_survey()
    {
         $data = $this->input->post();
         $result = $this->M_Ulok->count_amount_of_file_survey($data['form_num'],$data['tipe_form']);
         echo json_encode($result);
    }

    //end ulok survey

    //start input data ulok
   /* public function upload_file_ulok()
    {
        $data = $this->input->post();
        $config['upload_path'] = './uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $confif['file_name'] = array("file_1.ext", "file_2.ext", "file_3.ext");
        $config['max_size']  = '3000000';
        $config['encrypt_name'] = TRUE; 
        $this->load->library('upload', $config);


        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';

        }
        if ($_FILES['file']['size'] > $config['max_size']) {
              echo "error_large";
              $uploadOk = 0;
        } 

        $target_dir = "uploads/";
        $target_file = $config['upload_path'] . basename($_FILES['file']['name']);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($fileType != "gif" && $fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "pdf" ) {
            echo "error_file";
        }

           
    }*/


    public function save_temp_file_ulok($form_num)
    {
        
        $config['upload_path'] = './uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']  = '10000';
        $config['encrypt_name'] = false; 
         if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"]);

            }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('filesToUpload')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg', '
                    <div id="warning_upload" class="easyui-window" title="Caution" style="width:300px;height:95px;"
                data-options="iconCls:\'icon-ok\',modal:true,collapsible:false,minimizable:false,maximizable:false">
                            <div class="easyui-layout" data-options="fit:true,closed:true">
                                  <div data-options="region:\'center\'">
                                        <center><h4>'.$this->upload->display_errors().'</h4></center>
                                  </div>
                            </div>
                      </div>');
            } 
        $temp = explode(".", $_FILES["filesToUpload"]["name"]);
        $newfilename = $form_num.'_'.$_FILES["filesToUpload"]["name"];
        
        if(file_exists("./uploads/bkt_trf/" . $newfilename)) {
               
                unlink("./uploads/bkt_trf/" . $newfilename);
                
            }
            move_uploaded_file($_FILES["filesToUpload"]["tmp_name"], "./uploads/bkt_trf/" . $newfilename);
              if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"]);

            }
        echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
    }
    public function delete_temp_file_ulok()
    {

        $data = $this->input->post(); 
       
        $file_name=$data['nama_file'];
        if($data['form_num']){
             $newfilename = $data['form_num'].'_'.$file_name;
            if(file_exists("./uploads/bkt_trf/" . $file_name)) {
                    
                    unlink("./uploads/bkt_trf/" . $file_name);
                    $form_num_res= str_replace("-","/",''.$data['form_num']);
                    $file_bukti_trf="http://192.168.71.212/ULOK/uploads/bkt_trf/".$file_name;
                    $result = $this->M_Ulok->delete_ulok_master_file($form_num_res,$file_bukti_trf,$data['tipe_form']);
                    echo json_encode($result);
                    echo "success";
                }else if (file_exists("./uploads/bkt_trf/" . $newfilename)){
                    unlink("./uploads/bkt_trf/" . $newfilename);
                    $form_num_res= str_replace("-","/",''.$data['form_num']);
                    $file_bukti_trf="http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
                    $result = $this->M_Ulok->delete_ulok_master_file($form_num_res,$file_bukti_trf,$data['tipe_form']);
                    echo json_encode($result);
                    echo "success";
                }else{
                    echo "sesudah:".$file_name;
                    echo "error";
                }
        }else{
               $otherfilename = $data['session_id'].'_'.$file_name;
            if (file_exists("./uploads/bkt_trf/" . $file_name)){
                    unlink("./uploads/bkt_trf/" . $file_name);
                    echo "success";
                }else if(file_exists("./uploads/bkt_trf/" . $otherfilename)){
                    unlink("./uploads/bkt_trf/" . $otherfilename);
                    echo "success";
                }else{
                    echo "sesudah:".$file_name;
                    echo "error";
                }
        }
       
    }

     
    public function save_data_form_ulok()
    {
        $data = $this->input->post();
        $branch_id=$this->session->userdata('branch_id');
        $data['form_num'] = 'ULOK/'.$this->M_Ulok->get_nextval_form_num_now($branch_id).'/'.$this->M_Ulok->get_branch_nick($this->session->userdata('branch_code')).'/'.$this->month_name(intval(date('n'))).'/'.date('Y');
        $inserted_id = 0;
        $result=0;

            if ($data) 
            {   $tipe_form='ULOK';
                $status='N';
                $jenis_status='STATUS_CABANG';
                $result = $this->M_Ulok->save_data_form_ulok($data); 
                $hasil= $this->M_Ulok->insert_log_status($data['form-num'],$tipe_form,$status,$jenis_status); 
                  echo $data['form_num'];  
            }
      
    }

    public function update_data_form_ulok()
    {

                $data = $this->input->post();
                $branch_id=$this->session->userdata('branch_id');
                $inserted_id = 0;
                $result=0;
                if ($data) {
                    $inserted_id = $this->M_Ulok->update_data_form_ulok($data);
                    $tipe_form='ULOK';
                
                }    
                return true;
    }


    //end input data ulok

    //start input ulok survey
        public function save_temp_file_ulok_survey($form_num)
    {
        
        $config['upload_path'] = './uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']  = '10000';
        $config['encrypt_name'] = false; 
         if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUploadSurvey"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadSurvey"]["name"]);

            }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('filesToUploadSurvey')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg', '
                    <div id="warning_upload" class="easyui-window" title="Caution" style="width:300px;height:95px;"
                data-options="iconCls:\'icon-ok\',modal:true,collapsible:false,minimizable:false,maximizable:false">
                            <div class="easyui-layout" data-options="fit:true,closed:true">
                                  <div data-options="region:\'center\'">
                                        <center><h4>'.$this->upload->display_errors().'</h4></center>
                                  </div>
                            </div>
                      </div>');
            } 
        $temp = explode(".", $_FILES["filesToUploadSurvey"]["name"]);
        $newfilename = $form_num.'_SURVEY_'.$_FILES["filesToUploadSurvey"]["name"];
        
        if(file_exists("./uploads/bkt_trf/" . $newfilename)) {
               
                unlink("./uploads/bkt_trf/" . $newfilename);
                
            }
            move_uploaded_file($_FILES["filesToUploadSurvey"]["tmp_name"], "./uploads/bkt_trf/" . $newfilename);
              if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUploadSurvey"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadSurvey"]["name"]);

            }
        echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
    }
    public function delete_temp_file_ulok_survey()
    {

        $data = $this->input->post();    
        $file_name=$data['nama_file'];
        $newfilename = $data['form_num'].'_SURVEY_'.$file_name;
        if(file_exists("./uploads/bkt_trf/" . $file_name)) {
                
                unlink("./uploads/bkt_trf/" . $file_name);
                $form_num_res= str_replace("-","/",''.$data['form_num']);
                $file_bukti_trf="http://192.168.71.212/ULOK/uploads/bkt_trf/".$file_name;
                $result = $this->M_Ulok->delete_ulok_master_file($form_num_res,$file_bukti_trf,$data['tipe_form']);
                echo json_encode($result);
                echo "success";
            }else if (file_exists("./uploads/bkt_trf/" . $newfilename)){
                unlink("./uploads/bkt_trf/" . $newfilename);
                $form_num_res= str_replace("-","/",''.$data['form_num']);
                $file_bukti_trf="http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
                $result = $this->M_Ulok->delete_ulok_master_file($form_num_res,$file_bukti_trf,$data['tipe_form']);
                echo json_encode($result);
                echo "success";
            }else{
                echo "sesudah:".$file_name;
                echo "error";
            }
    }

    //end input ulok survey

    //start input to
    public function save_temp_file_to($form_num)
    {
        
        $config['upload_path'] = 'uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']  = '10000';
        $config['encrypt_name'] = false; 
         if(file_exists("uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"]);

            }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('filesToUploadTo')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg', '
                    <div id="warning_upload" class="easyui-window" title="Caution" style="width:300px;height:95px;"
                data-options="iconCls:\'icon-ok\',modal:true,collapsible:false,minimizable:false,maximizable:false">
                            <div class="easyui-layout" data-options="fit:true,closed:true">
                                  <div data-options="region:\'center\'">
                                        <center><h4>'.$this->upload->display_errors().'</h4></center>
                                  </div>
                            </div>
                      </div>');
            } 
        $temp = explode(".", $_FILES["filesToUploadTo"]["name"]);
        $newfilename = $form_num.'_'.$_FILES["filesToUploadTo"]["name"];
       
        if(file_exists("./uploads/bkt_trf/" . $newfilename)) {
               
                unlink("./uploads/bkt_trf/" . $newfilename);
                
            }
              move_uploaded_file($_FILES["filesToUploadTo"]["tmp_name"], "./uploads/bkt_trf/" . $newfilename);
              if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"]);

            }
        echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;

    }
    
    public function save_temp_file_to_by_session($session_id)
    {
        
        $config['upload_path'] = './uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']  = '10000';
        $config['encrypt_name'] = false; 
        if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"]);

            }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('filesToUploadTo')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg', '
                    <div id="warning_upload" class="easyui-window" title="Caution" style="width:300px;height:95px;"
                data-options="iconCls:\'icon-ok\',modal:true,collapsible:false,minimizable:false,maximizable:false">
                            <div class="easyui-layout" data-options="fit:true,closed:true">
                                  <div data-options="region:\'center\'">
                                        <center><h4>'.$this->upload->display_errors().'</h4></center>
                                  </div>
                            </div>
                      </div>');
            } 

        $temp = explode(".", $_FILES["filesToUploadTo"]["name"]);
        $newfilename = $session_id.'_'.$_FILES["filesToUploadTo"]["name"];
       
        if(file_exists("./uploads/bkt_trf/" . $newfilename)) {
               
                unlink("./uploads/bkt_trf/" . $newfilename);
                
            }
            move_uploaded_file($_FILES["filesToUploadTo"]["tmp_name"], "./uploads/bkt_trf/" . $newfilename);
              if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUploadTo"]["name"]);

            }
        echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;

     

    }

    public function save_temp_file_ulok_by_session($session_id)
    {
        
        $config['upload_path'] = './uploads/bkt_trf/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
        $config['max_size']  = '10000';
        $config['encrypt_name'] = false; 
        if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"])) {          
                unlink("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"]);
            }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('filesToUpload')){
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('msg', '
                    <div id="warning_upload" class="easyui-window" title="Caution" style="width:300px;height:95px;"
                data-options="iconCls:\'icon-ok\',modal:true,collapsible:false,minimizable:false,maximizable:false">
                            <div class="easyui-layout" data-options="fit:true,closed:true">
                                  <div data-options="region:\'center\'">
                                        <center><h4>'.$this->upload->display_errors().'</h4></center>
                                  </div>
                            </div>
                      </div>');
            } 

        $temp = explode(".", $_FILES["filesToUpload"]["name"]);
        $newfilename = $session_id.'_'.$_FILES["filesToUpload"]["name"];
        if(file_exists("./uploads/bkt_trf/" . $newfilename)) {
                unlink("./uploads/bkt_trf/" . $newfilename);
            }
            move_uploaded_file($_FILES["filesToUpload"]["tmp_name"], "./uploads/bkt_trf/" . $newfilename);
              if(file_exists("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"])) {
              
                unlink("./uploads/bkt_trf/".$_FILES["filesToUpload"]["name"]);

            }
        echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
    }

    public function change_name_file_to()
    {
        $data = $this->input->post();
        $last_file_name=$data['session_id'].'_'.$data['file_name'];

        if(file_exists("./uploads/bkt_trf/".$data['file_name'])) {
            $form_num=str_replace('/','-',$data['form_num']);
            $newfilename=str_replace($data['session_id'],$form_num,$data['file_name']);
            move_uploaded_file("./uploads/bkt_trf/" . $data['file_name'], "./uploads/bkt_trf/" . $newfilename);
            unlink("./uploads/bkt_trf/" . $data['file_name']);

        }else if(file_exists("./uploads/bkt_trf/".$last_file_name)){
            $form_num=str_replace('/','-',$data['form_num']);
            $newfilename=str_replace($data['session_id'],$form_num,$last_file_name);
            if (rename("./uploads/bkt_trf/" . $last_file_name,"./uploads/bkt_trf/" . $newfilename)) {
                echo "http://192.168.71.212/ULOK/uploads/bkt_trf/".$newfilename;
                return true;
            } else {
                return false;
            }

        }

    }

    public function save_data_form_to_toko()
    {
        $data = $this->input->post();
        $branch_id=$this->session->userdata('branch_id');
        $data['form_num'] = 'TO/'.$this->M_Ulok->get_nextval_to_form_num_now($branch_id).'/'.$this->M_Ulok->get_branch_nick($this->session->userdata('branch_code')).'/'.$this->month_name(intval(date('n'))).'/'.date('Y');
        $inserted_id = 0;
        $result=0;      
        if ($data) 
        {

                $tipe_form='TO';
                $status='N';
                $jenis_status='STATUS_CABANG';
                $result = $this->M_Ulok->save_data_form_to_toko($data); 
                $hasil= $this->M_Ulok->insert_log_status($data['form-num-to'],$tipe_form,$status,$jenis_status);
              
        }
            echo json_encode($result);              
    }

    //end input data to
   
   //start lpdu
    public function get_form_num_from_lpdu()
    {
        $data=$this->input->post();
        $result = $this->M_Ulok->get_form_num_from_lpdu($data['cabang'],$data['periode']);
        echo json_encode($result);
    }

    public function get_report_lpdu_detail()
    {
         $data = $this->input->post();
         $result = $this->M_Ulok->get_report_lpdu_detail($data['lpdu']);
         echo json_encode($result);
    }


    public function get_lpdu_id()
    {
        $data = $this->input->post();
         $result = $this->M_Ulok->get_lpdu_id($data['lpdu_form_num']);
         echo json_encode($result);
    }

    public function get_data_list_lpdu()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $noform_lpdu= isset($_POST['noform_lpdu']) ? $_POST['noform_lpdu'] : '';
        $periode= isset($_POST['periode']) ? $_POST['periode'] : '';
        $region= isset($_POST['region']) ? $_POST['region'] : '';
        $cabang= isset($_POST['cabang']) ? $_POST['cabang'] : '';
        if($noform_lpdu == ""){
            $where_noform_lpdu=null;
        }else{
            $where_noform_lpdu='AND "LPDU_FORM_NUM" LIKE \'%'.$noform_lpdu.'%\'';
        }
        if($region == ""){
            $where_region=null;
        }else{
            $where_region='AND"REGION_ID"= \''.$region.'\' ';
        }
        if($cabang == ""){
            $where_cabang=null;
        }else if($cabang=='0'){
               $where_cabang=' AND "BRANCH_ID"= \'0\'';
        }else if($cabang !='' && $cabang!='0'){

            $where_cabang=' AND "BRANCH_ID"=  \''.$cabang.'\'';
        }
        
        if($periode == ""){
            $where_periode=null;
        }else{
            $where_periode='AND TO_CHAR("TGL_LPDU",\'MM-YYYY\') = \''.$periode.'\'';
             
        }

        $wheretambahan=$where_noform_lpdu.' '.$where_region.' '.$where_cabang.' '.$where_periode;
        $rs = $this->M_Ulok->count_data_table_lpdu($wheretambahan);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_lpdu($page,$rows,$wheretambahan);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }

    public function generate_lpdu()
    {
        $data = $this->input->post();
        $result= $this->M_Ulok->generate_lpdu($data['cabang'],$data['region'],$data['periode'],$data['lpdu']);
        echo $result;
    }
    
    public function count_data_lpdu()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_data_lpdu($data['cabang'],$data['region'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }
      public function get_data_from_lpdu()
    
    {
        $data = $this->input->post();
        $result= $this->M_Ulok->get_data_from_lpdu($data['lpdu']);
        echo json_encode($result);
    }
    public function generate_lpdu_num()
    {
         $data['lpdu'] = 'LPDU/'.$this->M_Ulok->get_nextval_lpdu_form_num().'/'.$this->month_name(intval(date('n'))).'/'.substr(date('Y'),2,2);
         echo json_encode($data['lpdu']);
    }
     public function inquiry_lpdu()
    {
        $data['session_role']=$this->session->userdata('role_id');
        $this->load->view('Ulok/V_Inquiry_lpdu',$data);
    }

    public function print_lap_penerimaan_ulok($cabang,$periode,$lpdu_form,$lpdu_id,$lihat){

            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('user_id');
            date_default_timezone_set('Asia/Jakarta');
            $lpdu= str_replace("-","/",$lpdu_form);
            if( $cabang !=0){
                $region_fill='';
                $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
            }else if($cabang ==0){

                $data_cabang=$this->M_Ulok->get_all_branch_name_code();
            }
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
            $pdf->SetTitle('LAPORAN PENERIMAAN UANG MUKA DARI CALON FRANCHISEE');
            $header = 'LAPORAN PENERIMAAN UANG MUKA DARI CALON FRANCHISEE';
            $below_header='';
            $pdf->SetSubject('');
            $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(2, 15, 2);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('helveticaB', '', 20, '', true);
                     
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);

            // set cell margins
            $pdf->setCellMargins(0, 0, 0, 0);
            $counter = 0;
            if($cabang !=0){
                $region_fill='';
                $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
                if($lihat==1){
                    $where= 'and uf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.' and utx."STATUS"=\'FIN\' and utx."TIPE_FORM"=\'ULOK\' and utx."LPDU_ID"='.$lpdu_id;
                    $where_to= 'and tf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.' and utx."STATUS"=\'FIN\' and utx."TIPE_FORM"=\'TO\' and utx."LPDU_ID"='.$lpdu_id;       
                }else if ($lihat==0){
                    $where= 'and uf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.
                                        ' and utx."TIPE_FORM"=\'ULOK\' and utx."LPDU_ID"='.$lpdu_id;         
                    $where_to= 'and tf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.'  and utx."TIPE_FORM"= \'TO\' and utx."LPDU_ID"='.$lpdu_id;
                }
                $cek_data_ulok=$this->M_Ulok->count_data_lpdu_ulok($lpdu_id);
                if($cek_data_ulok->hitung != '0'){

                    $data=$this->M_Ulok->get_report_lpdu_where($where);
                    $pdf->AddPage('L','A4');   
                    $pdf->setCellHeightRatio(2);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '', 12, '', true);
                    $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 1,'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true); 
                    $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(8, 2, $data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 2, $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                    $pdf->setCellHeightRatio(1);
                    $pdf->Ln();
                    $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $periode_res = explode("-", $periode);
                    $res_periode_month= $this->month_name(intval($periode_res[0]));  
                    $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '', 7, '', true);
                    $pdf->MultiCell(290, 1, 'ULOK', 1, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(10,10, 'No', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30,10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20,10, 'Pembayaran', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30,10, 'Tanggal Pembayaran' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30,10, 'Pembayaran dari Bank', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40,10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35,10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(95, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(195, 5, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(290, 1,$data_cabang->BRANCH_CODE.'-'.$data_cabang->BRANCH_NAME , 1, 'L', 0, 0, '', '', true);          
                    $pdf->Ln();
                    $num=1;
                    foreach ($data as $hasil) 
                    {
                        $res = explode("-", $hasil->ULOK_BAYAR_DATE);
                        $ulok_tgl_bayar = $res[2]."-".$res[1]."-".$res[0];   
                        if($hasil->BBT_DATE){
                                $tgl_bbt = explode("-", $hasil->BBT_DATE);
                                $ulok_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                        }else{
                                $ulok_tgl_bbt_1='';
                              }     
                        $pdf->SetFont('helvetica', '', 6, '', true);
                        $pdf->MultiCell(10, 1, $num, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, $hasil->NAMA, 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 1,$hasil->ULOK_TIPE_BAYAR , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, $ulok_tgl_bayar , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil->BANK_NAME , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 1, $hasil->ULOK_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,$hasil->ACCOUNT_NUMBER, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil->BBT_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$ulok_tgl_bbt_1, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,number_format($hasil->BBT_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);                  
                        $pdf->Ln();
                        if ($num++ % 34 == 0 ) 
                        {   $pdf->AddPage('L','A4'); 
                            $pdf->SetFont('helveticaB', '', 12, '', true);
                            $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->setCellHeightRatio(2);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);    
                            $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(8, 2, $data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 2, $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                            $pdf->setCellHeightRatio(1);
                            $pdf->Ln();    
                            $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $periode_res = explode("-", $periode);
                            $res_periode_month= $this->month_name(intval($periode_res[0]));  
                            $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->Ln();

                            $pdf->SetFont('helveticaB', '', 7, '', true);
                            $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 10, 'Pembayaran', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Tanggal Pembayaran' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Pembayaran dari Bank' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(95, 10, 'BBT' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(195,5, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35,5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();


                        }//close jika harus tambah halaman
                    }//close loop ambil data 
           
                 }//jika ada data

                $cek_data_to=$this->M_Ulok->count_data_lpdu_to($lpdu_id);
                if($cek_data_to->hitung != '0'){
                      //mulai TO
                    $pdf->AddPage('L','A4');
                    $pdf->SetFont('helveticaB', '', 12, '', true);
                    $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->setCellHeightRatio(2);
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);    
                    $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
             
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(8, 2, $data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 2, $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                    $pdf->setCellHeightRatio(1);
                    $pdf->Ln();
                        
                    $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $periode_res = explode("-", $periode);
                    $res_periode_month= $this->month_name(intval($periode_res[0]));  
                    $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '', 7, '', true);
                    $pdf->MultiCell(290, 1, 'TO', 1, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 10, ' Pembayaran' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 10, 'Tanggal Pembayaran', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 10, 'Pembayaran dari Bank', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(95, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(195,5, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $data_TO=$this->M_Ulok->get_report_lpdu_to_where($where_to);
                    $pdf->MultiCell(290, 1,$data_cabang->BRANCH_CODE.'-'.$data_cabang->BRANCH_NAME , 1, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $num_to=1;
                    foreach ($data_TO as $hasil_to) 
                    { 
                        $res = explode("-", $hasil_to->TO_BAYAR_DATE);
                        $to_tgl_bayar = $res[2]."-".$res[1]."-".$res[0];   
                        if($hasil_to->BBT_DATE){
                                $tgl_bbt = explode("-", $hasil_to->BBT_DATE);
                                $to_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                        }else{
                                $to_tgl_bbt_1='';
                              }  

                        $pdf->SetFont('helvetica', '', 6, '', true);
                        $pdf->MultiCell(10, 1, $num_to, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, $hasil_to->NAMA, 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 1,$hasil_to->TO_TIPE_BAYAR , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, $to_tgl_bayar , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil_to->BANK_NAME , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 1, $hasil_to->TO_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,$hasil_to->ACCOUNT_NUMBER, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil_to->BBT_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$to_tgl_bbt_1, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,number_format( $hasil_to->BBT_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);     
                        $pdf->Ln();     
                        if ($num_to++ % 34 == 0 ) 
                        {
                            $pdf->AddPage('L','A4'); 
                            $pdf->SetFont('helveticaB', '', 12, '', true);
                            $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->setCellHeightRatio(2);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();

                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(8, 2, $data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 2, $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                            $pdf->setCellHeightRatio(1);
                            $pdf->Ln();
                            
                            $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $periode_res = explode("-", $periode);
                            $res_periode_month= $this->month_name(intval($periode_res[0]));  
                            $pdf->MultiCell(10 ,2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->Ln();

                            $pdf->SetFont('helveticaB', '', 7, '', true);
                            $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 10, 'Pembayaran' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Tanggal Pembayaran' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Pembayaran dari Bank' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(95,5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(195,5, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35,5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                          
                        }//close jika tambah halaman to
                    }//loop tarik data to

                }//jika ada data di to
             

            }else{

                   if($lihat==1){
                            $where= ' and utx."STATUS"=\'FIN\' and utx."TIPE_FORM"=\'ULOK\' and utx."LPDU_ID"='.$lpdu_id;
                            $where_to= ' and utx."STATUS"=\'FIN\' and utx."TIPE_FORM"=\'TO\' and utx."LPDU_ID"='.$lpdu_id;
                            
                        }else if ($lihat==0){
                            $where=  ' and utx."TIPE_FORM"=\'ULOK\' and utx."LPDU_ID"='.$lpdu_id;
                         
                            $where_to= ' and utx."TIPE_FORM"= \'TO\' and utx."LPDU_ID"='.$lpdu_id;
                        }
                        $cek_data_ulok=$this->M_Ulok->count_data_lpdu_ulok($lpdu_id);

                         if($cek_data_ulok->hitung != '0'){
                            $data=$this->M_Ulok->get_report_lpdu_where($where);
                            $pdf->AddPage('L','A4');   
                            $pdf->setCellHeightRatio(2);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '', 12, '', true);
                            $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(19, 1,'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true); 
                            $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(8, 2, 'All', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 2,'All', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                            $pdf->setCellHeightRatio(1);
                            $pdf->Ln();
                            $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $periode_res = explode("-", $periode);
                            $res_periode_month= $this->month_name(intval($periode_res[0]));  
                            $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '', 7, '', true);
                            $pdf->MultiCell(290, 1, 'ULOK', 1, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(10,10, 'No', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20,10, 'Cabang', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20,10, 'Pembayaran', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20,10, 'Tanggal Bayar' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,10, 'Pembayaran dari Bank', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40,10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35,10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(85, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(205, 5, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            
                            $num=1;

                            foreach ($data as $hasil) 
                            {          
                                $res = explode("-", $hasil->ULOK_BAYAR_DATE);
                                $ulok_tgl_bayar = $res[2]."-".$res[1]."-".$res[0];   
                                if($hasil->BBT_DATE){
                                        $tgl_bbt = explode("-", $hasil->BBT_DATE);
                                        $ulok_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                                }else{
                                        $ulok_tgl_bbt_1='';
                                }   
                                $pdf->SetFont('helvetica', '', 6, '', true);
                                $pdf->MultiCell(10, 1, $num, 1, 'C', 0, 0, '', '', true);

                                $pdf->MultiCell(20, 1,$hasil->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 1, $hasil->NAMA, 1, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 1,$hasil->ULOK_TIPE_BAYAR , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 1, $ulok_tgl_bayar , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 1,$hasil->BANK_NAME , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 1, $hasil->ULOK_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 1,$hasil->ACCOUNT_NUMBER, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 1,$hasil->BBT_NUM, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 1,$ulok_tgl_bbt_1, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 1,number_format($hasil->BBT_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);                  
                                $pdf->Ln();     

                                if ($num++ % 34 == 0 ) 
                                { 

                                    $pdf->AddPage('L','A4'); 
                                    $pdf->SetFont('helveticaB', '', 12, '', true);
                                    $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                                    $pdf->SetFont('helvetica', '',6, '', true);
                                    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                                    $pdf->Ln();
                                    $pdf->setCellHeightRatio(2);
                                    $pdf->SetFont('helveticaB', '',8, '', true);
                                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);    
                                    $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                                    $pdf->SetFont('helvetica', '',6, '', true);
                                    $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                                    $pdf->Ln();
                                    $pdf->SetFont('helveticaB', '',8, '', true);
                                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(8, 2,'All', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(30, 2,'All', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->SetFont('helvetica', '',6, '', true);
                                    $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                                    $pdf->setCellHeightRatio(1);
                                    $pdf->Ln();    
                                    $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->SetFont('helveticaB', '',8, '', true);
                                    $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                    $periode_res = explode("-", $periode);
                                    $res_periode_month= $this->month_name(intval($periode_res[0]));  
                                    $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                                    $pdf->Ln();
                                    $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->Ln();

                                    $pdf->SetFont('helveticaB', '', 7, '', true);
                                    $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(20, 1,'Cabang', 1, 'L', 0, 0, '', '', true);
                                    $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(20, 10, 'Mekanisme Pembayaran', 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(20, 10, 'Tanggal Bayar' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(30, 10, 'Pembayaran dari Bank' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(85, 10, 'BBT' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->Ln();
                                    $pdf->MultiCell(205,5, '' , 0, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(30,5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(20,5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                                    $pdf->MultiCell(35,5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                                    $pdf->Ln();
                    
                                 }// close tambah halaman ulok

                            }//close iterasi tarik data
                         }//close  cek data ulok ada atau ga
                $cek_data_to=$this->M_Ulok->count_data_lpdu_to($lpdu_id);
                if($cek_data_to->hitung != '0'){
                    //mulai TO
                    $pdf->AddPage('L','A4');
                    $pdf->SetFont('helveticaB', '', 12, '', true);
                    $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->setCellHeightRatio(2);
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);    
                    $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(8, 2, 'All', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 2,'All', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                    $pdf->setCellHeightRatio(1);
                    $pdf->Ln();
                        
                    $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $periode_res = explode("-", $periode);
                    $res_periode_month= $this->month_name(intval($periode_res[0]));  
                    $pdf->MultiCell(10, 2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '', 7, '', true);
                    $pdf->MultiCell(290, 1, 'TO', 1, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 10,'Cabang', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 10, 'Mekanisme Pembayaran' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 10, 'Tanggal Bayar', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 10, 'Pembayaran dari Bank', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(85, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(205,5, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(35, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
              
                    $num_to=1;

                    $data_TO=$this->M_Ulok->get_report_lpdu_to_where($where_to);
                    foreach ($data_TO as $hasil_to) {
                        $res = explode("-", $hasil_to->TO_BAYAR_DATE);
                        $to_tgl_bayar = $res[2]."-".$res[1]."-".$res[0];   
                        if($hasil_to->BBT_DATE){
                                $tgl_bbt = explode("-", $hasil_to->BBT_DATE);
                                $to_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                        }else{
                                $to_tgl_bbt_1='';
                              }  
                        $pdf->SetFont('helvetica', '', 6, '', true);
                        $pdf->MultiCell(10, 1, $num_to, 1, 'C', 0, 0, '', '', true);

                        $pdf->MultiCell(20, 1,$hasil_to->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, $hasil_to->NAMA, 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 1,$hasil_to->TO_TIPE_BAYAR , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 1, $to_tgl_bayar , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil_to->BANK_NAME , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 1, $hasil_to->TO_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,$hasil_to->ACCOUNT_NUMBER, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1,$hasil_to->BBT_NUM, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 1,$to_tgl_bbt_1, 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 1,number_format( $hasil_to->BBT_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);     
                        $pdf->Ln();   
                         if ($num_to++ % 34 == 0 ) 
                        {
                            $pdf->AddPage('L','A4'); 
                            $pdf->SetFont('helveticaB', '', 12, '', true);
                            $pdf->MultiCell(60, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(140, 1, $header , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(19, 1, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->setCellHeightRatio(2);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2, 'Nomor LPDU' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,$lpdu, 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(56, 2, '' , 0, 'R', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();

                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(100, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(8, 2,'All', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 2,'All', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(55, 2, '' , 0, 'L', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                            $pdf->setCellHeightRatio(1);
                            $pdf->Ln();
                            
                            $pdf->MultiCell(10, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helveticaB', '',8, '', true);
                            $pdf->MultiCell(90, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                            $periode_res = explode("-", $periode);
                            $res_periode_month= $this->month_name(intval($periode_res[0]));  
                            $pdf->MultiCell(10 ,2, $periode_res[0], 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(10, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->SetFont('helveticaB', '', 7, '', true);
                            $pdf->MultiCell(10, 10, 'No', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 10,'Cabang', 1, 'L', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 10, 'Mekanisme Pembayaran' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 10, 'Tanggal Bayar' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 10, 'Pembayaran dari Bank' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 10, 'No Rekening Tujuan Pembayaran milik HO Idm' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(85,5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            $pdf->MultiCell(205,5, '' , 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30,5, 'Nomor ', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20,5, 'Tanggal', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35,5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                        }//close jika tambah halaman


                    }
                  

                }//close jika ada data to
            }  // close cabang sama dengan all
                
            ob_end_clean();
            $namanya_file='Laporan Penerimaan Uang Muka dari Calon Franchisee'.'-'.date('YmdHi').'.pdf';
            $pdf->Output($namanya_file, 'I');
    }


    //end lpdu
          
   //start lduk
    public function generate_lduk()
    {
        $data = $this->input->post();
        $result= $this->M_Ulok->generate_lduk($data['cabang'],$data['region'],$data['periode'],$data['lduk']);
        echo $result;
    }



    public function get_lduk_id()
    {
        $data = $this->input->post();
         $result = $this->M_Ulok->get_lduk_id($data['lduk_form_num']);
         echo json_encode($result);
    }

    public function count_data_lduk()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_data_lduk($data['cabang'],$data['region'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }

     public function count_data_lmdo()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_data_lmdo($data['cabang'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }
     public function count_data_lstf()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_data_lstf($data['cabang'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }
     public function generate_lduk_num()
    {
         $data['lduk'] = 'LDUK/'.$this->M_Ulok->get_nextval_lduk_form_num().'/'.$this->month_name(intval(date('n'))).'/'.substr(date('Y'),2,2);
         echo json_encode($data['lduk']);
    }
   
    public function get_data_from_lduk()
    {
        $data = $this->input->post();
        $result= $this->M_Ulok->get_data_from_lduk($data['lduk']);
        echo json_encode($result);
    }
    public function inquiry_lduk()

    {
        $data['session_role']=$this->session->userdata('role_id');
        $this->load->view('Ulok/V_Inquiry_lduk',$data);
    }
    public function get_report_lduk_detail()
    {
         $data = $this->input->post();
         $result = $this->M_Ulok->get_report_lduk_detail($data['lduk']);
         echo json_encode($result);

    }

    public function get_data_list_lduk()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform_lduk= isset($_POST['noform_lduk']) ? $_POST['noform_lduk'] : '';
        $periode= isset($_POST['periode']) ? $_POST['periode'] : '';
        $region= isset($_POST['region']) ? $_POST['region'] : '';
        $cabang= isset($_POST['cabang']) ? $_POST['cabang'] : '';


        if($noform_lduk == ""){
            $where_noform_lduk=null;
        }else{
            $where_noform_lduk='AND "LDUK_FORM_NUM" LIKE \'%'.$noform_lduk.'%\'';
        }
        if($region == ""){
            $where_region=null;
        }else{
            $where_region='AND"REGION_ID"= \''.$region.'\' ';
        }
        if($cabang == ""){
            $where_cabang=null;
        }else{
            $where_cabang=' AND "BRANCH_ID"=  \''.$cabang.'\'';
        }
        
        if($periode == ""){
            $where_periode=null;
        }else{
            $where_periode='AND TO_CHAR("TGL_LDUK",\'MM-YYYY\') = \''.$periode.'\'';
             
        }

        $wheretambahan=$where_noform_lduk.' '.$where_region.' '.$where_cabang.' '.$where_periode;
        $rs = $this->M_Ulok->count_data_table_lduk($wheretambahan);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_lduk($page,$rows,$wheretambahan);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
    }

    public function print_laporan_uangmuka_kembali($cabang,$periode,$lduk_form,$lduk_id,$lihat)
    {
            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('user_id');
            date_default_timezone_set('Asia/Jakarta');
            $lduk= str_replace("-","/",$lduk_form);

           /* if($region !=0 && $cabang ==0){
                $region_fill=$region;
                $data_cabang=$this->M_Ulok->get_branch_from_region($region);
                $data_region=$this->M_Ulok->get_region_name($region);

            }else if($region ==0 && $cabang !=0){
                $region_fill='';
                $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
            }*/
            if($cabang!=0){
                $region_fill='';
                $data_cabang=$this->M_Ulok->get_branch_name_code($cabang); 
            }
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
            $pdf->SetTitle('LAPORAN UANG MUKA YANG HARUS DIKEMBALIKAN KE CALON FRANCHISEE');
            $header = 'LAPORAN UANG MUKA YANG HARUS DIKEMBALIKAN KE CALON FRANCHISEE';
            $below_header='';
            $pdf->SetSubject('');
            $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(5, 20, 5);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
                
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);

            // set cell margins
            
            $pdf->setCellMargins(0, 0, 0, 0);
            $counter = 0;
            $pdf->Ln();
            if( $cabang !=0){
              //  $region_fill='';
                $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
                        if($lihat==1){
                            //jika buat report baru
                            $where= 'and uf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.
                                ' and (utx."STATUS_HO"=\'FINAL-NOK\') AND utx."TIPE_FORM"=\'ULOK\' and utx."LDUK_ID" ='.$lduk_id;   

                            $where_to='and tf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.
                                ' and (utx."STATUS_HO"=\'FINAL-NOK\') and utx."TIPE_FORM"=\'TO\' and utx."LDUK_ID" ='.$lduk_id;  
                            
                        }else if ($lihat==0){
                            //jika hanya lihat
                            $where= 'and uf."BRANCH_ID"='.$data_cabang->BRANCH_ID.
                                ' and (utx."STATUS_HO"=\'FINAL-NOK\' OR utx."STATUS_HO"=\'LDUK\') and utx."TIPE_FORM"=\'ULOK\' AND utx."LDUK_ID" ='.$lduk_id;
                            $where_to= 'and tf."BRANCH_ID"='.$data_cabang->BRANCH_ID.' '.
                                ' and ( utx."STATUS_HO"=\'FINAL-NOK\' OR utx."STATUS_HO"=\'LDUK\') and utx."TIPE_FORM"=\'TO\' AND utx."LDUK_ID" ='.$lduk_id;
                        }
                $result_ulok=$this->M_Ulok->count_data_lduk_ulok($lduk_id);
                if($result_ulok->hitung !='0'){
                        $pdf->AddPage('L','A4'); 
                        $pdf->SetFont('helveticaB', '', 20, '', true);   
                        $data=$this->M_Ulok->get_report_lduk_where($where);
                        $pdf->SetFont('helveticaB', '', 12, '', true);
                        $pdf->setCellHeightRatio(2);
                        $pdf->MultiCell(40, 2,'', 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(170, 2, $header , 0, 'L', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(10, 2, '' , 0, 'R', 0, 0, '', '', true);
                        $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Nomor LDUK', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,$lduk, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(51, 2, '' , 0, 'R', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->setCellHeightRatio(0.8);
                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(8, 2,$data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2,$data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(63, 2, '' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                
                       // $pdf->MultiCell(85, 2,'', 0, 'C', 0, 0, '', '', true);
                       // $pdf->MultiCell(92, 2, $below_header , 0, 'C', 0, 0, '', '', true);
                       
                     



                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $periode_res = explode("-", $periode);
                        $res_periode_month= $this->month_name(intval($periode_res[0]));  
                        $pdf->MultiCell(10, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->SetFont('helveticaB', '', 7, '', true);
                        $pdf->MultiCell(5, 10, 'No', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(90, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(80, 5, 'Calon Franchisee ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(85, 5, 'BBK ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->MultiCell(35, 5, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(45, 5, 'Nama' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 5, 'Nama Bank - No Rekening' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->MultiCell(290, 1,$data_cabang->BRANCH_CODE.'-'.$data_cabang->BRANCH_NAME , 1, 'L', 0, 0, '', '', true);
             
                       /* $pdf->MultiCell(5, 1, '' , 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, 'Total:', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1, '', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(155, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1, '' , 1, 'C', 0, 0, '', '', true);  
                        */                
                                  
                        $pdf->Ln();
                        $num_1=1;
                        foreach ($data as $hasil) 
                        { 

                            $pdf->SetFont('helvetica', '',6, '', true);
                            $pdf->MultiCell(5, 1, $num_1, 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 1,$hasil->ULOK_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1,$hasil->BBT_NUM, 1, 'C', 0, 0, '', '', true);
                            if($hasil->BBT_DATE){

                                $tgl_bbt = explode("-", $hasil->BBT_DATE);
                                $ulok_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                            }else{
                                $ulok_tgl_bbt_1='';
                            }    
                            $pdf->MultiCell(20, 1, $ulok_tgl_bbt_1 , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 1,number_format($hasil->BBT_AMOUNT, 2 , ',' , '.' ) , 1, 'R', 0, 0, '', '', true);
                            $pdf->MultiCell(45, 1, $hasil->NAMA , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 1, $hasil->AKUN_BANK , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(35, 1,$hasil->BBK_NUM, 1, 'C', 0, 0, '', '', true);
                            if($hasil->BBK_DATE){
                                $tgl_bbk = explode("-", $hasil->BBK_DATE);
                                $ulok_tgl_bbk_1 = $tgl_bbk[2]."-".$tgl_bbk[1]."-".$tgl_bbk[0];  
                            }else{
                                $ulok_tgl_bbk_1='';
                            }   
                            $pdf->MultiCell(20, 1, $ulok_tgl_bbk_1, 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 1, number_format($hasil->BBK_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);   
                            $pdf->Ln();
                           
                            if ($num_1 % 10 == 0 ) 
                            {
                                       
                                $pdf->AddPage('L','A4'); 
                                $pdf->SetFont('helveticaB', '', 12, '', true);
                                $pdf->setCellHeightRatio(2);
                                $pdf->MultiCell(40, 2,'', 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(170, 2, $header , 0, 'L', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(10, 2, '' , 0, 'R', 0, 0, '', '', true);
                                $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();

                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Nomor LDUK', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,$lduk, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(51, 2, '' , 0, 'R', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->setCellHeightRatio(0.8);
                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(8, 2,$data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2,$data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(63, 2, '' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $periode_res = explode("-", $periode);
                                $res_periode_month= $this->month_name(intval($periode_res[0]));  
                                $pdf->MultiCell(10, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->SetFont('helveticaB', '', 7, '', true);
                                $pdf->MultiCell(5, 10, 'No', 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(90, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(80, 5, 'Calon Franchisee ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(85, 5, 'BBK ' , 1, 'C', 0, 0, '', '', true);
                         
                                $pdf->Ln();
                                $pdf->MultiCell(35, 5, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(45, 5, 'Nama' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 5, 'Nama Bank - No Rekening' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                                $pdf->Ln();
                                $counter++;
                                $pdf->MultiCell(290, 1,$data_cabang->BRANCH_CODE.'-'.$data_cabang->BRANCH_NAME , 1, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                          
                            }
                               $num_1++;  
                        
                    }

                        $pdf->SetFont('helveticaB', '', 7, '', true);
                        $total_bbt=$this->M_Ulok->get_sum_report_lduk_where($where);
                        $pdf->MultiCell(5, 1, '' , 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, 'Total:', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(60, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1, number_format($total_bbt->TOTAL_BBT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);
                        $pdf->MultiCell(135, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1,number_format( $total_bbt->TOTAL_BBK, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);  
                 
                        
                }
                 $result_to=$this->M_Ulok->count_data_lduk_to($lduk_id);
                        if($result_to->hitung !='0'){
                             //mulai TO
                        $pdf->AddPage('L','A4');
                        $pdf->SetFont('helveticaB', '', 12, '', true);
                        $pdf->setCellHeightRatio(2);
                        $pdf->MultiCell(40, 2,'', 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(170, 2, $header , 0, 'L', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(10, 2, '' , 0, 'R', 0, 0, '', '', true);
                        $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Nomor LDUK', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,$lduk, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(51, 2, '' , 0, 'R', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $pdf->setCellHeightRatio(0.8);
                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(8, 2,$data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2,$data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                        $pdf->SetFont('helvetica', '',6, '', true);
                        $pdf->MultiCell(63, 2, '' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                    
                       // $pdf->MultiCell(85, 2,'', 0, 'C', 0, 0, '', '', true);
                       // $pdf->MultiCell(92, 2, $below_header , 0, 'C', 0, 0, '', '', true);
                       
                     



                        $pdf->SetFont('helveticaB', '',8, '', true);
                        $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);

                        $periode_res = explode("-", $periode);
                        $res_periode_month= $this->month_name(intval($periode_res[0]));  
                        $pdf->MultiCell(10, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        
                        $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->Ln();   
                        $pdf->SetFont('helveticaB', '', 7, '', true);
                        $pdf->MultiCell(290, 1, 'TO', 1, 'L', 0, 0, '', '', true);
                        $pdf->Ln();

                        $pdf->MultiCell(5, 10, 'No', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 10, 'No Form Pengajuan Usulan Lokasi', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(90, 5, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(80, 5, 'Calon Franchisee ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(85, 5, 'BBK ' , 1, 'C', 0, 0, '', '', true);                         
                        $pdf->Ln();
                        $pdf->MultiCell(35, 5, '' , 0, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(40, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(45, 5, 'Nama' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 5, 'Nama Bank - No Rekening' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(35, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                        $pdf->Ln();
                        $data_TO=$this->M_Ulok->get_report_lduk_to_where($where_to);
                        $pdf->MultiCell(290, 1,$data_cabang->BRANCH_CODE.'-'.$data_cabang->BRANCH_NAME , 1, 'L', 0, 0, '', '', true);
                        $pdf->Ln();
                        $num_to_1=1;
                         foreach ($data_TO as $hasil_to) 
                        { 

                                $pdf->SetFont('helvetica', '', 6, '', true);
                                $pdf->MultiCell(5, 1,$num_to_1, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 1,$hasil_to->TO_FORM_NUM, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 1,$hasil_to->BBT_NUM, 1, 'C', 0, 0, '', '', true); 
                                if($hasil_to->BBT_DATE){

                                    $tgl_bbt = explode("-", $hasil_to->BBT_DATE);
                                    $to_tgl_bbt_1 = $tgl_bbt[2]."-".$tgl_bbt[1]."-".$tgl_bbt[0];  
                                }else{
                                    $to_tgl_bbt_1='';
                                }
                                $pdf->MultiCell(20, 1,$to_tgl_bbt_1 , 1, 'C', 0, 0, '', '', true);  
                                $pdf->MultiCell(30, 1,number_format($hasil_to->BBT_AMOUNT , 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);  
                                $pdf->MultiCell(45, 1,$hasil_to->NAMA, 1, 'C', 0, 0, '', '', true); 
                                $pdf->MultiCell(35, 1,$hasil_to->AKUN_BANK , 1, 'C', 0, 0, '', '', true);  
                                $pdf->MultiCell(35, 1,$hasil_to->BBK_NUM, 1, 'C', 0, 0, '', '', true); 
                                if($hasil_to->BBK_DATE){

                                    $tgl_bbk = explode("-", $hasil_to->BBK_DATE);
                                    $to_tgl_bbk_1 = $tgl_bbk[2]."-".$tgl_bbk[1]."-".$tgl_bbk[0];  
                                }else{
                                    $to_tgl_bbk_1='';
                                }
                                $pdf->MultiCell(20, 1,$to_tgl_bbk_1, 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 1,number_format($hasil_to->BBK_AMOUNT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);
                                $pdf->Ln();

                            

                            if ($num_to_1 % 10 == 0 ) 
                            {
                                       
                                $pdf->AddPage('L','A4'); 
                                $pdf->SetFont('helveticaB', '', 12, '', true);
                                $pdf->setCellHeightRatio(2);
                                $pdf->MultiCell(40, 2,'', 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(170, 2, $header , 0, 'L', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(10, 2, '' , 0, 'R', 0, 0, '', '', true);
                                $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Nomor LDUK', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,$lduk, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(51, 2, '' , 0, 'R', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->setCellHeightRatio(0.8);
                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Kode-Nama Cabang Idm', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(8, 2,$data_cabang->BRANCH_CODE, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2,$data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                                $pdf->SetFont('helvetica', '',6, '', true);
                                $pdf->MultiCell(60, 2, '' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                            
                       // $pdf->MultiCell(85, 2,'', 0, 'C', 0, 0, '', '', true);
                       // $pdf->MultiCell(92, 2, $below_header , 0, 'C', 0, 0, '', '', true);

                                $pdf->SetFont('helveticaB', '',8, '', true);
                                $pdf->MultiCell(85, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                                $periode_res = explode("-", $periode);
                                $res_periode_month= $this->month_name(intval($periode_res[0]));  
                                $pdf->MultiCell(8, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                                $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->MultiCell(160, 2, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->Ln();                       
                                $pdf->SetFont('helveticaB', '', 7, '', true);
                                $pdf->MultiCell(290, 1, 'TO', 1, 'L', 0, 0, '', '', true);
                                $pdf->Ln();
                                $pdf->MultiCell(30, 10, 'No Form Pengajuan Usulan Lokasi'."\n"."\n", 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(90, 10, 'BBT ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(80, 5, 'Calon Franchisee ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(85, 5, 'BBK ' , 1, 'C', 0, 0, '', '', true);                         
                                $pdf->Ln();
                                $pdf->MultiCell(35, 5, '' , 0, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(40, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(45, 5, 'Nama' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 5, 'Nama Bank - No Rekening' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(35, 5, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(20, 5, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
                                $pdf->MultiCell(30, 5, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
                                $pdf->Ln();

                            }
                                $num_to_1++;
                        }
                        $total_bbt=$this->M_Ulok->get_sum_report_lduk_to_where($where_to);

                        $pdf->SetFont('helveticaB', '', 7, '', true);
                        $pdf->MultiCell(5, 1, '' , 1, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(30, 1, 'Total:', 1, 'C', 0, 0, '', '', true);
                        $pdf->MultiCell(60, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1,number_format($total_bbt->TOTAL_BBT, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true);
                        $pdf->MultiCell(135, 1, '', 1, 'C', 1, 0, '', '', true);
                        $pdf->MultiCell(30, 1,number_format($total_bbt->TOTAL_BBK, 2 , ',' , '.' ), 1, 'R', 0, 0, '', '', true); 

                        }
                       
                        
            }
                    ob_end_clean();
                    $namanya_file='Laporan Penerimaan Uang Muka dari Calon Franchisee'.'-'.date('YmdHi').'.pdf';
                    $pdf->Output($namanya_file, 'I');

    }
        public function print_laporan_monitoring_uangmuka($cabang,$periode)
    {
            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('user_id');
           
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
            $pdf->SetTitle('LAPORAN MONITORING UANG MUKA ULOK/TO');
            $header = 'LAPORAN MONITORING UANG MUKA ULOK /TO ';
            $pdf->SetSubject('');
            $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(4, 20, 4);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('helveticaB', '', 20, '', true);
                       
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);

            // set cell margins
            $pdf->setCellMargins(0, 0, 0, 0);
            $counter = 0;
            $pdf->Ln();
            $data=$this->M_Ulok->get_data_listing_status_ulok($cabang,$periode);
            $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
                
            $count_data_lmdo=$this->M_Ulok->count_data_lmdo_ulok($cabang,$periode);

            if($count_data_lmdo->hitung !='0'){
                 $pdf->AddPage('L','A4'); 
                $pdf->SetFont('helveticaB', '', 10, '', true);
                $pdf->MultiCell(100, 2,'', 0, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(100, 2, $header , 0, 'C', 0, 0, '', '', true);
                $pdf->SetFont('helvetica', '',6, '', true);
                $pdf->MultiCell(36, 2, '' , 0, 'R', 0, 0, '', '', true);
                $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                $pdf->Ln();

            $pdf->MultiCell(120, 2, '' , 0, 'R', 0, 0, '', '', true);
                $pdf->SetFont('helveticaB', '',7, '', true);
            $pdf->MultiCell(40, 2,'Kode - Nama Cabang', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(40, 2,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(32, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->SetFont('helvetica', '',6, '', true);
            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->SetFont('helveticaB', '',7, '', true);
            

             $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $periode_res = explode("-", $periode);
                        $res_periode_month= $this->month_name(intval($periode_res[0]));  
                        $pdf->MultiCell(10, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                       
            $pdf->SetFont('helvetica', '',6, '', true);
            $pdf->MultiCell(42, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->MultiCell(92, 2,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(92, 2, $below_header , 0, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            
            $data_lmdo_ulok=$this->M_Ulok->get_data_lmdo_ulok($cabang,$periode);
            $pdf->SetFont('helveticaB', '', 6, '', true);
            $pdf->MultiCell(5, 1, 'No'."\n"."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1, 'No Form Pengajuan ULOK/TO'."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Tanggal Transfer'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);        
            $pdf->MultiCell(30, 1, 'Nama Calon Franchisee'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, ' Bank'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'A.N Pengirim '."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBT ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Status Usulan Lokasi ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBK ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, 'Keterangan' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, '' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
               $pdf->MultiCell(292, 1, 'Kode-Nama Cabang Idm' , 1, 'L', 0, 0, '', '', true); 
             $pdf->Ln();
                $no=1; 
                $pdf->MultiCell(292, 1, 'ULOK' , 1, 'L', 0, 0, '', '', true); 
            foreach ($data_lmdo_ulok as $report_detail) 
            {          
                      
                $pdf->SetFont('helvetica', '', 6, '', true);
                
                $pdf->Ln();
                $pdf->MultiCell(5, 5, $no, 1, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(30, 5, $report_detail->ULOK_FORM_NUM, 1, 'C', 0, 0, '', '', true);

                $pdf->MultiCell(20, 5, $report_detail->ULOK_BAYAR_DATE, 1, 'C', 0, 0, '', '', true);

                $pdf->MultiCell(30, 5, $report_detail->NAMA, 1, 'C', 0, 0, '', '', true);  

                $pdf->MultiCell(15, 5, $report_detail->ULOK_KARTU_KREDIT , 1, 'C', 0, 0, '', '', true); 


            $pdf->MultiCell(20, 5, $report_detail->ULOK_AN_PENGIRIM , 1, 'C', 0, 0, '', '', true); 

            $pdf->MultiCell(25, 5, $report_detail->BBT_NUM , 1, 'C', 0, 0, '', '', true);

            $pdf->MultiCell(15, 5, $report_detail->BBT_DATE  , 1, 'C', 0, 0, '', '', true);

            $pdf->MultiCell(25, 5,$report_detail->BBT_AMOUNT , 1, 'C', 0, 0, '', '', true);

             $pdf->MultiCell(15, 5, $report_detail->STATUS_ULOK , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 5, $report_detail->BBK_NUM , 1, 'C', 0, 0, '', '', true);


            $pdf->MultiCell(15, 5, $report_detail->BBK_DATE , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 5, $report_detail->BBK_AMOUNT, 1, 'C', 0, 0, '', '', true);
               $pdf->MultiCell(27, 5, $report_detail->KET_STATUS_ULOK , 1, 'C', 0, 0, '', '', true);
                

                
                if ($no % 25 == 0 ){
                       $pdf->AddPage('L','A4'); 
                
            $pdf->SetFont('helveticaB', '', 6, '', true);
            $pdf->MultiCell(5, 1, 'No'."\n"."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1, 'No Form Pengajuan ULOK/TO'."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Tanggal Transfer'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);        
            $pdf->MultiCell(30, 1, 'Nama Calon Franchisee'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, ' Bank'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'A.N Pengirim '."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBT ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Status Usulan Lokasi ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBK ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, 'Keterangan' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, '' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
               $pdf->MultiCell(292, 1, 'Kode-Nama Cabang Idm' , 1, 'L', 0, 0, '', '', true); 
             $pdf->Ln();
          
                $pdf->MultiCell(292, 1, 'ULOK' , 1, 'L', 0, 0, '', '', true); 

                  }

                  $no++;
            }
            }

            $count_data_lmdo_to=$this->M_Ulok->count_data_lmdo_to($cabang,$periode);

            if($count_data_lmdo_to->hitung !='0'){
                 $pdf->AddPage('L','A4'); 
            $pdf->SetFont('helveticaB', '', 10, '', true);
            $pdf->MultiCell(100, 2,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(100, 2, $header , 0, 'C', 0, 0, '', '', true);
            $pdf->SetFont('helvetica', '',6, '', true);
            $pdf->MultiCell(36, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();

            $pdf->MultiCell(120, 2, '' , 0, 'R', 0, 0, '', '', true);
                $pdf->SetFont('helveticaB', '',7, '', true);
            $pdf->MultiCell(40, 2,'Kode - Nama Cabang', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(40, 2,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(32, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->SetFont('helvetica', '',6, '', true);
            $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->SetFont('helveticaB', '',7, '', true);
            

             $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                        $periode_res = explode("-", $periode);
                        $res_periode_month= $this->month_name(intval($periode_res[0]));  
                        $pdf->MultiCell(10, 2, $res_periode_month, 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(3, 2, '-', 0, 'L', 0, 0, '', '', true);
                        $pdf->MultiCell(17, 2, $periode_res[1], 0, 'L', 0, 0, '', '', true);
                       
            $pdf->SetFont('helvetica', '',6, '', true);
            $pdf->MultiCell(42, 2, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->MultiCell(92, 2,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(92, 2, $below_header , 0, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            
            $data_lmdo_to=$this->M_Ulok->get_data_lmdo_to($cabang,$periode);
            $pdf->SetFont('helveticaB', '', 6, '', true);
            $pdf->MultiCell(5, 1, 'No'."\n"."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1, 'No Form Pengajuan ULOK/TO'."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Tanggal Transfer'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);        
            $pdf->MultiCell(30, 1, 'Nama Calon Franchisee'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, ' Bank'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'A.N Pengirim '."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBT ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Status Usulan Lokasi ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBK ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, 'Keterangan' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, '' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
               $pdf->MultiCell(292, 1, 'Kode-Nama Cabang Idm' , 1, 'L', 0, 0, '', '', true); 
             $pdf->Ln();
                $num_to=1; 
                $pdf->MultiCell(292, 1, 'TO' , 1, 'L', 0, 0, '', '', true); 
            foreach ($data_lmdo_to as $report_detail_to) 
            {          
                      
                $pdf->SetFont('helvetica', '', 6, '', true);
                
                $pdf->Ln();
                $pdf->MultiCell(5, 5, $num_to, 1, 'C', 0, 0, '', '', true);
                $pdf->MultiCell(30, 5, $report_detail_to->TO_FORM_NUM, 1, 'C', 0, 0, '', '', true);

                $pdf->MultiCell(20, 5, $report_detail_to->TO_BAYAR_DATE, 1, 'C', 0, 0, '', '', true);

                $pdf->MultiCell(30, 5, $report_detail_to->NAMA, 1, 'C', 0, 0, '', '', true);  

                $pdf->MultiCell(15, 5, $report_detail_to->TO_KARTU_KREDIT , 1, 'C', 0, 0, '', '', true); 


            $pdf->MultiCell(20, 5, $report_detail_to->TO_AN_PENGIRIM , 1, 'C', 0, 0, '', '', true); 

            $pdf->MultiCell(25, 5, $report_detail_to->BBT_NUM , 1, 'C', 0, 0, '', '', true);

            $pdf->MultiCell(15, 5, $report_detail_to->BBT_DATE  , 1, 'C', 0, 0, '', '', true);

            $pdf->MultiCell(25, 5,$report_detail_to->BBT_AMOUNT , 1, 'C', 0, 0, '', '', true);

             $pdf->MultiCell(15, 5, $report_detail_to->STATUS_ULOK , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 5, $report_detail_to->BBK_NUM , 1, 'C', 0, 0, '', '', true);


            $pdf->MultiCell(15, 5, $report_detail_to->BBK_DATE , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 5, $report_detail_to->BBK_AMOUNT, 1, 'C', 0, 0, '', '', true);
               $pdf->MultiCell(27, 5, $report_detail_to->KET_STATUS_ULOK , 1, 'C', 0, 0, '', '', true);
               
                if ($num_to % 25 == 0 ) 
                {
                      $pdf->AddPage('L','A4'); 
                    $pdf->SetFont('helveticaB', '', 6, '', true);
            $pdf->MultiCell(5, 1, 'No'."\n"."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1, 'No Form Pengajuan ULOK/TO'."\n"."\n", 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Tanggal Transfer'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);        
            $pdf->MultiCell(30, 1, 'Nama Calon Franchisee'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, ' Bank'."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'A.N Pengirim '."\n"."\n"."\n" , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBT ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Status Usulan Lokasi ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(65, 1, 'BBK ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, 'Keterangan' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(120, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nomor  ' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(15, 1, 'Tanggal' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, 'Nilai(Rp.)' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(27, 1, '' , 1, 'C', 0, 0, '', '', true);
            $pdf->Ln();
               $pdf->MultiCell(292, 1, 'Kode-Nama Cabang Idm' , 1, 'L', 0, 0, '', '', true); 
             $pdf->Ln();
            
                $pdf->MultiCell(292, 1, 'TO' , 1, 'L', 0, 0, '', '', true);            
                }

                $num_to++;
            }
            }
           
      
            ob_end_clean();
            $namanya_file='Laporan Pengembalian Uang Muka ke Calon Franchisee'.'-'.date('YmdHi').'.pdf';
            $pdf->Output($namanya_file, 'I');
    }

    //end lduk
   
    //start inquiry ulok

    public function get_data_ulok_form_where_ulok_form_num()
    {
        $data = $this->input->post();
        $result = $this->M_Ulok->get_data_ulok_form_where_ulok_form_num($data['ulok_form_num']);
        echo json_encode($result);

    }
    public function get_data_trx_cab()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform= isset($_POST['noform_ulok']) ? $_POST['noform_ulok'] : '';
        $nama= isset($_POST['nama_ulok']) ? $_POST['nama_ulok'] : '';
        $status= isset($_POST['status_ulok']) ? $_POST['status_ulok'] : '';

        $tanggal_mulai= isset($_POST['tanggal_mulai']) ? $_POST['tanggal_mulai'] : '';
        $tanggal_akhir= isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
        $tanggal_form_mulai= isset($_POST['tanggal_form_mulai']) ? $_POST['tanggal_form_mulai'] : '';
        $tanggal_form_akhir= isset($_POST['tanggal_form_akhir']) ? $_POST['tanggal_form_akhir'] : '';
        $to_form_start= $tanggal_form_mulai;
        $to_form_end= $tanggal_form_akhir;
        $to_trf_start=$tanggal_mulai;
        $to_trf_end= $tanggal_akhir; 

        if($noform == ""){
            $where_noform=null;
        }else{
            $where_noform='AND uf."ULOK_FORM_NUM" LIKE \'%'.$noform.'%\'';
        }
        if($nama == ""){
            $where_nama=null;
        }else{
            $where_nama='AND upper(uf."NAMA") LIKE upper(\'%'.$nama.'%\') ';
        }
        if($status == ""){
            $where_status=null;
        }else{
            $where_status=' AND utx."STATUS" = \''.$status.'\'';
        }
        if($to_form_start == "--"  || $to_form_end== "--" ){
            $where_tanggal_form=null;
        }else if(($to_form_start != "--"  && $to_form_end != "--" ) && ($to_form_start != ""  && $to_form_end != "" )){
            $where_tanggal_form= 'AND( uf."ULOK_FORM_DATE" >= \''.$to_form_start.'\' AND uf."ULOK_FORM_DATE" <= \''.$to_form_end.'\')';
        }else {
              $where_tanggal_form=null;
        }
        if($to_trf_start == "--"  || $to_trf_end== "--" ){
            $where_tanggal_trf=null;
        }else if(($to_trf_start != "--"  && $to_trf_end != "--" ) && ($to_form_start != ""  && $to_form_end != "" ) ){
            $where_tanggal_trf= '  AND( uf."ULOK_BAYAR_DATE" >= \''.$to_trf_start.'\' AND uf."ULOK_BAYAR_DATE" <= \''.$to_trf_end.'\')';
          
        }else {
            $where_tanggal_trf=null;
        }
       


        $wheretambahan=$where_noform.' '.$where_nama.' '.$where_status.' '.$where_tanggal_trf.' '.$where_tanggal_form;
        $rs = $this->M_Ulok->count_data_table_trx_ulok_toko($wheretambahan);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_trx_cab($page,$rows,$wheretambahan);
        $items = array();
            foreach ($rs['rows'] as $data) {
                array_push($items,$data);
            }
        $result["rows"] = $items;
        echo json_encode($result);
    }

    
    public function print_listing_status_ulok_calon_franchisee($cabang,$periode){
        $this->load->library('Pdf');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $username=$this->session->userdata('username');
        date_default_timezone_set('Asia/Jakarta');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->session->userdata('user_id'));
        $pdf->SetTitle('LISTING STATUS ULOK CALON FRANCHISEE');
        $header = 'LISTING STATUS ULOK CALON FRANCHISEE';
        $pdf->SetSubject('');
        $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
        $pdf->SetMargins(5, 20, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helveticaB', '', 20, '', true);
        $pdf->AddPage('L','A4');            
            // set cell padding

            // set cell margins
        $pdf->setCellMargins(0, 0, 0, 0);
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '', 12, '', true);
        $pdf->MultiCell(92, 2,'', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(100, 2, $header , 0, 'C', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', '',6, '', true);
        $pdf->MultiCell(28, 2, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->setCellHeightRatio(2);    
        $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $data=$this->M_Ulok->get_data_listing_status_ulok($cabang,$periode);
        $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
        $pdf->SetFont('helveticaB', '',7, '', true);
        $res_periode = explode("-", $periode);
        $pdf->MultiCell(110, 2, '' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(40, 2,'Kode - Nama Cabang', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(40, 2,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', '',6, '', true);
        $pdf->MultiCell(26, 2, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '',7, '', true);
        $pdf->MultiCell(110, 2, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 2,$this->month_name(intval($res_periode[0])).'-'.$res_periode[1], 0, 'L', 0, 0, '', '', true);
        $pdf->SetFont('helvetica', '',6, '', true);
        $pdf->MultiCell(49, 2, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '', 8, '', true);

        $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(10, 1, 'No         ', 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, 'Nama Calon Franchisee
         ', 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(20, 1, 'Tanggal Transfer        ' , 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, 'No Form Pengajuan Usulan Lokasi
        ' , 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(20, 1, 'Hasil Survey Lokasi ' , 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1, 'Status ULOK yg sdh dkonfirm' , 1, 'C', 0, 0, '', '', true);  
        $no=1;
        $pdf->Ln();
        $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(190, 1,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
        $pdf->Ln();      
        foreach ($data as $list_status_ulok) 
        { 
            if($list_status_ulok->STATUS_ULOK=='OK'){
                $status_ulok='Lanjut Buka';
            }else if($list_status_ulok->STATUS_ULOK=='NOK'){
                $status_ulok='Tdk Lanjut Buka';
            }else{
                $status_ulok=$list_status_ulok->STATUS_ULOK;
                }
        $pdf->setCellPaddings(1, 1, 1, 1);               
        $res_periode = explode("-", $list_status_ulok->ULOK_BAYAR_DATE);
        $pdf->SetFont('helvetica', '', 7, '', true);
        $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(10, 1, $no, 1, 'C', 0, 0, '', '', true);

        $pdf->MultiCell(50, 1,$list_status_ulok->NAMA, 1, 'C', 0, 0, '', '', true);

        $pdf->MultiCell(20, 1,$res_periode[2].' '.$this->month_name(intval($res_periode[1])).' '.$res_periode[0] , 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$list_status_ulok->ULOK_FORM_NUM , 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(20, 1,$list_status_ulok->SURVEY_HASIL, 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1,$status_ulok, 1, 'C', 0, 0, '', '', true);             
        $pdf->Ln();
        if ($no++ % 21 == 0 ) 
        {                           
            $pdf->AddPage('L','A4');
            $pdf->setCellPaddings(0,0, 0, 0);
            $pdf->SetFont('helveticaB', '', 8, '', true);
            $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(10, 1, 'No         ', 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1, 'Nama Calon Franchisee 
                ', 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Tanggal Transfer' , 1, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1, 'No Form Pengajuan Usulan Lokasi
                             ' , 1, 'C', 0, 0, '', '', true);

            $pdf->MultiCell(20, 1, 'Hasil Survey Lokasi' , 1, 'C', 0, 0, '', '', true);
                           /*   $pdf->MultiCell(30, 1, 'Hasil Survey Lokasi(oleh Franchise Mgr) ' , 1, 'C', 0, 0, '', '', true); 
                            $pdf->MultiCell(50, 1, 'Alasan Status blm difinalisasi
                                        
                                         ' , 1, 'C', 0, 0, '', '', true);*/
            $pdf->MultiCell(40, 1, 'Status ULOK yg sdh dkonfirm' , 1, 'C', 0, 0, '', '', true);              
            $pdf->Ln();
            $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(190, 1,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
            $pdf->Ln();
                                

        }
    }
            $counter++;
            ob_end_clean();
            $namanya_file='Laporan Penerimaan Uang Muka dari Calon Franchisee'.'-'.date('YmdHi').'.pdf';
            $pdf->Output($namanya_file, 'I');
    }


   
    public function get_data_trx_cab_where_ulok_trx_id($ulok_trx_id)
    {
        $result = $this->M_Ulok->get_data_trx_cab_where_ulok_trx_id($ulok_trx_id);
        echo json_encode($result);

    }

  

    public function print_form_pengajuan_ulok($form_id)
    {
        $this->load->library('Pdf');
        $form_num= str_replace("-","/",''.$form_id);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
        date_default_timezone_set('Asia/Jakarta');
        $username=$this->session->userdata('user_id');
            // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->session->userdata('user_id'));
          //  $pdf->SetTitle('FORMULIR PENGAJUAN USULAN TOKO');
        $header = 'FORMULIR PENGAJUAN USULAN LOKASI';
        $pdf->SetSubject('');
           // $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
        $pdf->SetMargins(10,5,10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            //$pdf->setFontSpacing(100); 
            // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
        $pdf->setFontSubsetting(true);             
            // set cell padding
        $pdf->setCellPaddings(1, 1, 1, 1);
            //$pdf->setCellHeightRatio(0.8);
        $pdf->setCellHeightRatio(1);
            // set cell margins
        $pdf->setCellMargins(0, 0, 0, 0);
        $pdf->AddPage('P','A4');           
        $pdf->SetFont('helveticaB', '', 12, '', true);
        $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(90, 1, $header , 0, 'L', 0, 0, '', '', true);          
        $pdf->SetFont('helvetica', '', 6, '', true);
        $pdf->MultiCell(30, 1, '' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(19, 1, 'Tgl Akses ' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(80, 1, '', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(19, 1,'Pukul Akses ', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 1,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(80, 1,'',0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1, '' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(19, 1, 'User ID ' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(17, 1, $username , 0, 'L', 0, 0, '', '', true);
        $data = $this->M_Ulok->get_report_ulok_form_where_ulok_form_num($form_num);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '',7, '', true);
        $pdf->MultiCell(30, 1,'Cabang ', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(30, 1,$data->BRANCH_NAME , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(20, 1, 'Nomor ' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1,$form_num, 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(30, 1, 'Tanggal Form' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $res = explode("-", $data->ULOK_FORM_DATE);
        $changedDate = $res[2]."-".$res[1]."-".$res[0];
        $pdf->MultiCell(17, 1,$changedDate, 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
            if($data->SUMBER_ULOK=='Pameran'){
                $cek_pameran='X';
                $cek_website='';
                $cek_cabang='';
                $cek_ho='';

            }else if($data->SUMBER_ULOK=='Website'){
                $cek_pameran='';
                $cek_website='X';
                $cek_cabang='';
                $cek_ho='';
            }else if($data->SUMBER_ULOK=='Cabang'){
                $cek_pameran='';
                $cek_website='';
                $cek_cabang='X';
                $cek_ho='';
            }else if($data->SUMBER_ULOK=='HO'){
                $cek_pameran='';
                $cek_website='';
                $cek_cabang='';
                $cek_ho='X';
            }

        $pdf->SetFont('helvetica', '',6, '', true);
        $pdf->MultiCell(30, 1,'Sumber Ulok', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,$cek_pameran, 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(15, 1, 'Pameran' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,$cek_website, 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(15, 1, 'Website' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,$cek_cabang, 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(15, 1, 'Cabang' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,$cek_ho, 1, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(15, 1, 'HO' , 0, 'C', 0, 0, '', '', true);
        $pdf->Ln();        
        $pdf->SetFont('helveticaB', '',8, '', true);
        $pdf->MultiCell(60, 1,'A. Data Calon Terwaralaba ', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '',7, '', true);
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'No.KTP', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(40, 1, $data->NO_KTP , 0, 'L', 0, 0, '', '', true);   
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Nama Lengkap (sesuai KTP)', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 1,$data->NAMA, 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(4, 10,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 10,'Alamat Lengkap', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 10, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->setCellHeightRatio(1);
        $pdf->MultiCell(100, 10,$data->ALAMAT, 0, 'L', 0, 0, '', '', true);
        $pdf->setCellHeightRatio(1);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Kelurahan', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->KELURAHAN, 0, 'L', 0, 0, '', '', true);
        $res = explode("/", $data->rtrw);
        $rt = $res[0];
        $rw = $res[1];
        $pdf->MultiCell(10, 1, 'RT' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(10, 3,$rt, 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(11, 1, 'RW' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(10, 3,$rw, 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Kodya/Kabupaten', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->KODYA_KAB, 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Kecamatan' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, $data->KECAMATAN , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Provinsi', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->PROVINSI , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Kode Pos' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(20, 1,$data->KODE_POS , 0, 'L', 0, 0, '', '', true);      
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Telepon/Handphone', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->TELP , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Email', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(60, 1,$data->EMAIL, 0, 'L', 0, 0, '', '', true);      
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'NPWP', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->NPWP , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(25, 1, '' , 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(10, 1, '' , 0, 'C', 0, 0, '', '', true);      
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Nama Bank', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->BANK_NAME , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Cabang' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, $data->ULOK_CABANG_BANK , 0, 'L', 0, 0, '', '', true);      
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'No Rekening', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, $data->ULOK_NO_REK , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Atas Nama' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, $data->ULOK_NAMA_REK , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '',8, '', true);
        $pdf->MultiCell(40, 1,'B. Data Usulan Lokasi', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '',7 ,'', true);
        $pdf->MultiCell(4, 10,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 10,'Alamat Lengkap', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 10, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->setCellHeightRatio(1);
        $pdf->MultiCell(100, 10, $data->ULOK_ALAMAT , 0, 'L', 0, 0, '', '', true);
        $pdf->setCellHeightRatio(0.8);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Kelurahan', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1, $data->ULOK_KELURAHAN , 0, 'L', 0, 0, '', '', true);
        $res_ulok = explode("/", $data->ULOK_RT_RW);
        $rt_ulok = $res_ulok[0];
        $rw_ulok = $res_ulok[1];
        $pdf->MultiCell(10, 1, 'RT' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(10, 1, $rt_ulok , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(11, 1, 'RW' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'R', 0, 0, '', '', true);
        $pdf->MultiCell(10, 1, $rw_ulok , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Kodya/Kabupaten', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->ULOK_KODYA_KAB, 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Kecamatan' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->ULOK_KECAMATAN , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1,'Provinsi', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->ULOK_PROVINSI, 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(37, 1, 'Kode Pos' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
        $pdf->MultiCell(50, 1,$data->ULOK_KODE_POS , 0, 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->Ln();
        $ulok_bentuk=$data->ULOK_BENTUK;
                    if($ulok_bentuk=='Tanah Kosong'){
                        $cek_tanah_kosong='X';
                        $cek_ruko='';
                        $cek_lainnya='';
                        $cek_kios='';
                        $lainnya='';
                        $cek_ruang_usaha='';
                        $ulok_uk_pjg_tanah_kosong=$data->ULOK_UKURAN_PJG;
                        $ulok_uk_lbr_tanah_kosong=$data->ULOK_UKURAN_LBR;
                        $ulok_uk_pjg_ruko='';
                        $ulok_uk_lbr_ruko='';
                        $ulok_uk_pjg_ruang_usaha='';
                        $ulok_uk_lbr_ruang_usaha='';
                        $ulok_uk_pjg_kios='';
                        $ulok_uk_lbr_kios='';
                        $ulok_jml_unit_kios='';
                        $ulok_jml_unit_ruko='';
                        $ulok_jml_unit_ruang_usaha='';
                        $ulok_jml_lt_ruko='';
                        $ulok_jml_lt_ruang_usaha='';
                        $ulok_jml_lt_kios='';
                        $ulok_uk_pjg_lain='';
                        $ulok_uk_lbr_lain='';
                        $ulok_jml_unit_lain='';
                        $ulok_jml_lt_lain='';
                    }else if($ulok_bentuk=='Ruko'){
                        $cek_tanah_kosong='';
                        $cek_lainnya='';
                        $cek_ruko='X';
                        $cek_kios='';
                        $lainnya='';
                        $cek_ruang_usaha='';
                        $ulok_uk_pjg_tanah_kosong='';
                        $ulok_uk_lbr_tanah_kosong='';
                        $ulok_uk_pjg_ruko=$data->ULOK_UKURAN_PJG;
                        $ulok_uk_lbr_ruko=$data->ULOK_UKURAN_LBR;
                        $ulok_uk_pjg_ruang_usaha='';
                        $ulok_uk_lbr_ruang_usaha='';
                        $ulok_uk_pjg_kios='';
                        $ulok_uk_lbr_kios='';
                        $ulok_jml_unit_kios='';
                        $ulok_jml_unit_ruko=$data->ULOK_JML_UNIT;
                        $ulok_jml_unit_ruang_usaha='';
                        $ulok_jml_lt_ruko=$data->ULOK_JML_LT;
                        $ulok_jml_lt_ruang_usaha='';
                        $ulok_jml_lt_kios='';
                        $ulok_uk_pjg_lain='';
                        $ulok_uk_lbr_lain='';
                        $ulok_jml_unit_lain='';
                        $ulok_jml_lt_lain='';
                    }else if($ulok_bentuk=='Ruang Usaha'){
                        $cek_tanah_kosong='';
                        $cek_lainnya='';
                        $cek_ruko='';
                        $cek_kios='';
                        $cek_ruang_usaha='X';
                        $lainnya='';
                        $ulok_uk_pjg_tanah_kosong='';
                        $ulok_uk_lbr_tanah_kosong='';
                        $ulok_uk_pjg_ruko='';
                        $ulok_uk_lbr_ruko='';
                        $ulok_uk_pjg_ruang_usaha=$data->ULOK_UKURAN_PJG;
                        $ulok_uk_lbr_ruang_usaha=$data->ULOK_UKURAN_LBR;
                        $ulok_uk_pjg_kios='';
                        $ulok_uk_lbr_kios='';
                        $ulok_jml_unit_kios='';
                        $ulok_jml_unit_ruko='';
                        $ulok_jml_unit_ruang_usaha=$data->ULOK_JML_UNIT;
                        $ulok_jml_lt_ruko='';
                        $ulok_jml_lt_ruang_usaha=$data->ULOK_JML_LT;
                        $ulok_jml_lt_kios='';
                        $ulok_uk_pjg_lain='';
                        $ulok_uk_lbr_lain='';
                        $ulok_jml_unit_lain='';
                        $ulok_jml_lt_lain='';
                    }else if($ulok_bentuk=='Kios'){
                        $cek_lainnya='';
                        $cek_tanah_kosong='';
                        $cek_ruko='';
                        $cek_kios='X';
                        $lainnya='';
                        $cek_ruang_usaha='';
                        $ulok_uk_pjg_tanah_kosong='';
                        $ulok_uk_lbr_tanah_kosong='';
                        $ulok_uk_pjg_ruko='';
                        $ulok_uk_lbr_ruko='';
                        $ulok_uk_pjg_ruang_usaha='';
                        $ulok_uk_lbr_ruang_usaha='';
                        $ulok_uk_pjg_kios=$data->ULOK_UKURAN_PJG;
                        $ulok_uk_pjg_lain='';
                        $ulok_uk_lbr_kios=$data->ULOK_UKURAN_LBR;
                        $ulok_jml_unit_kios=$data->ULOK_JML_UNIT;
                        $ulok_jml_unit_ruko='';
                        $ulok_jml_unit_ruang_usaha='';
                        $ulok_jml_lt_ruko='';
                        $ulok_jml_lt_ruang_usaha='';
                        $ulok_jml_lt_kios=$data->ULOK_JML_LT;
                        $ulok_uk_lbr_lain='';
                        $ulok_jml_unit_lain='';
                        $ulok_jml_lt_lain='';
                    }else if($ulok_bentuk=='Lainnya'){
                        $cek_tanah_kosong='';
                        $cek_ruko='';
                        $cek_kios='';
                        $cek_lainnya='X';
                        $lainnya=$data->ULOK_BENTUK_LOK_LAIN;
                        $cek_ruang_usaha='';
                        $ulok_uk_pjg_tanah_kosong='';
                        $ulok_uk_lbr_tanah_kosong='';
                        $ulok_uk_pjg_ruko='';
                        $ulok_uk_lbr_ruko='';
                        $ulok_uk_pjg_ruang_usaha='';
                        $ulok_uk_lbr_ruang_usaha='';
                        $ulok_uk_pjg_kios='';
                        $ulok_uk_lbr_kios='';
                        $ulok_jml_unit_kios='';
                        $ulok_jml_unit_ruko='';
                        $ulok_jml_unit_ruang_usaha='';
                        $ulok_jml_lt_ruko='';
                        $ulok_jml_lt_ruang_usaha='';
                        $ulok_jml_lt_kios='';
                        $ulok_jml_lt_lain=$data->ULOK_JML_LT;
                        $ulok_uk_pjg_lain=$data->ULOK_UKURAN_PJG;
                        $ulok_uk_lbr_lain=$data->ULOK_UKURAN_LBR;
                        $ulok_jml_unit_lain=$data->ULOK_JML_UNIT;
                    }
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'1.Bentuk Lokasi', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_tanah_kosong, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tanah Kosong' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Ukuran :' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_pjg_tanah_kosong.' '.'m' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'x' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_lbr_tanah_kosong.' '.'m' , 0, 'L', 0, 0, '', '', true);         
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_ruko, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ruko' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Ukuran :' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_pjg_ruko.' '.'m' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'x' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_lbr_ruko.' '.'m' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_jml_unit_ruko.' '.'Unit' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, $ulok_jml_lt_ruko.' '.'Lantai' , 0, 'C', 0, 0, '', '', true);   
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_ruang_usaha, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ruang Usaha' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Ukuran :' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_pjg_ruang_usaha.' '.'m' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'x' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_lbr_ruang_usaha.' '.'m' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_jml_unit_ruang_usaha.' '.'Unit' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, $ulok_jml_lt_ruang_usaha.' '.'Lantai' , 0, 'C', 0, 0, '', '', true);   
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_kios, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Kios' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Ukuran :' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_pjg_kios.' '.'m' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'x' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_lbr_kios.' '.'m' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_jml_unit_kios.' '.'Unit' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, $ulok_jml_lt_kios.' '.'Lantai' , 0, 'C', 0, 0, '', '', true);   
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,  $cek_lainnya, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Lainnya: ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, $lainnya , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Ukuran :' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_pjg_lain.' '.'m' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'x' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_uk_lbr_lain.' '.'m' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, $ulok_jml_unit_lain.' '.'Unit' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(15, 1, 'Jumlah :' , 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, $ulok_jml_lt_lain.' '.'Lantai' , 0, 'C', 0, 0, '', '', true);   
    $pdf->Ln();
    $pdf->Ln();
                    $status_parkir=$data->ULOK_LHN_PKR;
                    if($status_parkir=='Sendiri'){
                        $cek_status_pkr_sndr='X';
                        $cek_status_pkr_ada='X';
                        $cek_status_pkr_bersama='';
                        $cek_status_pkr_lainnya='';
                        $cek_status_pkr_tdk_ada='';
                        $status_pkr_lainnya='';
                    }else if($status_parkir=='Bersama'){
                        $cek_status_pkr_sndr='';
                        $cek_status_pkr_ada='X';
                        $cek_status_pkr_bersama='X';
                        $cek_status_pkr_lainnya='';
                        $cek_status_pkr_tdk_ada='';
                        $status_pkr_lainnya='';
                    }else if($status_parkir=='Lainnya'){
                        $cek_status_pkr_sndr='';
                        $cek_status_pkr_ada='X';
                        $cek_status_pkr_bersama='';
                        $cek_status_pkr_lainnya='X';
                        $cek_status_pkr_tdk_ada='';
                        $status_pkr_lainnya=$data->ULOK_LHN_PKR_LN;
                    }else if($status_parkir=='Tidak Ada'){
                        $cek_status_pkr_sndr='';
                        $cek_status_pkr_ada='';
                        $cek_status_pkr_bersama='';
                        $cek_status_pkr_lainnya='';
                        $cek_status_pkr_tdk_ada='X';
                        $status_pkr_lainnya='';
                    }
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'2.Lahan Parkir  ', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_pkr_tdk_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1,'Tidak ada' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_pkr_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(25, 1, 'Ada,Status Parkir:' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_pkr_sndr, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(10, 1, 'Sendiri' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_pkr_bersama, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Bersama' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_pkr_lainnya, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(15, 1, 'Lainnya: ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, $status_pkr_lainnya , 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
                    $status_lokasi=$data->ULOK_STATUS_LOK;
                    if($status_lokasi=='Milik Sendiri'){
                        $cek_status_lok_sendiri='X';
                        $cek_status_lok_kel='';
                        $cek_status_lok_lainnya='';
                        $status_lok_lainnya='';
                    }else if($status_lokasi=='Milik Keluarga'){
                        $cek_status_lok_sendiri='';
                        $cek_status_lok_kel='X';
                        $cek_status_lok_lainnya='';
                        $status_lok_lainnya='';
                    }else if($status_lokasi=='Lainnya'){
                        $cek_status_lok_sendiri='';
                        $cek_status_lok_kel='';
                        $cek_status_lok_lainnya='X';
                        $status_lok_lainnya=$data->ULOK_STATUS_LOK_LN;
                    }
    $pdf->MultiCell(4, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'3.Status Lokasi', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_status_lok_sendiri, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Milik Sendiri' , 0, 'L', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_status_lok_kel, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Milik Keluarga' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_status_lok_lainnya, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Lainnya: ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, $status_lok_lainnya , 0, 'C', 0, 0, '', '', true);        
    $pdf->Ln();
    $pdf->Ln();
    $res_ulok_dok=$data->ULOK_DOK;
                    if($res_ulok_dok=='SHM'){
                        $cek_shm='X';
                        $cek_shgb='';
                        $cek_shsrs='';
                        $cek_lainnya='';
                        $status_dok_lainnya='';
                    }else if($res_ulok_dok=='SHGB'){
                        $cek_shm='';
                        $cek_shgb='X';
                        $cek_shsrs='';
                        $cek_lainnya='';
                        $status_dok_lainnya='';
                    }else if($res_ulok_dok=='SHSRS'){
                        $cek_shm='';
                        $cek_shgb='';
                        $cek_shsrs='X';
                        $cek_lainnya='';
                        $status_dok_lainnya='';
                    }else if($res_ulok_dok=='Lainnya'){
                        $cek_shm='';
                        $cek_shgb='';
                        $cek_shsrs='';
                        $cek_lainnya='X';
                        $status_dok_lainnya=$data->ULOK_DOK_LN;
                    }
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'4.Dokumen Kepemilikian', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_shm, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'SHM' , 0, 'L', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_shgb, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'SHGB' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_shsrs, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'SHSRS ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_lainnya, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Lainnya: ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, $status_dok_lainnya , 0, 'C', 0, 0, '', '', true);        
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'5.Perizinan Bangunan', 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $res_izin_bgn=$data->ULOK_IZIN_BGN;
                    if($res_izin_bgn=='IMB')
                    {
                        $cek_imb='X';
                        $cek_izin_bgn_ada='X';
                        $cek_ipb='';
                        $cek_izin_bgn_tdk_ada='';
                    }else if($res_izin_bgn=='IPB')
                    {
                        $cek_imb='';
                        $cek_izin_bgn_ada='X';
                        $cek_ipb='X';
                        $cek_izin_bgn_tdk_ada='';
                    }else{

                        $cek_imb='';
                        $cek_izin_bgn_ada='';
                        $cek_ipb='';
                        $cek_izin_bgn_tdk_ada='X';
                    }
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'a.Izin Bangunan', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);

    $pdf->MultiCell(4, 1,$cek_izin_bgn_tdk_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak ada' , 0, 'L', 0, 0, '', '', true); 
    $pdf->MultiCell(4, 1,$cek_izin_bgn_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ada , yaitu : ' , 0, 'L', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_imb, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'IMB' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_ipb, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'IPB ' , 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
                    $res_izin_bgn_utk=$data->ULOK_IZIN_UTK;
                    if($res_izin_bgn_utk=='Ruko'){
                        $cek_izin_u_ruko='X';
                        $cek_izin_u_ruangusaha='';
                        $cek_izin_u_kios='';
                        $cek_izin_u_rumahtinggal='';
                        $cek_izin_u_lainnya='';
                        $izin_untuk_lainnya='';
                    }else if($res_izin_bgn_utk=='Ruang Usaha'){
                        $cek_izin_u_ruko='';
                        $cek_izin_u_ruangusaha='X';
                        $cek_izin_u_kios='';
                        $cek_izin_u_rumahtinggal='';
                        $cek_izin_u_lainnya='';
                        $izin_untuk_lainnya='';
                    }else if($res_izin_bgn_utk=='Kios'){
                        $cek_izin_u_ruko='';
                        $cek_izin_u_ruangusaha='';
                        $cek_izin_u_kios='X';
                        $cek_izin_u_rumahtinggal='';
                        $cek_izin_u_lainnya='';
                        $izin_untuk_lainnya='';
                    }else if($res_izin_bgn_utk=='Rumah Tinggal'){
                        $cek_izin_u_ruko='';
                        $cek_izin_u_ruangusaha='';
                        $cek_izin_u_kios='';
                        $cek_izin_u_rumahtinggal='X';
                        $cek_izin_u_lainnya='';
                        $izin_untuk_lainnya='';
                    }else if($res_izin_bgn_utk=='Lainnya'){
                        $cek_izin_u_ruko='';
                        $cek_izin_u_ruangusaha='';
                        $cek_izin_u_kios='';
                        $cek_izin_u_rumahtinggal='';
                        $cek_izin_u_lainnya='X';
                        $izin_untuk_lainnya=$data->ULOK_IZIN_UTK;
                    }
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'b.Peruntukan Bangunan (sesuai IMB/IPB) ', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_izin_u_ruko, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ruko' , 0, 'L', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_izin_u_ruangusaha, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ruang Usaha' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_izin_u_kios, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Kios ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_izin_u_rumahtinggal, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Rumah Tinggal ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_izin_u_lainnya, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Lainnya : ' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, $izin_untuk_lainnya , 0, 'C', 0, 0, '', '', true);

                    $res_idm_tdk=$data->ULOK_IDM_TDK;
                 
                    if($res_idm_tdk=='< 500 m'){
                        $cek_idm_tdkat_ada='X';
                        $cek_idm_krg_500m='X';
                        $cek_idm_lbh_500m='';
                        $cek_idm_tdkat_tidak_ada='';
                        $ket_idm_tdk=$data->ULOK_IDM_TDK_LN;
                        $cek_idm_tdkat_tdktahu='';
                    }else if($res_idm_tdk=='> 500 m'){
                        $cek_idm_tdkat_ada='X';
                        $cek_idm_krg_500m='';
                        $cek_idm_lbh_500m='X';
                        $cek_idm_tdkat_tidak_ada='';
                        $ket_idm_tdk=$data->ULOK_IDM_TDK_LN;
                        $cek_idm_tdkat_tdktahu='';
                    }else if($res_idm_tdk=='Tidak Ada'){
                        $cek_idm_tdkat_ada='';
                        $cek_idm_krg_500m='';
                        $cek_idm_lbh_500m='';
                        $cek_idm_tdkat_tidak_ada='X';
                        $ket_idm_tdk='';
                        $cek_idm_tdkat_tdktahu='';
                    }else if($res_idm_tdk=='Tidak Tahu'){
                        $cek_idm_tdkat_ada='';
                        $cek_idm_krg_500m='';
                        $cek_idm_lbh_500m='';
                        $cek_idm_tdkat_tidak_ada='';
                        $ket_idm_tdk='';
                        $cek_idm_tdkat_tdktahu='X';
                    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'6.Indomaret Terdekat', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,$cek_idm_tdkat_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ada,Sebutkan :  ' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(20, 1, $ket_idm_tdk , 0, 'C', 0, 0, '', '', true);        
    $pdf->MultiCell(20, 1, 'Jarak : ' , 0, 'C', 0, 0, '', '', true);  
    $pdf->MultiCell(4, 1,$cek_idm_krg_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '< 500 m' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_idm_lbh_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '> 500 m ' , 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(68, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_idm_tdkat_tidak_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak ada' , 0, 'L', 0, 0, '', '', true);  

    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, $cek_idm_tdkat_tdktahu, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak tahu' , 0, 'L', 0, 0, '', '', true);        
                    $res_pasar=$data->ULOK_PASAR;
                    if($res_pasar=='< 500 m'){
                        $cek_pasar_ada='X';
                        $cek_pasar_krg_500m='X';
                        $cek_pasar_lbh_500m='';
                        $cek_pasar_tidak_ada='';
                        $ket_pasar=$data->ULOK_PASAR_LN;
                        $cek_pasar_tidak_tahu='';
                    }else if($res_pasar=='> 500 m'){
                        $cek_pasar_ada='X';
                        $cek_pasar_krg_500m='';
                        $cek_pasar_lbh_500m='X';
                        $cek_pasar_tidak_ada='';
                        $ket_pasar=$data->ULOK_PASAR_LN;
                        $cek_pasar_tidak_tahu='';
                    }else if($res_pasar=='Tidak Ada'){
                        $cek_pasar_ada='';
                        $cek_pasar_krg_500m='';
                        $cek_pasar_lbh_500m='';
                        $cek_pasar_tidak_ada='X';
                        $ket_pasar='';
                        $cek_pasar_tidak_tahu='';
                    }else if($res_pasar=='Tidak Tahu'){
                        $cek_pasar_ada='';
                        $cek_pasar_krg_500m='';
                        $cek_pasar_lbh_500m='';
                        $cek_pasar_tidak_ada='';
                        $ket_pasar='';
                        $cek_pasar_tidak_tahu='X';
                    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'7.Pasar Tradisional  ', 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true); 
    $pdf->MultiCell(4, 1,$cek_pasar_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ada,Sebutkan :  ' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(20, 1, $ket_pasar , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(20, 1, 'Jarak : ' , 0, 'C', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_pasar_krg_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '< 500 m' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_pasar_lbh_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '> 500 m ' , 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(68, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_pasar_tidak_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak ada' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_pasar_tidak_tahu, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak tahu' , 0, 'L', 0, 0, '', '', true);          
                    $res_minimarket=$data->ULOK_MINIMARKET;
                    if($res_minimarket=='< 500 m'){
                        $cek_minimarket_ada='X';
                        $cek_minimarket_krg_500m='X';
                        $cek_minimarket_lbh_500m='';
                        $cek_minimarket_tidak_ada='';
                        $ket_minimarket=$data->ULOK_MINIMARKET_LN;
                        $cek_minimarket_tidak_tahu='';
                    }else if($res_minimarket=='> 500 m'){
                        $cek_minimarket_ada='X';
                        $cek_minimarket_krg_500m='';
                        $cek_minimarket_lbh_500m='X';
                        $cek_minimarket_tidak_ada='';
                        $ket_minimarket=$data->ULOK_MINIMARKET_LN;
                        $cek_minimarket_tidak_tahu='';
                    }else if($res_minimarket=='Tidak Ada'){
                        $cek_minimarket_ada='';
                        $cek_minimarket_krg_500m='';
                        $cek_minimarket_lbh_500m='';
                        $cek_minimarket_tidak_ada='X';
                        $ket_minimarket='';
                        $cek_minimarket_tidak_tahu='';
                    }else if($res_minimarket=='Tidak Tahu'){
                        $cek_minimarket_ada='';
                        $cek_minimarket_krg_500m='';
                        $cek_minimarket_lbh_500m='';
                        $cek_minimarket_tidak_ada='';
                        $ket_minimarket='';
                        $cek_minimarket_tidak_tahu='X';
                    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'8.Minimarket Lainnya  ', 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true); 
    $pdf->MultiCell(4, 1,$cek_minimarket_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Ada,Sebutkan :  ' , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(20, 1, $ket_minimarket , 0, 'C', 0, 0, '', '', true); 
    $pdf->MultiCell(20, 1, 'Jarak : ' , 0, 'C', 0, 0, '', '', true);        
    $pdf->MultiCell(4, 1,$cek_minimarket_krg_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '< 500 m' , 0, 'L', 0, 0, '', '', true);    
    $pdf->MultiCell(4, 1,$cek_minimarket_lbh_500m, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, '> 500 m ' , 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(68, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_minimarket_tidak_ada, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak ada' , 0, 'L', 0, 0, '', '', true);  
    $pdf->MultiCell(40, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_minimarket_tidak_tahu, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Tidak tahu' , 0, 'L', 0, 0, '', '', true);        
    
    $pdf->Ln();
    $pdf->Ln();
                    $res_lampiran=$data->ULOK_LAMPIRAN;
                    if($res_lampiran=='Melalui Email')
                    {
                        $cek_lampiran_email='X';
                        $cek_lampiran_kirim='';

                    }else if(trim($res_lampiran)=='Dikirim Langsung')
                    {
                        $cek_lampiran_email='';
                        $cek_lampiran_kirim='X';
                    }
    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'9.Denah / Foto Lokasi', 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true); 
    $pdf->MultiCell(4, 1,$cek_lampiran_email, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Melalui Email' , 0, 'L', 0, 0, '', '', true);      
    $pdf->MultiCell(4, 1,$cek_lampiran_kirim, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(25, 1, 'Terlampir' , 0, 'L', 0, 0, '', '', true);    
    
    $pdf->Ln();
    $pdf->Ln();
                    
    $pdf->SetFont('helveticaB', '',8, '', true);
    $pdf->MultiCell(50, 1,'C. Data Pembayaran Usulan Lokasi', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
               
                    $res_tipe_bayar=$data->ULOK_TIPE_BAYAR;
                    if($res_tipe_bayar=='Debit')
                    {
                        $cek_debit='X';
                        $cek_cash='';
                        $cek_kartu_kredit='';
                        $cek_transfer='';
                        $kartukredit=$data->ULOK_KARTU_KREDIT;
                    }else if($res_tipe_bayar=='Kartu Kredit')
                    {
                        $cek_debit='';
                        $cek_kartu_kredit='X';
                        $cek_cash='';
                        $cek_transfer='';
                        $kartukredit=$data->ULOK_KARTU_KREDIT;
                    }else if($res_tipe_bayar=='Transfer')
                    {
                        $cek_cash='';
                        $cek_debit='';
                        $cek_kartu_kredit='';
                        $cek_transfer='X';
                        $kartukredit=$data->ULOK_KARTU_KREDIT;
                    }else if($res_tipe_bayar=='Cash')
                    {   
                        $cek_cash='X';
                        $cek_debit='';
                        $cek_kartu_kredit='';
                        $cek_transfer='';
                        $kartukredit='';
                    }

    $pdf->Ln();
    $pdf->SetFont('helvetica', '',7, '', true);
    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,'Pembayaran Uang Muka ULOK melalui', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,$cek_cash, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Cash' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,$cek_transfer, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Transfer' , 0, 'L', 0, 0, '', '', true);      
    $pdf->MultiCell(4, 1,$cek_debit, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(20, 1, 'Debit Card' , 0, 'L', 0, 0, '', '', true);   
    $pdf->MultiCell(4, 1,$cek_kartu_kredit, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(25, 1, 'Credit Card' , 0, 'L', 0, 0, '', '', true); 
    $pdf->MultiCell(5, 1, ':' , 0, 'L', 0, 0, '', '', true);  
    $pdf->MultiCell(25, 1, $kartukredit , 0, 'C', 0, 0, '', '', true);    
    $res_tgl_bayar = explode("-", $data->ULOK_BAYAR_DATE);
    $changedDate_tgl_bayar = $res_tgl_bayar[2]."-".$this->month_name(intval($res_tgl_bayar[1]))."-".$res_tgl_bayar[0];
    $pdf->Ln();              
    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,'Tanggal Pembayaran Uang Muka Ulok', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,$changedDate_tgl_bayar, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,'Nilai Rp yang diswipe ', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1, number_format($data->ULOK_AMOUNT_SWIPE, 2 , ',' , '.' ), 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,'Nilai Rp yang masuk ke Rekening', 0, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(50, 1,number_format($data->ULOK_AMOUNT, 2 , ',' , '.' ), 0, 'L', 0, 0, '', '', true);
    $pdf->AddPage('L','A5'); 
    $pdf->SetFont('helveticaB', '',14, '', true);
    $pdf->MultiCell(70, 1,'', 0, 'C', 0, 0, '', '', true);
   // $pdf->SetTextColor(194,8,8);

    $pdf->MultiCell(40, 1,'TANDA TERIMA', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Telah terima dari', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(60, 1,$data->NAMA, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Uang sejumlah', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaBI', '',12, '', true);
    $pdf->MultiCell(200, 1,$this->terbilang($data->ULOK_AMOUNT_SWIPE).' rupiah', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Pembayaran via', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(60, 1,$data->ULOK_TIPE_BAYAR.'  '.$data->ULOK_KARTU_KREDIT, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(220, 1,'Untuk pembayaran uang muka usulan lokasi dengan nomor : '.$form_num.'.', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
     $pdf->MultiCell(60, 1,'Rp.'.number_format($data->ULOK_AMOUNT_SWIPE).',-', 0, 'L', 0, 0, '', '', true);
     $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',9, '', true);
    $pdf->MultiCell(60, 1,$changedDate_tgl_bayar, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->MultiCell(60, 1,'Yang Menerima,', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(80, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'Yang Menyerahkan,', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(60, 1,'.......................................', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(80, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'.......................................', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();

    ob_end_clean();
    $namanya_file='FORMULIR PENGAJUAN USULAN TOKO'.'-'.$form_id.'.pdf';
    //$path = '/uploads/bkt_trf/';
    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'ULOK/uploads/bkt_trf/' . $namanya_file, 'FI');

                    
                 
                
    }

    
    //end inquiry ulok
    
//start inquiry to

    public function get_data_to_form_where_to_form_num()
    {
        $data = $this->input->post();
        $result = $this->M_Ulok->get_data_form_to_where_to_form_num($data['to_form_num']);
        echo json_encode($result);

    }

    public function get_data_trx_to_toko()
    {   $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

        $noform= isset($_POST['noform_to']) ? $_POST['noform_to'] : '';
        $nama= isset($_POST['nama_to']) ? $_POST['nama_to'] : '';
        $status= isset($_POST['status_to']) ? $_POST['status_to'] : '';
        $tanggal_mulai= isset($_POST['tanggal_mulai']) ? $_POST['tanggal_mulai'] : '';
        $tanggal_akhir= isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
        $tanggal_form_mulai= isset($_POST['tanggal_form_mulai']) ? $_POST['tanggal_form_mulai'] : '';
        $tanggal_form_akhir= isset($_POST['tanggal_form_akhir']) ? $_POST['tanggal_form_akhir'] : '';
        $to_form_start= $tanggal_form_mulai;
        $to_form_end= $tanggal_form_akhir;
        $to_trf_start=$tanggal_mulai;
        $to_trf_end= $tanggal_akhir; 

        if($noform == ""){
            $where_noform=null;
        }else{
            $where_noform=' AND uf."TO_FORM_NUM" LIKE \'%'.$noform.'%\'';
        }
        if($nama == ""){
            $where_nama=null;
        }else{
            $where_nama='  AND UPPER(uf."NAMA") LIKE UPPER(\'%'.$nama.'%\') ';
        }
        if($status == ""){
            $where_status=null;
        }else{
            $where_status=' AND utx."STATUS" = \''.$status.'\'';
        }
        if($to_form_start == "--"  || $to_form_end== "--" ){
            $where_tanggal_form=null;
        }else if(($to_form_start != "--"  && $to_form_end != "--" ) && ($to_form_start != ""  && $to_form_end != "" )){
            $where_tanggal_form= ' AND( uf."TO_FORM_DATE" >= \''.$to_form_start.'\' AND uf."TO_FORM_DATE" <= \''.$to_form_end.'\')';
        }else {
              $where_tanggal_form=null;
        }
        if($to_trf_start == "--"  || $to_trf_end== "--" ){
            $where_tanggal_trf=null;
        }else if(($to_trf_start != "--"  && $to_trf_end != "--" ) && ($to_form_start != ""  && $to_form_end != "" ) ){
            $where_tanggal_trf= '  AND( uf."TO_BAYAR_DATE" >= \''.$to_trf_start.'\' AND uf."TO_BAYAR_DATE" <= \''.$to_trf_end.'\')';
          
        }else {
            $where_tanggal_trf=null;
        }
       
        $wheretambahan=$where_noform.' '.$where_nama.' '.$where_status.' '.$where_tanggal_trf.' '.$where_tanggal_form;

        $rs = $this->M_Ulok->count_data_table_trx_to_toko($wheretambahan);
        $result["total"] = $rs->hitung;
        $rs = $this->M_Ulok->get_data_trx_to_toko($page,$rows,$wheretambahan);
        $items = array();
        foreach ($rs['rows'] as $data) {
                    array_push($items,$data);
                }
        $result["rows"] = $items;
        echo json_encode($result);
        //$wheretambahan='AND  fmt."STORE_CODE" LIKE \'%'.strtoupper($kodetoko).'%\' AND fmt."STORE_NAME" LIKE \'%'.strtoupper($namatoko).'%\' ';
        //$where= ' where "STORE_CODE" LIKE \'%'.strtoupper($kodetoko).'%\' AND "STORE_NAME" LIKE \'%'.strtoupper($namatoko).'%\' ';    
        // $result = $this->M_Ulok->get_data_trx_to_toko();
        // echo json_encode($result);
        
    }
    public function print_form_pengajuan_to_toko($form_id)
    {
        $this->load->library('Pdf');
        $form_num= str_replace("-","/",''.$form_id);
        $data = $this->M_Ulok->get_data_to_form_where_to_form_num($form_num);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('user_id');
            date_default_timezone_set('Asia/Jakarta');
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
          //  $pdf->SetTitle('FORMULIR PENGAJUAN USULAN TOKO');
            $header = 'FORMULIR TAKE OVER TOKO ';
            $pdf->SetSubject('');
           // $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(10,5,10);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);        
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->setCellHeightRatio(1.0);
            // set cell margins
            $pdf->setCellMargins(0, 0, 0, 0);
            $pdf->AddPage('P','A4'); 
            $pdf->SetFont('helveticaB', '', 12, '', true);
            $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(90, 1, $header , 0, 'L', 0, 0, '', '', true);
            $pdf->SetFont('helvetica', '', 6, '', true);
            $pdf->MultiCell(30, 1,'', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(19, 1, 'Tgl Akses ' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);        
            $pdf->Ln();
            $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(80, 1, '', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(40, 1, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(19, 1,'Pukul Akses ', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 1,date('H:i:s') , 0, 'L', 0, 0, '', '', true);        
            $pdf->Ln();
            $pdf->MultiCell(30, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(80, 1,'',0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(40, 1, '' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(19, 1, 'User ID ' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(17, 1, $username , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->Ln();
            $res = explode("-", $data->TO_FORM_DATE);
            $changedDate_to = $res[2]."-".$this->month_name(intval($res[1]))."-".$res[0];
            $pdf->SetFont('helveticaB', '',7, '', true);
            $pdf->MultiCell(30, 1,'Cabang ', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1,$data->BRANCH_NAME  , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1, 'Nomor ' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(40, 1, $form_num , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(30, 1, 'Tanggal' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(19, 1,$changedDate_to, 0, 'L', 0, 0, '', '', true);    
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helveticaB', '',8, '', true);
            $pdf->MultiCell(60, 1,'A.Data Calon Terwaralaba ', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helvetica', '',7, '', true);
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'No.KTP', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(40, 1,$data->NO_KTP  , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Nama Lengkap (sesuai KTP)', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 1,$data->NAMA , 0, 'L', 0, 0, '', '', true);       
            $pdf->Ln();
            $pdf->MultiCell(4, 10,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 10,'Alamat Lengkap', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 10, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->setCellHeightRatio(1);
            $pdf->MultiCell(80, 10,$data->ALAMAT, 0, 'L', 0, 0, '', '', true);
            $pdf->setCellHeightRatio(0.8);
            $pdf->Ln();
            $res = explode("/", $data->rtrw);
            $rt = $res[0];
            $rw = $res[1];
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);          
            $pdf->MultiCell(50, 1, 'Kelurahan' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->KELURAHAN , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(10, 1, 'RT' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(10, 3,$rt, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(11, 1, 'RW' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(5, 1,':', 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(10, 3,$rw, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(42, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Kodya/Kabupaten', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->KODYA_KAB , 0, 'L', 0, 0, '', '', true); 
            $pdf->MultiCell(37, 1,'Kecamatan', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->KECAMATAN, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Provinsi', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->PROVINSI, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(37, 1, 'Kode Pos' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1,$data->KODE_POS, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Telepon/Handphone', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TELP, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(37, 1,'Email', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(60, 1,$data->EMAIL, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'NPWP', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->NPWP, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(25, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(10, 1, '' , 0, 'C', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Nama Bank', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->BANK_NAME , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(37, 1, 'Cabang' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_CABANG_BANK , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'No Rekening', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1, $data->TO_NO_REK , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(37, 1, 'Atas Nama' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1, $data->TO_NAMA_REK , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('helveticaB', '',8, '', true);
            $pdf->MultiCell(60, 1,'B.Data Proposal TO', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->SetFont('helvetica', '',7, '', true);
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Kode Toko', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_KODE_TOKO, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Nama Toko', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_NAMA_TOKO, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 10,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 10,'Alamat Lengkap Toko', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 10,':', 0, 'L', 0, 0, '', '', true);
            $pdf->setCellHeightRatio(1);
            $pdf->MultiCell(50, 10,$data->TO_ALAMAT, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Provinsi', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_PROVINSI, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(37, 1, 'Kodya/Kabupaten' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(20, 1,$data->TO_KODYA_KAB, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Kecamatan', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_KECAMATAN , 0, 'L', 0, 0, '', '', true); 
            $pdf->MultiCell(37, 1,'Kelurahan', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,$data->TO_KELURAHAN, 0, 'L', 0, 0, '', '', true);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Kode Pos', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(47, 1,$data->TO_KODE_POS , 0, 'L', 0, 0, '', '', true); 
            $res = explode("/", $data->TO_RT_RW);
            $rt = $res[0];
            $rw = $res[1];
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(10, 1, 'RT' , 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(12, 3,$rt, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(10, 1, 'RW' , 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(4, 1,':', 0, 'R', 0, 0, '', '', true);
            $pdf->MultiCell(10, 3,$rw, 0, 'L', 0, 0, '', '', true);
            $pdf->MultiCell(42, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->setCellHeightRatio(0.8);
            $pdf->Ln();
            $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
            $pdf->MultiCell(50, 1,'Nilai Investasi', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'', 0, 'L', 0, 0, '', '', true);
                    $counter++;

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'1.Actual Investment', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(7, 1,'Rp.', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 1,number_format($data->TO_ACTUAL_INVESTMENT, 2 , ',' , '.' ), 0, 'R', 0, 0, '', '', true);    
                    $counter++;


                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'2.Goodwill', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(7, 1,'Rp.', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 1,number_format($data->TO_GOOD_WILL, 2 , ',' , '.' ), 0, 'R', 0, 0, '', '', true);     
                    $counter++;

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'3.PPN', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(7, 1,'Rp.', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 1,number_format($data->TO_PPN, 2 , ',' , '.' ), 0, 'R', 0, 0, '', '', true);     
                    $counter++;

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(4, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'4.Total', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(7, 1,'Rp.', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(30, 1,number_format($data->TO_TOTAL, 2 , ',' , '.' ), 0, 'R', 0, 0, '', '', true);     
                    $counter++;

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->SetFont('helveticaB', '',8, '', true);
                      $pdf->setCellHeightRatio(1);
                    $pdf->MultiCell(60, 1,'C.Data Pembayaran Take Over Toko', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $counter++;
               
                    $pdf->Ln();
                    $res_tipe_bayar=$data->TO_TIPE_BAYAR;
                    if($res_tipe_bayar=='Transfer')
                    {
                        $cek_tipe_byr_transfer='X';
                        $cek_tipe_byr_debit='';
                        $cek_tipe_byr_credit='';
                        $kartukredit= $data->TO_KARTU_KREDIT;
                        $cek_tipe_byr_cash='';
                        
                    }else if($res_tipe_bayar=='Debit')
                    {
                        $cek_tipe_byr_transfer='';
                        $cek_tipe_byr_debit='X';
                        $cek_tipe_byr_credit='';
                        $kartukredit= $data->TO_KARTU_KREDIT;
                        $cek_tipe_byr_cash='';
                        
                    }else if(trim($res_tipe_bayar)=='Kartu Kredit')
                    {
                        $cek_tipe_byr_transfer='';
                        $cek_tipe_byr_debit='';
                        $cek_tipe_byr_credit='X';
                        $kartukredit= $data->TO_KARTU_KREDIT;
                        $cek_tipe_byr_cash='';
                        
                    }
                    else if(trim($res_tipe_bayar)=='Cash')
                    {
                        $cek_tipe_byr_transfer='';
                        $cek_tipe_byr_debit='';
                        $cek_tipe_byr_credit='';
                        $cek_tipe_byr_cash='X';
                        $kartukredit= '';
                        
                    }
                    $pdf->SetFont('helvetica', '',7, '', true);
                    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'Pembayaran Uang Muka TO Toko melalui', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,$cek_tipe_byr_cash, 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 1, 'Cash' , 0, 'C', 0, 0, '', '', true);      
                    $pdf->MultiCell(4, 1,$cek_tipe_byr_transfer, 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 1, 'Transfer' , 0, 'C', 0, 0, '', '', true);      
                    $pdf->MultiCell(4, 1,$cek_tipe_byr_debit, 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(20, 1, 'Debit Card' , 0, 'C', 0, 0, '', '', true);   
                    $pdf->MultiCell(4, 1,$cek_tipe_byr_credit, 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(25, 1, 'Credit Card' , 0, 'C', 0, 0, '', '', true); 
                     $pdf->MultiCell(25, 1, ':' , 0, 'L', 0, 0, '', '', true);  
                    $pdf->MultiCell(25, 1, $kartukredit, 0, 'C', 0, 0, '', '', true);    
                    $counter++;

                    $res_tgl_bayar = explode("-", $data->TO_BAYAR_DATE);
                    $changedDate_tgl_bayar = $res_tgl_bayar[2]."-".$this->month_name(intval($res_tgl_bayar[1]))."-".$res_tgl_bayar[0];
                    $pdf->Ln();
                    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'Tanggal Pembayaran Uang Muka TO Toko', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,$changedDate_tgl_bayar, 0, 'L', 0, 0, '', '', true);
                    $counter++;


                    $pdf->Ln();

                    $pdf->MultiCell(3, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'Nilai Rp yang diswipe ', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(6, 1, 'Rp.' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,number_format($data->TO_AMOUNT_SWIPE, 2 , ',' , '.' ), 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'Nilai Rp yang masuk ke Rekening', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(6, 1, 'Rp.' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,number_format($data->TO_AMOUNT, 2 , ',' , '.' ), 0, 'L', 0, 0, '', '', true);
                 $pdf->AddPage('L','A5'); 
    $pdf->SetFont('helveticaB', '',14, '', true);
    $pdf->MultiCell(70, 1,'', 0, 'C', 0, 0, '', '', true);
   // $pdf->SetTextColor(194,8,8);

    $pdf->MultiCell(40, 1,'TANDA TERIMA', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Telah terima dari', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(60, 1,$data->NAMA, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Uang sejumlah', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaBI', '',12, '', true);
    $pdf->MultiCell(200, 1,$this->terbilang($data->TO_AMOUNT_SWIPE).' rupiah', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',12, '', true);
    $pdf->MultiCell(40, 1,'Pembayaran via', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(4, 1,':', 0, 'L', 0, 0, '', '', true);
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(60, 1,$data->TO_TIPE_BAYAR.'  '.$data->TO_KARTU_KREDIT, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helveticaB', '',12, '', true);
    $pdf->MultiCell(220, 1,'Untuk pembayaran uang muka take over toko dengan nomor : '.$form_num.'.', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();

     $pdf->MultiCell(60, 1,'Rp.'.number_format($data->TO_AMOUNT_SWIPE).',-', 0, 'L', 0, 0, '', '', true);
     $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('helvetica', '',8, '', true);
    $pdf->MultiCell(60, 1,$data->BRANCH_NAME.','.$changedDate_tgl_bayar, 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->MultiCell(60, 1,'Yang Menerima,', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(80, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'Yang Menyerahkan,', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->MultiCell(60, 1,'.......................................', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(80, 1,'', 0, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(60, 1,'.......................................', 0, 'L', 0, 0, '', '', true);
    $pdf->Ln();

    
                    ob_end_clean();
                    $namanya_file='FORMULIR TAKE OVER TOKO'.'-'.$form_id.'.pdf';
                   // $path = 'C:/xampp/htdocs/ULOK/uploads/bkt_trf/';
                     $pdf->Output($_SERVER['DOCUMENT_ROOT'].'ULOK/uploads/bkt_trf/' . $namanya_file, 'FI');
                    

    }


    public function print_listing_status_to_calon_franchisee($cabang,$periode){
            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('username');
            date_default_timezone_set('Asia/Jakarta');
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
            $pdf->SetTitle('LISTING STATUS TO CALON FRANCHISEE');
            $header = 'LISTING STATUS TO CALON FRANCHISEE';
            $pdf->SetSubject('');
            $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(5, 20, 5);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('helveticaB', '', 20, '', true);
            $pdf->AddPage('L','A4');            
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);
             $data_cabang=$this->M_Ulok->get_branch_name_code($cabang);
            // set cell margins
        
              $counter = 0;
                    $pdf->Ln();

                    $pdf->SetFont('helveticaB', '', 12, '', true);
                    $pdf->MultiCell(90, 2,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(102, 2, $header , 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(28, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 2, 'Tgl Cetak' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->setCellHeightRatio(2);
                    $counter++;
                    $pdf->SetFont('helveticaB', '',7, '', true);
                    $res_periode = explode("-", $periode);
                    $pdf->MultiCell(110, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Kode - Nama Cabang', 0, 'L', 0, 0, '', '', true);
                     $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                     $pdf->MultiCell(40, 2,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);

                       $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(26, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 2, 'User        ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2, $username , 0, 'L', 0, 0, '', '', true);
     
                    $counter++;
                    $pdf->Ln();
                      $pdf->SetFont('helveticaB', '',7, '', true);
                    $res_periode = explode("-", $periode);

                    $pdf->MultiCell(110, 2, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 2,'Periode Pengajuan', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2,$this->month_name(intval($res_periode[0])).'-'.$res_periode[1], 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(49, 2, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',6, '', true);
                    $pdf->MultiCell(19, 2,'Pukul Cetak', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 2,':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 2,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                    $counter++;
                    $pdf->Ln();
                    $counter++; 
                    $pdf->setCellHeightRatio(1);

              
                    $data=$this->M_Ulok->get_data_listing_status_to($cabang,$periode);
                   
                    $pdf->SetFont('helveticaB', '', 8, '', true);
                     $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(10, 1, 'No', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 1, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 1, 'Tanggal Transfer' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(40, 1, 'No Form Pengajuan TO' , 1, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1, 'Status TO yg sdh dkonfirm' , 1, 'C', 0, 0, '', '', true);
                  
                    $pdf->Ln();
                    $counter++;
                      
                    $no=1;
                       $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(180, 1,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
                      $pdf->Ln();
                   /* echo '<pre>';
                    print_r ($data);
                    echo '</pre>'; */
                     foreach ($data as $list_status_to) 
                    { 
                        
                            $res_periode = explode("-", $list_status_to->TO_BAYAR_DATE);
                               $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '', 7, '', true);
                            $pdf->MultiCell(10, 1, $no, 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1,$list_status_to->NAMA, 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1,$res_periode[2].' '.$this->month_name(intval($res_periode[1])).' '.$res_periode[0] , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1,$list_status_to->TO_FORM_NUM , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(50, 1,$list_status_to->STATUS_ULOK, 1, 'C', 0, 0, '', '', true);
                            $pdf->Ln();
                            
                           

                        if ($no++ % 33 == 0 ) 
                        {
                                   
                                   
                            $pdf->AddPage('L','A4');
                           
                            $pdf->SetFont('helveticaB', '', 7, '', true);

                              $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(10, 1, 'No', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1, 'Nama Calon Franchisee', 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1, 'Tanggal Transfer' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(40, 1, 'No Form Pengajuan TO' , 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(50, 1, 'Status TO yg sdh dkonfirm' , 1, 'C', 0, 0, '', '', true); 
                            $pdf->Ln(); 
                               $pdf->MultiCell(50, 1, '', 0, 'C', 0, 0, '', '', true); 
                            $pdf->MultiCell(180, 1,$data_cabang->BRANCH_CODE.'-'.' '. $data_cabang->BRANCH_NAME, 1, 'L', 0, 0, '', '', true);
                            $pdf->Ln();
                            $counter++;

                        }
                    }
              

                    $counter++;
                    ob_end_clean();
                    $namanya_file='Listing Status TO Calon Franchisee'.'-'.date('YmdHi').'.pdf';
                    $pdf->Output($namanya_file, 'I');
    }


    //end inquiry to

    //generate_lstf
public function generate_lstf()
    {
        
        $data['role_id'] = $this->session->userdata('role_id');
        $data['branch_id']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_generate_lstf', $data);

    }

     public function count_listing_status_to()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_listing_status_to($data['cabang'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }

    //end generate_lstf


    //generate_lmdo
public function generate_lmdo()
    {

        $data['role_id'] = $this->session->userdata('role_id');
        $data['branch_id']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_generate_lmdo', $data);

    }

    //end generate lmdo


    //generate lsuf
public function generate_lsuf()
    {

        $data['role_id'] = $this->session->userdata('role_id');
        $data['branch_id']=$this->session->userdata('branch_id');
        $this->load->view('Ulok/V_generate_lsuf', $data);

    }


     public function count_listing_status_ulok()
    {
        $data = $this->input->post();
        $rs = $this->M_Ulok->count_listing_status_ulok($data['cabang'],$data['periode']);
        $result = $rs->hitung;
        echo $result;
    }

    //end lsuf
//start sampah
    public function report()
    {
        $data = '';
        $this->load->view('Ulok/V_Report', $data);

    }

    public function sendMailLocation($ref_num,$otp,$inactive_date,$tipe_form) {
        
        $nama = $this->session->userdata('username');
        $email = $this->M_Ulok->getEmailOTPApp($nama);
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => '192.168.2.240',
            'smtp_port' => 25,
            'smtp_keepalive' => true,
            'smtp_user' => 'support6',
            'smtp_pass' => 'password',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('support6@indomaret.co.id', 'IT Support SD 6');
        $this->email->to($email);
        $this->email->subject('Validasi'.'  '.$tipe_form);
        
        $body = "Email ini dikirim kan kepada :<STRONG> ".$nama."</STRONG>, jika anda bukan yang dituju, maka abaikan email berikut.<br><br>
            Berikut adalah data OTP yang dapat anda gunakan untuk 1 (satu) kali transaksi pada program ULOK :
            <br>
            <table border='0' align='center' width='100%' style='font-size:13px;font-family:Arial, Helvetica, sans-serif;'>
                <tr>
                    <td width='15%'><STRONG>Ref. Num</STRONG></td>
                    <td width='1%'><STRONG>:</STRONG></td>
                    <td><STRONG>".$ref_num."</STRONG></td>
                    
                </tr>
                <tr>
                    <td width='15%'><STRONG>OTP. Num</STRONG></td>
                    <td width='1%'><STRONG>:</STRONG></td>
                      <td><STRONG>".$otp."</STRONG></td>
                    
                </tr>
                <tr>
                    <td width='15%'><STRONG>Berlaku Hingga</STRONG></td>
                    <td width='1%'><STRONG>:</STRONG></td>
                     <td><STRONG>".$inactive_date."</STRONG></td>
                  
                </tr>
            </table>
                <br>Atas perhatiannya kami ucapkan terimakasih.
                <br><br><br>
                Supported by IT Support SD6<br>
                PT.Indomarco Prismatama<br>
                Phone: 021-6909400 Ext (306,316)<br>
        ";
        
        $this->email->message($body);
        $this->email->send();
       // echo $this->email->print_debugger();
    }
   
  
    

     public function print_form_bapp($bapp_id)
    {

       

            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $username=$this->session->userdata('user_id');
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('user_id'));
          //  $pdf->SetTitle('FORMULIR PENGAJUAN USULAN TOKO');
            $header = 'BERITA ACARA PENGAKUAN PENDAPATAN';
            $header1 = 'Usulan Lokasi/Take Over';
            $header2 = 'PT.INDOMARCO PRISMATAMA';
            $pdf->SetSubject('');
            $pdf->SetHeaderData('1001.png', PDF_HEADER_LOGO_WIDTH,'PT. INDOMARCO PRISMATAMA','');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(5,20,5);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 0);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
              require_once(dirname(__FILE__).'/lang/eng.php');
              $pdf->setLanguageArray($l);
            }
            $pdf->setFontSubsetting(true);
            $pdf->AddPage('L','A5');            
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->setCellHeightRatio(0.7);
            // set cell margins
            $pdf->setCellMargins(0, 0, 0, 0);
               $pdf->SetFont('helveticaB', '', 12, '', true);
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(20, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(160, 1, $header , 0, 'C', 0, 0, '', '', true);
/*
                    $pdf->SetFont('helvetica', '', 6, '', true);
                    $pdf->MultiCell(20, 1, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 1, 'Tgl Akses ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1, date('d-m-Y') , 0, 'L', 0, 0, '', '', true);
*/
              
                    $data=$this->M_Ulok->getDataBapp($bapp_id);
                     $pdf->Ln();
               
                    $pdf->SetFont('helveticaB', '', 8, '', true);
                    $pdf->MultiCell(50, 1,'', 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(60, 1,$data->BAPP_FORM_NUM, 0, 'R', 0, 0, '', '', true);
                   
                    $pdf->SetFont('helvetica', '', 6, '', true);

                    /*$pdf->MultiCell(25, 1,' ', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(25, 1,'Pukul Akses ', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1,':' , 0, 'R', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1,date('H:i:s') , 0, 'L', 0, 0, '', '', true);
            
                    
                    $pdf->Ln();
                    $pdf->MultiCell(160, 1, '' , 0, 'R', 0, 0, '', '', true);
                    $pdf->MultiCell(19, 1, 'User ID ' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(17, 1, $username , 0, 'L', 0, 0, '', '', true);
                  */
              
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->SetFont('helvetica', '',8, '', true);
                    $pdf->MultiCell(20, 1,'Pada tanggal', 0, 'L', 0, 0, '', '', true);
                    $periode_res = explode("-", $data->TGL_BAPP);
                    $res_day=$periode_res[2];
                    $res_year=$periode_res[0]  ;
                    $pdf->MultiCell(17, 1,$res_day.'-'.$periode_res[1].'-'.$res_year , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1,'yang bertanda tangan di bawah ini ', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);

              


                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(20, 1,'Nama', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(70, 1, $data->NAMA , 0, 'L', 0, 0, '', '', true);
                

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(20, 1,'Jabatan', 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(4, 1, ':' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(70, 1, 'Franchise Manager Cabang' , 0, 'L', 0, 0, '', '', true);


                    
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->MultiCell(110, 1,'Menyatakan bahwa formulir pengajuan ULOK/TO dari calon franchisee dengan nomor ', 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helveticaB', '',8, '', true);

                    $pdf->MultiCell(37, 1,$data->FORM_NUM, 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',8, '', true);
                
                    $pdf->MultiCell(100, 1,' tidak dapat diproses dikarenakan pihak', 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();
                
                    $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(26, 1,'calon Franchisee ', 0, 'L', 0, 0, '', '', true);
                    $pdf->SetFont('helvetica', '',8, '', true);
                    $pdf->MultiCell(150, 1,'tidak bersedia melanjutkan pembukaan toko franchise Indomaret.', 0, 'L', 0, 0, '', '', true);
           
                   
                                $pdf->Ln();
                    $pdf->MultiCell(220, 1,'Maka dengan ini terdapat pengakuan pendapatan atas uang muka ULOK/TO', 0, 'L', 0, 0, '', '', true);
                        $pdf->Ln();    
                    $pdf->MultiCell(15, 1,' sebesar :', 0, 'L', 0, 0, '', '', true);
             
                  
                        $pdf->SetFont('helveticaB', '',8, '', true);
                    $pdf->MultiCell(27, 1,'Rp.'.number_format($data->AMOUNT_SWIPE).',-' , 0, 'L', 0, 0, '', '', true);
          
                     $pdf->SetFont('helveticaBI', '',8, '', true);
                    $pdf->MultiCell(100, 1,'(Terbilang : '.$this->terbilang($data->AMOUNT_SWIPE) .' rupiah )', 0, 'L', 0, 0, '', '', true);
                    
                    $pdf->SetFont('helvetica', '',8, '', true);

                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                     $pdf->Ln();
                    $pdf->MultiCell(90, 1, 'Mengetahui,' , 0, 'L', 0, 0, '', '', true);
                    $pdf->MultiCell(170, 1, 'Dibuat,' , 0, 'L', 0, 0, '', '', true);
                    $pdf->Ln();


                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();

                    $pdf->MultiCell(70, 1, '(.....................................)' , 0, 'L', 0, 0, '', '', true);
                    //$pdf->MultiCell(50, 1, '(.................................)' , 0, 'C', 0, 0, '', '', true);
                      $pdf->MultiCell(10, 1, '' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1, '(.................................)' , 0, 'C', 0, 0, '', '', true);
                    $pdf->Ln();
                    $pdf->MultiCell(70, 1, 'BM/DBM INDOMARET CABANG  '.$data->BRANCH_NAME, 0, 'L', 0, 0, '', '', true);
                      $pdf->MultiCell(10, 1, '' , 0, 'C', 0, 0, '', '', true);
                  //  $pdf->MultiCell(50, 1, 'Franchise Development Sr.Mgr' , 0, 'C', 0, 0, '', '', true);
                    $pdf->MultiCell(50, 1, 'Franchise Mgr. Cabang' , 0, 'C', 0, 0, '', '', true);

                 
                    ob_end_clean();
                    $namanya_file='FORMULIR PENGAJUAN USULAN TOKO'.'-'.date('YmdHi').'.pdf';
                    $pdf->Output($namanya_file, 'I');
    }

    public function upload_multiple_files()
    {
        $this->load->helper('form');
        $data['title'] = 'Multiple file upload';

        if ($this->input->post()) {
            $config = array(
                'upload_path' => './upload/',
                'allowed_types' => 'gif|jpg|png',
                'max_size' => '2048'
            );

            // load Upload library
            $this->load->library('upload', $config);

            $this->upload->do_upload('uploadedimages');

            echo '<pre>';
            $uploaded = $this->upload->data();
            print_r($uploaded);
            echo '</pre>';
            echo '<hr />';
            echo '<pre>';
            print_r($this->upload->display_errors());
            echo '</pre>';
            exit();
        }
        $this->load->view('upload_form', $data);
    }
    
//end sampah


}

/* End of file Ulok.php */
/* Location: ./application/controllers/Ulok.php */