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

$storageProd = [];

foreach ($storageStatus as $stg) {
    array_push($storageProd, $stg);
}

if (isset($_POST['storage'])) {
    $max = count($_POST['hovedlager']);

    for ($i = 0; $i < $max; $i++) {
        $I_hovedlager = $_POST["hovedlager"][$i];
        $I_kslager = $_POST["ks-lager"][$i];
        $I_m_storage = $_POST["m_storage"][$i];


        $changeKS = $storageProd[$i]['ks_storage'] != $I_kslager;
        $changeH = $storageProd[$i]['quantity'] != $I_hovedlager;
        $changeM = $storageProd[$i]['m_storage'] != $I_m_storage;


        $KS_qty = $I_kslager - $storageProd[$i]['ks_storage'];
        $H_qty = $I_hovedlager - $storageProd[$i]['quantity'];
        $M_qty = $I_m_storage - $storageProd[$i]['m_storage'];

        if ($changeKS || $changeH || $changeM) {
            $query = "UPDATE products SET ks_storage = '{$I_kslager}', quantity = '{$I_hovedlager}', m_storage = '{$I_m_storage}', last_edited_by = '{$_SESSION['user_id']}' WHERE id = '{$_POST['id'][$i]}'";
            $result = $db->query($query);
            storage_log_ext($H_qty, $KS_qty, $M_qty, $_POST['id'][$i]);


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
                                <th class="text-center" style="width: 20%">Produkt</th>
                                <th class="text-center" style="width: 20%">Hovedlager</th>
                                <th class="text-center" style="width: 20%">KS-lager</th>
                                <th class="text-center" style="width: 20%">Montørlager</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($storageStatus as $storage):
                                $storageID = $storage['id'];
                                $ks_storage_value = $storage['ks_storage'];
                                $hovedlager_value = $storage['quantity'];
                                $m_storage_value = $storage['m_storage'];
                                ?>
                                <tr class="text-center">
                                    <td><?php echo first_character($storage['name']); ?></td>
                                    <td><input type='number' class='form-control' name='hovedlager[]' value="<?php echo($hovedlager_value); ?>" required></td>
                                    <td>
                                        <input type="number" class="form-control" name="ks-lager[]" value="<?php echo($storage['ks_storage']); ?>" required>
                                        <input type="number" name="id[]" value="<?php echo($storageID) ?>" hidden>
                                    </td>
                                    <td>
                                        <input type='number' class='form-control' name='m_storage[]' value="<?php echo($m_storage_value); ?>" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <button type="submit" name="storage" class="btn btn-success">Oppdater lagerstatus</button>
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