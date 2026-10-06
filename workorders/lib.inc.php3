<?
/*
 * lib.inc.php3 - shared functions
 * Data is stored in a flat text file, one order per line:
 *   id|date_in|plate|car|customer|phone|job|price|status
 * (we don't have MySQL on the shop PC, flat file is fine for now - RT)
 */
include("config.inc.php3");

function load_orders() {
	global $CFG_DATA_FILE;
	$orders = array();
	if (!file_exists($CFG_DATA_FILE)) {
		return $orders;
	}
	$lines = file($CFG_DATA_FILE);
	$i = 0;
	while (list($n, $line) = each($lines)) {
		$line = chop($line);
		if ($line == "") continue;
		$f = explode("|", $line);
		$o["id"]       = $f[0];
		$o["date_in"]  = $f[1];
		$o["plate"]    = $f[2];
		$o["car"]      = $f[3];
		$o["customer"] = $f[4];
		$o["phone"]    = $f[5];
		$o["job"]      = $f[6];
		$o["price"]    = $f[7];
		$o["status"]   = $f[8];
		$orders[$i] = $o;
		$i++;
	}
	return $orders;
}

function save_orders($orders) {
	global $CFG_DATA_FILE;
	$fp = fopen($CFG_DATA_FILE, "w");
	if (!$fp) {
		echo "<b>ERROR: cannot write $CFG_DATA_FILE (check permissions!)</b>";
		return 0;
	}
	flock($fp, 2);
	reset($orders);
	while (list($k, $o) = each($orders)) {
		fputs($fp, $o["id"]."|".$o["date_in"]."|".$o["plate"]."|".$o["car"]."|".
		           $o["customer"]."|".$o["phone"]."|".$o["job"]."|".
		           $o["price"]."|".$o["status"]."\n");
	}
	flock($fp, 3);
	fclose($fp);
	return 1;
}

function next_id($orders) {
	$max = 1000;
	reset($orders);
	while (list($k, $o) = each($orders)) {
		if ($o["id"] > $max) $max = $o["id"];
	}
	return $max + 1;
}

/* the | character would break the file */
function clean($s) {
	$s = ereg_replace("[|\r\n]", " ", $s);
	return trim($s);
}

function money($v) {
	global $CFG_CURRENCY;
	return number_format($v, 2, ",", ".")." ".$CFG_CURRENCY;
}
?>
