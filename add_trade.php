<?php
require_once('includes/load.php');

if (isset($_POST['custnr'])) {

    $req_fields = array('s_id', 'quantity', 'price', 'total');
    if (empty($errors)) {
        $max = count($_POST['s_id']);

        for ($i = 0; $i < $max; $i++) {
            $s_total = floatval(($_POST['quantity'][$i]) * ($_POST['price'][$i]));

            $p_id = $db->escape((int)$_POST['s_id'][$i]);
            $s_qty = $db->escape((int)$_POST['quantity'][$i]);
            $date = $db->escape($_POST['date']);
            $custnr = $db->escape($_POST['custnr']);
            $comment = $db->escape($_POST['comment']);
            $s_date = make_date();
            $s_userID = $_SESSION['user_id'];

            $sql = "INSERT INTO trade (";
            $sql .= " product_id, qty, price, date, custnr, comment, FK_userID";
            $sql .= ") VALUES (";
            $sql .= "'{$p_id}', '{$s_qty}', '{$s_total}', '{$s_date}', '{$custnr}', '{$comment}','$s_userID'";
            $sql .= ")";

            if ($s_qty > 0) {
                if ($db->query($sql)) {
                    update_product_qty($s_qty, $p_id);
//                    $session->msg('s', "Sale added. ");
                } else {
//                    $session->msg('d', ' Sorry failed to add!');
                }
            }
        }
        header('Location: trade.php');
        exit();

    } else {
        $session->msg("d", $errors);
        redirect('trade.php', false);
    }
}