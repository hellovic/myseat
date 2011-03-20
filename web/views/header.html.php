<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=pragma content=no-cache/>
<meta http-equiv=cache-control content=no-cache/> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
 
<!-- Website Title --> 
<title><?= $general['app_name'];?></title>

<!-- Meta data for SEO -->
<meta name="description" content="An easy to use Restaurant Reservation System"/>
<meta name="keywords" content="Restaurant Reservation System, Restaurant, Hotel, Reservation"/>
<meta name="author" content="Bernd Orttenburger"/>


<!-- Template stylesheet -->
<link rel="stylesheet" href="css/screen.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/print.css" type="text/css" media="print" >
<link rel="stylesheet" href="css/datepicker.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/tipsy.css" type="text/css" media="all"/>
<link rel="stylesheet" href="js/visualize/visualize.css" type="text/css" media="all"/>
<link rel="stylesheet" href="js/jwysiwyg/jquery.wysiwyg.css" type="text/css" media="all"/>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.0.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/autocomplete.css" type="text/css" media="all"/>
<!-- <link type="text/css" href="css/smoothness/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> -->
<!--[if IE 7]>
	<link href="css/ie7.css" rel="stylesheet" type="text/css" media="all">
<![endif]-->

<!--[if IE]>
	<script type="text/javascript" src="js/excanvas.js"></script>
<![endif]-->

<!-- Jquery and plugins -->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.custom.min.js"></script>

<!-- <script type="text/javascript" src="js/jquery.img.preload.js"></script> -->
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.0.js"></script>
<script type="text/javascript" src="js/hint.js"></script>
<script type="text/javascript" src="js/visualize/jquery.visualize.js"></script>
<script type="text/javascript" src="js/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/browser.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/mColorPicker.js"></script>

<?
list($y,$m,$d)	= explode("-",$_SESSION['selectedDate']);
$pickerDate = $d."/".$m."/".$y;
?>

<script type="text/javascript">
$(document).ready(function(){
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
	// Setup recurring date input
	$("#recurring_date").datepicker({
		nextText: '&raquo;',
		prevText: '&laquo;',
		showAnim: 'slideDown',
		firstDay: 1,
		numberOfMonths: 1,
		gotoCurrent: true,
		defaultDate: 0,
		altField: '#recurring_dbdate',
		altFormat: 'yy-mm-dd',
		dateFormat: '<?= $general['datepickerformat'];?>',
		regional: '<?= substr($_SESSION['language'],0,2);?>'
	});
	$("#recurring_date").datepicker('setDate', new Date ( "<?= $_SESSION['selectedDate']; ?>" ));
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

});
</script>
</head>