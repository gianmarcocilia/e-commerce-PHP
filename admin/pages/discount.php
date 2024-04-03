<?php
$discount_msg = '';
$discount_class = new Discount();
if (isset($_POST['create-discount'])) {
  $code = htmlspecialchars(trim($_POST['code']));
  $discount = htmlspecialchars(trim($_POST['discount']));


  $validated = $discount_class->discountValid($code, $discount);

  if ($validated) {
    $check = $discount_class->selectDiscount($code);
    if (!$check) {
      $discount_class->createDiscount($code, $discount);
      $discount_msg = "<div class='alert alert-success' role='alert'>
    Complimenti hai creato un nuovo codice sconto!
  </div>";
    } else {
      $discount_msg = "<div class='alert alert-warning' role='alert'>
    Attenzione questo codice Discount esiste già! Controlla nella tua lista Dicount qui sotto <i class='fa-solid fa-turn-down'></i>
  </div>";
    }
  } else {
    $discount_msg = "<div class='alert alert-danger' role='alert'>
    Il tuo codice non è valido! Controlla che tutti i valori siano corretti in base alle istruzioni sopra elencate.
  </div>";
  }
}

if(isset($_POST['delete_discount'])) {
  $id = htmlspecialchars(trim($_POST['delete_id']));
  $discount_class->deleteDiscount($id);
}

$discounts = $discount_class->selectAllDiscount();
?>

<div class="container py-5">
  <h1 class="display-5 fw-bold">Crea un nuovo Discount</h1>
  <p class="col-md-10 fs-4">Assicurati che il codice non sia <strong>superiore a 15 caratteri</strong> e che il discount non sia <strong>minore di 5 o maggiore di 60</strong>.</p>
  <form class="col-md-9 row g-3 mb-3" action="" method="POST">
    <div class="col-lg-10">
      <label for="code">Scrivi qui il tuo codice</label>
      <input id="code" class="form-control" type="text" name="code" placeholder="examplecode-20">
    </div>
    <div class="col-lg-8">
      <label for="discount">Inserisci qui il tuo sconto in %</label>
      <input class="form-control" type="number" value="5" min="5" max="60" step="1" name="discount">
    </div>
    <div>
      <button name="create-discount" class="btn btn-primary" type="submit">Inserisci</button>
    </div>
  </form>
  <?php echo $discount_msg ?>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">Codice</th>
      <th scope="col">Discount</th>
      <th scope="col">Azione</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($discounts as $discount): ?>
    <tr>
      <td><?php echo $discount->code ?></td>
      <td><?php echo $discount->discount * 100;?> %</td>
      <td>
        <form action="" method="POST">
          <button class="btn btn-danger" type="submit" name="delete_discount">Elimina</button>
          <input name="delete_id" type="hidden" value="<?php echo $discount->id; ?>">
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>