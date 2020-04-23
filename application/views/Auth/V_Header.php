<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ULOK</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/easyui/themes/default/easyui.css" >
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/easyui/themes/icon.css">
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/index.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/easyui/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/easyui/jquery.easyui.min.js"></script>
		<link rel="icon" href="<?php echo base_url();?>assets/images/favicon.png" type="image/png">
	</head>
	<body>
		<!-- <div align="left">
			<img src="<?php echo base_url();?>assets/images/logo_indomaret.png" style="width:142px;height:65px; no-repeat;">	
		</div> -->

		<div>
			<ul>
				<?php if (@$menu) {foreach (@$menu as $key) {?>
				<li style="display:inline;"><a class="menu" href="<?php echo base_url().@$key->URL; ?>"><?php echo $key->MENU_NAME; ?></a></li>
				<?php } ?>
				<?php } ?>
			</ul>
			<ul style="float:right; display:inline;">
				<?php if (@$menu) {?>
				<li style="display:inline;"><a class="menu" style="width:150px; text-align:center;" href="#"><?php echo $this->session->userdata('username'); ?></a></li>
				<li style="display:inline;"><a class="menu" style="width:100px; text-align:center;" href="<?php echo base_url('Auth/logout'); ?>">Logout</a></li>
				<?php } ?>
			</ul>
		</div>
		<br><br>