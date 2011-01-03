
<?php if ( current_user_can( 'Properties-All' ) ): ?>
<!-- Begin property table data -->
<table class="global" style="margin:0px 0px;" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
			<th style="width:30%"><?= _name; ?></th>
			<th style="width:20%"><?= _adress; ?></th>
			<th style="width:20%"><?= _area_code; ?></th>
			<th style="width:10%"><?= _contact; ?></th>
			<th style="width:5%"><?= _email; ?></th>
			<th style="width:5%"><?= _phone; ?></th>
			<th style="width:5%"><?= _fax; ?></th>
			<th style="width:5%"><?= _delete; ?></th>
	    </tr>
	</thead>
	<tbody>
		<?

		$properties =	querySQL('all_properties');
		
		if ($properties ) {
			foreach($properties as $row) {
			echo "<tr id='property-".$row->id."'>";
		
			echo"<td><strong><a href='?p=5&propertyID=".$row->id."'>".$row->name."</a></strong></td>
			<td>".$row->street."</td>
			<td>".$row->city."</td>
			<td>".$row->contactperson."</td>
			<td>".$row->email."</td>
			<td>".$row->phone."</td>
			<td>".$row->fax."</td>
			<td>
				<a href='#modaldelete' name='properties' id='".$row->id."' class='deletebtn'>
				<img src='images/icons/delete_cross.png' alt='"._cancelled."' class='help' title='"._delete."'/>
				</a>
		    	</td>
			</tr>";
			}
		}
		?>
	</tbody>
</table>
<!-- End property table data -->
<?php endif ?>