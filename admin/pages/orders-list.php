<?php
$order = new Order();
if(isset($_POST['send-order'])) {
    $id = htmlspecialchars(trim($_POST['order_id']));
    $order->sendOrder($id);
}
$orders = $order->allOrders();

?>
<?php if(count($orders) > 0){ ?>
<div class="container">
    <h2 class="pt-5">I tuoi ordini</h2>
    <div class="row">
        <?php foreach ($orders as $single_order) :?>
            <?php $products = $order->products($single_order->id) ?>
            <hr class="my-3">
            <div class="col-md-8 card justify-content-center pt-3">
                <?php foreach ($products as $product) : ?>
                    <h4 class="mb-0"><?php echo $product->name ?></h4>
                    <span class="text-muted">Quantità: <?php echo $product->quantity ?></span>
                    <span class="text-muted pb-3">Prezzo singolo prodotto: <?php echo $product->price ?> €</span>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4 card justify-content-center align-items-center">
                <h5 class="m-0 pt-2">Dati di fatturazione</h5>

                <p class="m-0"><?php echo $order->address($single_order->address_id)->name . ' ' . $order->address($single_order->address_id)->surname ?></p>
                <p class="m-0"><?php echo $order->address($single_order->address_id)->email ?></p>
                <p class="m-0"><?php echo $order->address($single_order->address_id)->street ?></p>
                <p class="mb-3"><?php echo $order->address($single_order->address_id)->city . ', ' . $order->address($single_order->address_id)->cap ?></p>
                
                <p class="m-0">Totale prezzo Ordine: <strong><?php echo $single_order->tot_price ?> €</strong></p>
                <p class="m-0">Ordine effettuato il <strong><?php echo $single_order->created_at ?></strong></p>
                <?php if($single_order->status == 'pending'){ ?>
                <form class="py-2" action="" method="POST">
                    <button name="send-order" class="btn btn-success mt-3">Spedisci</button>
                    <input name="order_id" value="<?php echo $single_order->id ?>" type="hidden">
                </form>
                <?php }else { ?>
                    <p class="mb-2">Ordine <span class="text-success fs-5">Spedito</span> il <strong><?php echo $single_order->updated_at ?></strong></p>
                    <?php }?>
            </div>
        <?php endforeach; ?>
        <hr class="my-3">
    </div>
</div>
<?php }else{ ?>
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Nessun ordine effettuato</h1>
        <p class="col-md-8 fs-4">Inserisci un indirizzo di fatturazione e completa il checkout per effettuare un ordine. Clicca sul bottone per andare allo shop.</p>
        <a href="/e-commerce/shop?page=products" class="btn btn-primary btn-lg" type="button">Vai allo shop</a>
      </div>
    </div>
    <?php }?>