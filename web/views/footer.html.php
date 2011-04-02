	<!--[if IE]>
		<script type="text/javascript" src="js/excanvas.js"></script>
	<![endif]-->
	<!-- Javascript at the bottom for fast page loading --> 
	<script type="text/javascript" src="js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.0.js"></script>
	<script type="text/javascript" src="js/hint.js"></script>
	<?php if($_SESSION['page']=='3'):?>
	<script type="text/javascript" src="js/visualize/jquery.visualize.js"></script>
	<?php endif ?>
	<?php if($_SESSION['page']=='6'):?>
	<script type="text/javascript" src="js/jwysiwyg/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="js/mColorPicker.js"></script>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?= $settings['googlemap_key']; ?>" type="text/javascript" ></script>
	<script type="text/javascript" src="../web/js/jquery.gmap-1.1.0-min.js"></script>
	<?php endif ?>
	<script type="text/javascript" src="js/jquery.img.preload.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/jquery.tipsy.js"></script>
	<script type="text/javascript" src="js/browser.js"></script>
	<script type="text/javascript" src="js/jquery.jeditable.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
		// edit toogle buttons
		$('#editToggle').click(function() {
          $('#show').toggle();
          $('#edit').toggle();
        });
		// Setup datepicker input
		$("#datepicker").datepicker({
			nextText: '&raquo;',
			prevText: '&laquo;',
			firstDay: 1,
			numberOfMonths: 2,
			gotoCurrent: true,
			altField: '#dbdate',
			altFormat: 'yy-mm-dd',
			defaultDate: 0,
			dateFormat: '<?= $general['datepickerformat'];?>',
			regional: '<?= substr($_SESSION['language'],0,2);?>',
			onSelect: function(dateText, inst) { window.location.href="?selectedDate="+$("#dbdate").val(); }
		});
		// Setup datepickers export
		<?php if($_SESSION['page']=='4'):?>
			$("#s_datepicker").datepicker({
				nextText: '&raquo;',
				prevText: '&laquo;',
				firstDay: 1,
				numberOfMonths: 1,
				gotoCurrent: true,
				altField: '#s_dbdate',
				altFormat: 'yy-mm-dd',
				defaultDate: 0,
				dateFormat: '<?= $general['datepickerformat'];?>',
				regional: '<?= substr($_SESSION['language'],0,2);?>'
			});
			$("#e_datepicker").datepicker({
				nextText: '&raquo;',
				prevText: '&laquo;',
				showAnim: 'slideDown',
				firstDay: 1,
				numberOfMonths: 1,
				gotoCurrent: true,
				defaultDate: 0,
				altField: '#e_dbdate',
				altFormat: 'yy-mm-dd',
				dateFormat: '<?= $general['datepickerformat'];?>',
				regional: '<?= substr($_SESSION['language'],0,2);?>'
			});
			//$("#datepicker").datepicker('setDate', new Date ( "<?= $pickerDate; ?>" ));
		<?php endif ?>
		// Setup recurring date input
		$("#recurring_date").datepicker({
			nextText: '&raquo;',
			prevText: '&laquo;',
			firstDay: 1,
			numberOfMonths: 1,
			gotoCurrent: true,
			defaultDate: 0,
			altField: '#recurring_dbdate',
			altFormat: 'yy-mm-dd',
			defaultDate: 0,
			dateFormat: '<?= $general['datepickerformat'];?>',
			regional: '<?= substr($_SESSION['language'],0,2);?>'
		});
		//$("#recurring_date").datepicker('setDate', new Date ( "<?= $_SESSION['selectedDate']; ?>" ));
		// Setup event datepicker
		$("#ev_datepicker").datepicker({
			nextText: '&raquo;',
			prevText: '&laquo;',
			firstDay: 1,
			numberOfMonths: 1,
			gotoCurrent: true,
			altField: '#event_date',
			altFormat: 'yy-mm-dd',
			defaultDate: 0,
			dateFormat: '<?= $general['datepickerformat'];?>',
			regional: '<?= substr($_SESSION['language'],0,2);?>'
		});
		
		<?php if($_SESSION['page']=='3'):?>
			/* Data Graph */
			setTimeout(function(){ 

				// Setup graph 1
		    	$('#graph_week').visualize({
					width: '760px',
					height: '240px',
					colors: ['#26ADE4', '#D1E751']
				}).appendTo('#graph_wrapper1');

				// Setup graph 2
		    	$('#graph_month').visualize({
					type: 'area',
					width: '760px',
					height: '240px',
					colors: ['#26ADE4', '#D1E751']
				}).appendTo('#graph_wrapper2');

				// Setup graph 3
		    	$('#graph_type').visualize({
					type: 'pie',
					width: '760px',
					height: '240px',
					colors: ['#be1e2d','#666699','#ee8310','#92d5ea','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744']
				}).appendTo('#graph_wrapper3');

				$('.visualize').trigger('visualizeRefresh');

			}, 200);
		<?php endif ?>
		<?php if($_SESSION['page']=='6'):?>
				/* JWYSIWYG Editor for description textarea */
				$('#wysiwyg').wysiwyg();
		<?php endif ?>
	});
	</script>
  </body>
</html>