<?
$msg = "<FONT size=+2 color = \"red\">Sorry, Wrong answer</FONT>";
$day = $_POST[day];
$place = $_POST[place];
$name = $_POST[name];
if((trim($day) == "thur") && (trim($place) == "walnut") && (trim($name) == "dark_cache")) {
	$msg = "<CENTER><B><FONT size=+1 color=\"green\">You are correct!!!</FONT></B>";
	$msg .= "<P>The Cache is located at:<BR>";
	$msg .= "Latitude: N30&deg 24.263<BR>";
	$msg .= "Longitude: W97&deg 41.417</P></CENTER>";
}
?>
<HTML>
<HEAD>
<TITLE>Check Your Answer</TITLE>
<link rel="stylesheet" type="text/css" href="css/geo.css" />
</HEAD>
<BODY>
<h1>Checking answer ...</h1>
<?
echo "$msg";
?>
<HR>
<address>&copy 2003 <A href = "mailto:banks@arlut.utexas.edu">RogerBanks</A><BR>
<small>Last modified: <? echo date ("F d Y H:i:s.", filemtime("do_check_answer.php")); ?>
</address>
<TABLE width=100%>
<TR>
<TD align="left"><A href="http://www.php.net"><img src="images/logos/php_logo.gif" alt="php logo" border=0></A></TD>
<TD align="right"><A HREF="http://www.geocaching.com"><img src="images/logos/geocaching.gif" alt="Let's Go Geocaching" border=0></A></TD>
</TR>
</TABLE>
</BODY>
</HTML> 