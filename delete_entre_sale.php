<?php
require_once('includes/load.php');
// Checking userlevel
page_require_level(5);

$d_sale = find_by_id('entre_sales', (int)$_GET['id']);
if (!$d_sale) {
    $session->msg("d", "3Missing sale id.");
    redirect('entre_sales.php');
}

storage_fix_entre_deletion($d_sale['product_id'], $d_sale['qty']);

$delete_id = delete_by_id('entre_sales', (int)$d_sale['id']);
if ($delete_id) {
    $session->msg("s", "sale deleted.");
    redirect('entre_sales.php');
} else {
    $session->msg("d", "sale deletion failed.");
    redirect('entre_sales.php');
}
