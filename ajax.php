<?php
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}

// Auto suggestion
$html = '';

// find all product

if (isset($_POST['p_name']) && strlen($_POST['p_name'])) {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if ($results = get_product_info_by_id($product_title)) {
        foreach ($results as $result) {

            $html .= "<tr>";

            $html .= "<td id=\"s_name\">" . $result['name'] . "</td>";
            $html .= "<input type=\"hidden\" name=\"s_id[]\" value=\"{$result['id']}\">";
            $html .= "<td>";
            $html .= "<input type=\"text\" class=\"form-control\" name=\"price[]\" value=\"{$result['sale_price']}\" readonly>";
            $html .= "</td>";
            $html .= "<td id=\"s_qty\">";
            $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity[]\" value=\"1\" min='0'>";
            $html .= "</td>";
            $html .= "<td>";
            $html .= "<input type=\"hidden\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\" readonly>";
            $html .= "</td>";

            $html .= "</tr>";

        }
    } else {
        $html = '<tr><td>Product name not registered in the database</td></tr>';
    }

     echo($html);
}
