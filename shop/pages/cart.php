<?php
unset($_SESSION['discount']);
$cart = new Cart();
$cart_id = $cart->getCartId();
$discount_msg = "";
if (isset($_POST['minus'])) {
    $product_id = htmlspecialchars(trim($_POST['product_id']));
    $cart->removeToCart($product_id, $cart_id);
}
if (isset($_POST['plus'])) {
    $product_id = htmlspecialchars(trim($_POST['product_id']));
    $cart->addToCart($product_id, $cart_id);
}

if (isset($_POST['sub_code'])) {
    $code = htmlspecialchars(trim($_POST['code']));
    $discount = new Discount();
    $checkDiscount = $discount->selectDiscount($code);
    if ($checkDiscount) {
        $items = $cart->cartList($cart_id);
        $cart_total = $cart->cartTotal($cart_id, $checkDiscount->discount);
        $_SESSION['discount'] = $cart_total->tot_price;
    } else {
        $items = $cart->cartList($cart_id);
        $cart_total = $cart->cartTotal($cart_id);
        $discount_msg = "<div class='alert alert-secondary m-0 mt-2' role='alert'>
        Mi dispiace questo codice Discount non è più valido <i class='fa-regular fa-face-frown-open'></i>
      </div>";
    }
} else {
    $items = $cart->cartList($cart_id);
    $cart_total = $cart->cartTotal($cart_id);
}

?>

<?php if (count($items) > 0) { ?>
    <div class="row justify-content-center pt-5">
        <div class="col-12 col-md-11 order-md-last">
            <h2 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Carrello</span>
                <span class="badge bg-secondary rounded-pill">Quantità <?php echo $cart_total->tot_quantity; ?></span>
            </h2>

            <ul class="list-group mb-3">
                <?php foreach ($items as $item) : ?>
                    <li class="list-group-item lh-sm py-3">
                        <div class="row">
                            <div class="col-6 col-lg-4">
                                <h4 class="mb-1"><?php echo $item->name ?></h4>
                                <small class="text-muted"><?php echo substr($item->description, 0, 75) ?>...</small>
                            </div>
                            <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                <span class="text-muted"><?php echo $item->single_price ?> €</span>
                            </div>
                            <div class="col-6 col-lg-4 d-flex justify-content-center align-items-center">
                                <form action="" method="POST">
                                    <button name="minus" type="submit" class="btn btn-secondary"><i class="fa-solid fa-minus"></i></button>
                                    <strong class="px-2"><?php echo $item->quantity ?></strong>
                                    <button name="plus" type="submit" class="btn btn-secondary"><i class="fa-solid fa-plus"></i></button>
                                    <input type="hidden" name="product_id" value="<?php echo $item->id ?>">
                                </form>
                            </div>
                            <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                <strong><?php echo $item->tot_price ?> €</strong>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if (isset($checkDiscount)) : ?>
                    <li class="list-group-item py-3">
                        <div class="row text-success">
                            <div class="col-6 col-lg-4">
                                <h6 class="m-0">Promo code</h6>
                                <small><?php echo $checkDiscount->code ?></small>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block"></div>
                            <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center ">
                                <span class="text-success">− <?php echo $cart_total->tot_discount ?> €</span>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="list-group-item py-3">
                    <div class="row">
                        <span class="col-6 col-lg-4">Totale</span>
                        <div class="col-lg-6 d-none d-lg-block"></div>
                        <strong class="col-6 col-lg-2 d-flex justify-content-center align-items-center"><?php echo $cart_total->tot_price; ?> €</strong>
                    </div>
                </li>
            </ul>

            <form action="" method="POST" class="card p-2">
                <div class="input-group">
                    <input name="code" type="text" class="form-control" placeholder="Promo code">
                    <button name="sub_code" type="submit" class="btn btn-secondary">Redeem</button>
                </div>
                <?php echo $discount_msg ?>
            </form>
            
                <a href="?page=checkout" class="btn btn-primary w-100 mt-3">Conferma Ordine</a>
            
        </div>
    </div>
<?php } else { ?>

    <h2 class="py-5 text-center">Non hai ancora aggiunto prodotti al Carrello.</h2>

    <div class="col-md-5 col-lg-4 order-md-last m-auto">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Carrello</span>
            <span class="badge bg-secondary rounded-pill">Quantità 0</span>
        </h4>
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-center lh-sm py-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="150px" viewBox="0 0 512 512">
                    <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" fill="#6c757d" />
                </svg>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Totale </span>
                <strong>0 €</strong>
            </li>
        </ul>

        <form class="card p-2">
            <div class="input-group">
                <a class="btn btn-primary w-100" href="?page=products">Torna allo Shopping</a>
            </div>
        </form>
    </div>

<?php } ?>