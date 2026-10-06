<?
include("lib.inc.php3");
include("header.inc");

/* $status comes from the URL (index.php3?status=OPEN) */
$orders = load_orders();
$total = 0;
$shown = 0;
?>
<h3>Work orders<? if ($status != "") echo " - ".htmlspecialchars($status); ?></h3>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
<tr bgcolor="#FFCC00">
  <th>#</th><th>Date</th><th>Plate</th><th>Car</th><th>Customer</th><th>Job</th><th>Price</th><th>Status</th>
</tr>
<?
while (list($k, $o) = each($orders)) {
	if ($status != "" && $o["status"] != $status) continue;
	$shown++;
	$total = $total + $o["price"];
	if ($o["status"] == "OPEN") $bg = "#FFFFCC"; else $bg = "#FFFFFF";
?>
<tr bgcolor="<? echo $bg; ?>">
  <td><? echo $o["id"]; ?></td>
  <td><? echo $o["date_in"]; ?></td>
  <td><tt><? echo htmlspecialchars($o["plate"]); ?></tt></td>
  <td><? echo htmlspecialchars($o["car"]); ?></td>
  <td><? echo htmlspecialchars($o["customer"]); ?><br><font size="1"><? echo htmlspecialchars($o["phone"]); ?></font></td>
  <td><? echo htmlspecialchars($o["job"]); ?></td>
  <td align="right"><? echo money($o["price"]); ?></td>
  <td><? if ($o["status"] == "OPEN") { ?>
        <b>OPEN</b> <a href="close_order.php3?id=<? echo $o["id"]; ?>">[close]</a>
      <? } else { echo "done"; } ?></td>
</tr>
<?
}
?>
<tr bgcolor="#EEEEEE">
  <td colspan="6"><b><? echo $shown; ?> order(s)</b></td>
  <td align="right"><b><? echo money($total); ?></b></td><td>&nbsp;</td>
</tr>
</table>
<?
include("footer.inc");
?>
