<?php
$page_title = 'Lagerlogg KS-lager';
require_once('includes/load.php');

// Checking userlevel
page_require_level(1);

$logs = get_log_ext();

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
                    <span>Lagerlogg KS-lager</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Produktnavn</th>
                        <th class="text-center">Bruker</th>
                        <th class="text-center">Lagerverdi tidligere</th>
                        <th class="text-center">Lagerverdi nåværende</th>
                        <th class="text-center">Differanse</th>
                        <th class="text-center">Tidspunkt</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <?php if ($log['diff_ks'] > 0): ?>
                                <td class="text-center"><?php echo($log['name']); ?></td>
                                <td class="text-center"><?php echo($log['username']); ?></td>
                                <td class="text-center"><?php echo($log['kslager'] - $log['diff_ks']); ?></td>
                                <td class="text-center"><?php echo($log['kslager']); ?></td>
                                <td class="text-center"><?php echo($log['diff_ks']); ?></td>
                                <td class="text-center"><?php echo($log['timecreated']); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
