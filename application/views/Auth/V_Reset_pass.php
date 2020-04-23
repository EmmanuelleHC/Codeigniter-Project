<?php echo @$header; ?>
		<div style="padding:2% 60px 20px 60px">
	        <form id="ff" method="post" action="<?php echo base_url('Auth/update_newpass/'); ?>">
	            <table cellpadding="5" align="center">
	            	<tr>
	            		<td colspan="2" align="center">
	            			<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="">
	            			<h1>Change Password.</h1>
	            			<?php echo $this->session->flashdata('msg'); ?>
            			</td>
	            	</tr>
	                <tr>
	                	<td>Current Password</td>
	                    <td><input type="password" name="curr_password" class="easyui-textbox" style="height:30px;width:200px;"></input></td>
	                </tr>
	                <tr>
	                	<td>New Password</td>
	                 <!--    <td><input type="password" name="new_password" class="easyui-textbox" onkeyup="cek()" style="height:30px;width:200px;"></input></td> -->
	                    <td><input name="new_password" id="new_password" type="password" style="height:30px;width:200px;" /></td>
	                </tr>
	                <tr>
	                	<td>Re-type Password</td>
	                   <!--  <td><input type="password" name="re_password" class="easyui-textbox" onkeyup="cek()" style="height:30px;width:200px;"></input></td>  -->
	                     <td><input name="re_password" id="re_password" type="password"style="height:30px;width:200px;" /></td> 
	                    <td><span id='message'></span></td>
	                </tr>
	                <tr>
	                	<td></td>
	                    <td><input type="submit" value="Save" class="easyui-linkbutton" style="height:30px;width:200px;"></input></td>
	                </tr>
	            </table>
	        </form>
        </div>
<?php echo @$footer; ?>
<script type="text/javascript">
	$('#new_password, #re_password').on('keyup', function () {
  if ($('#new_password').val() == $('#re_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else {
    $('#message').html('Not Matching').css('color', 'red');
  }
});
</script>