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
    <h2>Inquiry Data Take Over Toko</h2>
    <hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<div id="showDetailInquiryTO" style="display:none; width:1200px; height:auto; "class="easyui-window" title="Deskripsi Data Take Over Toko" data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
<form id="form-lihat-inquiryTO" class="easyui-form" data-options="novalidate:true" method="post" action="<?php echo base_url(); ?>Ulok/update_data_form_to/" enctype="multipart/form-data" >
    <div id="wizard-inquiryTO">
        <h2>Data Diri</h2>
        <section>
            <table>
                <tr>
                    <td style="min-width:150px;">Form No.</td>
                    <td>
                         <input type="text" id="show-form-to-no" name="" class="easyui-textbox" disabled="true" data-options="required:true" style="width:200px;"></input>
                        <input type="hidden" id="show-form-to-no-1" name="show-form-to-no-1" class="easyui-textbox"></input>
                        <input type="hidden" name="show-form-to-id" value="">

                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Tanggal Form</td>
                    <td>
                        <input type="text" id="show-tgl-to-form" name="show-tgl-to-form" class="easyui-datebox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">No KTP</td>
                    <td>
                        <input type="text" id="show-noktp-to" name="show-noktp-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Nama Lengkap</td>
                    <td>
                        <input type="text" id="show-nama-lengkap-to" name="show-nama-lengkap-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="show-alamat-lengkap-to" name="show-alamat-lengkap-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                        
                    </td>
                    <td style="min-width:150px;"></td>
                     <td style="min-width:150px;">RT/RW</td>
                    <td>
                        <input type="text" id="show-rt-rw-to" name="show-rt-rw-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
               
                </tr>

                <tr>
                    <td style="min-width:150px;">Provinsi</td>
                    <td>
                          <input type="text" id="show-provinsi-to" name="show-provinsi-to" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                  <td style="min-width:150px;">Kodya / Kab.</td>
                    <td>
                         <input type="text" id="show-kodya-to" name="show-kodya-to" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                   
                  
                </tr>
                <tr>
                    <td style="min-width:150px;">Kecamatan</td>
                    <td>
                        <input type="text" id="show-kecamatan-to" name="show-kecamatan-to" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    
                    </td>
                       <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Kelurahan</td>
                    <td>
                       <input type="text" id="show-kelurahan-to" name="show-kelurahan-to" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                    </td>  
                </tr>
                 <tr>
                   
                    <td style="min-width:150px;">Kode Pos</td>
                    <td>
                          <input type="text" id="show-kode-pos-to" name="show-kode-pos-to" class="easyui-combobox" data-options="panelHeight:'auto',valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>
                             <td style="min-width:150px;"></td>
                                <td style="min-width:150px;">Email</td>
                    <td>
                        <input type="email" id="show-email-to" name="show-email-to" class="easyui-textbox" data-options="required:true,validType:'email'" style="width:200px;"></input>
                    </td>
                </tr>
            

                <tr>
                    
           
                    <td style="min-width:150px;">NPWP</td>
                    <td>
                        <input type="text" id="show-npwp-to" name="show-npwp-to" class="easyui-textbox" style="width:200px;"></input>
                    </td>
                       <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Telp / No HP</td>
                    <td>
                        <input type="text" id="show-telp-to" name="show-telp-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                        <td colspan="2"><span id='message_inquiry_to' style="color:red;font-size:9px"></span></td>
                </tr>
                  <tr>
                 <td  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (005/006)</td>
               </tr>
            </table>
        </section>
         <h2>Detail Lokasi</h2>
        <section>
            <table>
                 <tr>
                    <td style="min-width:150px;">Kode Toko</td>
                    <td>
                        <input type="text" id="show-kode-toko-to" name="show-kode-toko-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">Nama Toko</td>
                    <td>
                         <input type="text" id="show-nama-toko-to" name="show-nama-toko-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
          
                <tr>
                    <td style="min-width:150px;">Alamat Lengkap</td>
                    <td>
                        <input type="text" id="show-alamat-to" name="show-alamat-to" class="easyui-textbox" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                    <td style="min-width:150px;">RT/RW</td>
                    <td>
                        <input type="text" id="show-rt-rw-toko-to" name="show-rt-rw-toko-to" class="easyui-textbox"  style="width:200px;"></input>
                    </td>
                     <td  style="color:blue;font-size:10px" >* Cth Pengisian : No RT / No RW (05/06)</td>
                   
                </tr>
                <tr>
                    <td style="min-width:150px;">Provinsi</td>
                    <td>
                          <input type="text" id="show-provinsi-to-lok" name="show-provinsi-to-lok" class="easyui-combobox" data-options="valueField:'PROVINCE',textField:'PROVINCE',url:'<?php echo base_url('Ulok/get_all_province/'); ?>'" style="width:200px;"></input>
                    </td>
                     <td style="min-width:150px;"></td>
                  <td style="min-width:150px;">Kodya / Kab.</td>
                    <td>

                          <input type="text" id="show-kodya-to-lok" name="show-kodya-to-lok" class="easyui-combobox" data-options="valueField:'CITY_KAB_NAME',textField:'CITY_KAB_NAME'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td>
                   
                  
                </tr>

                 <tr>
                     <td style="min-width:150px;">Kecamatan</td>
                    <td>
                         <input type="text" id="show-kecamatan-to-lok" name="show-kecamatan-to-lok" class="easyui-combobox" data-options="valueField:'KEC_SUB_DISTRICT',textField:'KEC_SUB_DISTRICT'" style="width:200px;"></input>
                    </td>
                    <td style="min-width:150px;"></td> 
                    <td style="min-width:150px;">Kelurahan</td>
                    <td>
                         <input type="text" id="show-kelurahan-to-lok" name="show-kelurahan-to-lok" class="easyui-combobox" data-options="valueField:'KEL_VILLAGE',textField:'KEL_VILLAGE'" style="width:200px;"></input>
                    </td>             
                </tr>
                <tr>
                   
                    <td style="min-width:150px;">Kode Pos</td>
                    <td>
                          <input type="text" id="show-kode-pos-to-lok" name="show-kode-pos-to-lok" class="easyui-combobox" data-options="valueField:'POSTAL_CODE',textField:'POSTAL_CODE'" style="width:200px;"></input>
                    </td>
                            
                </tr>
                <tr>
                   <td><hr></td>
                   <td><hr></td>

                   <td><hr></td>
                   <td><hr></td>
                   
                   <td><hr></td>
                   <td><hr></td>
               </tr>
                <tr>
                     <td style="min-width:150px;">Nilai Investasi</td>

                      <td style="min-width:150px;"></td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Actual Investment</td>
                    <td>
                        <input type="text" id="show-actual-investment-to" name="show-actual-investment-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                  
                   
                </tr>

                <tr>
                     <td style="min-width:150px;">PPN</td>
                    <td>
                        <input type="text" id="show-ppn-to" name="show-ppn-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                      <td style="min-width:150px;"></td>

                    <td style="min-width:150px;">Total</td>
                     <td>
                         <input type="text" id="show-total-to" name="show-total-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" readonly="true" style="width:200px;"></input>
                    </td>
                  </tr>
                  <tr>
                     <td style="min-width:150px;">Goodwill</td>
                    <td>
                        <input type="text" id="show-goodwill-to" name="show-goodwill-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                   
                </tr>
                 <tr>
                        <td colspan="2"><span id='message_inquiry_to2' style="color:red;font-size:9px"></span></td>
                </tr>
            </table>
        </section>
  <h2>Pembayaran</h2>
        <section>
            <table class="floatedLeft"> 
                <tr>
                    <td style="min-width:150px;">Tipe Pembayaran</td>
                    <td>
                        <select id="show-tipe-to" class="easyui-combobox" name="show-tipe-to" data-options="required:'true',panelHeight:'auto'" style="width:115px;">
                            <option value=""></option>
                            <option value="Cash">Cash</option>
                            <option value="Debit">Debit</option>
                            <option value="Kartu Kredit">Kartu Kredit</option>
                             <option value="Transfer">Transfer</option>
                        </select>
                        <input type="text" id="show-to-kredit" name="show-to-kredit" class="easyui-textbox"  style="width:85px;"></input>
                    </td>
                </tr>

                 <tr>
                    <td style="min-width:150px;">Nama Rekening Pengirim</td>
                    <td>
                        <input type="text" id="show-narek-to-pengirim" name="show-narek-to-pengirim" class="easyui-textbox"  style="width:200px;"></input>
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
                        <input type="text" id="show-bank-to" name="show-bank-to" class="easyui-combobox" data-options="required:true,valueField:'BANK_ID',textField:'BANK_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_bank_all/',panelHeight:'auto'" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Cabang</td>
                    <td>
                        <input type="text" id="show-cabang-bank-to" name="show-cabang-bank-to" class="easyui-textbox" data-options="required:true" style="width:200px;" />
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">No Rekening</td>
                    <td>
                        <input type="text" id="show-norek-to" name="show-norek-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nama Rekening</td>
                    <td>
                        <input type="text" id="show-narek-to" name="show-narek-to" class="easyui-textbox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                   <td><hr></td>
                   <td><hr></td>
               </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang diswipe</td>
                    <td>
                        <input type="text" id="show-jumlah-swipe-to" name="show-jumlah-swipe-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Nilai Rp. yang masuk ke rekening</td>
                    <td>
                        <input type="text" id="show-jumlah-masukrek-to" name="show-jumlah-masukrek-to" class="easyui-numberbox" data-options="required:true,min:0,groupSeparator:','" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Tanggal Pembayaran</td>
                    <td>
                        <input type="text" id="show-tgl-to" name="show-tgl-to" class="easyui-datebox" data-options="required:true" style="width:200px;"></input>
                    </td>
                </tr>
                <tr>
                    <td style="min-width:150px;">Bukti Transfer</td>
                    <td>
                           <input type="file"  name="update_TO_filesToUpload" id="update_TO_filesToUpload" size="20" style="width:200px;font-size: 10px"  onchange="update_file_to()" accept=".pdf,.jpg,.jpeg,.png,.gif" />
                    </td>
                </tr>
            
                <tr>

                    <td>
                            <div id ="div_update_cek_file_to">
                            <input type="text" id="update_cek_file_to" name="update_cek_file_to" class="easyui-textbox"  style="width:105px;"></input>
                            </div>
                    </td>
                </tr>
              
                    <tr>
                        <td>
                           <div id="div_update_to_inserted_id">
                           <input type="text" id="update_to_inserted_id" name="update_to_inserted_id" class="easyui-textbox"  style="width:105px;"></input>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="div_update_to_file_amount"> 
                            <input type="text" id="update_to_file_amount" name="update_to_file_amount" class="easyui-textbox"  style="width:105px;"></input>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul style="color:blue;font-size:11px">Ketentuan:
                                <li style="color:red;font-size:9px">Jumlah minimal swipe : Rp.3.600.000,-</li>
                                <li style="color:red;font-size:9px">Maks file upload : 5 file,,Ukuran maks : 3MB</li>
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
                    <td style="height:15px" ></td>
                </tr>
                <tr>
                        <td style="width: 100px"></td>
                        <td>List Upload File</td>
                </tr>
                <tr>
                        <td style="width: 100px"></td>
                        <td colspan="3">
                            <ul id="updatefileListTO"><li>No Files Selected</li></ul>

                         </td>
                    </tr>

            </table>
        </section>
           <h2>Log Status</h2>
    

            <section>
                   <table id ="data-list-detail-status-to" class="easyui-datagrid" title="Log Status TO " style="width:1100px" data-options="singleSelect:true,collapsible:true,pagination:true">
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
<div id="cc-to-toko" class="easyui-layout" style="height:110px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
        <table>
            <tr>
                <td>No. Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-no-form-to" name="search-no-form-to" class="easyui-textbox" style="width:215px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Nama</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-nama-to" name="search-nama-to" class="easyui-textbox" style="width:200px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Tgl Transfer</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-tgltrf-start-to" name="search-tgltrf-start-to" class="easyui-datebox" style="width:100px;">-
                    <input type="text" id="search-tgltrf-end-to" name="search-tgltrf-end-to" class="easyui-datebox" style="width:100px;">
                </td>
                
            </tr>
            <tr>
                <td>Tgl Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-tglform-start-to" name="search-tglform-start-to" class="easyui-datebox" style="width:100px;">
                    -
                    <input type="text" id="search-tglform-end-to" name="search-tglform-end-to" class="easyui-datebox" style="width:100px;">
                </td>
                <td style="width: 35px"></td>
                <td>Status</td>
                <td style="width: 15px"></td>
                <td>
                    <select id="search-status-to" class="easyui-combobox" name="f-status" style="width:200px;" >
                        <option value=""></option>
                        <option value="N">New</option>
                        <option value="FIN">FIN LPDU</option>
                        <option value="FIN2">FIN LDUK</option>
                        <option value="BBT">BBT</option>
                        <option value="BBK">BBK</option>
                        <option value="F-OK">F-OK</option>
                        <option value="F-NOK">F-NOK</option>
                        <option value="LDUK">LDUK</option>
                    </select>
                </td>
                        <td style="width: 35px"></td>
                <td colspan="3">
                    <a id="search-inq-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
                    <a id="print-listing-status-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'">Print</a>
                    <a id="clear-inq-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc-to-toko" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;">
        <div style="float: right;display: block;">
          <a id="reject-to" href="#" class="easyui-linkbutton" onclick="rejectTO()" data-options="iconCls:'icon-ess-checked'" style="color:white;font-weight:bold">Reject </a>

        </div>
        <div style="float:left;display: block;">
        </div>
             <div id="div_session_role" style="display:none"> <input type="text" id="session-role" name="session-role" class="easyui-textbox" style="width:200px;display:none" value="<?php echo @$role_id; ?>"/></div>
        <br><br>
        <hr>
        <table class="easyui-datagrid" id="data-trx-to-toko"style="width:100%"></table>
    </div>
</div> 

<div id="modal-req-liststatusto" style="display:none; width:400px; height:200px; "class="easyui-window" title="LAPORAN LISTING STATUS TO CALON FRANCHISEE " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-lstf">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="show-cabang-to" name="show-cabang-to" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 35px">Periode</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="show-periode-to" name="show-periode-to" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-liststatusto" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white" >Submit</a>
                    <a id="cancel-req-liststatusto" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        
            <tr>
                <td style="width: 35px"></td>
                 <td colspan="4"><div id="div_session_branch_id_to"><input type="text" id="session-branch-id-to" name="session-branch-id-to" class="easyui-textbox" style="width:200px;" value="<?php echo @$branch_id; ?>"/><input type="text" id="session-role-to" name="session-role-to" class="easyui-textbox" style="width:200px;" value="<?php echo @$role_id; ?>"/></div></td>
            </tr>
        </table>
    </div>
</div>

<div id="otp-reject-to" style="display:none; width:400px; height:auto; "class="easyui-window" title="Reject Ulok" data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="otp-rejectto">
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
                <td style="width: 35px"> <input type="text" id="input-ref-num-to" name="input-ref-num-to" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >Input OTP</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="password" id="input-otp-reject-to" name="input-otp-reject-to" class="easyui-textbox" style="width:200px;" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >No Form Ulok</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="input-no-to" name="input-no-to" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >Alasan Reject</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="input-alasan-reject-to" name="input-alasan-reject-to" class="easyui-textbox" style="width:200px;" /></td>
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
                    <a id="submit-otp-reject-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white" >Submit</a>
                    <a id="cancel-otp-reject-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"  style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>



<script type="text/javascript">
   $("#data-trx-to-toko").datagrid({
                url: 'Ulok/get_data_trx_to_toko/',
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
                onUnselectAll: function() {},
                onDblClickRow: function() {},
                columns: [
                                [
                                // {
                                //                                 field: 'ck',
                                //                                 title: '',
                                //                                 checkbox: "true"
                                //                 }, 
                                {
                                                                field: 'ULOK_TRX_ID',
                                                                hidden: "true"
                                                }, {
                                                                field: 'FORM_NUM',
                                                                title: 'Form-ID',
                                                                width: 200,
                                                                align: "center",
                                                                halign: "center",
                                                                formatter: function(value, row, index) {
                                                                                if (value) {
                                                                                                var s = '<a href="javascript:void(0)" onclick="print_report_to(\'' + value + '\')">' + value + '</a> ';
                                                                                                return s;
                                                                                } else {
                                                                                                return "";
                                                                                }
                                                                }
                                                }, {
                                                                field: 'NAMA',
                                                                title: 'Nama',
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
                                                                field: 'LPDU_NUM',
                                                                title: 'No LPDU',
                                                                width: 200,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'LDUK_NUM',
                                                                title: 'No LDUK',
                                                                width: 200,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'TO_FORM_DATE',
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
                                                                field: 'TO_BAYAR_DATE',
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
                                                                height: 80,
                                                                align: 'center',
                                                                formatter: function(value, row, index) {
                                                                                var q = ' <button href="javascript:void(0)" onclick="see_report_to(this)" class="easyui-linkbutton">View</button>';
                                                                                
                                                                                return q;

                                                                }
                                                }

                                ]
                ]
   });
    $(document).ready(function() {

         $("#reject-to").css("background","red");
         $("#submit-otp-reject-to").css("background","green");
         $("#cancel-otp-reject-to").css("background","red");
         $('#submit-req-liststatusto').css('background','green');
         $('#cancel-req-liststatusto').css('background','red');
         var role=<?php echo $this->session->userdata('role_id')?>;
         if(role=='3' || role=='1'){
            $('#reject-to').show();
         }else{
            $('#reject-to').hide();
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
