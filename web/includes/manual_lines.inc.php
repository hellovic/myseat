<!-- Start manual lines table -->
<table class="print global" width="100%" style="margin-top: 80px;">
	<thead>
	<tr>
		<th style='width:10%;'><?= _time;?></th>
		<th style='width:80%;'><?= _guest_name;?></th>
		<th style='width:10%;'><?= _pax;?></th>
	</tr>
	</thead>
	<tbody>
	<?
	for ($i = 1; $i <= $general['manual_lines']; $i++) {
		echo"<tr style='height:30px;'><td style='width:10%;'></td><td style='width:90%;'></td><td style='width:10%;'></td></tr>";
	}
	?>
	</tbody>
</table>
<!-- End manual lines table -->