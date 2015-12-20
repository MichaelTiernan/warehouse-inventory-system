<?php
$page_title = 'Salgsrapport';
$results = '';
require_once('includes/load.php');
// Checking userlevel
page_require_level(1);

if (isset($_POST['submit'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);



    if (empty($errors)):
        $idArray = [];
        $resultArray = [];
        $end_date_storage = [];
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));

        $p_id = get_unique_pid($start_date, $end_date);

        foreach ($p_id as $id) {
            array_push($idArray, $id['product_id']);
        }

        foreach ($idArray as $id) {
            array_push($resultArray, get_sales_by_date($start_date, $end_date, $id));
        }

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
<html>
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
<?php if ($resultArray): ?>
    <div class="page-break">
        <div class="sale-head pull-right">
            <h1>Sales Report</h1>
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
                <th>Antall salg</th>
                <th>Antall solgt</th>
                <th>KS-lager <?php echo $start_date?> </th>
                <th>KS-lager pr. d.d</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($resultArray as $result): ?>
                <tr>
                    <td class="desc"><?php echo($result[0]['name']); ?></h6></td>
                    <td class="text-right"><?php echo($result[0]['sold']); ?></td>
                    <td class="text-right"><?php echo($result[0]['sales']); ?></td>
                    <td class="text-right"><?php echo($result[0]['ks_storage'] + $result[0]['sold']); ?></td>
                    <td class="text-right"><?php echo($result[0]['ks_storage']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
else:
    $session->msg("d", "Sorry no sales has been found. ");
    redirect('sales_report.php', false);
endif;
?>
</body>
</html>
<?php if (isset($db)) {
    $db->db_disconnect();
} ?>
