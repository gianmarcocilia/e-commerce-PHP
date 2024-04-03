<?php
$cart = new Cart();
$cart_id = $cart->getCartId();
$cart_total = $cart->cartTotal($cart_id);
?>

<footer class="footer mt-auto py-3 bg-light">
    <ul class="contacts">
        <li>
            Contacts:
        </li>
        <li>
            <a  href="https://www.linkedin.com/in/gianmarco-cilia-aa89652b8" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
        </li>
        <li>
        <a href="https://github.com/gianmarcocilia" target="_blank"><i class="fa-brands fa-github"></i></a>
        </li>
    </ul>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    <?php require_once("../assets/js/main.js"); ?>
</script>
</body>

</html>