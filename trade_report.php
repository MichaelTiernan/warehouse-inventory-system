<?php
$page_title = 'Returrapport';
$results = '';
require_once('includes/load.php');
// Checking userlevel
page_require_level(1);

if (isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);
    $returnCategories = find_all('returnCategory');


    if (empty($errors)):
        $idArray = [];
        $resultArray = [];
        $end_date_storage = [];
        $return_total = [];
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));

        //finner alle unike produktid-er der det har vært trades.
        $p_id = get_unique_pid_trades($start_date, $end_date);

        //Pusher de til array så de kan lett itereres.
        foreach ($p_id as $id) {
            array_push($idArray, $id);
            array_push($return_total, get_trade_total($start_date, $end_date, $id['product_id']));
        }

    //skal her hente ut returinfo for produktene. har produkt-id, trenger kun hvor mange som har blitt returnert av hver FK_returncategoryID
    //må mekke en funksjon som returnerer summen av antallet som har vært returnert. Array i en array? Sjekke for p_id og deretter RC_id per funksjon? Så springe en liten for-loop inne i foreach.


    else:
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    endif;

} else {
    $session->msg("d", "Velg datoer");
    redirect('sales_report.php', false);
}
?>
<!doctype html>
<html lang="no">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Salgsrapport</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <style>
        @media print {
            html, body {
                font-size: 9.5pt;
                margin: 0;
                padding: 0;
            }

            .page-break {
                page-break-before: always;
                width: auto;
                margin: auto;
            }
        }

        .page-break {
            width: 980px;
            margin: 0 auto;
        }

        .sale-head {
            margin: 40px 0;
            text-align: center;
        }

        .sale-head h1, .sale-head strong {
            padding: 10px 20px;
            display: block;
        }

        .sale-head h1 {
            margin: 0;
            border-bottom: 1px solid #212121;
        }

        .table > thead:first-child > tr:first-child > th {
            border-top: 1px solid #000;
        }

        table thead tr th {
            text-align: center;
            border: 1px solid #ededed;
        }

        table tbody tr td {
            vertical-align: middle;
        }

        .sale-head, table.table thead tr th, table tbody tr td, table tfoot tr td {
            border: 1px solid #212121;
            white-space: nowrap;
        }

        .sale-head h1, table thead tr th, table tfoot tr td {
            background-color: #f8f8f8;
        }

        tfoot {
            color: #000;
            text-transform: uppercase;
            font-weight: 500;
        }
    </style>
</head>
<body>
<?php if ($idArray): ?>
    <div class="page-break">
        <div class="sale-head pull-right">
            <h1>Rapport Returer</h1>
            <strong><?php if (isset($start_date)) {
                    echo $start_date;
                } ?> til <?php if (isset($end_date)) {
                    echo $end_date;
                } ?> </strong>
        </div>
        <table class="table table-border">
            <thead>
            <tr>
                <th>Produktnavn</th>
                <th>Antall Returnert</th>
                <?php foreach ($returnCategories as $returns): ?>
                    <th><?php echo($returns['categoryName']); ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($idArray as $id): ?>
                <tr>
                    <td class="desc"><?php echo($id['name']); ?></td>
                    <td class="text-right"><?php echo(get_trade_total($start_date, $end_date, $id['product_id'])[0]['totalt']); ?></td>
                    <?php for ($i = 1; $i < 6; $i++) {
                        $returnCat = get_trades_by_dates($start_date, $end_date, $id['product_id'], $i)[0]['antall'];
                        if ($returnCat > 0) {
                            echo("<td class='text-right'>{$returnCat}</td>");
                        } else {
                            echo("<td class='text-right'>0</td>");
                        }
                    }
                    ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
else:
    $session->msg("d", "Ingen returer funnet ");
    redirect('sales_report.php', false);
endif;
?>
</body>
</html>
<?php if (isset($db)) {
    $db->db_disconnect();
} ?>
