<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.js"></script>
<style type="text/css">
    .textbox-readonly .textbox-text{
        background: #DEDEDE;
    }
  
    .floatedLeft {
            float:left;
    }
</style>
<div>
	<h2>Input Take Over Toko</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<form id="form-input-to-toko" class="easyui-form" data-options="novalidate:true" action="<?php echo base_url(); ?>Ulok/save_data_form_to_toko/" method="post" enctype="multipart/form-data" style="display: none;width:100%;">
    <div id="wizard-to">
    	<h2>Data Diri</h2>
        <section>
            <table>
                <tr>
                    <td style="min-width:150px;"></td>
                    <td>
                        <input type="hidden" id="f-form-to-no" name="f-form-to-no" value="<?php echo @$session_id; ?>">
                        <input type="hidden" name="f-form-to-id" value="">
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Tanggal Form</td>
                    <td>
                        <input type="text" id="f-tgl-to-form" name="f-tgl-to-form" class="easyui-datebox" data-options="required:true" style="width:200px;" value="<?php echo "".date("d-m-Y"); ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">No KTP</td>
                    <td>
                        <input type="text" id="f-noktp-to" name="f-noktp-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Nama Lengkap</td>
                    <td>
                        <input type="text" id="f-nama-lengkap-to" name="f-nama-lengkap-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                 
                </tr>
                <tr>
                    <td style="min-width:150px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="f-alamat-lengkap-to" name="f-alamat-lengkap-to" class="easyui-textbox" data-options="required:true,multiline:true" style="width:200px; height:60px"></input>
                    </td>
                       <td style="min-width:150px;"></td>
                     <td style="min-width:150px;">RT/RW</td>
                    <td>
                        <input type="text" id="f-rt-rw-to" name="f-rt-rw-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
           
                </tr>
                <tr>
                    <td style="min-width:150px;">Provinsi</td>
                    <td>
                          <input type="text" id="f-provinsi-to" name="f-provinsi-to" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                  <td style="min-width:150px;">Kodya / Kab.</td>
                    <td>
                         <input type="text" id="f-kodya-to" name="f-kodya-to" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                   
                  
                </tr>
                
                <tr>
                     <td style="min-width:150px;">Kecamatan</td>
                    <td>
                         <input type="text" id="f-kecamatan-to" name="f-kecamatan-to" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td> 
                    <td style="min-width:150px;">Kelurahan</td>
                    <td>
                         <input type="text" id="f-kelurahan-to" name="f-kelurahan-to" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                    </td>             
                </tr>
                <tr>
                   
                    <td style="min-width:150px;">Kode Pos</td>
                    <td>
                          <input type="text" id="f-kode-pos-to" name="f-kode-pos-to" class="easyui-combobox" data-options="panelHeight:'auto',valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>
                             <td style="min-width:150px;"></td>
                                <td style="min-width:150px;">Email</td>
                    <td>
                        <input type="email" id="f-email-to" name="f-email-to" class="easyui-textbox" data-options="required:true,validType:'email'" style="width:200px;"></input>
                    </td>
                </tr>

                <tr>
                 <td style="min-width:150px;">NPWP</td>
                    <td>
                        <input type="text" id="f-npwp-to" name="f-npwp-to" class="easyui-textbox" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Telp / No HP</td>
                    <td>
                        <input type="text" id="f-telp-to" name="f-telp-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                   
                </tr>
         
                <tr>   
                    <td colspan="2"><span id='message' style="color:red;font-size:9px"></span></td>
               </tr>
               <tr>
                    <td colspan="2"  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
               </tr>
            </table>
        </section>

        <h2>Detail Lokasi</h2>
        <section>
            <table>
                <tr>
                   <td>
                       <!-- <a href="" id="isi-otomatis-to-2" class="easyui-linkbutton" data-options="iconCls:'icon-ess-edit'" style="width:100px;">Isi Otomatis</a>-->
                     
                    </td>
                </tr>
                 <tr>
                    <td style="min-width:150px;">Kode Toko</td>
                    <td>
                        <input type="text" id="l-kode-toko-to" name="l-kode-toko-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Nama Toko</td>
                    <td>
                         <input type="text" id="l-nama-toko-to" name="l-nama-toko-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
          
                <tr>
                    <td style="min-width:150px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="l-alamat-to" name="l-alamat-to" class="easyui-textbox" data-options="multiline:true" style="width:200px; height:60px"></input>
                    </td>  
                     <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">RT/RW</td>
                    <td>
                        <input type="text" id="l-rt-rw-to" name="l-rt-rw-to" class="easyui-textbox" style="width:200px;"></input>
                    </td>
                </tr>
                    <tr>
                    <td style="min-width:150px;">Provinsi</td>
                    <td>
                          <input type="text" id="l-provinsi-to" name="l-provinsi-to" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                  <td style="min-width:150px;">Kodya / Kab.</td>
                    <td>
                         <input type="text" id="l-kodya-to" name="l-kodya-to" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                   
                  
                </tr>
                
                <tr>
                     <td style="min-width:150px;">Kecamatan</td>
                    <td>
                         <input type="text" id="l-kecamatan-to" name="l-kecamatan-to" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td> 
                    <td style="min-width:150px;">Kelurahan</td>
                    <td>
                         <input type="text" id="l-kelurahan-to" name="l-kelurahan-to" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                    </td>             
                </tr>
                <tr>
                   
                    <td style="min-width:150px;">Kode Pos</td>
                    <td>
                          <input type="text" id="l-kode-pos-to" name="l-kode-pos-to" class="easyui-combobox" data-options="panelHeight:'auto',valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>
                            
                </tr>


                  <tr style="height :10px;">
                   <td><hr></td>
                   <td><hr></td>
                   <td><hr></td>
                   <td><hr></td>
                   <td><hr></td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Investasi:</td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Actual Investment</td>
                    <td>
                        
                        <input type="text" id="l-actual-investment-to" name="l-actual-investment-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>

                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Total</td>
                    <td>
                        <input type="text" id="l-total-to" name="l-total-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" readonly="true" style="width:200px;"></input>

                    </td>
                    
                </tr>
                <tr>
                    <td style="min-width:150px;">PPN</td>
                    <td>
                        <input type="text" id="l-ppn-to" name="l-ppn-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>

                    </td>
                    <td style="min-width:150px;"></td>
                    
                   
                    
                </tr>
                <tr>
                     <td style="min-width:150px;">Goodwill</td>
                    <td>
                        <input type="text" id="l-goodwill-to" name="l-goodwill-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                    
                </tr>
                <tr>
                   
                    <td colspan="2"><span id='message2' style="color:red;font-size:9px"></span></td>
               </tr>
                <tr>
                    <td colspan="2"  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
               </tr>
            </table>
        </section>

        <h2>Pembayaran</h2>
        <section>
            <table  class="floatedLeft">
               
                <tr>
                    <td style="min-width:150px;">Tipe Pembayaran</td>
                    <td>
                        <select id="b-tipe-to" class="easyui-combobox" name="b-tipe-to" data-options="required:'true',panelHeight:'auto'" style="width:120px;">
                            <option value=""></option>
                            <option value="Cash">Cash</option>
                             <option value="Debit">Debit</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                             <option value="Transfer">Transfer</option>
                        </select>
                        <input type="text" id="b-kredit-to" name="b-kredit-to" class="easyui-textbox"style="width:80px;"></input>
                    </td>
                </tr>
                 <tr>
                    <td style="min-width:150px;">Nama Rekening Pengirim</td>
                    <td>
                        <input type="text" id="b-narek-to-pengirim" name="b-narek-to-pengirim" class="easyui-textbox"  style="width:200px;"></input>
                    </td>
                </tr>
                
                <tr>
                    <br>
                    <br>
                    <td style="min-width:150px;font-size:12px;"><b>*Data Rekening Bank Calon Franchisee</b></td>
                    
                </tr>
                <tr>
                    <td style="min-width:150px;">Bank</td>
                    <td>
                        <input type="text" id="b-bank-to" name="b-bank-to" class="easyui-combobox" data-options="required:true,valueField:'BANK_ID',textField:'BANK_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_bank_all/',panelHeight:'auto'" style="width:200px;" />
                    </td>
                    <td style="min-width:150px;"></td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Cabang</td>
                    <td>
                        <input type="text" id="b-cabang-bank-to" name="b-cabang-bank-to" class="easyui-textbox" data-options="required:true" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">No Rekening</td>
                    <td>
                        <input type="text" id="b-norek-to" name="b-norek-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nama Rekening</td>
                    <td>
                        <input type="text" id="b-narek-to" name="b-narek-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                   <td><hr></td>
                   <td><hr></td>
               </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang diswipe</td>
                    <td>
                        <input type="text" id="b-jumlah-swipe-to" name="b-jumlah-swipe-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang masuk ke rekening</td>
                    <td>
                        <input type="text" id="b-jumlah-masukrek-to" name="b-jumlah-masukrek-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Tanggal Pembayaran</td>
                    <td>
                        <input type="text" id="b-tgl-to" name="b-tgl-to" class="easyui-datebox" data-options="required:true" style="width:200px;" value="<?php echo "".date("d-m-Y"); ?>"></input>
                    </td>
                </tr>
              
                <tr>
                    <td style="min-width:150px;">Bukti Transfer</td>
                    <td>
                       <!--  <input id="b-bukti-trf-to" name="b-bukti-trf-to" class="easyui-filebox" data-options="required:true" style="width:200px"> -->
                       <input type="file"  name="filesToUploadTo" id="filesToUploadTo" size="20" style="width:200px;font-size: 10px"  accept=".pdf,.jpg,.jpeg,.png,.gif" />
                    </td>        
                </tr>
                <tr>
                    <td>  <input type="text" id="cek_file_to" name="cek_file_to" style="display: none"></input>
                    </td>
                    <td> <input type="text" id="inserted_to_id" name="inserted_to_id" style="display: none"></input></td>
                     <td> <input type="text" id="to_file_amount" name="to_file_amount" style="display: none"></input>
                    </td>
                    <div id="div_hidden_to"> 
                                   <input type="text"  class="easyui-textbox" id="form-num-to" name="form-num-to"  style="display: none" ></input>


                        </div>
                </tr>
                <tr>
                   
                    <td colspan="2"><span id='message3' style="color:red;font-size:9px"></span></td>
                </tr>
                 <tr>
                        <td>
                            <ul style="color:blue;font-size:11px">Ketentuan:
                                <li style="color:red;font-size:9px">Maks file upload : 5 file, Ukuran maks : 3MB</li>
                                <li style="color:red;font-size:9px">Nama file diharapkan tidak identik</li>
                                <li style="color:red;font-size:9px">Format yg diijinkan : pdf,jpg,jpeg,png</li>
                            </ul>
                        </td>
                </tr>
             
            </table>
             <table>
                <tr>
                        <td style="width: 100px"></td>
                        <td>List Upload File</td>
                </tr>
                <tr>
                        <td colspan="3">
                            <ul id="tofileList"><li>No Files Selected</li></ul>

                         </td>
                    </tr>
            </table>
        </section>
    </div>
</form>
<script type="text/javascript">
    
$(document).ready(function() {


               
                $("#form-input-to-toko").show();
       
                $('#div_hidden_to').hide();

                //input ulok


$("#wizard-to").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    labels: {
        finish: "Submit"
    },
    onStepChanging: function(event, currentIndex, newIndex) {
        if (newIndex < currentIndex) {
            return true;
        }
        if (currentIndex == '0') {
            var tgl_form = $("#f-tgl-to-form").datebox('getValue');
            var noktp = $("#f-noktp-to").textbox('getValue');
            var noktp_length=($("#f-noktp-to").textbox('getValue')).length;
            var nama = $("#f-nama-lengkap-to").textbox('getValue');
            var alamat = $("#f-alamat-lengkap-to").textbox('getValue');
            var rtrw = $("#f-rt-rw-to").textbox('getValue').length;
            var kecamatan = $("#f-kecamatan-to").combobox('getValue');
            var kelurahan = $("#f-kelurahan-to").combobox('getValue');
            var kodya = $("#f-kodya-to").combobox('getValue');
            var kd_pos = $("#f-kode-pos-to").combobox('getValue');
            var provinsi = $("#f-provinsi-to").combobox('getValue');
            var email = $("#f-email-to").textbox('getValue');
            var npwp = $("#f-npwp-to").textbox('getValue');
            var npwp_length =($("#f-npwp-to").textbox('getValue')).length;
            var telp = $("#f-telp-to").textbox('getValue');
            var telp_length = ($("#f-telp-to").textbox('getValue')).length;

            if ((npwp_length == 0 || npwp_length ==15) && tgl_form != '' && noktp != '' && noktp_length == 16 && nama != '' && alamat != '' && rtrw == 7 && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != "" && provinsi != "" && validatePhone(telp) && telp_length <= 15 && isEmail(email)) {
                return true;
            } else {
                if (rtrw != 7) {

                    $('#message').html('Error : RT RW  wajib  7 karakter');
                }else if (!validatePhone(telp)) {
                    $('#message').html('Error : Telp tidak valid');
                }else if (!isEmail(email)) {
                    $('#message').html('Error : Email tidak valid');
                }else if (telp_length > 15) {
                    $('#message').html('Error : Telp tidak valid,maks 15 digit');
                }else if(noktp_length !=16){
                    $('#message').html('Error : No KTP wajib 16 digit');
                }else if(npwp_length !=0 && npwp_length != 15){
                    $('#message').html('Error : NPWP wajib 15 digit');
                }else{
                    $('#message').html('Error : Harap lengkapi data di Bagian Data Diri');
                }
                return false;
            }
        } else if (currentIndex == '1') {

            var kd_toko_lok = $("#l-kode-toko-to").textbox('getValue');
            var nm_toko_lok = $("#l-nama-toko-to").textbox('getValue');
            var alamat_lok = $("#l-alamat-to").textbox('getValue');
            var provinsi_lok = $('#l-provinsi-to').combobox('getValue');
            var kecamatan = $("#l-kecamatan-to").combobox('getValue');
            var kelurahan = $("#l-kelurahan-to").combobox('getValue');
            var kodya = $("#l-kodya-to").combobox('getValue');
            var kd_pos = $("#l-kode-pos-to").combobox('getValue');
            var rtrw_lok = $("#l-rt-rw-to").textbox('getValue').length;
            var actualinves = $("#l-actual-investment-to").numberbox('getValue');
            var ppn_lok = $("#l-ppn-to").textbox('getValue');
            var goodwill_lok = $("#l-goodwill-to").textbox('getValue');
            var total_lok = $("#l-total-to").textbox('getValue');
            if (((provinsi_lok != '' && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != '' && kd_toko_lok != '' && nm_toko_lok != '' && alamat_lok != '' && rtrw_lok == 7)||(kd_toko_lok != '' && nm_toko_lok != ''  && rtrw_lok == 0)) && actualinves > 0 && ppn_lok != '' && goodwill_lok != '' && total_lok != '') {
                return true;
            } else {
                if (rtrw_lok != 7 && provinsi_lok !='' && kecamatan !='' && kelurahan!='' && kodya !='' && kd_pos !='') {
                    $('#message2').html('Error : RT RW wajib 7 karakter');
                } else {
                    $('#message2').html('Error : Harap lengkapi data di bagian Detail Lokasi');
                }
                return false;
            }

        }

    },
    onFinishing: function(event, currentIndex) {
        if (currentIndex == '2') {
            var tipe_bayar = $("#b-tipe-to").combobox('getValue');
            var bank = $("#b-bank-to").combobox('getValue');
            var cbg_bank = $("#b-cabang-bank-to").textbox('getValue');
            var no_rek = $('#b-norek-to').textbox('getValue');
            var na_rek = $('#b-narek-to').textbox('getValue');
            var na_rek_pengirim = $('#b-narek-to-pengirim').textbox('getValue');
            var jml_swipe = $('#b-jumlah-swipe-to').numberbox('getValue');
            var jml_rek = $('#b-jumlah-masukrek-to').numberbox('getValue');
            var tgl_trsfr = $('#b-tgl-to').datebox('getValue');
            var kartukredit = $('#b-kredit-to').textbox('getValue');
            var jumlah_file = parseInt(document.getElementById('to_file_amount').value);
            if (jumlah_file != 0 && jumlah_file != '' && ((tipe_bayar != 'Cash' &&  na_rek_pengirim != '' && kartukredit != '' ) || (tipe_bayar == 'Cash' &&  na_rek_pengirim == '' && kartukredit == '' )) && bank != '' && cbg_bank != '' && no_rek != '' && na_rek != '' && jml_swipe >=3600000 && jml_rek != '' && tgl_trsfr != '') {
                return $('#form-input-to-toko').form('enableValidation').form('validate');
            } else {
                if (jml_swipe < 3600000) {
                      $('#message3').html('Error : Jumlah Nilai Rp yg diswipe min Rp.3.600.000,-');
                      return false;
                  } else {
                      $('#message3').html('Error : Lengkapi data terlebih dahulu di bagian Detail Pembayaran');
                      return false;
                  }
            }
        }

    },
    onFinished: function(event, currentIndex) {

        $.ajax({
            url: 'Ulok/get_running_num_to/',
            type: 'POST',
            async: false,
            data: {},
            success: function(msg) {

                $('#form-num-to').textbox('setValue', msg);
                submit_file_to();
                var is_finish = document.getElementById('cek_file_to').value;
                var form_id = replaceAll($('#form-num-to').textbox('getValue'), "/", "-");
                if (is_finish) {
                    $('#form-input-to-toko').form('submit', {
                        success: function(msg) {
                            if (msg != '') {
                                getAllFileListTo($('#form-num-to').textbox('getValue'));
                                $.messager.alert('Warning', 'Berhasil diinput , No Form Ulok Anda ' + $('#form-num-to').textbox('getValue'));
                                $('#content').panel('refresh');
                                window.open('Ulok/print_form_pengajuan_to_toko/' + form_id);
                            }

                        }
                    });





                } else {
                    return false;
                }


            }
        });

    }
});

                $("#f-kodya-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#f-kecamatan-to').combobox('select', '');
                                                                $('#f-kelurahan-to').combobox('select', '');
                                                                $('#f-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#f-kecamatan-to').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
                                                }

                                }
                });
                $("#l-kodya-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#l-kecamatan-to').combobox('select', '');
                                                                $('#l-kelurahan-to').combobox('select', '');
                                                                $('#l-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#l-kecamatan-to').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
                                                }

                                }
                });
                $("#f-provinsi-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#f-kodya-to').combobox('select', '');
                                                                $('#f-kecamatan-to').combobox('select', '');
                                                                $('#f-kelurahan-to').combobox('select', '');
                                                                $('#f-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#f-kodya-to').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
                                                }

                                }
                });

                $("#l-provinsi-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#l-kodya-to').combobox('select', '');
                                                                $('#l-kecamatan-to').combobox('select', '');
                                                                $('#l-kelurahan-to').combobox('select', '');
                                                                $('#l-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#l-kodya-to').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
                                                }

                                }
                });
                $("#f-kecamatan-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#f-kelurahan-to').combobox('select', '');
                                                                $('#f-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#f-kelurahan-to').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
                                                }

                                }
                });
                $("#l-kecamatan-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {
                                                                $('#l-kelurahan-to').combobox('select', '');
                                                                $('#l-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#l-kelurahan-to').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
                                                }

                                }
                });
                $("#f-kelurahan-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {

                                                                $('#f-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#f-kode-pos-to').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
                                                }

                                }
                });
                $("#l-kelurahan-to").combobox({
                                editable: true,
                                onChange: function(new_val, old_val) {
                                                if (new_val == '') {

                                                                $('#l-kode-pos-to').combobox('select', '');
                                                } else {

                                                                $('#l-kode-pos-to').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
                                                }

                                }
                });

      
                $('#filesToUploadTo').on('change', function(evt) {
                                var jumlah_file = parseInt(document.getElementById('to_file_amount').value);
                                var ukuran_file = $("#filesToUploadTo")[0].files[0].size;
                                var form_id = document.getElementById('inserted_to_id').value;
                                if (ukuran_file > 3000000) {
                                                $.messager.alert('Warning', 'File size must not be more than 3 MB.');
                                                $('#filesToUploadTo').val('');
                                }

                                if (this.files.length == 0) {

                                                $.messager.alert('Warning', 'Anda tidak memilih file  .');

                                }
                                if (jumlah_file == 5) {

                                                $.messager.alert('Warning', 'Maximum file upload : 5 file  .');

                                }

                                if (form_id == '') {
                                                document.getElementById('to_file_amount').value = '0';
                                                makeFileListTo();
                                                var form_num = document.getElementById('f-form-to-no').value;

                                                var fileSelect = document.getElementById('filesToUploadTo');
                                                var files = fileSelect.files;
                                                var formData = new FormData();
                                                var tipe_form = 'TO';
                                                for (var x = 0; x < files.length; x++) {
                                                                var file = files[x];
                                                                formData.append('filesToUploadTo', file, file.name);
                                                                $.ajax({
                                                                                url: 'Ulok/save_temp_file_to_by_session/' + form_num,
                                                                                type: 'POST',
                                                                                async: false,
                                                                                dataType: 'text',
                                                                                cache: false,
                                                                                contentType: false,
                                                                                processData: false,
                                                                                data: formData,
                                                                                success: function(msg) {
                                                                                                $.messager.alert('Warning', 'File berhasil diupload.');
                                                                                                
                                                                                }
                                                                });
                                                }

                                } else if (form_id != '') {
                                                alert("yiha,hub programer");

                                }


                });
                $("#b-tipe-to").combobox({
    editable: true,
    onChange: function(new_val, old_val) {
        if (new_val == 'Cash') {

            $('#b-kredit-to').textbox('readonly', true);
            $('#b-narek-to-pengirim').textbox('readonly', true);
            $('#b-kredit-to').textbox('setValue', '');
            $('#b-narek-to-pengirim').textbox('setValue', '');
        } else {
            $('#b-kredit-to').textbox('readonly', false);
            $('#b-narek-to-pengirim').textbox('readonly', false);
        }

    }
});
$('#f-tgl-to-form').datebox({
    formatter: function(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
    },
    parser: function(s) {
        if (!s) return new Date();
        var ss = s.split('-');
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(d, m - 1, y);
        } else {
            return new Date();
        }
    }
});
$('#b-tgl-to').datebox({
    formatter: function(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
    },
    parser: function(s) {
        if (!s) return new Date();
        var ss = s.split('-');
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(d, m - 1, y);
        } else {
            return new Date();
        }
    }
});
$('#l-actual-investment-to').numberbox({
    onChange: function(value) {
        var ppn = parseInt($('#l-ppn-to').numberbox('getValue'));
        var goodwill = parseInt($('#l-goodwill-to').numberbox('getValue'));
        var actualinves = 0;
        if (value) {

            var actualinves = value;
        }
        var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinves);
        $('#l-total-to').numberbox('setValue', total);
    }
});

$('#l-ppn-to').numberbox({
    onChange: function(value) {
        var ppn = value;
        var goodwill = parseInt($('#l-goodwill-to').numberbox('getValue'));
        var actualinves = 0;
        if (parseInt($('#l-actual-investment-to').numberbox('getValue')) > 0) {

            var actualinves = parseInt($('#l-actual-investment-to').numberbox('getValue'));
        }
        var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinves);
        $('#l-total-to').numberbox('setValue', total);
    }
});


$('#l-goodwill-to').numberbox({
    onChange: function(value) {
        var ppn = parseInt($('#l-ppn-to').numberbox('getValue'));
        var goodwill = parseInt($('#l-goodwill-to').numberbox('getValue'));
        var actualinves = 0;
        if (parseInt($('#l-actual-investment-to').numberbox('getValue')) > 0) {

            var actualinves = parseInt($('#l-actual-investment-to').numberbox('getValue'));
        }
        var total = parseInt(ppn) + parseInt(goodwill) + parseInt(actualinves);
        $('#l-total-to').numberbox('setValue', total);
    }
});



});
</script>