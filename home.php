<?php
$page_title = 'Startside';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
?>
<?php
$c_categorie = count_by_id('categories');
$c_product = count_by_id('products');
$c_sale = count_by_id('sales');
$c_user = count_by_id('users');
$products_sold = find_higest_saleing_product('10');
$recent_products = find_recent_product_added('5');
$recent_sales = find_recent_sale_added('5');
$storageStatus = storage_status();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel">
            <div class="jumbotron text-center">
                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>
                                    <span class="glyphicon glyphicon-th"></span>
                                    <span>Mest solgte produkter</span>
                                </strong>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Produkt</th>
                                        <th>Antall salg</th>
                                        <th>Totalt antall</th>
                                    <tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($products_sold as $product_sold): ?>
                                        <tr>
                                            <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                                            <td><?php echo (int)$product_sold['totalSold']; ?></td>
                                            <td><?php echo (int)$product_sold['totalQty']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>
                                    <span class="glyphicon glyphicon-th"></span>
                                    <span>Siste salg</span>
                                </strong>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Produkt</th>
                                        <th>Dato</th>
                                        <th>Bruker</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($recent_sales as $recent_sale): ?>
                                        <tr>
                                            <td><?php echo remove_junk(first_character($recent_sale['name'])); ?> </td>
                                            <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
                                            <td><?php echo remove_junk(first_character($recent_sale['username'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>
                                    <span class="glyphicon glyphicon-th"></span>
                                    <span>Lagerstatus</span>
                                </strong>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Produktnavn</th>
                                        <th>KS-lager</th>
                                        <th>Hovedlager</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($storageStatus as $storage): ?>
                                        <tr>
                                            <td><?php echo first_character($storage['name']); ?></td>
                                            <td><?php echo($storage['ks_storage']); ?></td>
                                            <td><?php echo($storage['quantity']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
