<?php
$page_title = 'Add Product';
require_once('includes/load.php');
// Checking userlevel
page_require_level(2);
$all_categories = find_all('categories');
$all_photo = find_all('media');
?>
<?php
if (isset($_POST['add_product'])) {
    $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'saleing-price', 'ks_storage');
    validate_fields($req_fields);
    if (empty($errors)) {
        $p_name = remove_junk($db->escape($_POST['product-title']));
        $p_cat = remove_junk($db->escape($_POST['product-categorie']));
        $p_qty = remove_junk($db->escape($_POST['product-quantity']));
        $p_ksStorage = remove_junk($db->escape($_POST['ks_storage']));
        $p_buy = remove_junk($db->escape($_POST['buying-price']));
        $p_sale = remove_junk($db->escape($_POST['saleing-price']));
        $p_number = remove_junk($db->escape($_POST['product-number']));
        $hasMAC = remove_junk($db->escape($_POST['hasMac']));

        if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
            $media_id = '0';
        } else {
            $media_id = remove_junk($db->escape($_POST['product-photo']));
        }
        $date = make_date();
        $query = "INSERT INTO products (";
        $query .= " name, quantity, ks_storage, sale_price, categorie_id, media_id, product_number, date, buy_price, hasMAC";
        $query .= ") VALUES (";
        $query .= " '{$p_name}', '{$p_qty}', '{$p_ksStorage}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$p_number}', '{$date}', '{$p_buy}', '{$hasMAC}'";
        $query .= ")";
        $query .= " ON DUPLICATE KEY UPDATE name='{$p_name}'";
        if ($db->query($query)) {
            $session->msg('s', "Product added ");
            redirect('add_product.php', false);
        } else {
            $session->msg('d', ' Sorry failed to added!');
            redirect('product.php', false);
        }

    } else {
        $session->msg("d", $errors);
        redirect('add_product.php', false);
    }

}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Legg til produkt</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_product.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                                <input type="text" class="form-control" name="product-title" placeholder="Produktnavn">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="product-categorie">
                                        <option value="">Produktkategori</option>
                                        <?php foreach ($all_categories as $cat): ?>
                                            <option value="<?php echo (int)$cat['id'] ?>">
                                                <?php echo $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="product-photo">
                                        <option value="">Produktfoto</option>
                                        <?php foreach ($all_photo as $photo): ?>
                                            <option value="<?php echo (int)$photo['id'] ?>">
                                                <?php echo $photo['file_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                     <span class="input-group-addon">
                                      <i>Stk</i>
                                     </span>
                                        <input type="number" class="form-control" name="product-quantity" placeholder="Hovedlager">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group">
                                     <span class="input-group-addon">
                                       <i>Stk</i>
                                     </span>
                                        <input type="number" class="form-control" name="ks_storage" placeholder="KS-lager">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-info-sign"></i>
                                      </span>
                                        <input type="text" class="form-control" name="product-number" placeholder="Siebelkode">
                                    </div>
                                </div>

                                <div class="col-md-4"  style="padding-top: 15px">
                                    <div class="input-group">
                                         <span class="input-group-addon">
                                           <i class="glyphicon glyphicon-info-sign"></i>
                                         </span>
                                        <input type="number" class="form-control" name="buying-price" placeholder="Innkjøpspris">
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 15px">
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-info-sign"></i>
                                      </span>
                                        <input type="number" class="form-control" name="saleing-price" placeholder="Pris">
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 15px">
                                    <select class="form-control" name="hasMac">
                                        <option value="0">Ingen MAC</option>
                                        <option value="1">Har MAC</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-danger">Legg til</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
