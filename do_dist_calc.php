<?

// ported from: http://www.indo.com/distance/dist.pl
define ("FEET_PER_MILE", 5280); //number of feet in a mile
define ("RADIUS", 3956); //assume spherical earth, radius in miles
define ("RADCONVERT", .017453293); // pi/180
define ("MINUTES_PER_DEGREE", 60);

$lat2 = 30.4015667;
$lon2 = -97.796933;

$lat1 = parse_coords($_POST[lat1]);
$lon1 = parse_coords($_POST[lon1]);

$d = calc_distance($lat1, $lon1, $lat2, $lon2);
$result = sprintf("%.3f", $d);
$units = "miles";
if ($d < .3) {
   $d *= FEET_PER_MILE;
   $result = sprintf("%d", $d);
   $units = "feet";
   if($d < 360) {
   	$lat2 = ddd2dm($lat2);
	$lon2 = ddd2dm($lon2);
   	$msg = "<P><B><CENTER>Congratulations, Your coordinates are within 360 ft of the cache!</B><BR>";
	$msg .= "The cache coordinates are:<BR>";
	$msg .= "Latitude: $lat2<BR>";
	$msg .= "Longitude: $lon2</CENTER></P>";
	}
}

function parse_coords($coord) {
	 $coord = trim($coord);
	 list($degrees, $minutes, $seconds) = preg_split("/[\s ]/ ", $coord);
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
	 return (RADIUS * $c);
}
?>
<HTML>
<HEAD>
<TITLE>Distance Calculation</TITLE>
<link rel="stylesheet" type="text/css" href="css/geo.css" />
</HEAD>
<BODY>
<P><strong>The distance from your coordinates to my cache is:</strong></P>
<? echo "<P>$result $units<BR>$msg</P>"; ?>
<HR>
<address>&copy 2003 <A href = "mailto:banks@arlut.utexas.edu">RogerBanks</A><BR>
<small>Last modified: <? echo date ("F d Y H:i:s.", filemtime("do_dist_calc.php")); ?>
</address>
<TABLE width=100%>
<TR>
<TD align="left"><A href="http://www.php.net"><img src="images/logos/php_logo.gif" alt="php logo" border=0></A></TD>
<TD align="center"><A href="http://www.barebones.com"><img src="images/logos/built_with_bbedit_01.gif" alt="bbedit logo" border=0></A></TD>
<TD align="right"><A HREF="http://www.geocaching.com"><img src="images/logos/geocaching.gif" alt="Let's Go Geocaching" border=0></A></TD>
</TR>
</TABLE>
</BODY>
</HTML>
