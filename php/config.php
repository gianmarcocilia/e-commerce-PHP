<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'ecommerce_db');

require_once('../classes/DB.php');
require_once('../classes/Product.php');
require_once('../classes/ProductValidation.php');
require_once('../classes/Category.php');
require_once('../classes/Cart.php');
require_once('../classes/CartProduct.php');
require_once('../classes/User.php');
require_once('../classes/UserValidation.php');
require_once('../classes/Discount.php');
require_once('../classes/Order.php');
require_once('../classes/Address.php');
require_once('../classes/AddressValidation.php');
