<!-- Begin one column box -->
	<div class="onecolumn" style="margin:4px;" id="outlet_detail_slider" >
		
		<div class="header"><h2><?= _detail;?></h2></div>

		<div class="content">
		<!-- Begin outlet detail slider -->
		<div style='width:45%; float:left;'>
			<?
					$passerby_now_pax = querySQL('passerby_max_pax');
					if ($passerby_now_pax >= $maitre['passerby_max_pax'] && $maitre['passerby_max_pax'] > 0){ 
						$_SESSION['messages'] [] = _sentence_16 ;
					}

					echo "<h4 style='margin-left:5px;'>"._description."</h4> 	
							<p>".$_SESSION['selOutlet']['outlet_description']."</p>";
					echo "<h4 style='margin-left:5px;'>"._cuisine_style."</h4> 	
							<p><strong>".$cuisines[($_SESSION['selOutlet']['cuisine_style']-1)]."</strong></p>";
					echo "</div><div style='width:35%; float:left; margin-left:40px;'>";
					echo "<h4 style='margin-left:5px;'>"._settings."</h4>";
					echo "<p>";
					$cando = ( current_user_can( 'Daily-Outlet-Edit' ) ) ? 'enabled' : 'disabled';
					getDayoff_select($dayoff,$maitre['maitre_id'],$cando);
					echo "</p>";
			?>
			<form method="post" action="?q=1" id="edit_maitre_form">
			<label><?= _day_comment;?></label>
			<p>
				<? if ( current_user_can( 'Daily-Outlet-Edit' ) ){
					echo'<input type="text" name="maitre_comment_day" id="maitre_comment_day" style="width:260px;" 
					value="'.$maitre['maitre_comment_day'].'"/>';
				   }else{
					echo ($maitre['maitre_comment_day']) ? $maitre['maitre_comment_day'] : '--';
				   }
				?>
			</p>
			<?
			$timestamp = ($maitre['maitre_timestamp']=='') ? " " : " @ ".humanize($maitre['maitre_timestamp']) ;
			echo"<p style='margin-top:80px;'><small>".$maitre['maitre_author'].$timestamp."</small></p>";
			?>
			</div>
			<div class="content">
				<label><?= _add_seats;?></label>
				<p>
					<? if ( current_user_can( 'Daily-Outlet-Edit' ) ){
						echo'<input type="text" name="outlet_child_capacity" id="outlet_child_capacity" 
								style="width:50px;" value="'.$maitre['outlet_child_capacity'].'"/>';
					   }else{
						echo ($maitre['outlet_child_capacity']) ? $maitre['outlet_child_capacity'] : 0;
					   }
					?>
				</p>
				<label><?= _add_tables;?></label>
				<p>
					<? if ( current_user_can( 'Daily-Outlet-Edit' ) ){
						echo'<input type="text" name="outlet_child_tables" id="outlet_child_tables" 
								style="width:50px;" value="'.$maitre['outlet_child_tables'].'"/>';
					   }else{
						echo ($maitre['outlet_child_tables']) ? $maitre['outlet_child_tables'] : 0;
					   }
					?>
				</p>
				<label>Max. <?= _passerby;?></label>
				<p>
					<? if ( current_user_can( 'Daily-Outlet-Edit' ) ){
						echo'<input type="text" name="outlet_child_passer_max_pax" id="outlet_child_passer_max_pax" 
								style="width:50px;" value="'.$maitre['outlet_child_passer_max_pax'].'"/>';
					   }else{
						echo ($maitre['outlet_child_passer_max_pax']) ? $maitre['outlet_child_passer_max_pax'] : 0;
					   }
					?>
				</p>
				
				<input type="hidden" name="maitre_id" value="<?= $maitre['maitre_id'];?>">
				<input type="hidden" name="maitre_outlet_id" value="<?= $_SESSION['selOutlet']['outlet_id'];?>">
				<input type="hidden" name="maitre_author" value="<?= $_SESSION['u_fullname'];?>">
				<input type="hidden" name="maitre_date" value="<?= $_SESSION['selectedDate']; ?>">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<input type="hidden" name="action" value="save_maitre">
				<? if ( current_user_can( 'Daily-Outlet-Edit' ) ){
						echo'<input type="submit" class="button_dark" value="'._save.'" style="float:right;"/>';
				   }
				?>
			</form>
			</div>
 			<br class="clear"/><br class="clear"/>
 		<!-- End outlet detail slider -->
		</div>
	</div>
<!-- End one column box -->