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
    .wizard > .content
{
    background: #eee;
    display: block;
    margin: 0.5em;
    
    overflow: hidden;
    position: relative;
    width: auto;

    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}
    
</style>

<div >
	<h2>Input Data Usulan Lokasi</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<form id="form-input-ulok" class="easyui-form" data-options="novalidate:true"method="post" action="<?php echo base_url(); ?>Ulok/save_data_form_ulok/" enctype="multipart/form-data" style="display: none;width:100%;height:100%">
    <div id="wizard" >
    	<h2>Data Diri</h2>
        <section data-step="0">
            <table>
               
                <tr>
                    <td style="min-width:150px;"></td>
                    <td>
                        <input type="hidden"  id="f-form-no" name="f-form-no" value="<?php echo @$session_id; ?>">
                        <input type="hidden" name="f-form-id" value="">
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Tanggal Form</td>
                    <td>
                        <input type="text" id="f-tgl-form" name="f-tgl-form" class="easyui-datebox" data-options="required:true" value="<?php echo "".date("d-m-Y"); ?>" style="width:200px;"></input>
                    </td>
                 
                </tr>
                
                <tr>
                    <td style="min-width:150px;">Sumber Ulok</td>
                    <td>
                        <select id="f-sumber-ulok" name="f-sumber-ulok" class="easyui-combobox" data-options="required:'true',panelHeight:'auto'" style="width:200px;" >   
                            <option value="Pameran">Pameran</option>
                            <option value="Website">Website</option>
                            <option value="Cabang">Cabang</option>
                            <option value="HO">HO</option>
                        </select>
                    </td>
                    <td style="min-width:150px;"></td>
                      <td style="min-width:150px;">NPWP</td>
                    <td>
                        <input type="text" id="f-npwp" name="f-npwp" class="easyui-textbox"  style="width:200px;"></input>
                    </td>
                   
                </tr>
                <tr>
                    <td style="min-width:150px;">No KTP</td>
                    <td>
                        <input type="text" id="f-noktp" name="f-noktp" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                      <td style="min-width:150px;">Nama Lengkap</td>
                    <td>
                        <input type="text" id="f-nama-lengkap" name="f-nama-lengkap" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    
                </tr>
               
                <tr>
                    <td style="min-width:150px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="f-alamat-lengkap" name="f-alamat-lengkap" class="easyui-textbox" data-options="required:true,multiline:true" style="width:200px; height:60px"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">RT/RW</td>
                    <td>
                        <input type="text" id="f-rt-rw" name="f-rt-rw" class="easyui-textbox" data-options="required:true" style="width:200px;" min="5"></input>
                    </td>

                   
                  
                   
                </tr>
                <tr>
                    <td style="min-width:150px;">Provinsi</td>
                    <td>
                          <input type="text" id="f-provinsi" name="f-provinsi" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Kodya/Kab</td>
                    <td>
                        <input type="text" id="f-kodya" name="f-kodya" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                      
                    </td>
                   
                  
                </tr>
                 <tr>
                   <td style="min-width:150px;">Kecamatan</td>
                    <td>

                        <input type="text" id="f-kecamatan" name="f-kecamatan" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                   <td style="min-width:150px;">Kelurahan</td>
                    <td>

                         <input type="text" id="f-kelurahan" name="f-kelurahan" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>

                    </td>
                   
                </tr>
                <tr>
                    <td style="min-width:150px;">Telp / No HP</td>
                    <td>
                        <input type="text" id="f-telp" name="f-telp" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Kode Pos</td>
                    <td>
                        <input type="text" id="f-kode-pos" name="f-kode-pos" class="easyui-combobox" data-options="panelHeight:'auto',valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>

                </tr>
                <tr>
                    <td style="min-width:150px;">Email</td>
                    <td>
                        <input type="email" id="f-email" name="f-email" class="easyui-textbox" data-options="required:true,validType:'email'" style="width:200px;"></input>
                    </td>
                </tr>
               
               <tr>
                   
                    <td colspan="2"><span id='message' style="color:red;font-size:9px"></span></td>
               </tr>
               <tr>
                 <td  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
               </tr>
               
            </table>
        </section>
        <h2>Detail Lokasi</h2>
        <section data-step="1">
            <table>
              
                <tr>
                    <td style="min-width:100px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="l-alamat" name="l-alamat" class="easyui-textbox" data-options="required:true,multiline:true" style="width:200px; height:50px"></input>
                    </td>
                    <td style="width:25px;"></td>
                    <td style="min-width:100px;">RT/RW</td>
                    <td>
                        <input type="text" id="l-rt-rw" name="l-rt-rw" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    
                </tr>
                <tr>
                    <td style="min-width:100px;">Provinsi</td>
                    <td>
                          <input type="text" id="l-provinsi" name="l-provinsi" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                         <td style="width: 25px"></td>
                     <td style="min-width:100px;">Kodya / Kab.</td>
                    <td>
                         <input type="text" id="l-kodya" name="l-kodya" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                    </td>
                
                  
                </tr>
                <tr>
                    <td style="min-width:100px;">Kecamatan</td>
                    <td>
                        <input type="text" id="l-kecamatan" name="l-kecamatan" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    </td>
                    <td style="width: 25px"></td>
                    <td style="min-width:100px;">Kelurahan</td>
                    <td>
                      <input type="text" id="l-kelurahan" name="l-kelurahan" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                   
                    <td style="min-width:100px;">Kode Pos</td>
                    <td>
                            <input type="text" id="l-kode-pos" name="l-kode-pos" class="easyui-combobox" data-options="panelHeight:'auto',valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>

                    
                    <td style="min-width:100px;">Bentuk Lokasi</td>
                    <td>
                        <select id="l-bentuk-lok" class="easyui-combobox" name="l-bentuk-lok" data-options="required:'true',panelHeight:'auto'" style="width:98px;">
                            <option value=""></option>
                            <option value="Tanah Kosong">Tanah Kosong</option>
                            <option value="Ruko">Ruko</option>
                            <option value="Ruang Usaha">Ruang Usaha</option>
                            <option value="Kios">Kios</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="l-bentuk-lok-lain" name="l-bentuk-lok-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                    </td>
                    <td style="min-width:50px;"></td>
                    <td style="min-width:100px;">Ukuran</td>
                    <td>
                        <input type="text" id="l-ukuran-panjang" name="l-ukuran-panjang" class="easyui-numberbox" style="width:91px;" data-options="required:true,prompt:'Meter'"></input>
                        x
                        <input type="text" id="l-ukuran-lebar" name="l-ukuran-lebar" class="easyui-numberbox" style="width:91px;" data-options="required:true,prompt:'Meter'"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:100px;">Jumlah Unit</td>
                    <td>
                        <input type="text" id="l-jumlah-unit" name="l-jumlah-unit" class="easyui-numberbox"  style="width:200px;" readonly="true"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:100px;">Jumlah Lantai</td>
                    <td>
                        <input type="text" id="l-jumlah-lantai" name="l-jumlah-lantai" class="easyui-numberbox" readonly="true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:100px;">Status Lokasi</td>
                    <td>
                        <select id="l-status-lokasi" class="easyui-combobox" name="l-status-lokasi" data-options="required:'true',panelHeight:'auto'" style="width:98px;">
                            <option value=""></option>
                            <option value="Milik Sendiri">Milik Sendiri</option>
                            <option value="Milik Keluarga">Milik Keluarga</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="l-status-lokasi-lain" name="l-status-lokasi-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                    </td>
                    <td style="min-width:100px;"></td>
                    <td style="min-width:100px;">Dokumen Kepemilikan</td>
                    <td>
                        <select id="l-dok-milik" class="easyui-combobox" name="l-dok-milik" data-options="required:'true',panelHeight:'auto'" style="width:98px;">
                            <option value=""></option>
                            <option value="SHM">SHM</option>
                            <option value="SHGB">SHGB</option>
                            <option value="SHSRS">SHSRS</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="l-dok-milik-lain" name="l-dok-milik-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:100px;">Lahan Parkir</td>
                    <td>
                        <select id="l-lahan-parkir" class="easyui-combobox" name="l-lahan-parkir" data-options="required:'true',panelHeight:'auto'" style="width:98px; display: inline;">
                            <option value=""></option>
                            <option value="Sendiri">Sendiri</option>
                            <option value="Bersama">Bersama</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="l-lahan-parkir-lain" name="l-lahan-parkir-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                    </td>
                    <td style="width: 25px"></td>
                    <td style="min-width:100px;">Denah/Foto Lokasi</td>
                    <td>
                        <select id="l-denah" class="easyui-combobox" name="l-denah" data-options="required:'true',panelHeight:'auto'" style="width:200px;">
                            <option value=""></option>
                            <option value="Melalui Email">Melalui Email</option>
                            <option value="Dikirim Langsung">Terlampir</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:100px;">Izin Bangunan</td>
                    <td>
                        <select id="l-izin-bangun" class="easyui-combobox" name="l-izin-bangun" data-options="required:'true',panelHeight:'auto'" style="width:200px;">
                            <option value=""></option>
                            <option value="IMB">IMB</option>
                            <option value="IPB">IPB</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </td>
                    <td style="min-width:100px;"></td>
                    <td style="min-width:100px;">Peruntukan Bangunan (sesuai IMB/IPB)</td>
                    <td>
                        <select id="l-izin-untuk" class="easyui-combobox" name="l-izin-untuk" data-options="required:'true',panelHeight:'auto'" style="width:98px;">
                            <option value=""></option>
                            <option value="Ruko">Ruko</option>
                            <option value="Ruang Usaha">Ruang Usaha</option>
                            <option value="Kios">Kios</option>
                            <option value="Rumah Tinggal">Rumah Tinggal</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" id="l-izin-untuk-lain" name="l-izin-untuk-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                    </td>
                </tr>
                  <tr>
                    <td style="min-width:100px;">Pasar Tradisional</td>
                    <td>
                        <select id="l-pasar" class="easyui-combobox" name="l-pasar" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                            <option value=""></option>
                            <option value="< 500 m">< 500 m</option>
                            <option value="> 500 m">> 500 m</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                        </select>
                        <input type="text" id="l-pasar-ada" name="l-pasar-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                    </td>
                    <td style="width: 25px"></td>
                    <td style="min-width:100px;">Minimarket</td>
                    <td>
                        <select id="l-minimarket" class="easyui-combobox" name="l-minimarket" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                            <option value=""></option>
                            <option value="< 500 m">< 500 m</option>
                            <option value="> 500 m">> 500 m</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                        </select>
                        <input type="text" id="l-minimarket-ada" name="l-minimarket-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                    </td>
                </tr>
                <tr>   
                    <td style="min-width:100px;">Indomaret Terdekat</td>
                    <td>
                        <select id="l-idm-dekat" class="easyui-combobox" name="l-idm-dekat" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                            <option value=""></option>
                            <option value="< 500 m">< 500 m</option>
                            <option value="> 500 m">> 500 m</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                        </select>
                        <input type="text" id="l-idm-dekat-ada" name="l-idm-dekat-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                    </td>  
                </tr>
                <tr>
                   
                    <td colspan="2"><span id='message2' style="color:red;font-size:9px"></span></td>
                </tr>
                <tr>
                    <td  colspan="2"style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
                   
               </tr>
            </table>
        </section>

        <h2>Pembayaran</h2>
        <section data-step="2">
            <table class="floatedLeft">
                <tr>
                    <td style="min-width:150px;">Tipe Pembayaran</td>
                    <td>
                        <select id="b-tipe" class="easyui-combobox" name="b-tipe" data-options="required:'true',panelHeight:'auto'" style="width:120px;">
                            <option value=""></option>
                            <option value="Cash">Cash</option>
                            <option value="Debit">Debit</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                            <option value="Transfer">Transfer</option>

                        </select>
                        <input type="text" id="b-kredit" name="b-kredit" class="easyui-textbox"  style="width:75px;"></input>
                    </td>
                </tr>
                 <tr>
                    <td style="min-width:150px;">Nama Rekening Pengirim</td>
                    <td>
                        <input type="text" id="b-narek-pengirim" name="b-narek-pengirim" class="easyui-textbox"  style="width:200px;"></input>
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
                        <input type="text" id="b-bank" name="b-bank" class="easyui-combobox" data-options="required:true,valueField:'BANK_ID',textField:'BANK_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_bank_all/',panelHeight:'auto'" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Cabang</td>
                    <td>
                        <input type="text" id="b-cabang-bank" name="b-cabang-bank" class="easyui-textbox" data-options="required:true" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">No Rekening</td>
                    <td>
                        <input type="text" id="b-norek" name="b-norek" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nama Rekening</td>
                    <td>
                        <input type="text" id="b-narek" name="b-narek" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr style="height :5px;">
                    <td><hr></td>
                    <td><hr></td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang diswipe</td>
                    <td>
                        <input type="text" id="b-jumlah-swipe" name="b-jumlah-swipe" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang masuk ke rekening</td>
                    <td>
                        <input type="text" id="b-jumlah-masukrek" name="b-jumlah-masukrek" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Tanggal Pembayaran</td>
                    <td>
                        <input type="text" id="b-tgl" name="b-tgl" class="easyui-datebox" data-options="required:true" style="width:200px;" value="<?php echo "".date("d-m-Y"); ?>"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Bukti Transfer</td>
                    <td>
                         <input type="file"  name="filesToUpload" id="filesToUpload" size="20" style="width:200px;font-size: 10px"  accept=".pdf,.jpg,.jpeg,.png,.gif" />
                          <input type="text" id="cek_file" name="cek_file" style="display: none" ></input>

                    </td>
                  
                    <td style="min-width:150px;"> </td>
                </tr>
                <tr>
                    <td>
                         <input type="text" id="inserted_id" name="inserted_id"  style="display: none"></input>
                
                    </td>
                    <td>
                     <!--    <input type="text" id="file_amount" name="file_amount" style="display: none"></input>-->
                     <input type="text" id="file_amount" name="file_amount" style="display: none" ></input>
                    </td>

                     <div id="div_hidden"> 
                                   <input type="text"  class="easyui-textbox" id="form-num" name="form-num"  style="display: none" ></input>


                        </div>
                </tr>
                <tr>
                        <td>
                            <ul style="color:blue;font-size:10px">Ketentuan:
                                <li style="color:red;font-size:9px">Maks file upload : 5 file,Ukuran file maks : 3 MB </li>
                                <li style="color:red;font-size:9px">Nama file diharapkan tidak identik</li>
                                <li style="color:red;font-size:9px">Format yg diijinkan : pdf,jpg,jpeg,png</li>
                                
                            </ul>
                        </td>
                </tr>
                <tr>
                   
                    <td colspan="2"><span id='message3' style="color:red;font-size:9px"></span></td>
                </tr>
        
            </table>
            
            <table>
                <tr>
                        <td style="width: 100px"></td>
                        <td>List Upload File</td>
                </tr>
                <tr>
                        <td colspan="3">
                            <ul id="fileList"><li>No Files Selected</li></ul>

                         </td>
                    </tr>
            </table>
        
        </section>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $("#form-input-ulok").show();
    $('#div_hidden').hide();
    $("#wizard").steps({
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

              var tgl_form = $("#f-tgl-form").datebox('getValue');
              var sumber_ulok = $("#f-sumber-ulok").combobox('getValue');
              var npwp = $("#f-npwp").textbox('getValue');
              var npwp_length=($("#f-npwp").textbox('getValue')).length;
              var noktp = $("#f-noktp").textbox('getValue');
              var noktp_length=($("#f-noktp").textbox('getValue')).length;
              var nama = $("#f-nama-lengkap").textbox('getValue');
              var alamat = $("#f-alamat-lengkap").textbox('getValue');
              var rtrw = ($("#f-rt-rw").textbox('getValue')).length;
              var kecamatan = $("#f-kecamatan").combobox('getValue');
              var kelurahan = $("#f-kelurahan").combobox('getValue');
              var kodya = $("#f-kodya").combobox('getValue');
              var kd_pos = $("#f-kode-pos").combobox('getValue');
              var telp = $("#f-telp").textbox('getValue');
              var telp_length = ($("#f-telp").textbox('getValue')).length;
              var email = $("#f-email").textbox('getValue');
              var provinsi = $("#f-provinsi").combobox('getValue');
              if ((npwp_length == 0 || npwp_length == 15 ) &&tgl_form != '' && sumber_ulok != '' && noktp != ''   && noktp_length == 16 && nama != '' && alamat != '' && rtrw == 7 && kecamatan != '' && kelurahan != '' && kodya != '' && kd_pos != '' && provinsi != '' && validatePhone(telp) && telp_length <= 15 && isEmail(email)) {

                  return true;
              } else {
                  if (!isEmail(email)) {
                    $('#message').html('Error : Email tidak valid');
                  }else if (!validatePhone(telp)) {
                    $('#message').html('Error : Telp tidak valid');
                  }else if (telp_length > 15) {
                    $('#message').html('Error : Telp tidak valid,maks 15 digit');
                  }else if (rtrw != 7) {
                    $('#message').html('Error : RT RW wajib 7 karakter');
                  }else if(noktp_length !=16){
                    $('#message').html('Error : No KTP wajib 16 digit');
                  }else if(npwp_length !=0 && npwp_length != 15){
                    $('#message').html('Error : NPWP wajib 15 digit');
                  }else {
                    $('#message').html('Error : Lengkapi data terlebih dahulu di bagian Data diri');
                  }
                  return false;
              }
          } else if (currentIndex == '1') {
              var alamat_lok = $("#l-alamat").textbox('getValue');
              var rtrw_lok = $("#l-rt-rw").textbox('getValue').length;
              var provinsi_lok = $('#l-provinsi').combobox('getValue');
              var kelurahan_lok = $("#l-kelurahan").combobox('getValue');
              var kecamatan_lok = $("#l-kecamatan").combobox('getValue');
              var kodya_lok = $("#l-kodya").combobox('getValue');
              var kd_pos_lok = $("#l-kode-pos").combobox('getValue');
              var bentuk_lok = $("#l-bentuk-lok").combobox('getValue');
              var bentuk_lok_lain = $("#l-bentuk-lok-lain").textbox('getValue');
              var panjang_lok = $("#l-ukuran-panjang").textbox('getValue');
              var lebar_lok = $("#l-ukuran-lebar").textbox('getValue');
              var status_lok = $("#l-status-lokasi").combobox('getValue');
              var dok_milik_lok = $("#l-dok-milik").combobox('getValue');
              var lahan_parkir_lok = $("#l-lahan-parkir").combobox('getValue');
              var izin_bangunan_lok = $("#l-izin-bangun").combobox('getValue');
              var pasar_lok = $("#l-pasar").combobox('getValue');
              var minimarket_lok = $("#l-minimarket").combobox('getValue');
              var denah_lok = $("#l-denah").combobox('getValue');
              var peruntuk_izin_lok = $('#l-izin-untuk').combobox('getValue');
              var ket_peruntuk_izin_lok = $('#l-izin-untuk-lain').textbox('getValue');
              var ket_status_lok = $('#l-status-lokasi-lain').textbox('getValue');
              var ket_lahan_parkir_lok = $("#l-lahan-parkir-lain").textbox('getValue');
              var ket_pasar_lok = $("#l-pasar-ada").textbox('getValue');
              var ket_minimarket_lok = $("#l-minimarket-ada").textbox('getValue');
              var ket_dok_milik_lok = $("#l-dok-milik-lain").textbox('getValue');
              var idm_lok = $("#l-idm-dekat").combobox('getValue');
              var ket_idm_lok = $('#l-idm-dekat-ada').textbox('getValue');
              var jml_unit = $("#l-jumlah-unit").textbox('getValue');
              var jml_lantai = $("#l-jumlah-lantai").textbox('getValue');
              if (alamat_lok != "" && rtrw_lok == 7 && kelurahan_lok != "" && provinsi_lok != "" && kecamatan_lok != "" && kodya_lok != "" && kd_pos_lok != "" && bentuk_lok != "" && panjang_lok != "" && lebar_lok != "" && status_lok != "" && dok_milik_lok != "" && lahan_parkir_lok != "" && izin_bangunan_lok != "" && pasar_lok != "" && minimarket_lok != "" && denah_lok != "" && peruntuk_izin_lok != "" && idm_lok != "") {
                  if (((bentuk_lok == 'Tanah Kosong') || (bentuk_lok == 'Lainnya' && bentuk_lok_lain != '' && (jml_unit != '' && jml_lantai != '')) || ((bentuk_lok != 'Tanah Kosong' && bentuk_lok != 'Lainnya') && (jml_unit != '' && jml_lantai != ''))) && ((status_lok != 'Lainnya') || (status_lok == 'Lainnya' && ket_status_lok != '')) &&
                      ((lahan_parkir_lok != 'Lainnya') || (lahan_parkir_lok == 'Lainnya' && ket_lahan_parkir_lok != '')) &&
                      ((pasar_lok == 'Tidak Ada' || pasar_lok =='Tidak Tahu') || (pasar_lok != 'Tidak Ada' && pasar_lok !='Tidak Tahu' && ket_pasar_lok != '')) &&
                      ((minimarket_lok == 'Tidak Ada' || minimarket_lok =='Tidak Tahu') || (minimarket_lok != 'Tidak Ada' && minimarket_lok !='Tidak Tahu' && ket_minimarket_lok != '')) &&
                      ((dok_milik_lok != 'Lainnya') || (dok_milik_lok == 'Lainnya' && ket_dok_milik_lok != '')) &&
                      ((idm_lok == 'Tidak Ada'  || idm_lok =='Tidak Tahu') || (idm_lok != 'Tidak Ada' && idm_lok !='Tidak Tahu' && ket_idm_lok != '')) &&
                      ((peruntuk_izin_lok != 'Lainnya') || (peruntuk_izin_lok == 'Lainnya' && ket_peruntuk_izin_lok != ''))
                  ) {


                      return true;
                  } else {
                      $('#message2').html('Error : Lengkapi data terlebih dahulu di bagian Detail Lokasi');
                      return false;
                  }
              } else {
                  if (rtrw_lok != 7) {
                      $('#message2').html('Error : RT/ RW  wajib 7 karakter');
                      return false;
                  } else {
                      $('#message2').html('Error : Lengkapi data terlebih dahulu di bagian Detail Lokasi');
                      return false;
                  }
              }
          }

      },
      onFinishing: function(event, currentIndex) {
          if (currentIndex == '2') {

              var tipe_bayar = $("#b-tipe").combobox('getValue');
              var bank = $("#b-bank").combobox('getValue');
              var kartukredit = $('#b-kredit').textbox('getValue');
              var cbg_bank = $("#b-cabang-bank").textbox('getValue');
              var no_rek = $('#b-norek').textbox('getValue');
              var na_rek = $('#b-narek').textbox('getValue');
              var ba_narek = $('#b-narek-pengirim').textbox('getValue');

              var jml_swipe = $('#b-jumlah-swipe').numberbox('getValue');
              var jml_rek = $('#b-jumlah-masukrek').numberbox('getValue');
              var tgl_trsfr = $('#b-tgl').datebox('getValue');
              var jumlah_file = parseInt(document.getElementById('file_amount').value);

              if ( jumlah_file != 0 && ((tipe_bayar != 'Cash' && kartukredit != '' && ba_narek != '')||(tipe_bayar == 'Cash' && kartukredit == '' && ba_narek == '')) && bank != '' && cbg_bank != '' && no_rek != '' && na_rek != '' && jml_swipe >=3600000 && jml_rek != '' && tgl_trsfr != '') {
                  return true;
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
              url: 'Ulok/get_running_num/',
              type: 'POST',
              async: false,
              success: function(msg) {
                  $('#form-num').textbox('setValue', msg);
                  submit_file_ulok();
                  var is_finish = document.getElementById('cek_file').value;
                  if (is_finish) {

                      $('#form-input-ulok').form('submit', {
                          success: function(msg) {
                              if (msg != '') {
                                  getAllFileListUlok($('#form-num').textbox('getValue'));
                                  $.messager.alert('Warning', 'Berhasil diinput , No Form Ulok Anda ' + $('#form-num').textbox('getValue'));

                                  var form_id = replaceAll($('#form-num').textbox('getValue'), "/", "-");
                                  $('#content').panel('refresh');                             
                                  window.open('Ulok/print_form_pengajuan_ulok/' + form_id);
                                              

                              } else {

                                  alert(msg);
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
$("#l-bentuk-lok").combobox({
     onChange: function(new_val, old_val) {
         $("#l-jumlah-unit").numberbox('setValue', '');
         $("#l-jumlah-lantai").numberbox('setValue', '');
         if (new_val == '' || new_val == 'Tanah Kosong') {
             $('#l-jumlah-unit').numberbox('readonly', true);
             $('#l-jumlah-lantai').numberbox('readonly', true);
             $('#l-bentuk-lok-lain').textbox('setValue', '');
             $('#l-bentuk-lok-lain').textbox('readonly', true);
         } else if (new_val == 'Lainnya') {

             $('#l-bentuk-lok-lain').textbox('readonly', false);
             $('#l-jumlah-unit').numberbox('readonly', false);
             $('#l-jumlah-lantai').numberbox('readonly', false);
         } else {
             $('#l-jumlah-unit').numberbox('readonly', false);
             $('#l-jumlah-lantai').numberbox('readonly', false);
             $('#l-bentuk-lok-lain').textbox('setValue', '');
             $('#l-bentuk-lok-lain').textbox('readonly', true);
         }
     }
 });

 $('#filesToUpload').on('change', function(evt) {
     var jumlah_file = parseInt(document.getElementById('file_amount').value);
     var ukuran_file = $("#filesToUpload")[0].files[0].size;
     var form_id = document.getElementById('inserted_id').value;
     if (ukuran_file > 3000000) {
         $.messager.alert('Warning', 'File size must not be more than 3 MB.');
         $('#filesToUpload').val('');
     }

     if (this.files.length == 0) {

         $.messager.alert('Warning', 'Anda tidak memilih file  .');

     }
     if (jumlah_file == 5) {

         $.messager.alert('Warning', 'Maximum file upload : 5 file  .');

     }

     if (form_id == '') {

         makeFileList();
         var form_num = document.getElementById('f-form-no').value;

         var fileSelect = document.getElementById('filesToUpload');
         var files = fileSelect.files;
         var formData = new FormData();
         var tipe_form = 'ULOK';
         for (var x = 0; x < files.length; x++) {
             var file = files[x];
             formData.append('filesToUpload', file, file.name);
             $.ajax({
                 url: 'Ulok/save_temp_file_ulok_by_session/' + form_num,
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
$("#f-provinsi").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#f-kodya').combobox('select', '');
             $('#f-kecamatan').combobox('select', '');
             $('#f-kelurahan').combobox('select', '');
             $('#f-kode-pos').combobox('select', '');
         } else {

             $('#f-kodya').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });
$("#b-tipe").combobox({
    editable: true,
    onChange: function(new_val, old_val) {
        if (new_val == 'Cash') {
            $('#b-kredit').textbox('readonly', true);
            $('#b-narek-pengirim').textbox('readonly', true);
            $('#b-kredit').textbox('setValue', '');
            $('#b-narek-pengirim').textbox('setValue', '');
        } else {
            $('#b-kredit').textbox('readonly', false);
            $('#b-narek-pengirim').textbox('readonly', false);
        }

    }
});
 $("#l-provinsi").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#l-kodya').combobox('select', '');
             $('#l-kecamatan').combobox('select', '');
             $('#l-kelurahan').combobox('select', '');
             $('#l-kode-pos').combobox('select', '');
         } else {

             $('#l-kodya').combobox('reload', 'Ulok/get_all_kab_name/' + new_val);
         }

     }
 });

$("#f-kodya").combobox({
       editable: true,
       onChange: function(new_val, old_val) {
           if (new_val == '') {
               $('#f-kecamatan').combobox('select', '');
               $('#f-kelurahan').combobox('select', '');
               $('#f-kode-pos').combobox('select', '');
           } else {

               $('#f-kecamatan').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
           }

       }
   });

 $("#l-kodya").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {
             $('#l-kecamatan').combobox('select', '');
             $('#l-kelurahan').combobox('select', '');
             $('#l-kode-pos').combobox('select', '');
         } else {

             $('#l-kecamatan').combobox('reload', 'Ulok/get_all_kec_name/' + new_val);
         }

     }
 });

$("#f-kecamatan").combobox({
       editable: true,
       onChange: function(new_val, old_val) {
           if (new_val == '') {
               $('#f-kelurahan').combobox('select', '');
               $('#f-kode-pos').combobox('select', '');
           } else {

               $('#f-kelurahan').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
           }

       }
   });

$("#l-kecamatan").combobox({
      editable: true,
      onChange: function(new_val, old_val) {
          if (new_val == '') {
              $('#l-kelurahan').combobox('select', '');
              $('#l-kode-pos').combobox('select', '');
          } else {

              $('#l-kelurahan').combobox('reload', 'Ulok/get_all_kel_name/' + new_val);
          }

      }
  });

 $("#f-kelurahan").combobox({
     editable: true,
     onChange: function(new_val, old_val) {
         if (new_val == '') {

             $('#f-kode-pos').combobox('select', '');
         } else {

             $('#f-kode-pos').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
         }

     }
 });

  $("#l-kelurahan").combobox({
      editable: true,
      onChange: function(new_val, old_val) {
          if (new_val == '') {

              $('#l-kode-pos').combobox('select', '');
          } else {

              $('#l-kode-pos').combobox('reload', 'Ulok/get_all_kdpos/' + new_val);
          }

      }
  });
  $("#l-lahan-parkir").combobox({
      onChange: function(new_val, old_val) {
          $("#l-lahan-parkir-lain").textbox('setValue', '');
          if (new_val == 'Lainnya') {
              $('#l-lahan-parkir-lain').textbox('readonly', false);
          } else {
              $('#l-lahan-parkir-lain').textbox('readonly', true);
          }
      }
  });


  $("#l-status-lokasi").combobox({
      onChange: function(new_val, old_val) {
          $("#l-status-lokasi-lain").textbox('setValue', '');
          if (new_val == 'Lainnya') {
              $('#l-status-lokasi-lain').textbox('readonly', false);
          } else {
              $('#l-status-lokasi-lain').textbox('readonly', true);
          }
      }
  });

  $("#l-dok-milik").combobox({
      onChange: function(new_val, old_val) {
          $("#l-dok-milik-lain").textbox('setValue', '');
          if (new_val == 'Lainnya') {
              $('#l-dok-milik-lain').textbox('readonly', false);
          } else {
              $('#l-dok-milik-lain').textbox('readonly', true);
          }
      }
  });



  $("#l-izin-untuk").combobox({
      onChange: function(new_val, old_val) {
          $("#l-izin-untuk-lain").textbox('setValue', '');
          if (new_val == 'Lainnya') {
              $('#l-izin-untuk-lain').textbox('readonly', false);
          } else {
              $('#l-izin-untuk-lain').textbox('readonly', true);
          }
      }
  });

  $("#l-idm-dekat").combobox({
      onChange: function(new_val, old_val) {
          $("#l-idm-dekat-ada").textbox('setValue', '');
          if (new_val == 'Tidak Ada' || new_val == 'Tidak Tahu') {
              $('#l-idm-dekat-ada').textbox('readonly', true);
          } else {
              $('#l-idm-dekat-ada').textbox('readonly', false);

          }
      }
  });

  $("#l-pasar").combobox({
      onChange: function(new_val, old_val) {
          $("#l-pasar-ada").textbox('setValue', '');
          if (new_val == 'Tidak Ada' || new_val == 'Tidak Tahu') {
              $('#l-pasar-ada').textbox('readonly', true);
          } else {
              $('#l-pasar-ada').textbox('readonly', false);

          }
      }
  });

  $("#l-minimarket").combobox({
      onChange: function(new_val, old_val) {
          $("#l-minimarket-ada").textbox('setValue', '');
          if (new_val == 'Tidak Ada' || new_val == 'Tidak Tahu') {
              $('#l-minimarket-ada').textbox('readonly', true);
          } else {
              $('#l-minimarket-ada').textbox('readonly', false);
          }
      }
  });

  $('#b-tgl').datebox({
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



  $('#f-tgl-form').datebox({
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

    });
</script>



