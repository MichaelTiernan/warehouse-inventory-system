<?php
$page_title = 'Dine utleveringer';
require_once('includes/load.php');

// Checking userlevel
page_require_level(5);

//Show only own sales, unless userlevel is admin
if (get_userlevel() == 1) {
    $sales = find_all_entre_sale();
} else {
    $sales = find_all_entre_user_sales();
}


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
                    <span>Utleveringer </span>
                </strong>

                <div class="pull-right">
                    <a href="entre_sale.php" class="btn btn-primary">Nytt salg</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th> Produkt</th>
                        <th class="text-center" style="width: 5%;"> Antall</th>
                        <th class="text-center" style="width: 5%;"> Total</th>
                        <th class="text-center" style="width: 5%;"> Dato</th>
                        <?php if(get_userlevel() == 1) { echo("<th class='text-center'> Bruker </th>"); } ?>
                        <th class="text-center" style="width: 5%;"> Kundenummer</th>
                        <th class="text-center" style="width: 5%;"> MAC</th>
                        <th class="text-center" style="width: 50%;"> Kommentar</th>
                        <th class="text-center" style="width: 100px;"> Handlinger</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo remove_junk($sale['name']); ?></td>
                            <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                            <td class="text-center"><?php echo remove_junk($sale['price']); ?>,-</td>
                            <td class="text-center"><?php echo $sale['date']; ?></td>
                            <?php if(get_userlevel() == 1) { echo("<td class='text-center'>{$sale['username']}</td> "); } ?>
                            <td class="text-center"><?php echo $sale['custnr']; ?></td>
                            <td class="text-center"><?php echo $sale['mac']; ?></td>
                            <td class="text-center" style="max-width: 250px"><?php echo $sale['comment']; ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_entre_sale.php?id=<?php echo (int)$sale['id']; ?>"
                                       class="btn btn-warning btn-xs" title="Edit" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_entre_sale.php?id=<?php echo (int)$sale['id']; ?>"
                                       class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
