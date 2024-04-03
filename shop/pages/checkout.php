<?php
$cart = new Cart();
$address = new Address();
$order = new Order();
if ($user_logged) {
    $address_data = $address->selectAddress($user_logged->id);
}

$cart_id = $cart->getCartId();
$items = $cart->cartList($cart_id);
$cart_total = $cart->cartTotal($cart_id);
$last_price = $_SESSION['discount'] ?? $cart_total->tot_price;

if (isset($_POST['checkout'])) {
    if (isset($address_data)) {

        $order_id = $order->createOrder($last_price, 'pending', $_SESSION['client_id'], $address_data->id, $user_logged->id);
        if ($order_id !== null) {
            foreach ($items as $item) {
                $order->orderProduct($order_id, $item->id, $item->quantity);
            }
        }
        header('Location: ?page=thanks');
    } else {
        $values = [
            'name' => htmlspecialchars(trim($_POST['name'])),
            'surname' => htmlspecialchars(trim($_POST['surname'])),
            'email' => htmlspecialchars(trim($_POST['email'])),
            'street' => htmlspecialchars(trim($_POST['street'])),
            'city' => htmlspecialchars(trim($_POST['city'])),
            'cap' => htmlspecialchars(trim($_POST['cap']))
        ];
        $validation = new AddressValidation();
        $validated = $validation->validate($values);

        if ($validated) {
            if ($user_logged) {
                $values['user_id'] = $user_logged->id;
            }
            $address_id = $address->saveAddress($values);
            if ($user_logged) {
                $order_id = $order->createOrder($last_price, 'pending', $_SESSION['client_id'], $address_id, $user_logged->id);
                if ($order_id !== null) {
                    foreach ($items as $item) {
                        $order->orderProduct($order_id, $item->id, $item->quantity);
                    }
                }
            } else {
                $order_id = $order->createOrder($last_price, 'pending', $_SESSION['client_id'], $address_id);
                if ($order_id !== null) {
                    foreach ($items as $item) {
                        $order->orderProduct($order_id, $item->id, $item->quantity);
                    }
                }
            }
            header('Location: ?page=thanks');
        } else {
            $errors = $validation->getErrors();
        }
    }
}
?>


<div class="container">

    <div class="row g-5 pt-5">
        <div class="col-lg-5 order-lg-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Carrello</span>
                <span class="badge bg-secondary rounded-pill">Quantità <?php echo $cart_total->tot_quantity; ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($items as $item) : ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div class="w-75">
                            <h4 class="mb-1"><?php echo $item->name ?></h4>
                            <small class="text-muted">Quantità <?php echo $item->quantity ?> x <?php echo $item->single_price ?> €</small>
                        </div>
                        <strong><?php echo $item->tot_price ?> €</strong>
                    </li>
                <?php endforeach; ?>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Totale</span>
                    <strong><?php echo $_SESSION['discount'] ?? $cart_total->tot_price ?> €</strong>
                </li>
            </ul>
        </div>
        <div class="col-lg-7">
            <h4 class="mb-3">Indirizzo di fatturazione</h4>
            <form class="needs-validation" method="POST" action="">
                <?php if (isset($address_data)) { ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <h5><?php echo $address_data->name . ' ' . $address_data->surname ?></h5>
                        </div>

                        <div class="col-12">
                            <h5><?php echo $address_data->email ?></h5>
                        </div>

                        <div class="col-12">
                            <h5><?php echo $address_data->street ?></h5>
                        </div>

                        <div class="col-md-5">
                            <h5><?php echo $address_data->city ?></h5>
                        </div>

                        <div class="col-md-3">
                            <h5><?php echo $address_data->cap ?></h5>
                        </div>

                        <a class="btn btn-warning" href="/e-commerce/user?page=address-edit">Non è questo?</a>
                    </div>
                <?php } else { ?>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Nome</label>
                            <input name="name" type="text" class="form-control <?php isset($errors) ? isValid($errors['name']) : '' ?>" id="firstName" placeholder="" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''?>">
                            <?php isset($errors) ? errorMessage($errors['name']) : '' ?>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Cognome</label>
                            <input name="surname" type="text" class="form-control <?php isset($errors) ? isValid($errors['surname']) : '' ?>" id="lastName" placeholder="" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''?>">
                            <?php isset($errors) ? errorMessage($errors['surname']) : '' ?>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control <?php isset($errors) ? isValid($errors['email']) : '' ?>" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''?>" id="email">
                            <?php isset($errors) ? errorMessage($errors['email']) : '' ?>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Indirizzo</label>
                            <input name="street" type="text" class="form-control <?php isset($errors) ? isValid($errors['street']) : '' ?>" value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''?>" id="address">
                            <?php isset($errors) ? errorMessage($errors['street']) : '' ?>
                        </div>

                        <div class="col-md-5">
                            <label for="city" class="form-label">Città</label>
                            <input name="city" type="text" class="form-control <?php isset($errors) ? isValid($errors['city']) : '' ?>" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''?>" id="city">
                            <?php isset($errors) ? errorMessage($errors['city']) : '' ?>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">CAP</label>
                            <input name="cap" type="text" class="form-control <?php isset($errors) ? isValid($errors['cap']) : '' ?>" value="<?php echo isset($_POST['cap']) ? $_POST['cap'] : ''?>" id="zip" placeholder="">
                            <?php isset($errors) ? errorMessage($errors['cap']) : '' ?>
                        </div>
                    </div>
                <?php } ?>

                <hr class="my-4">

                <button name="checkout" class="w-100 btn btn-primary btn-lg" type="submit">Continua il checkout</button>
            </form>
        </div>
    </div>
</div>