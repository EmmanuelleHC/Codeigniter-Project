<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/normalize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/main.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/jstep/jquery.steps.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/modernizr-2.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jstep/jquery.steps.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ulok.inq.js"></script>

<div>
    <h2>Inquiry Berita Acara Pengakuan Pendapatan (BAPP)</h2>
    <hr>
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<div id="cc-inq-bapp" class="easyui-layout" style="height:140px;width:100%">
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Filter'" style="height:150px;padding:5px;">
        <table>
            <tr>
                <td>No. BAPP</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-bapp-no" name="search-bapp-no" class="easyui-textbox" style="width:200px;"></input>
                </td>

                
                <td colspan="5"></td>
                <td colspan="4">
                    <a id="search-inq-bapp" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
                    <a id="clear-inq-bapp" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
                </td>
                
            </tr>
      
          
        </table>
    </div>
</div>
<div id="cc-datagrid-lduk" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;">
        
      
        <div id="div_session_role">
          <input type="text" id="session_role" name="session_role" value="<?php echo @$session_role; ?>"  style="display: none" ></input>
        </div>
        <br><br>
        <hr>
        <table class="easyui-datagrid" id="data-list-bapp" style="width:100%"></table>
    </div>

</div> 

<script type="text/javascript">

    function lihat_bapp(){
        var data=$('#data-list-bapp').datagrid('getSelected');
        if(data){

            window.open('Ulok/print_form_bapp/' + data.BAPP_ID);
        }
    }
  
    $("#data-list-bapp").datagrid({
                url: 'Ulok/get_data_list_bapp/',
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
                                [ {
                                                                field: 'BAPP_ID',
                                                                hidden: "true"
                                                }, {
                                                                field: 'BAPP_NUM',
                                                                title: 'No BAPP',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center"
                                                },{
                                                                field: 'FORM_NUM',
                                                                title: 'Form Num',
                                                                width: 150,
                                                                align: "center",
                                                                halign: "center"
                                                }, {
                                                                field: 'TGL_BAPP',
                                                                title: 'Tanggal BAPP',
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
                                                                width: 100,
                                                                align: 'center',
                                                                formatter: function(value, row, index) {
                                                                                var p = ' <button href="javascript:void(0)" onclick="lihat_bapp(this)" class="easyui-linkbutton">View Report</button>';
                                                                                return p;

                                                                }
                                                }

                                ]
                ]
   });
     $(document).ready(function() {
         var role=<?php echo $this->session->userdata('role_id')?>;

          $("#clear-inq-bapp").click(function(event) {
            $('#data-list-bapp').datagrid('reload');
            $('#search-bapp-no').textbox('setValue','');
            $('#data-list-bapp').datagrid('load', {
                bapp: null
            });

        });
       


        $("#search-inq-bapp").click(function(event) {
       
            var noform=$('#search-bapp-no').textbox('getValue');
            if (noform=='') {
                            $.messager.alert('Warning', 'Harap parameter di isi terlebih dahulu');
            } else if (noform != "" ) {
                            doSearchBAPP();
                            }

        });
    
        
     });
</script>