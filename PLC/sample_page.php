<?php session_start();

/** Login **/
require_once '../PLC/plc.class.php';
$user = new flexibleAccess();

if ( $_GET['logout'] == 1 ) 
	$user->logout();
	
if ( !$user->autologin()){
	$_SESSION['forwardPage'] = "home.php";
	header("Location: home.php");
	exit; //To ensure security
}else{
$cookie 		= $user->read_cookie();
$data			= $user->loadUser( $cookie['user_id'] );
$user_id  		= $user->userData[$user->tbFields['userID']];
$user_name 		= $user->userData[$user->tbFields['login']];
$data			= $user->loadUserDetail( $cookie['user_id'] );
$user_fullname 		= $user->userDetail['loggeduser'];
$user_email  		= $user->userDetail['emailaddress'];
$dept_id		= $user->userDetail['department_id'];
$hot_id 		= $user->userDetail['hotelid'];
$role 			= $user->userDetail['account_id'];
$user_time		= date("Y-m-d H:i:s", time());

// Convert user details from single login
// to application details
include("convert_plc.php");

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log-in</title>
<meta name="robots" content="noindex,nofollow" />
</head>
<body>
	<h2>Sample Page for PLC single sign on</h2>

		<?
			echo "<span class='bold'>User ID: </strong>".$user_id."<br/>";
			echo "<span class='bold'>User Name: </strong>".$user_name."<br/>";
			echo "<span class='bold'>Real Name: </strong>".$user_fullname."<br/>";
			echo "<span class='bold'>Email: </strong>".$user_email."<br/>";
			echo "<span class='bold'>Hotel, Department, Role: </strong>".$hot_id.", ".$dept_id.", ".$role."<br/>";
			echo "<br/>";
		?>	


</body>
</html>
