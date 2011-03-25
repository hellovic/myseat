<?
// General settings per resort from database
$general = array();
$general = querySQL('settings_inc');
	//print_r($general);

if($_SESSION['valid_user']==TRUE){
	$_SESSION['language'] = $general['language'];
}

// Set default timezone in PHP 5.
if ( function_exists( 'date_default_timezone_set' ) ){
	date_default_timezone_set( $general['timezone'] );
}
/* Set locale to Dutch */
setlocale(LC_ALL, $general['language']);

?>

