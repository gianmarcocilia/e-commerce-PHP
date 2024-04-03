<?php

$pages = ['home'];
if(isset($_GET['page']) && !in_array($_GET['page'], $pages)) {
    header('Location: ?page=home');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<?php include __DIR__ . '/../php/auth.php'; ?>
<?php include __DIR__ . '/../php/config.php'; ?>
<?php include __DIR__ . '/components/header.php'; ?>

<div id="app" class="container-fluid">
    <div class="row">

        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <div id="main" class="col-md-9 col-xl-10 ms-sm-auto">
            <?php include __DIR__ . "/pages/$page.php"; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?>