<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<div>
	<h2>Master Role</h2>
	<hr>
    <a id="add-master-role" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add</a>
    <table class="easyui-datagrid" id="dt-master-role"></table>
</div>

<div id="modal-add-role" class="easyui-window" title="Add Master Role" style="width:376px; height:165px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
	<form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Nama Role</td>
                <td>
                	<input type="hidden" id="role-id" value="">
                	<input type="text" id="role-name" name="role-name" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Deskripsi Role</td>
                <td><input type="text" id="role-desc" name="role-desc" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="" id="save-role" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a></td>
            </tr>
        </table>
    </form>
</div>