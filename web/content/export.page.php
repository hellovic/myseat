
<!-- Begin one column box -->
<div class="onecolumn">
	<div class="header">
		<h2><?= _export;?></h2>
		
		<!-- Begin 2nd level tab -->
		<ul class="second_level_tab">
			<li>
				<a href="?p=2" class="button_dark">
					<?= _back;?>
				</a>
			<li/>
		</ul>
		<!-- End 2nd level tab -->
		
	</div>
	
	
	<div id="content_wrapper">
	<br/>
		<div class="onecolumn_wrapper">
		 <div class="onecolumn" style="margin-right:20%; margin-left:20%;">
		  <div class="content" >
			
			<table class="general">
			<form name="export_form" id="export_form" method="post" action="classes/export.class.php" accept-charset="UTF-8">	
			<tr>
				<td>
					<th></th>
					<label style='float:left'><?= _date; ?></label>
					<br class="clear"/>
					<div class="date dategroup">
						<div class="text" id="s_datetext"><?= $_SESSION['selectedDate_user']; ?></div>
						<input type="text" id="s_datepicker"/>
						<input type="hidden" name="s_dbdate" id="s_dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
		    	    </div>
					
					<strong style='float:left'>&nbsp;&nbsp; <?= _till;?> &nbsp;&nbsp;</strong>  
					
					<div class="date dategroup">
						<div class="text" id="e_datetext"><?= $_SESSION['selectedDate_user']; ?></div>
						<input type="text" id="e_datepicker"/>
						<input type="hidden" name="e_dbdate" id="e_dbdate" value="<?= $_SESSION['selectedDate']; ?>"/>
		    	    </div>
				</td>
			</tr>
			<tr>
				<th><strong><?= _outlets; ?></strong></th>
				<td>
					<div class="option">
						<div class="text" style='font-weight:normal;' ></div>
							<? getOutletList(1,'enabled'); ?>
					</div>
				</td>
			</tr>
			<tr>
				<th><strong><?= _type; ?></strong></th>
				<td>
					<div class="option">
						<div class="text"></div>
							<? getTypeList();?>
				    </div>
				</td>
			</tr>
			<tr>
				<td>
					<br/><br/>
				<input type="hidden" name="action" value="export">
				<input type="submit" class="button_dark" value="<?= _export;?>">
				</td>
			</tr>
			</form>
			</table> <!-- close table -->
			
			
		  </div>
		 </div>
		</div>
	</div>
	<br/>
</div>

<br class="clear"/><br/>