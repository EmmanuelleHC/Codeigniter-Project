<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>
<style type="text/css">
    .textbox-readonly .textbox-text{
         background: #DEDEDE;
    }



    #wizard .content {
        min-height: 100px;
    }
    #wizard .content > .body {
        width: 100%;
        height: auto;
        padding: 15px;
        position: relative;
    }
    .floatedRight {
            float:right;
    }
</style>
<div>
	<h2>Hasil Survey</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>

<div id="inq-hasil-survey-ulok" class="easyui-layout" style="height:150px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
        <table>
            <tr>
                <td>No. Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-form-survey" name="search-form-survey" class="easyui-textbox" style="width:215px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Tgl Survey</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-tglsurvey-start-to" name="search-tglsurvey-start-to" class="easyui-datebox" style="width:100px;">-
                    <input type="text" id="search-tglsurvey-end-to" name="search-tglsurvey-end-to" class="easyui-datebox" style="width:100px;">
                </td>
                            <td style="width: 35px"></td>
                 <td>Status Cabang</td>
                <td style="width: 15px"></td>
                <td>
                    <select id="search-status-cabang-survey" class="easyui-combobox" name="search-status-cabang-survey" style="width:215px;">
                        <option value=""></option>
                        <option value="N">New</option>
                        <option value="FIN">FIN LPDU</option>
                        <option value="FIN">FIN LDUK</option>
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
                
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <!-- <td>Status Validate HO</td>
                <td style="width: 15px"></td>
                <td>
                    <select id="search-status-ho-survey" class="easyui-combobox" name="search-status-ho-survey" style="width:215px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="FINAL-NOK">Final-NOK</option>
                    </select>
                </td>
                <td style="width: 35px"></td>-->
               
                              <td colspan="5"></td>
                <td colspan="6">
                    <a id="search-inq-survey" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                  
                    <a id="clear-inq-survey" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="width:100px">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc-survey-ulok" class="easyui-layout" style="height:500px;width:100%">
     <div data-options="region:'north',title:'Survey Lokasi ULOK'" style="height:450px;padding:5px;">
        <div style="float:left;display: block;">
        <!--    <a id="kirim-email" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-checked'">Email ke Location</a>
        -->
        </div>
        <div style="float:right;display: block;">
           
            <a id="submit-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-checked'" style="font-weight:bold;color:white">Finalisasi </a>
            <a id="finalisasi-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-checked'" style="font-weight:bold;color:white">Finalisasi</a>
        
        </div>
        <br><br>
        <hr>
          <table class="easyui-datagrid" id="data-survey-ulok-toko"style=";width:100%"></table>
    </div>
</div> 
<div id="modal-input-hasil-survey-ulok" style="display:none; width:1000px; height:auto; "class="easyui-window" title="INPUT HASIL SURVEY " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-hasil-survey-ulok">
        <table>
             <tr>
                <td><br></td>
            </tr>
            <tr>
                <td style="width: 200px">
                <div id="div_session_role"> <input type="text" id="session-role" name="session-role" class="easyui-textbox" style="width:200px;display:none;"value="<?php echo @$role_id; ?>" />
                </div>
                </td>
               
            </tr>
            <tr>
                <td style="width: 200px">
                <div id="div_session_form_id_field">
                  <input type="text" id="form-id-field" name="form-id-field"  style="width:200px;display:none;"value="<?php echo @$role_id; ?>" />
                </div>
                </td>
            </tr>
            <tr> 
                
                <td style="width: 200px" >No Form</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-survey-no-form" name="input-survey-no-form" class="easyui-textbox" style="width:200px;" /></td>
                <td style="width: 15px"></td>
                <td style="width: 200px">Status Cabang</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="input_status_cabang" class="easyui-combobox" name="input_status_cabang" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="Email">Email</option>
                        <option value="BBT">BBT</option>
                        <option value="S-OK">S-OK</option>
                        <option value="S-NOK">S-NOK</option>
                        <option value="NOK">NOK</option>
                        <option value="OK">OK</option>
                        <option value="HANGUS">HANGUS</option>
                        <option value="F-OK">F-OK</option>
                          <option value="F-NOK">F-NOK</option>
                    </select>
                </td>
            </tr>
           <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr> 
                <td style="width: 200px" >Nama Franchisee</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-survey-nama" name="input-survey-nama" class="easyui-textbox" style="width:200px;" /></td>
                <td style="width: 15px"></td>
                <td style="width: 200px">Status HO</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="input_status_ho" class="easyui-combobox" name="input_status_ho" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">OK</option>
                        <option value="NOK">NOK</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr>
                <td style="width: 200px">Tanggal Jawaban Ulok secara Potensi</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-survey-tgl-survey" name="input-survey-tgl-survey" class="easyui-datebox" readonly="true" style="width:200px;" /></td>
            </tr>
             <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr>
                <td style="width: 200px">Jawaban Ulok secara Potensi</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="input_hasil_survey" class="easyui-combobox" name="input_hasil_survey" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">OK</option>
                        <option value="NOK">NOK</option>
                    </select>
                </td>
                <td style="width: 15px"></td>
                <td style="width: 200px" >Alasan NOK</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-alasan-survey" name="input-alasan-survey" class="easyui-textbox"   style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr>
                <td style="width: 220px">Tanggal Penyampaian ke Calon Franchisee</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-survey-tgl-penyampai-survey" name="input-survey-tgl-penyampai-survey" class="easyui-datebox"  style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
             <tr>
                <td style="width: 200px">Jawaban dari Calon Franchisee</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="input_status_ulok" class="easyui-combobox" name="input_status_ulok" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">Lanjut Buka</option>
                        <option value="NOK">Tdk Lanjut Buka</option>
                    </select>
                </td>
                <td style="width: 15px"></td>
                <td style="width: 200px" >Alasan NOK</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="input-alasan-status-ulok" name="input-alasan-status-ulok" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr>
                <td style="width: 200px">Lampiran Jawaban Ulok secara Potensi</td>
                <td style="width: 15px">:</td>
                <td>
                         <input type="file"  name="filesToUploadSurvey" id="filesToUploadSurvey" size="20" style="width:200px;font-size: 10px"  accept=".pdf,.jpg,.jpeg,.png,.gif" />
                      
                </td>
                  
            </tr>
           <!-- <table border="true">
                <tr>
                    <td>
                            <ul style="color:blue;font-size:10px">Ketentuan:
                                <li style="color:red;font-size:9px">Ukuran file maks : 3 MB </li>
                                <li style="color:red;font-size:9px">Format yg diijinkan : pdf,jpg,jpeg,png</li>
                                
                            </ul>
                    </td>

                </tr>
            </table>-->
           
            <div id="div_upload_file">
                <table>
                    <tr>
                        <td>List Upload File</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <ul id="fileListSurveyUlok"><li>No Files Selected</li></ul>

                         </td>
                    </tr>
                </table>
            </div>
            <tr>
                
                <td  style="width: 220px">
                 
                    <a id="submit-survey-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                   
                </td>
      
                <td>
                    <a id="cancel-survey-ulok" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
            <tr>
                    <td><div id="div_amount_survey_ulok">
                         <input type="text" id="file_amount_survey" name="file_amount_survey" class="easyui-textbox" ></input>
                        </div>
                    </td>
            </tr>
        </table>
    </div>
</div>
<div id="modal-input-hasil-penyampaian-to" style="display:none; width:800px; height:auto; "class="easyui-window" title="INPUT TANGGAL PENYAMPAIAN PROPOSAL TO " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-lstf">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
             <tr>
              
                 <td style="width: 200px">
                    <div id="div_session_role_to"> 
                    <input type="text" id="session-role-to" name="session-role-to" class="easyui-textbox" style="width:200px;display:none;"value="<?php echo @$role_id; ?>" />
                    </div>
                </td>
            </tr>
            <tr> 
                <td style="width: 200px" >No Form</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="to-input-no-form" name="to-input-no-form" class="easyui-textbox" style="width:200px;" /></td>
                <td style="width: 15px"></td>
                <td style="width: 200px">Status Cabang</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="to_input_status_cabang" class="easyui-combobox" name="to_input_status_cabang" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">OK</option>
                        <option value="NOK">NOK</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr> 
                <td style="width: 200px" >Nama Franchisee</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="to-input-survey-nama" name="to-input-survey-nama" class="easyui-textbox" style="width:200px;" /></td>
                <td style="width: 15px"></td>
                <td style="width: 200px">Status HO</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="to_input_status_ho" class="easyui-combobox" name="to_input_status_ho" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">OK</option>
                        <option value="NOK">NOK</option>
                    </select>
                </td>
            </tr>
             <tr>
                <td style="width: 2px"></td>
            </tr>
             <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr>
                <td style="width: 220px">Tanggal Update Status Proposal TO Sold</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="to-input-survey-tgl-penyampai-survey" name="to-input-survey-tgl-penyampai-survey" class="easyui-datebox"  style="width:200px;" /></td>
            </tr>
             <tr>
                <td style="width: 2px"></td>
            </tr>
             <tr>
                <td style="width: 200px">Update Status Proposal TO Sold</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="to_input_status_ulok" class="easyui-combobox" name="to_input_status_ulok" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="OK">Lanjut TO</option>
                        <option value="NOK">Tdk Lanjut TO</option>
                    </select>
                </td>
                <td style="width: 15px"></td>
                <td style="width: 200px" >Alasan NOK</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="to-input-alasan-status-ulok" name="to-input-alasan-status-ulok" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
             
              <tr>
                <td style="width: 2px"><br></td>
            </tr>
          
            <tr>
                <td colspan="2">
                    <a id="submit-penyampaian-proposal-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>

                    <a id="cancel-penyampaian-proposal-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>               
                <td>
                </td>
            </tr>
             
        </table>

        
    </div>
</div>
<script type="text/javascript">

      $("#data-survey-ulok-toko").datagrid({
                url: 'Ulok/get_data_survey_ulok/',
                striped: true,
                rownumbers: true,
                remoteSort: true,
                singleSelect: false,
                pagination: true,
                fit: false,
                autoRowHeight: false,
                fitColumns: true,
                onSelect: function() {
                },
                onSelectAll: function() {
                },
                onUnselect: function() {
                },
                onUnselectAll: function() {

                },
                onDblClickRow: function() {


                },
                columns: [
                                [{
                                                                field: 'ck',
                                                                title: '',
                                                                checkbox: "true"
                                                }, {
                                                                field: 'FORM_ID',
                                                                hidden: "true"
                                                }, {
                                                                field: 'TIPE_FORM',
                                                                hidden: "true"
                                                }, {
                                                                field: 'FORM_NUM',
                                                                title: 'Form-ID',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'NAMA',
                                                                title: 'Nama Franchisee',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'STATUS_CABANG',
                                                                title: 'Status Cabang',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center",
                                                                formatter: function(value, row, index) {
                                                                                if (value.trim() == 'N') {

                                                                                                return "New";
                                                                                } else {
                                                                                                return value;
                                                                                }
                                                                }
                                                }, {
                                                                field: 'STATUS_HO',
                                                                title: 'Status Validate HO',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'TGL_SURVEY',
                                                                title: 'Tanggal Survey',
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
                                                                width: 200,
                                                                align: 'center',
                                                                formatter: function(value, row, index) {
                                                                var role=<?php echo $this->session->userdata('role_id')?>;
                                                                if(role=='3'){
                                                                    var p = ' <button href="javascript:void(0)" onclick="input_hasil_survey(this)" class="easyui-linkbutton">Lihat Hasil Survey</button>';
                                                                }else{
                                                                        var p = ' <button href="javascript:void(0)" onclick="input_hasil_survey(this)" class="easyui-linkbutton">Input Hasil Survey</button>';
                                                                }
                                                                            
                                                                return p;

                                                                }
                                                }

                                ]
                ]
   });
    $(document).ready(function() {
         var role=<?php echo $this->session->userdata('role_id')?>;
        $("#finalisasi-ulok").css("background","green");
        $("#submit-ulok").css("background","green");
        $('#submit-survey-ulok').css('background','green');
        $('#cancel-survey-ulok').css('background','red');
        $('#submit-penyampaian-proposal-to').css('background','green');
        $('#cancel-penyampaian-proposal-to').css('background','red');
        $('#div_session_role').hide();
        $('#div_session_form_id_field').hide();
        
         if(role=='4'){
            $('#finalisasi-ulok').show();
            $('#submit-ulok').hide();
            $('#submit-penyampaian-proposal-to').hide();
            $('#submit-survey-ulok').hide();
            
         }else if(role=='5'){

            $('#finalisasi-ulok').hide();
            $('#submit-survey-ulok').hide();
            
         }else if(role=='1'){
            $('#finalisasi-ulok').show();
            $('#submit-survey-ulok').hide();
            
         }else if(role=='3'){
            $('#submit-ulok').hide();
            $('#finalisasi-ulok').hide();
            $('#submit-penyampaian-proposal-to').hide();
            $('#submit-survey-ulok').hide();
         }else{
            $('#finalisasi-ulok').hide();
            $('#submit-ulok').hide();
         }

         
       
         
    });
</script>
      
    