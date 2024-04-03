<?php

if ($user_logged) {
    header('Location: /e-commerce/public/');
    exit;
}

if (isset($_POST['register'])) {
    $values = [
        'name' => htmlspecialchars(trim($_POST['name'])),
        'email' => htmlspecialchars(trim($_POST['email'])),
        'password' => htmlspecialchars(trim($_POST['password'])),
        'confirm_password' => htmlspecialchars(trim($_POST['confirm_password']))
    ];

    $validation = new UserValidation();
    $validated = $validation->validate($values, true);
    if ($validated) {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $user = new User();
        $user->register($name, $email, $password);

        header('Location: ?page=login');
    } else {
        $errors = $validation->getErrors();
    }
}
?>
<form class="mt-5 w-75 m-auto" action="" method="POST">
    <h2 class="py-3">Registrazione</h2>
    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input name="name" id="name" type="text" class="form-control <?php isset($errors) ? isValid($errors['name']) : '' ?>" value="">
        <?php isset($errors) ? errorMessage($errors['name']) : '' ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" id="email" type="email" class="form-control <?php isset($errors) ? isValid($errors['email']) : '' ?>" value="">
        <?php isset($errors) ? errorMessage($errors['email']) : '' ?>
    </div>

    <div class="mb-3">
        <label for="password">Password</label>
        <input name="password" id="password" type="password" class="form-control <?php isset($errors) ? isValid($errors['password']) : '' ?>" value="">
        <?php isset($errors) ? errorMessage($errors['password']) : '' ?>
    </div>

    <div class="mb-3">
        <label for="confirm_password">Conferma Password</label>
        <input name="confirm_password" id="confirm_password" type="password" class="form-control <?php isset($errors) ? isValid($errors['confirm_password']) : '' ?>" value="">
        <?php isset($errors) ? errorMessage($errors['confirm_password']) : '' ?>
    </div>

    <div>
        <button class="btn btn-primary" type="submit" name="register">Registrati</button>
        <span>Hai già un account? <a href="/e-commerce/auth?page=login">Accedi.</a></span>
    </div>
</form>