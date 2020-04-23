<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ULOK</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/easyui/themes/default/easyui.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/fontawesome/css/fontawesome-all.css" rel="stylesheet">
		<script type="text/javascript" src="<?php echo base_url();?>assets/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/accounting.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/home.js"></script>
		<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.png" type="image/png">
	</head>
	<body onload="startTime()">
	
        
		<div class="nav-shadow">
			<div class="container">
				
				<div id="cssmenu">
						 <input type="text" id="session_role" name="session_role" value="<?php echo $this->session->userdata('role_id') ?> "style="display:none"   ></input>
					<ul>
						<li><a href="#" class="logo"><img src="<?php echo base_url();?>assets/images/logo.png" style="height: 50px; width: 100px;"></a></li>
						<!--<li style="padding-top: 20px; padding-left: 10px;">
							<span id="version-number" style="height: 50px; width: 100px;"><b>v 1.0.0.0</b></span>
						</li>-->
		
					   	<!-- <li><a href="#">Home</a></li>
					   	<li class="active has-sub"><a href="#">Products</a>
					   								<ul>
					   									<li><a href="#">Product 1</a></li>
					   									<li class="has-sub"><a href="#">Product 2</a>
					   										<ul>
					   											<li><a href="#">Sub Product</a></li>
					   											<li><a href="#">Sub Product</a></li>
					   										</ul>
					   									</li>
					   								</ul>
					   							</li>
					   							<li><a href="#">About</a></li>
					   							<li><a href="#">Contact</a></li> -->
						<li class="active has-sub" style="height:60px;float: right;">
							<a href="#"><i class="fas fa-user"></i>&nbsp&nbsp <?php echo $this->session->userdata('username'); ?></a>
							<ul>
								<li><a href="" id="help"><i class="far fa-edit"></i>&nbsp&nbsp Help</a></li>
								<li><a href="" id="change-password"><i class="far fa-edit"></i>&nbsp&nbsp Change Password</a></li>
								<li><a href="<?php echo base_url(); ?>Auth/logout/"><i class="fas fa-sign-out-alt"></i>&nbsp&nbsp Logout</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

	

