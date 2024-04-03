<?php
if(isset($_POST['modify-data'])) {
    $values = [
        'name' => htmlspecialchars(trim($_POST['name'])),
        'email' => htmlspecialchars(trim($_POST['email'])),
        'password' => htmlspecialchars(trim($_POST['password'])),
        'confirm_password' => htmlspecialchars(trim($_POST['confirm_password']))
    ];
    $validation = new UserValidation();
    $validated = $validation->validate($values);
    if($validated) {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $id = $user_logged->id;
        $user = new User();
        $user->modifyData($name, $email, $password, $id);
        header('Location: ?page=dashboard');
    }else {
        $errors = $validation->getErrors();
    }
}
?>


<div class="container">
    
    <form class="row justify-content-center mt-3" method="post">
        <div class="col-lg-8 d-flex justify-content-between align-items-center">
            <h5 class="mb-3 mt-3">Modifica dati</h5>
            <a class="btn btn-primary" href="?page=dashboard">Torna al Profilo</a>
        </div>

        <div class="form-group col-lg-8 mb-3 ">
            <label for="name">Nome</label>
            <input name="name" id="name" type="text" class="form-control <?php isset($errors) ? isValid($errors['name']) : '' ?>" value="<?php echo $user_logged->name ?>">
            <?php isset($errors) ? errorMessage($errors['name']) : '' ?>
        </div>
        <div class="form-group col-lg-8 mb-3">
            <label for="email">Email</label>
            <input name="email" id="email" type="email" class="form-control <?php isset($errors) ? isValid($errors['email']) : '' ?>" value="<?php echo $user_logged->email ?>">
            <?php isset($errors) ? errorMessage($errors['email']) : '' ?>
        </div>

        <div class="form-group col-lg-8 mb-3">
            <label for="password">Password</label>
            <input name="password" id="password" type="password" class="form-control <?php isset($errors) ? isValid($errors['password']) : '' ?>" value="">
            <?php isset($errors) ? errorMessage($errors['password']) : '' ?>
        </div>
        <div class="form-group col-lg-8 mb-3">
            <label for="confirm_password">Conferma Password</label>
            <input name="confirm_password" id="confirm_password" type="password" class="form-control <?php isset($errors) ? isValid($errors['confirm_password']) : '' ?>" value="">
            <?php isset($errors) ? errorMessage($errors['confirm_password']) : '' ?>
        </div>
        <div class="col-lg-8">
            <button name="modify-data" type="submit" class="btn btn-primary">Modifica</button>
        </div>
    </form>

</div>