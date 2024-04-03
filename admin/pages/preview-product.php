<?php
$products_class = new Product();
$id = htmlspecialchars(trim($_GET['id']));
$product = $products_class->show($id);
if($product){
?>
<div class="container text-center pt-5">
    <h2 class="py-3">Previe di <?php echo $product->name; ?></h2>
    <img class="mb-3" src="<?php echo $product->img ?>" alt="">
    <p ><?php echo $product->description; ?></p>
    <h5>Prezzo: <?php echo $product->price ?> €.</h5>
    <h5>Categoria: <?php echo $products_class->category($product->category_id)->name; ?></h5>
</div>
<a href="/e-commerce/admin?page=product-edit&id=<?php echo $product->id?>">Modifica</a>
<a href="/e-commerce/admin?page=products-list">Salva</a>
<?php }else {?>
<h2 class="text-center mt-5">Prodotto non trovato <i class="fa-regular fa-face-frown"></i></h2>
<a class="mx-5 btn btn-secondary" href="/e-commerce/admin?page=products-list">Torna ai prodotti</a>
<?php } ?>