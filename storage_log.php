<?php
$page_title = 'Lagerlogg';
require_once('includes/load.php');

// Checking userlevel
page_require_level(1);

//Show only own sales, unless userlevel is admin

$logs = get_log();

include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lagerlogg</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Produktnavn</th>
                        <th class="text-center">Differanse hovedlager</th>
                        <th class="text-center">Differanse ks-lager</th>
                        <th class="text-center">Tidspunkt</th>
                        <th class="text-center">Bruker</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="text-center"><?php echo($log['name']); ?></td>
                            <td class="text-center"><?php echo($log['quantity']); ?></td>
                            <td class="text-center"><?php echo($log['ks_storage']); ?></td>
                            <td class="text-center"><?php echo($log['updated']); ?></td>
                            <td class="text-center"><?php echo($log['username']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
