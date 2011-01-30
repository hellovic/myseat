<div class="popup">
	<div class="top"></div>
	<div class="content">
		<ul class="submenu">
			
			<?
			$outlets = querySQL('db_outlets');
			foreach($outlets as $row) {
			 if ( ($row->saison_start<=$row->saison_end 
				 && $_SESSION['selectedDate_saison']>=$row->saison_start 
				 && $_SESSION['selectedDate_saison']<=$row->saison_end)
				) {
				echo"<li>\n<a href='?p=2&outletID=".$row->outlet_id."'>".$row->outlet_name."</a>\n</li>\n";
				}
			}
			?>
		</ul>
		<br class="clear"/>
	</div>
	<div class="footer"></div>
</div>