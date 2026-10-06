<?
include("lib.inc.php3");
include("header.inc");

/* $id from URL, $price from the form */
$orders = load_orders();
$found = -1;
while (list($k, $o) = each($orders)) {
	if ($o["id"] == $id) $found = $k;
}

if ($found == -1) {
	echo "<p><b>Order #".htmlspecialchars($id)." not found.</b></p>";
} else if ($submit != "") {
	$price = ereg_replace(",", ".", $price);
	$orders[$found]["price"]  = sprintf("%.2f", $price);
	$orders[$found]["status"] = "DONE";
	if (save_orders($orders)) {
		echo "<p><b>Order #$id closed: ".money($orders[$found]["price"]).".</b> <a href=\"index.php3\">Back</a></p>";
	}
} else {
	$o = $orders[$found];
?>
<h3>Close order #<? echo $o["id"]; ?></h3>
<p><? echo htmlspecialchars($o["car"]); ?> (<? echo htmlspecialchars($o["plate"]); ?>) - <? echo htmlspecialchars($o["job"]); ?></p>
<form method="post" action="<? echo $PHP_SELF; ?>">
<input type="hidden" name="id" value="<? echo $o["id"]; ?>">
Final price (<? echo $CFG_CURRENCY; ?>): <input type="text" name="price" size="8" value="<? echo $o["price"]; ?>">
<input type="submit" name="submit" value="Close order">
</form>
<?
}
include("footer.inc");
?>
