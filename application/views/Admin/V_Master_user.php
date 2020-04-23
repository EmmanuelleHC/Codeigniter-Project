<script type="text/javascript" src="<?php echo base_url();?>assets/js/admin.js"></script>

<div id="cc-to-toko" class="easyui-layout" style="height:110px;width:100%">

    <h2>Master User</h2>
    <hr>
    <div data-options="iconCls:'icon-ess-filter',region:'north',title:'Master User'" style="height:150px;padding:5px;">
        <table>
            <tr>

                <td>Nik</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-nik" name="search-nik" class="easyui-textbox" style="width:200px;"></input>
                </td>
                <td style="width: 35px"></td>
                <td>Username</td>
                <td style="width: 15px"></td>
                <td>
                    <input type="text" id="search-username" name="search-username" class="easyui-textbox" style="width:200px;"></input>
                </td>
          
                
            </tr>
            <tr>
                  <td>Branch</td>
                <td style="width: 15px"></td>
                <td>
                     <input type="text" id="search-cabang" name="search-cabang" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Ulok/get_data_cabang_all_w_HO/'" style="width:200px;" />
                </td>
                <td style="width: 35px"></td>
                <td>Role</td>
                <td style="width: 15px"></td>
                <td>
                     <input type="text" id="search-role" name="search-role" class="easyui-combobox" data-options="valueField:'ROLE_ID',textField:'ROLE_NAME',url:'<?php echo base_url(); ?>Ulok/get_data_role/'" style="width:200px;" />
                </td>
                        <td style="width: 35px"></td>
                <td colspan="3">
                    <a id="search-inq-user" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-search'">Search</a>
                    <a id="clear-inq-user" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-error'">Clear</a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div id="cc-user" class="easyui-layout" style="height:500px;width:100%">
    <div data-options="region:'north',title:'Data'" style="height:450px;padding:5px;">
        <div style="float: right;display: block;">
          
        </div>
        <div style="float:left;display: block;">

    <a id="add-master-user" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ess-add'">Add</a>
        </div>
        <br><br>
        <hr>
           <table class="easyui-datagrid" id="dt-master-user"></table>
    </div>
</div> 

<div id="modal-add-user" class="easyui-window" title="Add Master User" style="width:376px; height:360px; padding:10px; top:250px;" data-options="iconCls:'icon-ess-add',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
	<form action="" method="post">
        <table cellpadding="" align="center">
            <tr>
                <td>Branch</td>
                <td>
                	<input type="hidden" id="user-id" value="">
                	<input type="text" id="u-branch" name="user-role" class="easyui-combobox" data-options="valueField:'BRANCH_ID',textField:'BRANCH',url:'<?php echo base_url(); ?>Admin/get_data_branch/'" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Role</td>
                <td>
                    <input type="text" id="u-role" name="user-role" class="easyui-combobox" data-options="valueField:'ROLE_ID',textField:'ROLE_NAME',url:'<?php echo base_url(); ?>Admin/get_data_role/'" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>
                    <input type="text" id="u-nik" name="user-nik" class="easyui-numberbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Username</td>
                <td>
                    <input type="text" id="u-username" name="user-username" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>
                    <input type="text" id="u-nama" name="u-nama" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td>
                    <input type="email" id="u-email" name="user-email" class="easyui-textbox" style="height:30px;width:200px;"></input>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="" id="save-user" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;">Save</a>
                </td>
            </tr>
        </table>
    </form>
</div>