<?php
$category = new Category();
$categories = $category->categories();
$discount = new Discount();
$discounts = $discount->selectAllDiscount();
?>

<div class="mb-4 bg-light rounded-3">
  <div class="container-fluid py-5">
    <h1 class="display-5 fw-bold">Benvenuto in questo E-commerce</h1>
    <?php if($user_logged && count($discounts) > 0){ ?>
    <p class="col-md-8 fs-4">Utilizza questa promo, valida su tutti i nostri prodotti, <span class="text-success"><?php echo $discounts[0]->code ?></span> per avere uno sconto del 15%. Affrettati! <i class="fa-regular fa-face-kiss-wink-heart"></i></p>
    <?php }else{ ?>
      <p class="col-md-8 fs-4">Puoi scegliere se visualizzare tutti i nostri prodotti o filtrarli per le nostre categorie.</p>
      <?php }?>
    <a href="/e-commerce/shop/" class="btn btn-primary btn-lg">Vai allo Shopping.</a>
  
<?php if(count($categories) > 0): ?>
<h2 class="pb-2 border-bottom pt-5">Le nostre Categorie</h2>
<div class="row g-4 pt-3 row-cols-1 row-cols-lg-3">
  <?php foreach ($categories as $category) : ?>
    <div class="col d-flex align-items-start">
      
      <div>
        <h2 ><?php echo ucfirst($category->name) ?></h2>
        <p>Scopri i prodotti collegati alla categoria <?php echo $category->name ?>, clicca il bottone qui sotto.</p>
        <a href="/e-commerce/shop/?page=products&category=<?php echo $category->id ?>" class="btn btn-primary">
          Vai allo shop
        </a>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</div>