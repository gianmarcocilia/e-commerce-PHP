<?php
$products_class = new Product();
$product_msg = '';
if (isset($_POST['delete'])) {
    $id_delete = htmlspecialchars(trim($_POST['delete_id']));
    $result = $products_class->delete($id_delete);
    if ($result) {
        $product_msg = "<div class='alert alert-success my-2' role='alert'>
        Il Prodotto è stato eliminato con successo!
      </div>";
    }
}

$products = $products_class->index();
?>
<?php if (count($products) > 0) { ?>
    <div class="ps-md-2">
        <div class="d-flex justify-content-between align-items-center mt-5 pb-3">
            <h2>Ecco la lista dei tuoi prodotti </h2>
            <div>
                <a class="btn btn-success m-auto" href="?page=create-product">Aggiungi un nuovo Prodotto</a>
            </div>
        </div>

        <?php echo $product_msg ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <th scope="row"> <?php echo $product->name ?></th>
                        <td><?php echo $product->price ?> €</td>
                        <td><?php echo $products_class->category($product->category_id)->name ?></td>
                        <td>
                            <div class="d-flex flex-column flex-lg-row gap-3">
                                <a class="btn btn-warning" href="?page=product-edit&id=<?php echo $product->id ?>">Modifica</a>
                                <button class="btn btn-danger button-delete" data-id="<?php echo $product->id ?>" data-title="<?php echo $product->name ?>" data-bs-toggle="modal" data-bs-target="#my-modal">Elimina</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
<?php } else { ?>
    <div class="container py-5">
        <div class="alert alert-warning mt-5" role="alert">
            <h2>Non hai ancora nessun Prodotto da vendere!</h2>
            <p>Clicca sul bottone ed inseriscine qualcuno.</p>
            <a class="btn btn-success" href="?page=create-product">Aggiungi un nuovo Prodotto</a>
        </div>
    </div>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title <span id="title-delete"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <form method="POST" action="" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="delete" name="delete" type="submit" class="btn btn-primary">Save changes</button>
                <input type="hidden" name="delete_id" value="" class="product_id">
            </form>
        </div>
    </div>
</div>