<?php
$page_title = 'Edit sale';
require_once('includes/load.php');
// Checking userlevel
page_require_level(3);


$sale = find_by_id('sales', (int)$_GET['id']);
$mac = (remove_junk($sale['mac']));
if (!$sale) {
    $session->msg("d", "Missing product id.");
    redirect('sales.php');
}

$product = find_by_id('products', $sale['product_id']);

if (isset($_POST['update_sale'])) {
    $req_fields = array('title', 'quantity', 'price', 'total', 'date', 'custnr', 'comment');
    validate_fields($req_fields);
    if (empty($errors)) {
        $p_id = $db->escape((int)$product['id']);
        $s_qty = $db->escape((int)$_POST['quantity']);
        $s_total = $db->escape($_POST['total']);
        $date = $db->escape($_POST['date']);
        $custnr = $db->escape($_POST['custnr']);
        $comment = $db->escape($_POST['comment']);
        $s_date = date("Y-m-d", strtotime($date));
        $s_mac = $db->escape($_POST['mac']);

        $qty_change = $s_qty - $sale['qty'];

        $sql = "UPDATE sales SET";
        $sql .= " product_id= '{$p_id}',qty={$s_qty},price='{$s_total}',date='{$s_date}', custnr='{$custnr}', comment='{$comment}', mac='{$s_mac}'";
        $sql .= " WHERE id ='{$sale['id']}'";
        $result = $db->query($sql);

        if ($result && $db->affected_rows() === 1) {
            if ($s_qty != $product['ks_storage']) {
                update_product_qty($qty_change, $p_id);
                $session->msg('s', "Sale updated.");
                redirect('edit_sale.php?id=' . $sale['id'], false);
            } else {
                $session->msg('s', "Sale updated.");
                redirect('edit_sale.php?id=' . $sale['id'], false);
            }
        } else {
            $session->msg('d', ' Sorry failed to update!');
            redirect('sales.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_sale.php?id=' . (int)$sale['id'], false);
    }
}

include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All Sales</span>
                </strong>

                <div class="pull-right">
                    <a href="sales.php" class="btn btn-primary">Show all sales</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <th> Produkt</th>
                    <th> Antall</th>
                    <th> Pris</th>
                    <th> Total</th>
                    <th> Dato</th>
                    <th> Kundenummer</th>
                    <th> MAC </th>
                    <th> Kommentar</th>
                    </thead>
                    <tbody id="product_info">
                    <tr>
                        <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
                            <td id="s_name">
                                <input type="text" class="form-control" id="sug_input" name="title" value="<?php echo remove_junk($product['name']); ?>">

                                <div id="result" class="list-group"></div>
                            </td>
                            <td id="s_qty">
                                <input type="text" class="form-control" name="quantity" value="<?php echo (int)$sale['qty']; ?>">
                            </td>
                            <td id="s_price">
                                <input type="text" class="form-control" name="price" value="<?php echo remove_junk($product['sale_price']); ?>" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="total" value="<?php echo remove_junk($sale['price']); ?>" readonly>
                            </td>
                            <td id="s_date">
                                <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>">
                            </td>
                            <td>
                                <input type='number' class='form-control' name='custnr' value="<?php echo remove_junk($sale['custnr']); ?>" required>
                            </td>
                            <td>
                                <?php
                                if ($product['hasMAC'] > 0) {
                                    echo("<input type='text' class='form-control' name='mac' maxlength='17' value='{$mac}' >");
                                } else {
                                    echo("<input type='text' class='form-control' name='mac' maxlength='17' value='{$mac}' readonly>");
                                }
                                ?>
                            </td>
                            <td>
                                <textarea name="comment" rows="1" style="width: 100%"><?php echo remove_junk($sale['comment']); ?></textarea>
                            </td>
                            <td>
                                <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
                            </td>
                        </form>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>

<?php include_once('layouts/footer.php'); ?>
