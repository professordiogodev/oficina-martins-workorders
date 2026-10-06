<?
include("lib.inc.php3");
include("header.inc");

/* form fields arrive as globals: $plate, $car, $customer, $phone, $job */
$error = "";
if ($submit != "") {
	if (clean($plate) == "" || clean($customer) == "") {
		$error = "Plate and customer are required.";
	} else {
		$orders = load_orders();
		$o["id"]       = next_id($orders);
		$o["date_in"]  = date("Y-m-d");
		$o["plate"]    = strtoupper(clean($plate));
		$o["car"]      = clean($car);
		$o["customer"] = clean($customer);
		$o["phone"]    = clean($phone);
		$o["job"]      = clean($job);
		$o["price"]    = "0.00";
		$o["status"]   = "OPEN";
		$orders[count($orders)] = $o;
		if (save_orders($orders)) {
			echo "<p><b>Order #".$o["id"]." created.</b> <a href=\"index.php3?status=OPEN\">See open orders</a></p>";
			include("footer.inc");
			exit;
		}
	}
}
?>
<h3>New work order</h3>
<? if ($error != "") echo "<p><font color=\"red\"><b>$error</b></font></p>"; ?>
<form method="post" action="<? echo $PHP_SELF; ?>">
<table border="0" cellpadding="3">
<tr><td>Plate *</td><td><input type="text" name="plate" size="10" maxlength="10" value="<? echo htmlspecialchars($plate); ?>"></td></tr>
<tr><td>Car</td><td><input type="text" name="car" size="40" value="<? echo htmlspecialchars($car); ?>"></td></tr>
<tr><td>Customer *</td><td><input type="text" name="customer" size="40" value="<? echo htmlspecialchars($customer); ?>"></td></tr>
<tr><td>Phone</td><td><input type="text" name="phone" size="15" value="<? echo htmlspecialchars($phone); ?>"></td></tr>
<tr><td valign="top">Job</td><td><textarea name="job" rows="3" cols="40"><? echo htmlspecialchars($job); ?></textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Create order"></td></tr>
</table>
</form>
<?
include("footer.inc");
?>
