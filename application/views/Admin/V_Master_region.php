<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<div>
	<h2>Master Region-Branch</h2>
	<hr>
    <a id="add-master-region" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'"  style="height:30px;width:200px;" >Add Region</a>
    <br>
    <table class="easyui-datagrid" id="dt-master-region"></table>
    <br>
    <br>
    <a id="add-master-branch-region" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'"  style="height:30px;width:200px;">Add Branch-Region</a>
    <hr>
    <br>
    <table class="easyui-datagrid" id="dt-master-region-branch"></table>
    <br>
</div>

<div id="modal-add-region" class="easyui-window" title="Add Master Region" style="width:auto; height:auto; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
	<form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Kode Region</td>
                <td>
                	<input type="text" id="region-code" name="region-code" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Nama Region</td>
                <td><input type="text" id="region-name" name="region-name" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="" id="save-region" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a></td>
            </tr>
            <tr>
                <td>
                    <div id ="region-base"><input type="text" id="region-id" name="region-id" class="easyui-textbox" style="height:30px;width:200px;"></input>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>


<div id="modal-add-region-branch" class="easyui-window" title="Add Master Region-Branch" style="width:auto; height:auto; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
    <form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Cabang</td>
                <td>
                    <input type="text" id="branch" name="branch" class="easyui-combobox" data-options="required:true, valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url('Admin/get_data_branch_available'); ?>'" style="height:20px;width:300px;"></input>
                  <!-- <input type="text" id="branch" name="branch" class="easyui-combobox" data-options="required:true, valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url('Admin/get_data_branch_available'); ?>'" style="height:20px;width:300px;"></input>-->
                </td>
            </tr>
            <tr>
                <td>Region</td>
                <td>    <input type="text" id="region" name="region" class="easyui-combobox" data-options="required:true, valueField:'REGION_ID',textField:'REGION',url:'<?php echo base_url('Admin/get_data_region'); ?>'" style="height:20px;width:300px;"></input>
                </td>
            </tr>
            <tr>
                <td> <div id="region-branch-base">
                    <input type="text" id="branch-region-id" name="branch-region-id" class="easyui-textbox" style="height:30px;width:200px;"></input>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="" id="save-region-branch" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a>
                   
                </td>
            </tr>
        </table>
    </form>
</div>