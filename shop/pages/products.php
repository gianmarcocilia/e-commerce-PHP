<?php
$products_class = new Product();
$check_product_db = $products_class->index();
$category_msg = "";
$product_result_search = "";
$add_to_cart_msg = "";
if (isset($_POST['search']) && trim($_POST['search_value'] > 0)) {
    $value = htmlspecialchars(trim($_POST['search_value']));
    $products = $products_class->search($value);
    $product_result_search = "<div class='alert alert-secondary mt-3' role='alert'>
    Prodotti trovati con questa ricerca " . count($products) . " 
    <a class='btn btn-outline-secondary mx-3' href='?page=products'>Annulla ricerca</a>
  </div>";
} else {
    if (isset($_GET['category']) && $_GET['category'] != null) {
        $category = new Category();
        $id = htmlspecialchars($_GET['category']);
        $products = $category->products($id);
        if (count($products) > 0) {
            $category_msg = "<div class='alert alert-secondary mt-3' role='alert'>
        Abbiamo " . count($products) . " prodotti per la cateogria " . $products_class->category($id)->name . ".
        <a class='btn btn-outline-secondary mx-3' href='?page=products'>Annulla filtro</a>
      </div>";
        }
    } else {
        $products = $products_class->index();
    }
}

if (isset($_POST['add_to_cart'])) {
    $product_id = htmlspecialchars(trim($_POST['product_id']));
    $cart = new Cart();
    $cart_id = $cart->getCartId();

    $cart->addToCart($product_id, $cart_id);
    $add_to_cart_msg = "<div class='alert alert-success py-3 mt-3' role='alert'>
    Il prodotto è stato aggiunto al Carrello <i class='fa-regular fa-face-smile-beam'></i>
  </div>";
}
?>

<?php if (count($check_product_db) > 0) { ?>
    <?php if (count($products) > 0) { ?>
        <div class="container">
            <?php if (isset($_GET['category'])) { ?>
                <?php echo $category_msg; ?>
            <?php } else { ?>
                <form class="d-flex gap-3 pt-3" action="" method="POST">
                    <input class="form-control m-0" name="search_value" value="<?php echo isset($_POST['search_value']) ? $_POST['search_value'] : '' ?>" type="text" placeholder="Cosa stai cercando?" aria-label="Search">
                    <button type="submit" name="search" class="btn btn-secondary">Cerca</button>
                </form>
            <?php } ?>

            <?php echo $product_result_search ?>

            <?php echo $add_to_cart_msg ?>

            <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-lg-3 pt-3 mb-3 text-center">
                <?php foreach ($products as $product) : ?>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm h-100 ">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal"><?php echo $product->name; ?></h4>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between align-items-center">
                                <div>
                                    <h1 class="card-title pricing-card-title"><?php echo $product->price; ?><small class="text-muted fw-light">€</small></h1>
                                    <img class="mt-3 mb-4" src="<? echo $product->img; ?>" alt="<? echo $product->name; ?>">
                                </div>
                                <form action="" method="POST">
                                    <a href="?page=product&id=<?php echo $product->id ?>" class="w-100 btn btn-lg btn-outline-primary mb-2">Dettagli</a>
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <button name="add_to_cart" type="submit" class="w-100 btn btn-lg btn-outline-primary">Aggiungi al Carrello</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php } else { ?>
        <h2 class="mt-5 mx-3">Mi dispiace non sono stati trovati prodotti con questa ricerca.</h2>
        <a class="btn btn-primary mx-3" href="?page=products">Annulla ricerca</a>
    <?php } ?>

<?php } else { ?>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 fw-normal">Work in Progress.</h1>
            <p class="lead fw-normal">Presto aggiungeremo nuovi prodotti... Per creare dei prodotti di prova cliccare sul bottone Coming soon.</p>
            <a class="btn btn-outline-secondary" href="/e-commerce/seeder">Coming soon</a>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
<?php } ?>