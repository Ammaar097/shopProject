<?php
include_once '../database/Category.php';
include_once '../database/Product.php';
include_once 'Redirection.php';
$category = new Category();
$product = new Product();
if (isset($_POST)) {
    if ($_POST['table'] === 'category') {
        if ($_POST['form_action'] === 'update') {
            $category->update($_POST);
        } else if ($_POST['form_action'] === 'delete') {
            $P = $product->fetchByCategoryId($_POST['category_id']);
            foreach ($P as $p) {
                if (file_exists($p['product_img'])) {
                    unlink($p['product_img']);
                }
                if (file_exists($p['product_detail_img'])) {
                    unlink($p['product_detail_img']);
                }
            }
            $product->deleteByCategoryId($_POST['category_id']);
            $category->delete($_POST['category_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $category->insert($_POST);
            redirection("/category.php");
        }
    }
} else {
    echo "Page Not found.";
}
