/* This is the loader for the mySeat Reclame Box */
<?php 
// Get global file path
function GetFileDir($php_self){
	$filename = explode("/", $php_self); // THIS WILL BREAK DOWN THE PATH INTO AN ARRAY
		for( $i = 0; $i < (count($filename) - 2); ++$i ) {
			$filename2 .= $filename[$i].'/';
		}
	return $filename2;
}

/* Set global base path */
$global_basedir = '';
if ($_SERVER['HTTPS']) {
	$global_basedir = 'https://';
}else{
	$global_basedir = 'http://';
}
$global_basedir .= $_SERVER['SERVER_NAME'].GetFileDir($_SERVER['PHP_SELF']);
?>
(function(){
  var url = "<?php echo $global_basedir;?>widget/widget.php?" + "propertyID=" + propertyID + "&outletID=" + outletID  ;
  document.write("<iframe src='" + url + "' style='border: none !important;'></iframe>");
})()
