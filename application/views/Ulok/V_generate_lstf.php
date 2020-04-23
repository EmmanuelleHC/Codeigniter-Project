<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/accounting.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>
        
   
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Listing Status TO Calon Franchisee (LSTF)" style="width:100%;padding:30px 60px;">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lstf-cabang" name="generate-lstf-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 35px">Periode</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lstf-periode" name="generate-lstf-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-lstf" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white" >Submit</a>
                    <a id="cancel-req-lstf" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        
            <tr>
                <td style="width: 35px"></td>
                 <td colspan="4"><div id="div_session_branch_id_lstf">
                    <input type="text" id="session-branch-id-lstf" name="session-branch-id-lstf"  class="easyui-textbox" style="width:200px;" value="<?php echo @$branch_id; ?>"/>
                    <input type="text" id="session-role-lstf" name="session-role-lstf" style="width:200px;" value="<?php echo @$role_id; ?>"/></div></td>
            </tr>
        </table>

    </div>





<script>

    

         $('#submit-req-lstf').css('background','green');
         $('#cancel-req-lstf').css('background','red');
    
   
            $('#div_session_branch_id_lstf').hide();

    $(document).ready(function() {
      /*  if (document.getElementById('session-role-lstf').value== '5' || document.getElementById('session-role-lstf').value == '2') {
                 $('#generate-lstf-cabang').combobox('select',$).value);
               //  $('#generate-lstf-cabang').combobox('readonly', true);
                                               
                                             
        } 
*/

        $("#submit-req-lstf").click(function(event) {
                                event.preventDefault();
                                var cabang = $('#generate-lstf-cabang').combobox('getValue');
                                var periode = $('#generate-lstf-periode').combobox('getValue');
                                if (cabang != '' && periode != '') {
                                   

                                            $.ajax({
                                        url: 'Ulok/count_listing_status_to/',
                                        type: 'POST',
                                        async: false,
                                        data: {
                                            cabang: cabang,
                                            periode: periode
                                          },
                                    success: function(msg) {

                                            if (msg > 0) {
                                                     window.open('Ulok/print_listing_status_to_calon_franchisee/' + cabang + '/' + periode);
                                    
                                            }else{

                                                    $.messager.alert('Warning', 'Tidak ada data baru');
                                            }
                                        }
                                    }); 

                                             
                                              
                                } else {
                                                $.messager.alert('Warning', 'Parameter tidak lengkap');

                                }
                });

          $("#cancel-req-lstf").click(function(event) {
                                event.preventDefault();
                                $('#generate-lstf-cabang').combobox('select', '');
                                $('#generate-lstf-periode').combobox('select', '');
                });
        
    
    });

</script>


