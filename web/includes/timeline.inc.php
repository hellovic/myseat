<ul class="timeline">

<?
// get outlet maximum capacity
$maxC = maxCapacity();
// get Pax by timeslot
$resbyTime = reservationsByTime('pax');
$tblbyTime = reservationsByTime('tbl');
// get availability by timeslot
$availability = getAvailability($resbyTime,$general['timeintervall']);
$tbl_availability = getAvailability($tblbyTime,$general['timeintervall']);

// ERROR REPORTING
/*
echo $_SESSION['outlet_max_capacity']."->".$_SESSION['outlet_max_tables']."<br>";
echo"<pre>";
print_r($resbyTime)."<br><br>";
print_r($tblbyTime)."<br><br>";
print_r($availability)."<br><br>";
print_r($tbl_availability);
echo"</pre>";
*/

// actual time rounded half hour  
$round_numerator = 60 * $general['timeintervall']; // 60 seconds per minute * 15 minutes equals 900 seconds
$rounded_time = ( round ( time() / $round_numerator ) * $round_numerator );

//timeline open/close time
//prevent 'division by zero error'
$open_time = ($_SESSION['selOutlet']['outlet_open_time']!="") ? $_SESSION['selOutlet']['outlet_open_time'] : "11:00:00";
$close_time = ($_SESSION['selOutlet']['outlet_close_time']!="") ? $_SESSION['selOutlet']['outlet_close_time'] : "22:00:00";

// calculate after midnight
$day    = date("d");
$endday = ($open_time < $close_time) ? date("d") : date("d")+1;

list($h1,$m1)		= explode(":",$open_time);
list($h2,$m2)		= explode(":",$close_time);
$value  			= mktime($h1+0,$m1+0,0,date("m"),$day,date("Y"));
$endtime		 	= mktime($h2+0,$m2+0,0,date("m"),$endday,date("Y"));
$i 					= 1;

	while( $value <= $endtime )
	{ 
		// generate timeslot value in percentage
		$percentage = ($_SESSION['outlet_max_capacity']>0) ? 100/$_SESSION['outlet_max_capacity'] : 0;
		$tbl_percentage = ($_SESSION['outlet_max_tables']>0) ? 100/$_SESSION['outlet_max_tables'] : 0;
		
		$pax_by_time = ($availability[date('H:i',$value)]) ? $percentage*$availability[date('H:i',$value)] : 2.5;
		$pax_by_time = ( round($pax_by_time,1)>100 ) ? 100 : round($pax_by_time,1);
		
		$tbl_by_time = ($tbl_availability[date('H:i',$value)]) ? $tbl_percentage*$tbl_availability[date('H:i',$value)] : 2.5;
		$tbl_by_time = ( round($tbl_by_time,1)>100 ) ? 100 : round($tbl_by_time,1);
		
		$pax_capacity = $_SESSION['outlet_max_capacity']-$availability[date('H:i',$value)];
		$tbl_capacity = $_SESSION['outlet_max_tables']-$tbl_availability[date('H:i',$value)];
		if ($pax_by_time >= $tbl_by_time){
			$val_capacity = $pax_capacity;
			$val_by_time = $pax_by_time;
			$txt_capacity = $val_capacity."P";
		}else{
			$val_capacity = $tbl_capacity;
			$val_by_time = $tbl_by_time;
			$txt_capacity = $val_capacity."T";
		}
		
		$txt_time = ($general['timeformat'] == 24) ? date('H:i',$value) : date("g:i a", $value);
		if($tbl_by_time == 100){
			$txt_capacity = 0;
		}else if($tbl_by_time <= 25){
			$txt_capacity = $pax_capacity;
		}
		
		// Generating the timeline graph
			echo"<li>\n";
			echo "<span class='label";
			if ($value == $rounded_time) {
				echo " active";
			}
			echo "'>";
			echo $txt_capacity."</span>";
			echo"<span class='label2'>";
			if (date('i',$value)=="00") {
				echo ($general['timeformat'] == 24) ? date('H',$value) : date('h a', $value);
			}
			echo "</span>";
			echo "<span class='count";
			
			if($val_by_time >= 100){
				echo " full ";
			}else if($val_by_time >= 60){
				echo " high ";
			}else if($val_by_time >= 5){
				echo " low ";
			}else if($val_by_time > 3){
				echo " free ";
			}
			if ($value == $rounded_time) {
				echo " active";
			}
			echo "' style='height: ".$val_by_time."%'>(0)</span>\n</li>\n";
	$value = mktime($h1+0,$m1+$i*$general['timeintervall'],0,date("m"),$day,date("Y")); 
	$i++;
	}
?>
<li><span class="label"></span><span class="label2" style='font-weight:normal; color:#bbb;'>&copy;timecontrol</span><span class="count"></span></li>
</ul>