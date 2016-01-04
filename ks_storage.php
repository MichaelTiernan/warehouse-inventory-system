<?php
$page_title = 'KS-lager';
require_once('includes/load.php');
include_once('layouts/header.php');

// Checking userlevel
page_require_level(2);

//Show only own sales, unless userlevel is admin
if (get_userlevel() == 1) {
    $is_admin = true;
} else {
    $is_admin = false;
}

$storageStatus = storage_status();
$prod_id = get_last_product_id();
$dbupdate = false;

$storageProd = [];

foreach ($storageStatus as $stg) {
    array_push($storageProd, $stg);
}


if (isset($_POST['ks-storage'])) {
    $max = count($_POST['id']);

    for ($i = 0; $i < $max; $i++) {
        $refillSum = 0;
        $hovedSum = 0;


        if ($_POST['refill'][$i] > 0) {
            $refillSum = $storageProd[$i]['ks_storage'] + $_POST['refill'][$i];
            $hovedSum = $storageProd[$i]['quantity'] - $_POST['refill'][$i];

            echo "refill $refillSum  hovedsum $hovedSum  hlager {$storageProd[$i]['quantity']}";

            $query = "UPDATE products SET ks_storage = {$refillSum}, quantity = {$hovedSum} WHERE id = {$_POST['id'][$i]}";
            $result = $db->query($query);
            storage_log($hovedSum, $refillSum, $_POST['id'][$i]);

            if ($result && $db->affected_rows() === 1) {
                $dbupdate = true;
            }
        }
    }

    if ($dbupdate) {
        $session->msg('s', "Lagerstatus oppdatert");
//        redirect('home.php', true);
        echo "<meta http-equiv=\"refresh\" content=\"0\">";
    } else {
        $session->msg('d', ' Sorry failed to update!');
//        redirect('home.php', false);
    }

    $dbupdate = false;
}

?>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Lagerstatus</span>
                    </strong>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 25%">Produkt</th>
                                <th class="text-center" style="width: 10%">Hovedlager</th>
                                <th class="text-center" style="width: 10%">KS-lager</th>
                                <th class="text-center" style="width: 25%">Påfyll</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($storageStatus as $storage):
                                $storageID = $storage['id'];
                                $ks_storage_value = $storage['ks_storage'];
                                $hovedlager_value = $storage['quantity'];
                                ?>
                                <tr class="text-center">
                                    <td>
                                        <?php echo first_character($storage['name']); ?>
                                        <input type="number" name="id[]" value="<?php echo($storageID) ?>" hidden>
                                    </td>
                                    <td><?php echo($storage['quantity']); ?></td>
                                    <td><?php echo($storage['ks_storage']); ?></td>
                                    <td><input class="form-control" name="refill[]" type="number" min="0" placeholder="Antall lagt til på lager"></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <button type="submit" name="ks-storage" class="btn btn-success">Fullfør</button>
                                </td>
                            </tr>
                            <tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php include_once('layouts/footer.php'); ?>