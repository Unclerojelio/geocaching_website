<?

// Auther:   Roger Banks
// Date:     6 Mar 2003
// File:     display.php
// Language: PHP
//
// Usage: "http://.../display.php?[gallery=$gallery]
//		$gallery is the file path to the input file
//
// Description:
// This script reads the filename in the variable $gallery and
// displays it in the browser as a table. Provides the ability
// to sort, add, and delete records.
//
// Change Log:
// 6 Mar 2003	Started Project
// 7 Mar 2003	Added functionality to add and remove entries
//
// Todo:

function rocket_sort($a, $b) {
	return ($a[1] == $b[1]) ? 0 : (($a[1] < $b[1]) ? -1 : 1);
}

function launch_sort($a, $b) {
	return ($a[2] == $b[2]) ? 0 : (($a[2] < $b[2]) ? -1 : 1);
}

if($gallery == "") $gallery = "gallery.txt";

// Open the gallery file and parse each of the lines
// into the array $line. If the key of one of the lines matches what we are
// looking for, save the line to the array $lines.
if (!$fp = fopen($gallery, "r")) {
	echo "Could not open file $gallery!";
} else { // file opened successfully
	while($line = fgetcsv($fp,1024,"|")) {
		$lines[] = $line;
	}	
	fclose($fp); // Close "gallery.txt"
	
	// If user has already been to this page and selected items to delete
	// go ahead and delete them from the array.
	if($s == "delete" || is_array($selected)) {
		foreach($selected as $item) {
			echo "Delete item: $item<BR>";
			// add code here to delete items from the array (array_splice)
			// and then write the array back out to the file.
		}
	}

	$num_files = count($lines);     // Count the number of lines found
	if($sort_key == 0) sort($lines);
	elseif ($sort_key == 1) usort($lines, 'rocket_sort');
	elseif ($sort_key == 2) usort($lines, 'launch_sort');

	echo "<html>";
	echo "<head>";
	echo "<title>Roger's Rocket Gallery</title>";
	echo "</head>";
	
	echo "<body>";
	echo "<center><h1>Roger's Rocket Gallery</h1></center>";
	
	echo "<form action=$PHP_SELF method=\"POST\">";
	echo "<Center>";
	echo "<TABLE width = \"50%\" border=0>";
	echo "<TR>";
	echo "<TH align=\"left\"><input type=\"submit\" name=\"s\" value=\"delete\"></TH>";
	echo "<TH align=\"left\"><A HREF=\"$PHP_SELF\">Name</A></TH>";
	echo "<TH align=\"left\"><A HREF=\"$PHP_SELF?sort_key=1\">Number</A></TH>";
	echo "<TH align=\"left\"><A HREF=\"$PHP_SELF?sort_key=2\">Launch</A></TH>";
	echo "<TH align=\"left\">Comments</TH>";
	foreach($lines as $line) {
		echo "<TR>";
		echo "<TD>";
		echo "<input type=\"checkbox\" name=\"selected[]\" value=\"$line[0]\">";
		echo "</TD>";
		foreach($line as $field) {
			echo "<TD>";
			echo $field;
			echo "</TD>";
		}
		echo "</TR>"; 
	}
	echo "</TABLE>"; // close outer table
	echo "</Center>";
	echo "<A HREF=\"add.php\">Add a new picture</A>";
}

// end of script
?>

<HR>
&copy<A href = "mailto:banks@arlut.utexas.edu">RogerBanks</A> - 2003
<TABLE width=100%>
<TR>
<TD align="left"><A href="http://www.php.net"><img src="images/logos/php_logo.gif" alt="php logo" border=0></A></TD>
<TD align="right"><A href="http://www.barebones.com"><img src="images/logos/built_with_bbedit_01.gif" alt="bbedit logo" border=0></A></TD>
</TR>
</TABLE>
</body>
</html>