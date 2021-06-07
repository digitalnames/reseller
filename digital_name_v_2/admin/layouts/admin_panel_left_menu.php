<div class="fix floatleft twenty_percent p_10 border_box bg_very_light_ash" style="min-height:900px">
	<ul>
		<li class="bg_blue bb_1 border_bottom_solid border_bottom_white"><a href="index.php" class="fs_16 lh_30 font_bold text_dim_white display_block pl_30 pt_5 pb_5">Dashboard</a></li>
		<li class="bg_blue bb_1 border_bottom_solid border_bottom_white"><a href="customer_list.php" class="fs_16 lh_30 font_bold text_dim_white display_block pl_30 pt_5 pb_5">Customers</a></li>
		<li class="bg_blue bb_1 border_bottom_solid border_bottom_white"><a href="settings.php" class="fs_16 lh_30 font_bold text_dim_white display_block pl_30 pt_5 pb_5">Settings</a></li>
		<?php if($affiliate_program_type == 'tns') { ?> 
		<li class="bg_blue bb_1 border_bottom_solid border_bottom_white"><a href="affiliates.php" class="fs_16 lh_30 font_bold text_dim_white display_block pl_30 pt_5 pb_5">Affiliates</a></li>
		<?php } ?>
		<li class="bg_blue bb_1 border_bottom_solid border_bottom_white"><a href="logout.php" class="fs_16 lh_30 font_bold text_dim_white display_block pl_30 pt_5 pb_5">Logout</a></li>
	</ul>
</div>