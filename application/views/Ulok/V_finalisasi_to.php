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
	<h2>Finalisasi TO</h2>
	<hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>

<div id="inq-hasil-status-to" class="easyui-layout" style="height:100px;width:70%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:100px;padding:5px;">
        <table>
            <tr>
                <td>No. Form</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-form-status-to" name="search-form-status-to" class="easyui-textbox" style="width:215px;"></input>
                </td>
                <td style="width: 35px"></td>
 
               
                <td colspan="5"></td>
                <td colspan="6">
                    <a id="search-inq-status-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'" style="width:100px">Search</a>
                  
                    <a id="clear-inq-status-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="width:100px">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc-status-to" class="easyui-layout" style="height:500px;width:70%">
     <div data-options="region:'north',title:'Finalisasi Status To (Hangus atau Dikembalikan)'" style="height:200px;padding:5px;">
        <div style="float:left;display: block;">
        <!--    <a id="kirim-email" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-checked'">Email ke Location</a>
        -->
        </div>
        <div style="float:right;display: block;">
        
            <a id="finalisasi-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-checked'" style="font-weight:bold;color:white">Finalisasi</a>
        
        </div>
        <br><br>
        <hr>
          <table class="easyui-datagrid" id="data-status-to"style=";width:90%"></table>
    </div>
</div> 
<div id="modal-finalisasi-to" style="display:none; width:800px; height:auto; "class="easyui-window" title="FINALISASI STATUS TO" data-options="modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <div id="div_finalisasi_to">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
              <tr>
                <td style="width: 200px">
                <div id="div_form_id"> <input type="text" id="form-id" name="form-id" class="easyui-textbox" style="width:200px;display:none;" />
                </div>
                </td>
               
            </tr>
            <tr> 
                <td style="width: 200px" >No Form</td>
                <td style="width: 15px">:</td>
                <td style="width: 200px"> <input type="text" id="no-form-to" name="no-form-to" class="easyui-textbox" style="width:200px;" /></td>
                <td style="width: 15px"></td>
            </tr>
            <tr>
                <td style="width: 200px">Status Akhir</td>
                <td style="width: 15px">:</td>
                <td>
                    <select id="status-cabang-to" class="easyui-combobox" name="status-cabang-to" style="width:200px;" data-options="panelHeight:'auto'">
                        <option value=""></option>
                        <option value="FINAL-NOK">FINAL-NOK</option>
                        <option value="HANGUS">HANGUS</option>
                    </select>
                </td>
            </tr>

            <tr><td><br></td></tr>
            <tr>
                <td colspan="2">
                    <a id="submit-status-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white">Submit</a>
                    <a id="cancel-status-to" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>               
                <td>
                </td>
            </tr>
             
        </table>

        
    </div>
</div>

<script type="text/javascript">
 $("#data-status-to").datagrid({
     url: 'Ulok/get_data_finalisasi_to/',
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
                 field: 'FORM_ID',
                 hidden: "true"
             }, {
                 field: 'TO_FORM_NUM',
                 title: 'Form-ID',
                 width: 50,
                 align: "center",
                 halign: "center"
             }, {
                 field: 'STATUS_CABANG',
                 title: 'Status Cabang',
                 width: 50,
                 align: "center",
                 halign: "center",
                 formatter: function(value, row, index) {
                     if (value.trim() == 'N') {

                         return "New";
                     } else {
                         return value;
                     }
                 }
             }

         ]
     ]
 });
    $(document).ready(function() {
         var role=<?php echo $this->session->userdata('role_id')?>;
        $("#finalisasi-to").css("background","green");
       $('#div_form_id').hide();
        $('#submit-status-to').css('background','green');
        $('#cancel-status-to').css('background','red');
         if(role=='3'){
            $('#finalisasi-to').show();
         }else{
            $('#finalisasi-to').hide();
         }

         
       
         
    });
</script>
      
    