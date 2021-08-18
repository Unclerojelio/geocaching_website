<?php
define ("FEET_PER_MILE", 5280); //number of feet in a mile
define ("RADIUS", 3956); //assume spherical earth, radius in miles
define ("RADCONVERT", .017453293); // pi/180
define ("MINUTES_PER_DEGREE", 60);
define ("SECONDS_PER_MINUTE", 60);

$msg = "";

$lat2 = 30.27040;
$lon2 = -97.83521;

$lat1 = parse_coords($_POST["lat1"]);
$lon1 = parse_coords($_POST["lon1"]);

$b = calc_bearing($lat1, $lon1, $lat2, $lon2);
$result = round($b);
$units = "degrees (True)";
$dist = calc_distance($lat1, $lon1, $lat2, $lon2);
$dist = $dist * RADIUS * FEET_PER_MILE; //convert to feet
if($dist < 300) {
	$lat2 = ddd2dm($lat2);
	$lon2 = ddd2dm($lon2);
	$msg = "<P><B><CENTER>Congratulations, Your coordinates are within 300 ft of the cache!</B><BR>";
	$msg .= "The cache coordinates are:<BR>";
	$msg .= "Latitude: $lat2<BR>";
	$msg .= "Longitude: $lon2</CENTER></P>";
}

function parse_coords($coord) {
	 $coord = trim($coord);
	 $coordArray = preg_split("/[\s ]/ ", $coord);
	 $degrees = $coordArray[0] ?? 0;
     $minutes = $coordArray[1] ?? 0;
     $seconds = $coordArray[2] ?? 0;
	 return dms2ddd($degrees, $minutes, $seconds);
}

function dms2ddd($degrees, $minutes, $seconds) {
	 if($degrees < 0) {
	    return ($degrees - ($minutes + ($seconds / 60)) / 60);
	 } else {
	   return ($degrees + ($minutes + ($seconds / 60)) / 60);
	 }
}

function ddd2dm($ddegrees) { //output is html-ized
	list($degrees, $minutes) = explode(".", $ddegrees);
	return $degrees . "&deg " . (("." . $minutes) * MINUTES_PER_DEGREE) . "&#39";
}

function calc_distance($lat1, $lon1, $lat2, $lon2) {
	 $dlat = $lat2 - $lat1;
	 $dlon = $lon2 - $lon1;

	 $a = pow((sin($dlat * RADCONVERT/2)),2) + cos($lat1 * RADCONVERT) * cos($lat2 * RADCONVERT) * pow((sin($dlon * RADCONVERT/2)),2);
	 $c = 2 * asin(min(1,sqrt($a)));
	 return $c;
}

function calc_bearing($lat1, $lon1, $lat2, $lon2) {
	$d = calc_distance($lat1, $lon1, $lat2, $lon2);
	if($d == 0) return 0;
	$bearing = acos((sin($lat2 * RADCONVERT) - sin($lat1 * RADCONVERT) * cos($d)) / (sin($d) * cos($lat1 * RADCONVERT)));
	if($lon1 > $lon2) {
		$bearing = 6.2830 - $bearing;
	}
	return $bearing / RADCONVERT;
}
?>
<HTML>
<HEAD>
<TITLE>Bearing Calculation</TITLE>
<link rel="stylesheet" type="text/css" href="css/geo.css" />
</HEAD>
<BODY>
<P><strong>The bearing from your coordinates to my cache is:</strong></P>
<?php echo "<P>$result $units<BR>$msg</P>"; ?>
<HR>
<address>&copy 2003 <A href = "mailto:roger_banks@mac.com">RogerBanks</A><BR>
<small>Last modified: <?php echo date ("F d Y H:i:s.", filemtime("do_bearing_calc.php")); ?>
</address>
<!--
<TABLE width=100%>
<TR>
<TD align="left"><A href="http://www.php.net"><img src="images/PHP.png" alt="php logo" border=0></A></TD>
<TD align="right"><A HREF="http://www.geocaching.com"><img src="images/geocaching.jpg" alt="Let's Go Geocaching" border=0></A></TD>
</TR>
</TABLE>
-->
</BODY>
</HTML>
