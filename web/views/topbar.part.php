<!-- Begin top bar -->
<div id="top_bar">
	
	
	<!-- Begin logo -->
	<div class="logo">
		<a href="/web"><img src="images/logo.png" alt=""/></a>
	</div>
	<!-- End logo -->
	
	<!-- Begin account menu -->
	<div class="account">
		<div class="detail">
			<?
			if($this_page != "property"){
				echo _hello."<a href=''><strong> ".$_SESSION['u_name']."</strong></a>, ".$roles[$_SESSION['role']]." - <strong>".querySQL('db_property')."</strong>";
			}
			?>
		</div>
		<ul class="icon">
			<!--
			<li>
				<a href="" title="Message">
					<img src="images/icon_message.png" alt="" class="middle"/>
				</a>
			</li>
			<li>
				<a href="" title="Setting">
					<img src="images/icon_setting.png" alt="" class="middle"/>
				</a>
			</li>
			-->
			<li>
				<a href="?logout=1" title="Logout">
					<img src="images/icon_logout.png" alt="" class="middle"/>
				</a>
			</li>
		</ul>
	</div>
	<!-- End account menu -->
	
	
</div>
<!--End top bar -->