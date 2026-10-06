<?
/*
 * export.php3 - dump all orders as CSV (for the accountant, opens in Excel 97)
 */
include("lib.inc.php3");

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=orders_".date("Ymd").".csv");

echo "id;date_in;plate;car;customer;phone;job;price;status\r\n";
$orders = load_orders();
while (list($k, $o) = each($orders)) {
	echo $o["id"].";".$o["date_in"].";".$o["plate"].";\"".$o["car"]."\";\"".
	     $o["customer"]."\";".$o["phone"].";\"".$o["job"]."\";".
	     ereg_replace("\\.", ",", $o["price"]).";".$o["status"]."\r\n";
}
?>
