<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>
<div>
	<h2>Inquiry Laporan Penerimaan Uang Muka ULOK dari Calon Franchisee (LPDU)</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<div id="cc-inq-lpdu" class="easyui-layout" style="height:140px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
		<table>
			<tr>
				<td>No. LPDU </td>
				<td style="width: 15px"></td>
				<td>
					<input type="text" id="search-lpdu-no" name="search-lpdu-no" class="easyui-textbox" style="width:200px;"></input>
				</td>
				<td style="width: 35px"></td>
				<td>Cabang</td>
                <td style="width: 15px"></td>
                <td> <input type="text" id="search-lpdu-cabang" name="search-lpdu-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all_lpdu/'" style="width:200px;" /></td>
                <td style="width: 35px"></td>
                <td>Periode</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-lpdu-periode" name="search-lpdu-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" />
                </td>
                
				
			</tr>
            <tr><td><br></td></tr>
			<tr> 
                    <td colspan="5"></td>
				<td colspan="4">
                    <a id="search-inq-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                     <a id="clear-inq-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'"style="width:100px">Clear</a>
                </td>
				<!--<td>Region</td>
				<td style="width: 15px"></td>
				<td style="width: 35px"> <input type="text" id="search-lpdu-region" name="search-lpdu-region" class="easyui-combobox" data-options="valueField:'REGION_ID',textField:'REGION_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_region/',panelHeight:'auto'" style="width:200px;" /></td>
						<td style="width: 35px"></td>-->
				
                 
			</tr>
         
		</table>
    </div>
</div>
<div id="cc-datagrid-lpdu" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;">
    	
         <div style="float:left;display: block;">
            
            <a id="generate-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight:bold;color:white">Generate NEW LPDU</a>
        </div>
    	<div style="float:right;display: block;">
            <!--
            <a id="validasi-lpdu" href="#" class="easyui-linkbutton" onclick="validasilpdu()" data-options="iconCls:'icon-ess-checked'">Validasi LPDU</a>-->
        </div>
        <div id="div_session_role">
          <input type="text" id="session_role" name="session_role" value="<?php echo @$session_role; ?>" style="display: none"></input>
          </div>
        <br><br>
        <hr>
		<table class="easyui-datagrid" id="data-list-lpdu" style="width:100%"></table>
    </div>

</div> 
<div id="modal-generate-lpdu" style="display:none; width:500px; height:auto; "class="easyui-window" title="GENERATE LAPORAN PENERIMAAN UANG MUKA LOKASI DARI CALON FRANCHISEE " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="req-lpdu">
        <table>
             <tr>
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px">LPDU</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px"> <input type="text" id="lpdu" name="lpdu" class="easyui-textbox" style="width:210px;" disabled="true"></input></td>
            </tr>
            <tr>
                <td style="width: 2px"></td>
            </tr>
            <tr> 
                <td style="width: 35px">Cabang</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px"> <input type="text" id="generate-lpdu-cabang" name="generate-lpdu-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all_lpdu/'" style="width:210px;" /></td>
            </tr>
            <tr>
                <td style="width: 5px"></td>
            </tr>
        <!--    <tr>
                <td style="width: 50px">Region</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px"><input type="text" id="generate-lpdu-region" name="generate-lpdu-region" class="easyui-combobox" data-options="valueField:'REGION_ID',textField:'REGION_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_region/',panelHeight:'auto'" style="width:210px;" /></td>
            </tr>-->
            <tr>
                <td style="width: 5px"></td>
            </tr>
            <tr>
                
                <td style="width: 50px">Periode</td>
                <td style="width: 15px">:</td>
                <td style="width: 250px">
                    <input type="text" id="generate-lpdu-periode" name="generate-lpdu-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:210px;" /></td>
            </tr>
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-generate-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-req-generate-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="otp-validasi-lpdu" style="display:none; width:400px; height:auto; "class="easyui-window" title="Validate LPDU " data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="otp-lpdu">
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
                <td style="width: 35px"> <input type="password" id="input-otp-lpdu" name="input-otp-lpdu" class="easyui-textbox" style="width:200px;" /></td>
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
                    <a id="submit-otp-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'">Submit</a>
                    <a id="cancel-otp-lpdu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Cancel</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
$('#generate-lpdu').css("background","red");
$('#submit-req-generate-lpdu').css("background","green");
$('#cancel-req-generate-lpdu').css("background","red");
$("#data-list-lpdu").datagrid({
     url: 'Ulok/get_data_list_lpdu/',
     striped: true,
     rownumbers: true,
     remoteSort: true,
     singleSelect: false,
     pagination: true,
     fit: false,
     autoRowHeight: false,
     fitColumns: true,
     onSelect: function() {
         //  var rows = $(this).datagrid('getSelections');
     },
     onSelectAll: function() {
         //  var rows = $(this).datagrid('getSelections');
     },
     onUnselect: function() {
         //  var rows = $(this).datagrid('getSelections');
     },
     onUnselectAll: function() {

     },
     onDblClickRow: function() {


     },
     columns: [
         [

             {
                 field: 'ck',
                 title: '',
                 checkbox: "true"
             }, {
                 field: 'LPDU_ID',
                 hidden: true
             }, {
                 field: 'LPDU_NUM',
                 title: 'No LPDU',
                 width: 150,
                 align: "center",
                 halign: "center"
             }, {
                 field: 'TGL_LPDU',
                 title: 'Tanggal LPDU',
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
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value == null) {
                         return "All Cabang";
                     } else {
                         return value;
                     }
                 }

             }, {
                 field: 'REGION_NAME',
                 title: 'Region',
                 width: 150,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value == null) {
                         return "All Region";
                     } else {
                         return value;
                     }
                 }
             }, {
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
                 field: 'action',
                 title: 'Action',
                 width: 100,
                 align: 'center',
                 formatter: function(value, row, index) {
                     var p = ' <button href="javascript:void(0)" onclick="lihat_lpdu(this)" class="easyui-linkbutton">View</button>';
                     return p;

                 }
             }

         ]
     ]
 });



</script>
