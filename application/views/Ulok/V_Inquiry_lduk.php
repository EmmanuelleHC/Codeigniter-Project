<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>

<div>
	<h2>Inquiry Laporan Uang Muka ULOK yang Harus Dikembalikan ke Calon Franchisee (LDUK)</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<div id="cc-inq-lduk" class="easyui-layout" style="height:140px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
		<table>
			<tr>
				<td>No. LDUK </td>
				<td style="width: 15px"></td>
				<td>
					<input type="text" id="search-lduk-no" name="search-lduk-no" class="easyui-textbox" style="width:200px;"></input>
				</td>
				<td style="width: 35px"></td>
				<td>Cabang</td>
                <td style="width: 15px"></td>
                <td> <input type="text" id="search-lduk-cabang" name="search-lduk-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
                    <td style="width: 35px"></td>
                <td>Periode</td>
                <td style="width: 15px"></td>
                <td> <input type="text" id="search-periode-lduk" name="show-periode-lduk" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
                <td style="width: 35px"></td>
				
			</tr>
			<tr>
				
				<!--<td>Region</td>
				<td style="width: 15px"></td>
				<td style="width: 35px"> <input type="text" id="search-region-lduk" name="search-region-lduk" class="easyui-combobox" data-options="valueField:'REGION_ID',textField:'REGION_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_region/',panelHeight:'auto'" style="width:200px;" /></td>
				<td style="width: 35px"></td>
				<td colspan="3">
					<a id="search-inq-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
					<a id="clear-inq-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
				</td>-->
			</tr>
            <tr><td><br></td></tr>
            <tr> 
                <td colspan="5"></td>
                <td colspan="4">
                    <a id="search-inq-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
                    <a id="clear-inq-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
                </td>
                <!--<td>Region</td>
                <td style="width: 15px"></td>
                <td style="width: 35px"> <input type="text" id="search-lpdu-region" name="search-lpdu-region" class="easyui-combobox" data-options="valueField:'REGION_ID',textField:'REGION_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_region/',panelHeight:'auto'" style="width:200px;" /></td>
                        <td style="width: 35px"></td>-->
                
                 
            </tr>
		</table>
    </div>
</div>
<div id="cc-datagrid-lduk" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;">
    	
        <div style="float:left;display: block;">
            
            <a id="generate-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight:bold;color:white">Generate NEW LDUK</a>
        </div>

        <div  id="lduk" style="float:right;display: block;">
            
            <a id="validasi-lduk" href="#" class="easyui-linkbutton" onclick="validasilduk()" data-options="iconCls:'icon-ess-checked'" style="font-weight:bold;color:white">Validasi LDUK</a>
        </div>
        <div id="div_session_role">
          <input type="text" id="session_role" name="session_role" value="<?php echo @$session_role; ?>"  style="display: none" ></input>
        </div>
    	<br><br>
    	<hr>
		<table class="easyui-datagrid" id="data-list-lduk" style="width:100%"></table>
    </div>

</div> 
<div id="otp-validasi-lduk" style="display:none; width:400px; height:auto; "class="easyui-window" title="Validate LDUK " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="otp-lduk">
        <table>
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
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
                <td style="width: 35px"> <input type="text" id="input-ref-num" name="input-ref-num" class="easyui-textbox" style="width:200px;" readonly="true" /></td>
            </tr>
            <tr> 
                <td style="width: 100px" >Input OTP</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="password" id="input-otp-lduk" name="input-otp-lduk" class="easyui-textbox" style="width:200px;" /></td>
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
                    <a id="submit-otp-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-otp-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="modal-generate-lduk" style="display:none; width:500px; height:auto; "class="easyui-window" title="LAPORAN UANG MUKA ULOK YANG HARUS DIKEMBALIKAN KE CALON FRANCHISEE " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-lduk">
        <table>
             <tr>
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px">LDUK</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px"> <input type="text" id="lduk_num"  class="easyui-textbox" style="width:210px;" disabled="true"></input></td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="generate-lduk-cabang" name="generate-lduk-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:210px;" /></td>
            </tr>
            <tr>
                <td style="width: 5px"></td>
            </tr>
           <!-- <tr>
                <td style="width: 50px">Region</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px"><input type="text" id="generate-lduk-region" name="generate-lduk-region" class="easyui-combobox" data-options="valueField:'REGION_ID',textField:'REGION_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_region/',panelHeight:'auto'" style="width:210px;" /></td>
            </tr>-->
            <tr>
                <td style="width: 5px"></td>
            </tr>
            <tr>
                <td style="width: 50px">Periode</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="generate-lduk-periode" name="generate-lduk-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:210px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-generate-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'"  style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-req-generate-lduk" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    $("#submit-req-generate-lduk").css("background","green");
    $("#cancel-req-generate-lduk").css("background","red");
    $('#validasi-lduk').css("background","green");
    $('#generate-lduk').css("background","red");
    $('#submit-otp-lduk').css('background','green');
    $('#cancel-otp-lduk').css('background','red');
    $("#data-list-lduk").datagrid({
     url: 'Ulok/get_data_list_lduk/',
     striped: true,
     rownumbers: true,
     remoteSort: true,
     singleSelect: false,
     pagination: true,
     fit: false,
     autoRowHeight: false,
     fitColumns: true,
     onSelect: function() {},
     onSelectAll: function() {},
     onUnselect: function() {},
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
                 field: 'LDUK_NUM',
                 title: 'No LDUK',
                 width: 150,
                 align: "center",
                 halign: "center"
             },
             {
                                                                field: 'PERIODE',
                                                                title: 'Periode',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center",
                                                                formatter: function(value, row, index) {
                                                                                if (value == null) {
                                                                                                return "";
                                                                                } else {
                                                                                                return value;
                                                                                }
                                                                }
                                                }, {
                 field: 'TGL_LDUK',
                 title: 'Tanggal LDUK',
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
                 field: 'BRANCH_NAME',
                 title: 'Cabang',
                 width: 150,
                 align: "center",
                 halign: "center"
             }, {
                 field: 'action',
                 title: 'Action',
                 width: 100,
                 align: 'center',
                 formatter: function(value, row, index) {
                     var p = ' <button href="javascript:void(0)" onclick="lihat_lduk(this)" class="easyui-linkbutton">View Report</button>';
                     return p;

                 }
             }

         ]
     ]
 });
     $(document).ready(function() {
         var role=<?php echo $this->session->userdata('role_id')?>;

          if(role=='3'){
            $('#lduk').show();
            
         }else {

            $('#lduk').hide();
            
         }
     });
</script>