<?php
$error_message = '';
if ($user_logged) {
    header('Location: /e-commerce/public/');
    exit;
}

if (isset($_POST['login'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $user = new User();
    $result = $user->login($email, $password);

    if ($result) {
        header('Location: /e-commerce/public/');
        exit;
    } else {
        $error_message = 'Login Fallito!';
    }
}
?>

<form class="mt-5 w-75 m-auto" action="" method="POST">
    <h2 class="py-3">Accedi</h2>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="text-danger b-3">
        <?php echo $error_message; ?>
    </div>
    <div>
        <button class="btn btn-primary" type="submit" name="login">Accedi</button>
        <span>Non hai un account? <a href="/e-commerce/auth?page=register">Registrati.</a></span>
    </div>
</form>