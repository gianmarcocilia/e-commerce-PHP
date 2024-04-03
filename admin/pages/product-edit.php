<?php
$products_class = new Product();
$id = htmlspecialchars(trim($_GET['id']));
$product = $products_class->show($id);
$category = new Category();
$categories = $category->categories();
$category_msg = '';
if (isset($_POST['modify'])) {
    if (isset($_POST['category_id'])) {
        $values = [
            'name' => htmlspecialchars(trim($_POST['name'])),
            'price' => htmlspecialchars(trim($_POST['price'])),
            'description' => htmlspecialchars(trim($_POST['description'])),
            'image' => htmlspecialchars(trim($_POST['image'])),
            'category_id' => htmlspecialchars(trim($_POST['category_id'])),
        ];
        $validation = new ProductValidation();
        $validated = $validation->validate($values);
        if ($validated) {
            $products_class->setUpdateValue($values);
            $products_class->update($product->id);
            header("Location: ?page=preview-product&id=$product->id");
        } else {
            $errors = $validation->getErrors();
        }
    } else {
        $category_msg = 'Devi selezionare una categoria!';
    }
}
?>

<h2 class="py-5">Stai modificando il prodotto: <?php echo $product->name; ?></h2>
<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control <?php isset($errors) ? isValid($errors['name']) : '' ?>" id="name" value="<?php echo $product->name ?>" name="name">
        <?php isset($errors) ? errorMessage($errors['name']) : '' ?>
    </div>
    <div class="col-md-6">
        <label for="price" class="form-label">Prezzo €</label>
        <input type="number" class="form-control <?php isset($errors) ? isValid($errors['price']) : '' ?>" value="<?php echo $product->price ?>" id="price" name="price">
        <?php isset($errors) ? errorMessage($errors['price']) : '' ?>
    </div>
    <div class="form-floating">
        <textarea name="description" class="form-control <?php isset($errors) ? isValid($errors['description']) : '' ?>" id="description" style="height: 100px">
        <?php echo $product->description ?>
    </textarea>
        <label for="description">Descrizione</label>
        <?php isset($errors) ? errorMessage($errors['description']) : '' ?>
    </div>

    <div class="col-md-6">
        <label for="image" class="form-label">Immagine</label>
        <input name="image" type="text" class="form-control <?php isset($errors) ? isValid($errors['image']) : '' ?>" value="<?php echo $product->img ?>" id="image" aria-describedby="image">
        <?php isset($errors) ? errorMessage($errors['image']) : '' ?>
    </div>
    <div class="col-md-6">
        <label for="category" class="form-label">Categoria</label>
        <select name="category_id" class="form-select" id="category" aria-describedby="category">
            <?php foreach($categories as $category): ?>
            <option <?php if($products_class->category($product->id)->id == $category->id){ echo 'selected';} ?> value="<?php echo $category->id; ?>"><?php echo $category->name ?></option> 
            <?php endforeach; ?>
        </select>
        <small class="text-danger p-1"><?php echo $category_msg; ?></small>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" name="modify" type="submit">Submit form</button>
    </div>
</form>