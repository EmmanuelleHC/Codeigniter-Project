<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>

        
   
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Listing Monitoring Uang Muka ULOK / TO  (LMDO)" style="width:100%;padding:30px 60px;">
        <table>
             <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr> 
                <td style="width: 35px" >Cabang</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lmdo-cabang" name="generate-lmdo-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all/'" style="width:200px;" /></td>
            </tr>
            <tr>
                <td style="width: 35px">Periode</td>
                <td style="width: 35px">:</td>
                <td style="width: 35px"> <input type="text" id="generate-lmdo-periode" name="generate-lmdo-periode" class="easyui-combobox" data-options="valueField:'PERIOD_NUM',textField:'PERIOD_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_period/'" style="width:200px;" /></td>
            </tr>
         
            <tr style="width: 35px" >
                <td style="width: 35px"><br></td>
            </tr>
            <tr>
                <td style="width: 35px"></td>
                <td colspan="4">
                    <a id="submit-req-lmdo" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-print'" style="font-weight: bold;font-size:50px;height:30px;color:white" >Submit</a>
                    <a id="cancel-req-lmdo" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'" style="font-weight: bold;font-size:50px;height:30px;color:white">Cancel</a>
                </td>
            </tr>
        
          <tr>
                <td style="width: 35px"></td>
                 <td colspan="4"><div id="div_session_branch_id_lmdo"><input type="text" id="session-branch-id-lmdo" name="session-branch-id-lmdo" class="easyui-textbox" style="width:200px;" value="<?php echo @$branch_id; ?>"/><input type="text" id="session-role-lmdo" name="session-role-lmdo" class="easyui-textbox" style="width:200px;" value="<?php echo @$role_id; ?>"/></div></td>
            </tr>
        </table>

    </div>





<script>

      

         $('#submit-req-lmdo').css('background','green');
         $('#cancel-req-lmdo').css('background','red');
        $('#div_session_branch_id_lmdo').hide();
    

    $(document).ready(function() {
        if (document.getElementById('session-role-lmdo').value== '5' || document.getElementById('session-role-lmdo').value == '2') {
                 $('#generate-lsuf-cabang').combobox('select', document.getElementById('session-branch-id-lmdo').value);
           //      $('#generate-lsuf-cabang').combobox('readonly', true);
                                               
                                          
        }else if(document.getElementById('session-role-lmdo').value=='4'){
                        /*
                $.ajax({
                            url: 'Ulok/get_branch_from_region/',
                            type: 'POST',
                            async: false,
                            data: {
                                region: region
                            },
                            success: function(msg) {
                                var hasil_cbg = JSON.parse(msg);
                                  $('#cc2').combobox('reload',get_branch_from_region);

                               

                            }
                        });
                                  
                */
                                   
        }


        $("#submit-req-lmdo").click(function(event) {
                                event.preventDefault();
                                var cabang = $('#generate-lmdo-cabang').combobox('getValue');
                                var periode = $('#generate-lmdo-periode').combobox('getValue');
                                if(cabang !='' && periode !=''){

                                    $.ajax({
                                        url: 'Ulok/count_data_lmdo/',
                                        type: 'POST',
                                        async: false,
                                        data: {
                                            cabang: cabang,
                                            periode: periode
                                          },
                                    success: function(msg) {

                                            if (msg > 0) {
                                                    window.open('Ulok/print_laporan_monitoring_uangmuka/' + cabang + '/' + periode);
                                    
                                            }else{

                                                    $.messager.alert('Warning', 'Tidak ada data baru');
                                            }
                                        }
                                    });   
                                }else {
                                                $.messager.alert('Warning', 'Parameter tidak lengkap');

                                }
                });

          $("#cancel-req-lmdo").click(function(event) {
                                event.preventDefault();
                                $('#generate-lmdo-cabang').combobox('select', '');
                                $('#generate-lmdo-periode').combobox('select', '');
                });
        
    
    });

</script>


