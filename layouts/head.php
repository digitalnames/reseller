<div class="fix half floatleft">
	<a href="index.php"><h1 class="fs_30 lh_40 font_bold text_dark_ash pl_20 pr_20"><?php echo $company_name; ?></h1></a>
</div>
<div class="fix half floatright">
	<?php if(isset($_SESSION['login_token'])){ ?>
	<a href="logout.php" class="floatright"><p class="fs_14 lh_22 font_bold text_dark_ash pl_20 pr_20">Logout</p></a>			
	<!-- <a href="marketplace.php" class="floatright"><p class="fs_14 lh_22 font_bold text_dark_ash pl_20 pr_20">Marketplace</p></a> -->
	<a href="control_panel.php" class="floatright"><p class="fs_14 lh_22 font_bold text_dark_ash pl_20 pr_20">Control Panel</p></a>
	<?php }else{ ?>
	<a href="login.php" class="floatright"><p class="fs_14 lh_22 font_bold text_dark_ash pl_20 pr_20">Login</p></a>
	<!-- <a href="marketplace.php" class="floatright"><p class="fs_14 lh_22 font_bold text_dark_ash pl_20 pr_20">Marketplace</p></a> -->
	<?php } ?>
</div>
<div class="fix position_fixed w_150 r_400 t_0 bg_very_light_ash2 b_2 border_ash border_solid border_dark_ash">
	<a href="cart.php">
		<div class="fix floatleft half fs_20 lh_30 pl_5 pr_5 border_box br_2 border_right_solid border_right_black">Cart</div>
		<div class="fix floatleft half fs_20 lh_30 pl_5 pr_5 border_box" id="name_in_cart">0</div>
	</a>
</div>