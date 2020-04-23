<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/accounting.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>


<style type="text/css">
.textbox-readonly .textbox-text{
        background: #DEDEDE;
}
.floatedLeft {
            float:left;
        }
.floatedRight {
            float:right;
        }

</style>
<div>
    <h2>Inquiry Data Usulan Lokasi</h2>
    <hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>

<div id="cc" class="easyui-layout" style="height:110px;;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;width:100%">
        <table>
            <tr>
                <td>No. Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-no-form-ulok" name="search-no-form-ulok" class="easyui-textbox" style="width:215px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Nama</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-nama-ulok" name="search-nama-ulok" class="easyui-textbox" style="width:200px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Tgl Transfer</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-tgltrf-start-ulok" name="search-tgltrf-start-ulok" class="easyui-datebox" style="width:100px;">-
                    <input type="text" id="search-tgltrf-end-ulok" name="search-tgltrf-end-ulok" class="easyui-datebox" style="width:100px;">
                </td>
                
            </tr>
            <tr>
                <td>Tgl Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-tglform-start-ulok" name="search-tglform-start-ulok" class="easyui-datebox" style="width:100px;">
                    -
                    <input type="text" id="search-tglform-end-ulok" name="search-tglform-end-ulok" class="easyui-datebox" style="width:100px;">
                </td>
                <td style="width: 35px"></td>
                <td>Status</td>
                <td style="width: 15px"></td>
                <td>
                    <select id="search-status-ulok" class="easyui-combobox" name="search-status-ulok" style="width:200px;">
                        <option value=""></option>
                        <option value="N">New</option>
                        <option value="FIN">FIN LPDU</option>
                        <option value="FIN2">FIN LDUK</option>
                        <option value="BBT">BBT</option>
                        <option value="BBK">BBK</option>
                        <option value="EMAIL">Email</option>
                        <option value="S-OK">Survey OK</option>
                        <option value="S-NOK">Survey NOK</option>
                        <option value="F-OK">F-OK</option>
                        <option value="F-NOK">F-NOK</option>
                        <option value="LDUK">LDUK</option>
                    </select>
                </td>
                <td style="width: 35px"></td>
                <td colspan="3">
                    <a id="search-inq-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
                    <a id="print-listing-status-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'">Print</a>
                    <a id="clear-inq-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;width:100%">
        <div style="float: right;display: block;">
           <a id="reject-ulok" href="#" class="easyui-linkbutton" onclick="rejectUlok()" data-options="iconCls:'icon-ess-checked'" style="color:white;font-weight:bold">Reject </a>
        </div>
        <div style="float:left;display: block;">
              <div id="div_session_role" style="display:none"> <input type="text" id="session-role" name="session-role" class="easyui-textbox" style="width:200px;display:none" value="<?php echo @$role_id; ?>"/></div>
        </div>
        <br><br>
        <hr>
        <table id="data-trx-frc-cab"  style="width:100%"></table>


          
    </div>
</div>

<div id="modal-req-liststatusulok" style="display:none; width:400px; height:auto; "class="easyui-window" title="LAPORAN LISTING STATUS ULOK CALON FRANCHISEE " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-lsuf">
        <table>


             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
               
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="show-cabang" name="show-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 35px">Periode</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="show-periode" name="show-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-liststatusulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-req-liststatusulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                 <td colspan="4">
                 <div id="div_session_role"> </div>
                 </td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
               
                 <td colspan="4">  <div id="div_session_branch_id"><input type="text" id="session-branch-id" name="session-branch-id" class="easyui-textbox" style="width:200px;" value="<?php echo @$branch_id; ?>"/>
                 <input type="text" id="session-role" name="session-role" class="easyui-textbox" style="width:200px;" value="<?php echo @$role_id; ?>"/> </div></td>
            
            </tr>
            
        </table>
    </div>
</div>

<div id="showDetailInquiry" style=" width:1200px; height:auto; "class="easyui-window" title="Deskripsi Data Usulan Lokasi" data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
<form id="form-lihat-inquiry" class="easyui-form" data-options="novalidate:true" method="post" action="<?php echo base_url(); ?>Ulok/update_data_form_ulok/" enctype="multipart/form-data" >

    <div id="wizard-inquiry">
            <h2>Data Diri</h2>
            <section>
                <table>
              
                    <tr>
                        <td style="min-width:150px;">Form No.</td>
                        <td>
                            <input type="text" id="show-ulok-form-no" name="" class="easyui-textbox" disabled="true" data-options="required:true" style="width:200px;"></input>
                             <input type="hidden" id="show-ulok-form-no-1" name="show-ulok-form-no-1" class="easyui-textbox"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">Tanggal Form</td>
                        <td>
                            <input type="text" id="show-ulok-tgl-form" class="easyui-datebox" name="show-ulok-tgl-form"  data-options="required:true" style="width:200px;"></input>
                        </td>
                      
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Sumber Ulok</td>
                        <td>
                            <select id="show-ulok-sumber-ulok" name="show-ulok-sumber-ulok" class="easyui-combobox" data-options="required:'true',panelHeight:'auto'" style="width:200px;">   
                                <option value="Pameran">Pameran</option>
                                <option value="Website">Website</option>
                                <option value="Cabang">Cabang</option>
                                <option value="HO">HO</option>
                            </select>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">NPWP</td>
                        <td>
                            <input type="text" id="show-ulok-npwp" name="show-ulok-npwp" class="easyui-textbox"  style="width:200px;"></input>
                        </td>   
                    </tr>
                    <tr>
                        <td style="min-width:150px;">No KTP</td>
                        <td>
                            <input type="text" id="show-ulok-noktp" name="show-ulok-noktp" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">Nama Lengkap</td>
                        <td>
                            <input type="text" id="show-ulok-nama-lengkap" name="show-ulok-nama-lengkap" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>
                        
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Alamat Lengkap</td>
                        <td>
                            <input type="text" id="show-ulok-alamat-lengkap" name="show-ulok-alamat-lengkap" class="easyui-textbox" data-options="required:true, multiline:true" style="width:200px; height:60px"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">RT/RW</td>
                        <td>
                            <input type="text" id="show-ulok-rt-rw" name="show-ulok-rt-rw" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>    
                         <td  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
                    </tr>

                    <tr>
                        <td style="min-width:150px;">Provinsi</td>
                        <td>
                          <input type="text" id="show-ulok-provinsi" name="show-ulok-provinsi" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                        </td>
                         <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">Kodya/Kab</td>
                        <td>
                        <input type="text" id="show-ulok-kodya" name="show-ulok-kodya" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                      
                        </td>
                   
                  
                </tr>
                
                    <tr>
                        <td style="min-width:150px;">Kecamatan</td>
                        <td>

                            <input type="text" id="show-ulok-kecamatan" name="show-ulok-kecamatan" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">Kelurahan</td>
                        <td>
                             <input type="text" id="show-ulok-kelurahan" name="show-ulok-kelurahan" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                        </td>
                    </tr>
                  
                    <tr>
                        <td style="min-width:150px;">Telp / No HP</td>
                        <td>
                            <input type="text" id="show-ulok-telp" name="show-ulok-telp" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:150px;">Kode Pos</td>
                        <td>
                             <input type="text" id="show-ulok-kode-pos" name="show-ulok-kode-pos" class="easyui-combobox" data-options="valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Email</td>
                        <td>
                            <input type="email" id="show-ulok-email" name="show-ulok-email" class="easyui-textbox" data-options="required:true,validType:'email'" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><span id='message_inquiry' style="color:red;font-size:9px"></span></td>
                    </tr>
                </table>
            </section>
        <h2>Detail Lokasi</h2>
            <section>
                <table>
                
                    <tr>
                        <td style="min-width:200px;">Alamat Lengkap</td>
                        <td style="min-width:200px;">
                            <input type="text" id="show-ulok-alamat-lok" name="show-ulok-alamat-lok" class="easyui-textbox" data-options="required:true,multiline:true" style="width:200px; height:60px"></input>
                        </td>
                        <td style="min-width:150px;"></td>
                        <td style="min-width:200px;">RT/RW</td>
                        <td style="min-width:200px;">
                            <input type="text" id="show-ulok-rt-rw-lok" name="show-ulok-rt-rw-lok" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>  
                        <td  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Provinsi</td>
                        <td style="min-width:200px;">
                          <input type="text" id="show-ulok-provinsi-lok" name="show-ulok-provinsi-lok" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                        </td>
                         <td style="width: 25px"></td>
                        <td style="min-width:200px;">Kodya / Kab.</td>
                        <td style="min-width:200px;">
                             <input type="text" id="show-ulok-kodya-lok" name="show-ulok-kodya-lok" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Kecamatan</td>
                        <td style="min-width:200px;">
                            <input type="text" id="show-ulok-kecamatan-lok" name="show-ulok-kecamatan-lok" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                        </td>
                        <td style="width: 25px"></td>
                        <td style="min-width:200px;">Kelurahan</td>
                        <td>
                            <input type="text" id="show-ulok-kelurahan-lok" name="show-ulok-kelurahan-lok" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Kode Pos</td>
                        <td style="min-width:200px;">
                            <input type="text" id="show-ulok-kode-pos-lok" name="show-ulok-kode-pos-lok" class="easyui-combobox" data-options="valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Bentuk Lokasi</td>
                        <td style="min-width:200px;" >
                            <select id="show-ulok-bentuk-lok" class="easyui-combobox" name="show-ulok-bentuk-lok" data-options="required:'true',panelHeight:'auto'" style="width:120px;">
                                <option value=""></option>
                                <option value="Tanah Kosong">Tanah Kosong</option>
                                <option value="Ruko">Ruko</option>
                                <option value="Ruang Usaha">Ruang Usaha</option>
                                <option value="Kios">Kios</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="show-ulok-bentuk-lok-lain" name="show-ulok-bentuk-lok-lain" class="easyui-textbox" readonly="true" style="width:75px;"></input>
                        </td>
                        <td style="min-width:25px;"></td>
                        <td style="min-width:200px;">Ukuran</td>
                        <td>
                            <input type="text" id="show-ulok-ukuran-panjang" name="show-ulok-ukuran-panjang" class="easyui-numberbox" style="width:91px;" data-options="required:true,prompt:'Meter'"></input>
                            <input type="text" id="show-ulok-ukuran-lebar" name="show-ulok-ukuran-lebar" class="easyui-numberbox" style="width:91px;" data-options="required:true,prompt:'Meter'"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Jumlah Unit</td>
                        <td style="min-width:200px;">
                            <input type="text" id="show-ulok-jumlah-unit" name="show-ulok-jumlah-unit" class="easyui-numberbox"  style="width:200px;" readonly="true"></input>
                        </td>
                        <td style="min-width:25px;"></td>
                        <td >Jumlah Lantai</td>
                        <td>
                            <input type="text" id="show-ulok-jumlah-lantai" name="show-ulok-jumlah-lantai" class="easyui-numberbox" readonly="true" style="width:195px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Status Lokasi</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-status-lokasi" class="easyui-combobox" name="show-ulok-status-lokasi" data-options="required:'true',panelHeight:'auto'" style="width:90px;display: inline;">
                                <option value=""></option>
                                <option value="Milik Sendiri">Milik Sendiri</option>
                                <option value="Milik Keluarga">Milik Keluarga</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="show-ulok-status-lokasi-lain" name="show-ulok-status-lokasi-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                        </td>
                        <td style="min-width:25px;"></td>
                        <td style="min-width:200px;">Dokumen Kepemilikan</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-dok-milik" class="easyui-combobox" name="show-ulok-dok-milik" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                                <option value=""></option>
                                <option value="SHM">SHM</option>
                                <option value="SHGB">SHGB</option>
                                <option value="SHSRS">SHSRS</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="show-ulok-dok-milik-lain" name="show-ulok-dok-milik-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Lahan Parkir</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-lahan-parkir" class="easyui-combobox" name="show-ulok-lahan-parkir" data-options="required:'true',panelHeight:'auto'" style="width:90px; display: inline;">
                                <option value=""></option>
                                <option value="Sendiri">Sendiri</option>
                                <option value="Bersama">Bersama</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="show-ulok-lahan-parkir-lain" name="show-ulok-lahan-parkir-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                        </td>
                        <td style="width: 25px"></td>
                        <td style="min-width:200px;">Denah/Foto Lokasi</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-denah" class="easyui-combobox" name="show-ulok-denah" data-options="required:'true',panelHeight:'auto'" style="width:200px;">
                                <option value=""></option>
                                <option value="Melalui Email">Melalui Email</option>
                                <option value="Dikirim Langsung">Terlampir</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Izin Bangunan</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-izin-bangun" class="easyui-combobox" name="show-ulok-izin-bangun" data-options="required:'true',panelHeight:'auto'" style="width:200px;">
                                <option value=""></option>
                                <option value="IMB">IMB</option>
                                <option value="IPB">IPB</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </td>
                        <td style="min-width:200px;"></td>
                        <td style="min-width:200px;">Peruntukan Bangunan (sesuai IMB/IPB)</td>
                        <td>
                            <select id="show-ulok-izin-untuk" class="easyui-combobox" name="show-ulok-izin-untuk" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                                <option value=""></option>
                                <option value="Ruko">Ruko</option>
                                <option value="Ruang Usaha">Ruang Usaha</option>
                                <option value="Kios">Kios</option>
                                <option value="Rumah Tinggal">Rumah Tinggal</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="show-ulok-izin-untuk-lain" name="show-ulok-izin-untuk-lain" class="easyui-textbox" readonly="true" style="width:98px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:200px;">Pasar Tradisional</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-pasar" class="easyui-combobox" name="show-ulok-pasar" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                                <option value=""></option>
                                <option value="< 500 m">< 500 m</option>
                                <option value="> 500 m">> 500 m</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Tidak Tahu">Tidak Tahu</option>
                            </select>
                            <input type="text" id="show-ulok-pasar-ada" name="show-ulok-pasar-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                        </td>
                        <td style="width: 25px"></td>
                        <td style="min-width:200px;">Minimarket</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-minimarket" class="easyui-combobox" name="show-ulok-minimarket" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                                <option value=""></option>
                                <option value="< 500 m">< 500 m</option>
                                <option value="> 500 m">> 500 m</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Tidak Tahu">Tidak Tahu</option>

                            </select>
                            <input type="text" id="show-ulok-minimarket-ada" name="show-ulok-minimarket-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                        </td>
                    </tr>
                    <tr>   
                        <td style="min-width:200px;">Indomaret Terdekat</td>
                        <td style="min-width:200px;">
                            <select id="show-ulok-idm-dekat" class="easyui-combobox" name="show-ulok-idm-dekat" data-options="required:'true',panelHeight:'auto'" style="width:90px;">
                                <option value=""></option>
                                <option value="< 500 m">< 500 m</option>
                                <option value="> 500 m">> 500 m</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Tidak Tahu">Tidak Tahu</option>
                            </select>
                            <input type="text" id="show-ulok-idm-dekat-ada" name="show-ulok-idm-dekat-ada" class="easyui-textbox" readonly="true" style="width:105px;"></input>
                        </td>  
                    </tr>
                    <tr>
                        <td colspan="2"><span id='message_inquiry2' style="color:red;font-size:9px"></span></td>
                    </tr>
                 </table>
            </section>
        <h2>Pembayaran</h2>
            <section>
                <table class="floatedLeft">
                    <tr>
                        <td style="min-width:150px;">Tipe Pembayaran</td>
                        <td>
                            <select id="show-ulok-tipe" class="easyui-combobox" name="show-ulok-tipe" data-options="required:'true',panelHeight:'auto'" style="width:115px;">
                                <option value=""></option>
                                <option value="Cash">Cash</option>
                                <option value="Debit">Debit</option>
                                <option value="Kartu Kredit">Kartu Kredit</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                            <input type="text" id="show-ulok-kredit" name="show-ulok-kredit" class="easyui-textbox"  style="width:80px;"></input>
                         </td>
                    </tr>
                     <tr>
                        <td style="min-width:150px;">Nama Rekening Pengirim</td>
                        <td>
                            <input type="text" id="show-ulok-narek-pengirim" name="show-ulok-narek-pengirim" class="easyui-textbox" style="width:200px;"></input>
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
                            <input type="text" id="show-ulok-bank" name="show-ulok-bank" class="easyui-combobox" data-options="required:true,valueField:'BANK_ID',textField:'BANK_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_bank_all/'" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Cabang</td>
                        <td>
                            <input type="text" id="show-ulok-cabang-bank" name="show-ulok-cabang-bank" class="easyui-textbox" data-options="required:true" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">No Rekening</td>
                        <td>
                            <input type="text" id="show-ulok-norek" name="show-ulok-norek" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Nama Rekening</td>
                        <td>
                            <input type="text" id="show-ulok-narek" name="show-ulok-narek" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td><hr></td>
                        <td><hr></td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Nilai Rp. yang diswipe</td>
                        <td>
                            <input type="text" id="show-ulok-jumlah-swipe" name="show-ulok-jumlah-swipe" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Nilai Rp. yang masuk ke rekening</td>
                        <td>
                            <input type="text" id="show-ulok-jumlah-masukrek" name="show-ulok-jumlah-masukrek" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Tanggal Pembayaran</td>
                        <td>
                            <input type="text" id="show-ulok-tgl" name="show-ulok-tgl" class="easyui-datebox" data-options="required:true" style="width:200px;"></input>

                        </td>
                    </tr>
                    <tr>
                        <td style="min-width:150px;">Bukti Transfer</td>
                        <td>
                             <input type="file"  name="update_filesToUpload" id="update_filesToUpload" size="20" style="width:200px;font-size: 10px"  onchange="update_file()" accept=".pdf,.jpg,.jpeg,.png,.gif" />
                            <div id="div_update_cek_file">
                            <input type="text" id="update_cek_file" name="update_cek_file" class="easyui-textbox"  style="width:105px;"></input>
                            <input type="text" id="file_amount" name="file_amount" class="easyui-textbox"  style="width:105px;"></input></div>
                        </td>
                          <td style="min-width:150px;"> </td>
                    </tr>
                
                     <tr>
                        <td>
                            <ul style="color:blue;font-size:11px">Ketentuan:                
                                <li style="color:red;font-size:9px">Jumlah minimal swipe : Rp.3.600.000,-</li>
                                <li style="color:red;font-size:10px">Maks file upload : 5 file</li>
                                <li style="color:red;font-size:10px">Nama file diharapkan tidak identik</li>
                                <li style="color:red;font-size:10px">Format yg diijinkan : pdf,jpg,jpeg,png</li>
                                <li style="color:red;font-size:10px">Ukuran file maks : 3 MB </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <div id="div_inserted_id"> 
                            <input type="text" id="inserted_id" name="inserted_id" class="easyui-textbox"  style="width:105px;"></input>


                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <div id="div_file_amount">
                         
                        </div>
                        </td>
                    </tr>
                </table>
                <table>
                <tr>
                        <td style="width: 100px"></td>
                        <td>List Upload File</td>
                </tr>
                <tr>
                          <td style="width: 100px"></td>
                      <td colspan="3">
                            <ul id="updatefileList"><li>No Files Selected</li></ul>

                         </td>
                    </tr>

            </table>
            </section>
            <h2>Log Status</h2>
            <section>
                   <table id ="data-list-detail-status" class="easyui-datagrid" title="Basic DataGrid" style="width:100%" data-options="singleSelect:true,collapsible:true,pagination:true">
                <thead>
                    <tr>
                   
                                                            
                <th data-options="field:'FORM_NUM',width:300,align:'center'">No Form</th>
                <th data-options="field:'STATUS',width:200,align:'center',formatter:formatStatus">Status</th>
                <th data-options="field:'JENIS_STATUS',width:200,align:'center'">Jenis Status</th>
                <th data-options="field:'CREATED_DATE',width:200,align:'center',formatter:formatDate1">Tanggal Status</th>
                <th data-options="field:'USERNAME',width:200,align:'center'">Last Updated by</th>
            </tr>
        </thead>
    </table>
            </section>
        </div>
    </form>
</div>

<div id="otp-reject-ulok" style="display:none; width:400px; height:auto; "class="easyui-window" title="Reject Ulok" data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="otp-rejectulok">
        <table>
            <tr style="width: 35px" >
                <td style="width: 35px"><br>
              </td>
            </tr>
             <tr>
                  <td colspan="3">
                <div id="div_message">
                  <p style="font-size:70%;">Anda memiliki satu kode yang belum digunakan</p>
                </div>
                </td>
            </tr>
             <tr> 
                <td style="width: 100px" >Ref Num</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="input-ref-num-ulok" name="input-ref-num-ulok" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >Input OTP</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="password" id="input-otp-reject-ulok" name="input-otp-reject-ulok" class="easyui-textbox" style="width:200px;" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >No Form Ulok</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="input-no-ulok" name="input-no-ulok" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >Alasan Reject</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="input-alasan-reject-ulok" name="input-alasan-reject-ulok" class="easyui-textbox" style="width:200px;" /></td>
            </tr>
             <tr style="width: 35px" >
                <td colspan="3">
                    
                        <p style="font-size:60%;">* Silahkan cek email untuk mengisi OTP berikut.</p>
                  
                    </td>
            </tr>

            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-otp-reject-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-otp-reject-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
      //start datagrid inquiry ulok
   $("#data-trx-frc-cab").datagrid({
     url: 'Ulok/get_data_trx_cab/',
     striped: true,
     rownumbers: true,
     remoteSort: true,
     singleSelect: true,
     pagination: true,
     fit: false,
     autoRowHeight: false,
     fitColumns: true,
     toolbar: '#toolbar',
     onSelect: function() {},
     onSelectAll: function() {},
     onUnselect: function() {},
     onUnselectAll: function() {

     },
     onDblClickRow: function() {


     },
     columns: [
         [
         // {
         //         field: 'ck',
         //         title: '',
         //         checkbox: "true"
         //     },
          {
                 field: 'ULOK_TRX_ID',
                 hidden: "true"
             }, {
                 field: 'FORM_NUM',
                 title: 'Form-ID',
                 width: 250,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {

                     var s = '<a href="javascript:void(0)" onclick="print_report_ulok(\'' + value + '\')">' + value + '</a> ';

                     return s;

                 }
             }, {
                 field: 'NAMA',
                 title: 'Nama Franchisee',
                 width: 150,
                 align: "center",
                 halign: "center"
             }, {
                 field: 'TRX_AMOUNT',
                 title: 'Amount',
                 width: 150,
                 align: "right",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value == null) {
                         return "";
                     } else {
                         return accounting.formatNumber(value);
                     }
                 }
             }, {
                 field: 'STATUS',
                 title: 'STATUS',
                 width: 150,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value == 'N') {
                         return "New";
                     } else {
                         return value;
                     }
                 }

             }, {
                 field: 'LPDU_FORM_NUM',
                 title: 'No LPDU',
                 width: 200,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     return value;
                     /* if(value){
                          var s = '<a href="javascript:void(0)" onclick="lihat_lpdu(\''+value+'\')">'+value+'</a> ';
                      
                        return s;
                      }else return "";
                        
                    */
                 }
             }, {
                 field: 'LDUK_FORM_NUM',
                 title: 'No LDUK',
                 width: 200,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     return value;
                     /* if (value){
                         var s = '<a href="javascript:void(0)" onclick="lihat_lduk(\''+value+'\')">'+value+'</a> ';
                      
                        return s;
                      }else return "";
                       */

                 }
             }, {
                 field: 'ULOK_FORM_DATE',
                 title: 'Tanggal Form',
                 width: 150,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value != null) {

                         var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                         options = {
                             year: 'numeric',
                             month: 'long',
                             day: 'numeric'
                         };
                         return Intl.DateTimeFormat('id-ID', options).format(date);
                     } else {
                         return "";
                     }
                 }

             }, {
                 field: 'ULOK_BAYAR_DATE',
                 title: 'Tanggal Transfer',
                 width: 150,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value != null) {

                         var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
                         options = {
                             year: 'numeric',
                             month: 'long',
                             day: 'numeric'
                         };
                         return Intl.DateTimeFormat('id-ID', options).format(date);
                     } else {
                         return "";
                     }
                 }

             }, {
                 field: 'action',
                 title: 'Action',
                 width: 120,
                 align: 'center',
                 formatter: function(value, row, index) {
                     var p = ' <button href="javascript:void(0)" onclick="see_report_ulok(this)" class="easyui-linkbutton">View</button>';

                     return p;

                 }
             }

         ]
     ]
 });
   //end datagrid inquiry ulok

    $(document).ready(function() {
         var role=<?php echo $this->session->userdata('role_id')?>;
         $("#reject-ulok").css("background","red");
         $('#cancel-req-liststatusulok').css('background','red');
         $('#submit-req-liststatusulok').css('background','green');
         $('#submit-otp-reject-ulok').css('background','green');
         $('#cancel-otp-reject-ulok').css('background','red');
         if(role=='3' || role=='1'){
            $('#reject-ulok').show();
         }else{
            $('#reject-ulok').hide();
         }   
         
    });
    function formatDate1(value,row){
        var date = new Date(value.substring(0, 4) + '-' + value.substring(5, 7) + '-' + value.substring(8, 10));
        options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                  };
        return Intl.DateTimeFormat('id-ID', options).format(date) + "  " + value.substring(11, 19);
    }

    function formatStatus(value,row){
         if (value == 'N') {
                return "New";
        } else {
                return value;
        }
    }

 
</script>
 
        

