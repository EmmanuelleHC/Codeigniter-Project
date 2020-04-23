
<?php echo @$header; ?>
		<div style="padding:5% 60px 20px 60px">
			<?php echo $this->session->flashdata('msg'); ?>
	        <form id="ff" method="post" action="<?php echo base_url('Auth/create_sess/'); ?>">
	            <table cellpadding="5" align="center" style="background: #fff; padding: 10px;">
	            	<tr>
	            		<td colspan="2" align="center">
	            			<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="">
            			</td>
	            	</tr>
	            	<tr>
	            		<td colspan="2">
	            			<hr>
            			</td>
	            	</tr>
	                <tr>
	                	<td>NIK</td>
	                    <td><input id="nik" type="text" name="nik" class="easyui-numberbox"  style="height:30px;width:200px;"></input></td>
	                </tr>
	                <tr>
	                	<td>Password</td>
	                  <!--   <td><input type="password" name="password" id="password" class="easyui-textbox" style="height:30px;width:200px;"></input></td> -->
	                    <td><input type="password"  id="password" name="password"   style="height:30px;width:200px;"></td>

	                </tr>
	             
	                <tr>
	                	<td><input type="checkbox" onclick="myFunction()">Show Password </td>
	                </tr>
	                <tr>
	                	<td></td>
	                    <td><input id="login" type="submit" value="Login" class="easyui-linkbutton" style="height:35px;width:210px;"></input></td>
	                </tr>
	            </table>
	        </form>
        </div>
  
<?php echo @$footer; ?>
<script type="text/javascript">
	function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        $('#password').attr('type', 'text'); 
    } else {
        $('#password').attr('type', 'password'); 
    }



} 



</script>

