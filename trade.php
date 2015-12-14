<?php
$page_title = 'Retur';
require_once('includes/load.php');
// Checking userlevel
page_require_level(4);

include_once('layouts/header.php');

if (get_userlevel() == 1) {
    $isAdmin = true;
} else {
    $isAdmin = false;
}

$prod_id = get_last_product_id();


if ($isAdmin) {
    $products = get_products_from_categories();
    $categories = find_all('categories');
} else {
    $categories = get_categories_user();
    $products = get_products_user();
}
?>
<script type="text/javascript" src="includes/jquery.js"></script>
<script type="text/javascript" src="add_prod.js"></script>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Retur</span>
            </strong>
        </div>
        <div class="panel-body">
            <div id="productButton">
                <?php foreach ($products as $prod): ?>
                    <button name="<?php echo($prod['id']); ?>" class="btn btn-danger"><?php echo $prod['name']; ?></button>
                <?php endforeach; ?>
            </div>
            <form method="post" action="add_trade.php">
                <div class="form-group" style="margin-top: 15px">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                      <i class="glyphicon glyphicon-info-sign"></i>
                                 </span>
                                <input class="form-control" type="number" min="0" max="10000000" size="8" name="custnr" placeholder="Kundenummer" autocomplete="on" style="min-width: 350px">
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="hidden" class="form-control datePicker" name="date" data-date data-date-format="yyyy-mm-dd" required placeholder="Dato">
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                      <i class="glyphicon glyphicon-info-sign"></i>
                                 </span>
                                <textarea rows="1" class="form-control" type="text" name="comment" placeholder="Kommentar" style="min-width: 350px" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <th style="width: 33%"> Produkt</th>
                    <th style="width: 33%"> Pris</th>
                    <th style="width: 33%"> Antall</th>
                    </thead>

                    <tbody id="result">

                    </tbody>
                    <button type="submit" name="sale" class="btn btn-primary">Fullfør</button>
            </form>
            </table>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>