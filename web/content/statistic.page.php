<?
//prepare selected Date
list($sy,$sm,$sd) = explode("-",$_SESSION['selectedDate']);

// Bar Plot month
$datamonth = array();
$i=1;
while ($i<=12){
	//month, without leading zeros
	if ( strlen($i)==1){
		$_SESSION['statistic_month']="0".$i;
	}else{
		$_SESSION['statistic_month']=$i;
	}

	$statistic = querySQL('statistic_month');
	$statistic2 = querySQL('statistic_month_last');
	
	foreach ($statistic as $row) {
		$datamonth[$i-1] = ($row->paxsum) ? $row->paxsum : 0; 
		$labelmonth[] = $_SESSION['statistic_month']; 
	}
	foreach ($statistic2 as $row) {
		$datamonth2[$i-1] = ($row->paxsum) ? $row->paxsum : 0; 
	}
	
$i++;
}

// Bar Plot week DEF
$data1 = array();
$labels = array();
$i=0;
while ($i<=6){
	$labeldate=date('d.m.',mktime(0,0,0,$sm,$sd-$i,$sy));
	$_SESSION['statistic_week'] = date('Y-m-d',mktime(0,0,0,$sm,$sd-$i,$sy));
	
	$statistic = querySQL('statistic_week_def');
	foreach ($statistic as $row) {
		$statistic_week_def[$i] = ($row->paxsum) ? $row->paxsum : 0; 
	}
	$labels[] = $labeldate;
	
$i++;
}

// Guest type
$datapie = array();
$labelpie = array();
$_SESSION['statistic_month'] = $sm;

	$pie_data = querySQL('statistic_type');

	foreach ($pie_data as $row) {
		$labelpie[] = $row->reservation_hotelguest_yn;
		$datapie[] = $row->paxsum;
	}

?>

<!-- Begin one column box -->
<div class="onecolumn">
	<div class="header">
		<h2><?= _statistics." ".querySQL('db_outlet').": ".date('d.m.',mktime(0,0,0,$sm,$sd,$sy));?></h2>
		
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
	<div class="content">
		<br/>
		<div id="graph_wrapper1" class="graph_wrapper"></div>
		<table id="graph_week" class="data" style="display:none" cellpadding="0" cellspacing="0" width="100%">
			<caption><?= _occupancy_per_week;?></caption>
			<thead>
				<tr>
					<td class="no_input">&nbsp;</td>
					<?
					foreach ($labels as $value) {
						echo "<th>".$value."</th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th><?= _week;?></th>
					<?
					foreach ($statistic_week_def as $value) {
						echo "<td>".$value."</td>";
					}
					?>
				</tr>
			</tbody>
		</table>
		<br/>
		<div id="graph_wrapper2" class="graph_wrapper"></div>
		<table id="graph_month" class="data" style="display:none;" cellpadding="0" cellspacing="0" width="100%">
			<caption><?= _occupancy_per_month;?></caption>
			<thead>
				<tr>
					<td class="no_input">&nbsp;</td>
					<?
					foreach ($labelmonth as $value) {
						echo "<th>".$value."</th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th><?= $_SESSION['selectedDate_year'];?></th>
					<?
					foreach ($datamonth as $value) {
						echo "<td>".$value."</td>";
					}
					?>
				</tr>
				<tr>
					<th><?= $_SESSION['selectedDate_year']-1;?></th>
					<?
					foreach ($datamonth2 as $value) {
						echo "<td>".$value."</td>";
					}
					?>
				</tr>
			</tbody>
		</table>
		<div id="graph_wrapper3" class="graph_wrapper"></div>
		<table id="graph_type" class="data" style="display:none;" cellpadding="0" cellspacing="0" width="100%">
			<caption><?= _guest_type_per_month;?></caption>
			<thead>
				<tr>
					<?
					foreach ($labelpie as $value) {
						echo "<th>".$value."</th>";
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?
				foreach ($pie_data as $row) {
					echo "<tr><th scope='row'>".$row->reservation_hotelguest_yn."</th>\n";
					echo "<td>".$row->paxsum."</td>\n</tr>\n";
				}
				?>
			</tbody>
		</table>
		
	</div>
</div>

<br class="clear"/><br/>