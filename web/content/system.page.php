<?
		// check what startpage
		if ($q==1) {
			if ( current_user_can( 'Settings-Outlets' ) ){
				$q=1;
			}else if ( current_user_can( 'Settings-Users' ) ){
				$q=2;
			}else if ( current_user_can( 'Settings-General' ) ){
				$q=3;
			}else if ( current_user_can( 'Settings-Events' ) ){	
				$q=4;
			}
		}
?>
	<!-- Begin 1st level tab -->
	<ul class="first_level_tab">
		<?php if ( current_user_can( 'Settings-Outlets' ) ): ?>
		<li>
			<a href="?p=6&q=1&btn=1" <? if ($q == 1) { echo " class='active'";}?> >
				<img src='images/menu-icons/store.png' class='nav-image'><?= _outlets; ?>
			</a>
		</li>
		<?php endif ?>
		<?php if ( current_user_can( 'Settings-Users' ) ): ?>
		<li>
			<a href="?p=6&q=2&btn=1" <? if ($q == 2) { echo " class='active'";}?> >
				<img src='images/menu-icons/user.png' class='nav-image'><?= _users; ?>
			</a>
		</li>
		<?php endif ?>
		<?php if ( current_user_can( 'Settings-General' ) ): ?>
			<li>
				<a href="?p=6&q=3" <? if ($q == 3) { echo " class='active'";}?> >
					<img src='images/menu-icons/equalizer.png' class='nav-image'><?= _general; ?>
				</a>
			</li>
		<?php endif ?>
		<?php if ( current_user_can( 'Settings-Events' ) ): ?>
			<li>
				<a href="?p=6&q=4&btn=1" <? if ($q == 4) { echo " class='active'";}?> >
					<img src='images/menu-icons/ticket.png' class='nav-image'><?= _sp_events; ?>
				</a>
			</li>
		<?php endif ?>
		<?php if ( current_user_can( 'Property-New' ) ): ?>
			<li>
				<a href="?p=6&q=5" <? if ($q == 5) { echo " class='active'";}?> >
					<img src='images/menu-icons/home.png' class='nav-image'><?= _property; ?>
				</a>
			</li>
		<?php endif ?>
	</ul>	
	<!-- End 1st level tab -->
	
	<br class="clear"/>
	
	<!-- Begin one column box -->
	<div class="onecolumn">
		
		<div class="header">
			<div class="description">
				<?
				if ($q == 1 && $_SESSION['button'] == 1) { 
					echo "<h3>"._existing_outlets."</h3>";
				}else if ($q == 1 && $_SESSION['button'] == 2) { 
					echo "<h3>"._add_outlet."</h3>";
				}else if (	$q == 2 && $_SESSION['button'] == 1) { 
					echo "<h3>"._users."</h3>";
				}else if ($q == 2 && $_SESSION['button'] == 2) { 
					echo "<h3>"._add_user."</h3>";
				}else if ($q == 2 && $_SESSION['button'] == 3) { 
					echo "<h3>"._edit." "._users."</h3>";
				}else if ($q == 3 ) { 
					echo "<h3>"._general." "._settings."</h3>";
				}else if ($q == 4 ) { 
					echo "<h3>"._sp_events."</h3>";
				}else if ($q == 5 || q == 6) { 
					echo "<h3>"._property." "._info."</h3>";
				}
				?>
			</div>
			
			<!-- Begin 2nd level tab -->
			<?php if ( $q == 1 ): ?>
			<ul class="second_level_tab">
				<li>
					<a href="?p=6&q=1&btn=1" <? if ($_SESSION['button'] == 1) { echo " class='active'";}?> >
						<?= _active;?>
					</a>
				</li>
				<li>
					<a href="?p=6&q=1&btn=3" <? if ($_SESSION['button'] == 3) { echo " class='active'";}?> >
						<?= 'In'._active;?>
					</a>
				</li>
				<li>
					<a href="?p=6&q=1&btn=2" <? if ($_SESSION['button'] == 2) { echo " class='active'";}?> >
						<?= _create;?>
					</a>
				</li>
				<li>
					<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>">
						<?= _back;?>
					</a>
				</li>
			</ul>
			<?php endif ?>
			<?php if ( $q == 2 ): ?>
			<ul class="second_level_tab">
				<li>
					<a href="?p=6&q=2&btn=1" <? if ($_SESSION['button'] == 1) { echo " class='active'";}?> >
						<?= _users;?>
					</a>
				</li>
				<li>
					<a href="?p=6&q=2&btn=2" <? if ($_SESSION['button'] == 2 || $_SESSION['button'] == 3 || $p == 6) { echo " class='active'";}?> >
						<?= _create;?>
					</a>
				</li>
				<li>
					<?
					echo'<a href="';
					if ($_SESSION['button'] == 2 || $_SESSION['button'] == 3) {
						echo "?p=6&q=2&btn=1";
					}else{
						echo "?p=2&outletID=".$_SESSION['outletID'];
					}
					echo '">'._back;
					?>
					</a>
				</li>
			</ul>
			<?php endif ?>
			<?php if ( $q == 3 ): ?>
			<ul class="second_level_tab">
				<li>
					<a href="?p=6&q=1&btn=1">
						<?= _back;?>
					</a>
				</li>
			</ul>
			<?php endif ?>
			<?php if ( $q == 4 ): ?>
			<ul class="second_level_tab">
				<li>
					<a href="?p=6&q=4&btn=1" <? if ($_SESSION['button'] == 1) { echo " class='active'";}?> >
						<?= _overview;?>
					</a>
				</li>
				<li>
					<a href="?p=6&q=4&btn=2" <? if ($_SESSION['button'] == 2 || $_SESSION['button'] == 3) { echo " class='active'";}?> >
						<?= _create;?>
					</a>
				</li>
				<li>
					<?
					echo'<a href="';
					if ($_SESSION['button'] == 2 || $_SESSION['button'] == 3) {
						echo "?p=6&q=4&btn=1";
					}else{
						echo "?p=2&outletID=".$_SESSION['outletID'];
					}
					echo '">'._back;
					?>
					</a>
				</li>
			</ul>
			<?php endif ?>
			<?php if ( $q == 5 ): ?>
			<ul class="second_level_tab" style="line-height:1.4em">
				<?php if ( current_user_can( 'Settings-Outlets' ) ): ?>
				<li>
					<a href="#" id="editToggle" onclick="return false;">
						<?= _edit;?>
					</a>
				</li>
				<li>
					<a href="?p=6&q=1&btn=1">
						<?= _back;?>
					</a>
				</li>
				<?php endif ?>
			</ul>
			<?php endif ?>
			<!-- End 2nd level tab -->
			
		</div>
		
		<!-- Begin nomargin -->
		<div class="content nomargin">
			
			<?
			// ** content of pages **
			
			switch($q){
				case '1':
				if ( current_user_can( 'Settings-Outlets' ) ){
					// outlets
					if($_SESSION['button'] == 1 || $_SESSION['button'] == 3){
						include('includes/outlets_grid.inc.php');
					}else if($_SESSION['button'] == 2){
						include('includes/outlets_new.inc.php');
					}
				}else{
					redeclare_access();
				}
				break;
				case '2':
				if ( current_user_can( 'Settings-Users' ) ){
					// user
					if($_SESSION['button'] == 1){
						include('includes/users_grid.inc.php');
					}else if($_SESSION['button'] == 2){
						include('includes/users_new.inc.php');
					}else if($_SESSION['button'] == 3){
						include('includes/users_new.inc.php');
					}
				}else{
					redeclare_access();
				}	
				break;
				case '3':
				if ( current_user_can( 'Settings-General' ) ){
					// general
					include('includes/generalsettings.inc.php');
				}else{
					redeclare_access();
				}		
				break;
				case '4':
				if ( current_user_can( 'Settings-Events' ) ){
					// event
					if($_SESSION['button'] == 1){
						include('includes/events_grid.inc.php');
					}else if($_SESSION['button'] == 2){
						include('includes/events_new.inc.php');
					}else if($_SESSION['button'] == 3){
						include('includes/events_new.inc.php');
					}
				}else{
					redeclare_access();
				}	
				break;
				case '5':
				if ( current_user_can( 'Property-New' ) ){
					// property
					include('register/detail.property.page.php');
				}else{
					redeclare_access();
				}	
				break;
			}
			?>
			
			<br class="clear"/>
		
		</div>
		<!-- End nomargin -->
</div>
<br/>
	<a href="?p=2&outletID=<?= $_SESSION['outletID']; ?>" class="button_dark"><input type="button" class="button_dark" value="<?= _back;?>"/></a>
<br/>
<br class="clear"/>