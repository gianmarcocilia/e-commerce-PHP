<?php
$products_class = new Product();
$id = htmlspecialchars(trim($_GET['id']));
$product = $products_class->show($id);
$product_msg = "";

if (isset($_POST['add_to_cart'])) {
    $product_id = htmlspecialchars(trim($_POST['product_id']));
    $cart = new Cart();
    $cart_id = $cart->getCartId();

    $cart->addToCart($product_id, $cart_id);
    $product_msg = "<div class='alert alert-success py-3' role='alert'>
    Il prodotto è stao aggiunto al Carrello <i class='fa-regular fa-face-smile-beam'></i>
  </div>";
}

if ($product) {
?>
    <div class="jumbotron py-5">
    <h1 class="display-5"><?php echo $product->name; ?></h1>
    <p class="lead">Prezzo: <?php echo $product->price ?> €</p>
    <p class="lead">Categoria: <a href="?page=products&category=<?php echo $products_class->category($product->category_id)->id ?>"><?php echo ucfirst($products_class->category($product->category_id)->name) ?></a></p>
    <hr class="my-4">
    <div class="d-flex gap-5">
    <img src="<?php echo $product->img ?>" alt="">
    <p class="py-3 w-50"><?php echo $product->description; ?></p>
    </div>
    
    <div class="lead py-5 ">
        <form class="d-flex flex-column flex-md-row justify-content-center gap-3" action="" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
            <button name="add_to_cart" class="btn btn-primary" type="submit">Aggiungi al Carrello</button>
            <a class="btn btn-secondary" href="/e-commerce/shop/">Torna allo Shop</a>
        </form>
    </div>
    <?php echo $product_msg; ?>
</div>
<?php } else { ?>
    <h2 class="text-center">Prodotto non trovato</h2>
    <a class="btn btn-secondary" href="/e-commerce/shop/">Torna allo Shop</a>
<?php } ?>

