<?php
require_once('includes/load.php');
// Checking userlevel
page_require_level(3);

$d_sale = find_by_id('trade', (int)$_GET['id']);
if (!$d_sale) {
    $session->msg("d", "Missing trade id.");
    redirect('trades.php');
}


$delete_id = delete_by_id('trade', (int)$d_sale['id']);
if ($delete_id) {
    $session->msg("s", "trade deleted.");
    redirect('trades.php');
} else {
    $session->msg("d", "trade deletion failed.");
    redirect('trades.php');
}
