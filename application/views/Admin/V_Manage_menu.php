<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<div>
	<h2>Menu</h2>
	<hr>
    <a id="add-menu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add Menu</a>
    <table class="easyui-datagrid" id="dt-manage-menu-h"></table>
    <h2>Menu Detail</h2>
	<hr>
    <a id="add-menu-detail" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add Detail</a>
    <table class="easyui-datagrid" id="dt-manage-menu-l"></table>

    <div id="modal-add-menu" class="easyui-window" title="Add Menu" style="width:407px; height:234px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
		<form method="post">
	        <table cellpadding="" align="center">
	        	<tr>
	                <td>Role</td>
	                <td>
	                	<input type="hidden" id="h-menu-id" value="">
	                	<input type="text" id="h-role" name="mast-menu-name" class="easyui-combobox" data-options="valueField:'ROLE_ID',textField:'ROLE_NAME',url:'<?php echo base_url(); ?>Admin/get_data_role/'" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr>
	                <td>Detail</td>
	                <td>
                	    <select id="h-is-detail" class="easyui-combobox" style="height:30px;width:200px;">
					        <option value=""></option>
					        <option value="Y">Y</option>
					        <option value="N">N</option>
					    </select>
	                </td>
	            </tr>
	            <tr id="disp-h-name" style="display: none;">
	                <td>Nama Menu</td>
	                <td>
                	    <input type="text" id="h-menu-name" name="menu-name" class="easyui-textbox" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr id="disp-h-desc" style="display: none;">
	                <td>Deskripsi Menu</td>
	                <td>
                	    <input type="text" id="h-menu-desc" name="menu-desc" class="easyui-textbox" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr id="disp-h-mast" style="display: none;">
	            	<td>Nama Master Menu</td>
	                <td>
	                	<input type="text" id="h-mast-menu-name" name="mast-menu-name" class="easyui-combobox" data-options="valueField:'MASTER_MENU_ID',textField:'MENU_NAME',url:'<?php echo base_url(); ?>Admin/get_data_master_menu2/'" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr>
	                <td></td>
	                <td>
	                	<a href="" id="h-save" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a>
	                	<a href="" id="h-delete" class="easyui-linkbutton" data-options="iconCls:'icon-ess-remove'" style="display: none;">Delete</a>
	                </td>
	            </tr>
	        </table>
	    </form>
	</div>

    <div id="modal-add-menu-detail" class="easyui-window" title="Add Master Menu" style="width:407px; height:168px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
		<form method="post">
	        <table cellpadding="" align="center">
	            <tr>
	                <td>Nama Menu</td>
	                <td>
	                	<input type="hidden" id="l-menu-det-id" value="">
	                	<input type="hidden" id="l-menu-id" value="">
	                	<input type="text" id="l-menu" name="menu-name" class="easyui-combobox" data-options="valueField:'MENU_ID',textField:'MENU_NAME',url:'<?php echo base_url(); ?>Admin/get_data_menu/'" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr>
	                <td>Nama Master Menu</td>
	                <td>
	                	<input type="text" id="l-mast-menu-name" name="mast-menu-name" class="easyui-combobox" data-options="valueField:'MASTER_MENU_ID',textField:'MENU_NAME',url:'<?php echo base_url(); ?>Admin/get_data_master_menu2/'" style="height:30px;width:200px;"></input>
	                </td>
	            </tr>
	            <tr>
	                <td></td>
	                <td>
	                	<a href="" id="l-save" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a>
	                	<a href="" id="l-delete" class="easyui-linkbutton" data-options="iconCls:'icon-ess-remove'" style="display: none;">Delete</a>
	                </td>
	            </tr>
	        </table>
	    </form>
	</div>
</div>