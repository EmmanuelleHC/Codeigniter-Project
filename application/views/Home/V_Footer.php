    <div id="modal-change-password" class="easyui-window" title="Change Password" style="width:390px;height:auto; padding:10px;top: 250px;" data-options="iconCls:'icon-ess-edit',modal:true,collapsible:false,minimizable:false,maximizable:false,closed:true">
		<form action="<?php echo base_url(); ?>Auth/update_newpass/" method="post">
            <table cellpadding="" align="center">
                <tr>
                    <td>Current Password</td>
                    <td><input type="password" id="curr-password" name="curr_password" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <!-- <td><input type="password" id="new-password" name="new_password" class="easyui-textbox" style="height:30px;width:200px;"></input></td> -->
                     <td><input name="new_password" id="new_password" type="password" style="height:30px;width:200px;" /></td>
                </tr>
                <tr>
                    <td>Re-type Password</td>
                  <!--   <td><input type="password" id="re-password" name="re_password" class="easyui-textbox" style="height:30px;width:200px;"></input></td> -->
                    <td><input name="re_password" id="re_password" type="password"style="height:30px;width:200px;" /></td> 
                     <td><span id='message'></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Save" class="easyui-linkbutton" data-options="iconCls:'icon-ess-save'" style="width:100px;"></input></td>
                </tr>
            </table>
        </form>
	</div>

	</body>
</html>
<script type="text/javascript">
    $('#new_password, #re_password').on('keyup', function () {
  if ($('#new_password').val() == $('#re_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else {
    $('#message').html('Not Matching').css('color', 'red');
  }
});
</script>