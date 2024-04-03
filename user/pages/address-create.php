<?php 
$address = new Address();
$checkAddress = $address->selectAddress($user_logged->id);
if($checkAddress) {
    header('Location: ?page=address-edit');
}
if(isset($_POST['create-data'])) {
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
        $address->modifyAddress($values, $user_logged->id);
        header('Location: ?page=dashboard');
    }else {
        $errors = $validation->getErrors();
    }
}
?>

<div class="container">
    <h4 class="mb-3 pt-5"> Crea Indirizzo di fatturazione</h4>
    <form class="needs-validation" method="POST" action="">
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
                <input name="email" type="email" class="form-control <?php isset($errors) ? isValid($errors['email']) : '' ?>" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''?>">
                <?php isset($errors) ? errorMessage($errors['email']) : '' ?>
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Indirizzo</label>
                <input name="street" type="text" class="form-control <?php isset($errors) ? isValid($errors['street']) : '' ?>" id="address" value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''?>">
                <?php isset($errors) ? errorMessage($errors['street']) : '' ?>
            </div>

            <div class="col-md-5">
                <label for="city" class="form-label">Città</label>
                <input name="city" type="text" class="form-control <?php isset($errors) ? isValid($errors['city']) : '' ?>" id="city" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''?>">
                <?php isset($errors) ? errorMessage($errors['city']) : '' ?>
            </div>

            <div class="col-md-3">
                <label for="zip" class="form-label">CAP</label>
                <input name="cap" type="text" class="form-control <?php isset($errors) ? isValid($errors['cap']) : '' ?>" id="zip" value="<?php echo isset($_POST['cap']) ? $_POST['cap'] : ''?>" placeholder="">
                <?php isset($errors) ? errorMessage($errors['cap']) : '' ?>
            </div>
        </div>
        <button name="create-data" type="submit" class="btn btn-primary mt-3">Salva</button>
    </form>
</div>