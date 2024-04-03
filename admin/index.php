<?php
include __DIR__ . '/../php/auth.php';

if(!$user_logged) {
     header('Location: /e-commerce/auth?page=login');
    exit;
 }

if(!$user_logged->is_admin) {
     header('Location: /e-commerce/public');
     exit;
 }

 $pages = ['create-product', 'dashboard', 'discount', 'orders-list', 'preview-product', 'product-edit', 'products-list'];
if(isset($_GET['page']) && !in_array($_GET['page'], $pages)) {
    header('Location: ?page=dashboard');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<?php include '../php/config.php'; ?>
<?php include '../php/functions.php'; ?>
<?php include __DIR__ . '\..\public\components\header.php'; ?>

<div id="app" class="container-fluid">
    <div class="row">

        <?php include __DIR__ . '\..\public\components\sidebar.php'; ?>

        <div id="main" class="col-md-9 col-xl-10 ms-sm-auto">
            <?php include __DIR__ . "\pages\\$page.php"; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '\..\public\components\footer.php'; ?>