<?php
$page_title = 'Lagerstatus';
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


if (isset($_POST['storage'])) {
    for ($i = 1; $i < $prod_id[0]['MAX(id)']; $i++) {
        $I_hovedlager = $_POST["hovedlager-$i"];
        $I_kslager = $_POST["ks-lager-$i"];

        $oldHoved = $storageStatus[$i]['quantity'];
        $oldKS = $storageStatus[$i]['ks_storage'];

        $hovedDiff = $I_hovedlager - $oldHoved;

        $hoved = $I_hovedlager - $hovedDiff;

        //TODO legge inn if som sjekker om verdier har vært forandret og fiks quantity
        //TODO Quantity fikses med å hente gammel verdi for kslageret og ta quantity minus den.
        //TODO Legge til if som setter quantity til 0?

        $query = "UPDATE products SET ks_storage = '{$I_kslager}', quantity = '{$I_hovedlager}' WHERE id = '{$i}'";
        $result = $db->query($query);
        if ($result && $db->affected_rows() === 1) {
            $dbupdate = true;
        }
    }


    //TODO viser ikke statusmelding på oppdatert lager.
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
                                <th class="text-center" style="width: 20%">Produkt</th>
                                <th class="text-center" style="width: 20%">Hovedlager</th>
                                <th class="text-center" style="width: 20%">KS-lager</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($storageStatus as $storage):
                                $storageID = $storage['id'];
                                $ks_storage_value = $storage['ks_storage'];
                                $hovedlager_value = $storage['quantity'];
                                ?>
                                <tr class="text-center">
                                    <td><?php echo first_character($storage['name']); ?></td>
                                    <?php echo("<td><input type='number' class='form-control' name='hovedlager-$storageID' value='$hovedlager_value' required>"); ?>
                                    <td><input type="number" class="form-control" name="ks-lager-<?php echo($storage['id']); ?>" value="<?php echo($storage['ks_storage']); ?>" required></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    <button type="submit" name="storage" class="btn btn-danger">Oppdater lagerstatus</button>
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