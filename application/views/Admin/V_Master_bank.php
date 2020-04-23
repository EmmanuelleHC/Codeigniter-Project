<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>
<div>
	<h2>Master Bank</h2>
	<hr>
    <a id="add-master-bank" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add</a>
    <a id="delete-master-bank" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-remove'">Delete</a>
    <table class="easyui-datagrid" id="dt-master-bank" style="width:70%"></table>
</div>

<div id="modal-add-bank" class="easyui-window" title="Add Master Bank" style="width:376px; height:150px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
	<form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Nama Bank</td>
                <td>
                	<input type="hidden" id="bank-id" value="">
                	<input type="text" id="bank-name" name="bank-name" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
           <!--  <tr>
                <td>Kode Bank</td>
                <td><input type="text" id="bank-code" name="bank-code" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr> -->
           <!-- <tr>
                <td>Account Number</td>
                <td><input type="text" id="account-number" name="account-number" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>
            <tr>
                <td>Account Name</td>
                <td><input type="text" id="account-name" name="account-name" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
            </tr>-->
            <tr>
                <td><br></td>
                <td><a href="" id="save-bank" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a></td>
            </tr>
        </table>
    </form>
</div>