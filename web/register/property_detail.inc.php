<script type="text/javascript">	
	// GOOGLE MAP INTEGRATION
	$(document).ready(function() {
		$("#map_canvas").gMap({ markers: [
                            { address: "<?= $row['street'].", ".$row['city'].", ".$row['country'];?>",
                              html: "_address"}],
			      zoom: 16 });
	});
</script>
				<h3>	 	 				 
					<div class="property-logo" style="background-image: url(../uploads/logo/<? echo ($row['logo_filename']=='') ? 'logo.png' : $row['logo_filename'];?>);"></div>
					<?= $row['name'];?>
				</h3>
				<br class="cl" />
				<br/>
				<div class="property-image" style="background-image: url(../uploads/img/<? echo ($row['img_filename']=='') ? 'noImage.png' : $row['img_filename'];?>);"></div>
				<br class="cl" />
				<br/><br/>
				<label><?= _contact;?></label>
				<p><span class='bold'>
					<?= $row['contactperson'];?>
				</p></strong>
				<label><?= _adress;?></label>
				<p><span class='bold'>
					<?= $row['street'];?>
				</p></strong>
				<label><?= _zip;?></label>
				<p><span class='bold'>
					<?= $row['zip'];?>
				</p></strong>
				<label><?= _city;?></label>
				<p><span class='bold'>
					<?= $row['city'];?>
				</p></strong>
				<label><?= _country;?></label>
				<p><span class='bold'>
					<?= $countries[$row['country']];?>
				</p></strong>
				<label><?= _email;?></label>
				<p><span class='bold'>
					<?= $row['email'];?>
				</p></strong>
				<label><?= _phone;?></label>
				<p><span class='bold'>		 	 	 	 	 	 	
					<?= $row['phone'];?>
				</p></strong>
				<label><?= _fax;?></label>	
				<p>	 	 	 	 	 	 	
					<?= $row['fax'];?>
				</p>
				<br/><br/>	 	 	 	 	 	 	 
				<small>				
					<? if($row['created']){ echo _created." ".humanize($row['created']);}?>
				</small>
				<?php if($settings['googlemap_key'] != ""){?>
					<!-- Google Map Plugin -->
					<div class="google_map" style="margin-top:80px;">
						<div id="map_canvas"></div>
					</div>
					<!-- /Google Map -->
				<?php } ?>