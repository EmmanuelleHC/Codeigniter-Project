<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
        
   
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Listing Status ULOK Calon Franchisee (LSUF)" style="width:100%;padding:30px 60px;">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lsuf-cabang" name="generate-lsuf-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 35px">Periode</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lsuf-periode" name="generate-lsuf-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-lsuf" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white" >Submit</a>
                    <a id="cancel-req-lsuf" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        
            <tr>
                <td style="width: 35px"></td>
                 <td colspan="4"><div id="div_session_branch_id_lsuf"><input type="text" id="session-branch-id-lsuf" name="session-branch-id-lsuf" style="width:200px;" value="<?php echo @$branch_id; ?>"/><input type="text" id="session-role-lsuf" name="session-role-lsuf"  style="width:200px;" value="<?php echo @$role_id; ?>"/></div></td>
            </tr>
        </table>

    </div>
<script>
$('#submit-req-lsuf').css('background','green');
$('#cancel-req-lsuf').css('background','red');    
$('#div_session_branch_id_lsuf').hide();

$(document).ready(function() {
    /*    if ( document.getElementById('session-role-lsuf').value == '5' || document.getElementById('session-role-lsuf').value== '2') {
    $('#generate-lsuf-cabang').combobox('select', document.getElementById('session-branch-id-lsuf').value);

            //     $('#generate-lsuf-cabang').combobox('readonly', true);
                                               
                                          
        } */

$("#submit-req-lsuf").click(function(event) {
    event.preventDefault();
    var cabang = $('#generate-lsuf-cabang').combobox('getValue');
    var periode = $('#generate-lsuf-periode').combobox('getValue');
    if (cabang != '' && periode != '') {
        $.ajax({
            url: 'Ulok/count_listing_status_ulok/',
            type: 'POST',
            async: false,
            data: {
                cabang: cabang,
                periode: periode
            },
            success: function(msg) {

                if (msg > 0) {
                    window.open('Ulok/print_listing_status_ulok_calon_franchisee/' + cabang + '/' + periode);

                } else {

                    $.messager.alert('Warning', 'Tidak ada data baru');
                }
            }
        });
    } else {
        $.messager.alert('Warning', 'Parameter tidak lengkap');

    }
});

$("#cancel-req-lsuf").click(function(event) {
      event.preventDefault();
      $('#generate-lsuf-cabang').combobox('select', '');
      $('#generate-lsuf-periode').combobox('select', '');
  });
    
});

</script>


