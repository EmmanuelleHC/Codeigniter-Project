<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<div>
	<h2>Master Menu</h2>
	<hr>
    <a id="add-master-menu" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add</a>
    <table class="easyui-datagrid" id="dt-master-menu" ></table>
</div>

<div id="modal-add-mm" class="easyui-window" title="Add Master Menu" style="width:390px; height:232px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
	<form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Nama Menu</td>
                <td>
                	<input type="hidden" id="mm-id" value="">
                	<input type="text" id="menu-name" name="menu-name" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Deskripsi Menu</td>
                <td><input type="text" id="menu-desc" name="menu-desc" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td>Url</td>
                <td><input type="text" id="menu-url" name="menu-url" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td>Attribute ID</td>
                <td><input type="text" id="menu-attr" name="menu-attr" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="" id="save-mm" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a></td>
            </tr>
        </table>
    </form>
</div>