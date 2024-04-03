<?php
class Cart extends DB
{
    private $client_id;

    public function __construct()
    {
        parent::__construct();
        $this->initClientId();
    }

    public function cartList($cartId) {
        $result = $this->conn->query("SELECT products.name as name,
        products.id as id,
        products.description as description,
        products.price as single_price,
        cart_product.quantity as quantity,
        products.price * cart_product.quantity as tot_price FROM cart_product
        INNER JOIN products ON cart_product.product_id = products.id
        WHERE cart_product.cart_id = '$cartId'");
        
        $cart = [];
        while ($row = $result->fetch_object()) {
            $cart[] = $row;
        }
        return $cart;
    }

    public function cartTotal($cartId, $discount = null){
        $result = $this->conn->query("SELECT SUM(quantity) as tot_quantity,
        SUM(quantity* price) as tot_price FROM cart_product
        INNER JOIN products ON cart_product.product_id = products.id
        WHERE cart_id = '$cartId'");

        $row = $result->fetch_object();
        if($discount !== null) {
            $value_discount = $row->tot_price * $discount;
            $row->tot_discount = $value_discount;
            $row->tot_price = $row->tot_price - $value_discount;
            $row->tot_discount = number_format($row->tot_discount, 2);
            $row->tot_price = number_format($row->tot_price, 2);
        }

        return $row;
    }

    public function removeToCart($productId, $cartId){
        $quantity = 0;
        $query = "SELECT quantity, id FROM cart_product WHERE cart_id = ? AND product_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $cartId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            $quantity = $row->quantity;
            $cart_product_id = $row->id;
        }
        $quantity--;
        
        if ($quantity > 0) {
            $query = "UPDATE cart_product SET quantity = ? WHERE cart_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iii',$quantity, $cartId, $productId);
            $stmt->execute();
        } else {
            $this->delete($cart_product_id);
        }
    }

    public function addToCart($productId, $cartId)
    {
        $quantity = 0;
        $query = "SELECT quantity FROM cart_product WHERE cart_id = ? AND product_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $cartId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quantity = $row['quantity'];
        }
        $quantity++;
        
        if ($result->num_rows > 0) {
            $query = "UPDATE cart_product SET quantity = ? WHERE cart_id = ? AND product_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iii',$quantity, $cartId, $productId);
            $stmt->execute();
        } else {
            $this->createCartProduct($cartId, $productId, $quantity);
        }
    }

    public function getCartId()
    {
        $cart_id = 0;
        $result = $this->conn->query("SELECT * FROM carts WHERE client_id = '$this->client_id'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            $cart_id = $row->id;
        } else {
            $cart_id = $this->createCart($this->client_id);
        }

        return $cart_id;
    }

    private function initClientId()
    {
        if (isset($_SESSION['client_id'])) {
            $this->client_id = $_SESSION['client_id'];
        } else {
            $rand_str = $this->randomString();
            $_SESSION['client_id'] = $rand_str;
            $this->client_id = $rand_str;
        }
    }

    private function randomString()
    {
        return md5(mt_rand());
    }

    private function createCart($clientId)
    {
        $query = "INSERT INTO carts (client_id)
        VALUES (?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $clientId);

        $stmt->execute();
    }

    private function createCartProduct($cartId, $productId, $quantity) {
        $query = "INSERT INTO cart_product (cart_id, product_id, quantity)
        VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('iii', $cartId, $productId, $quantity);

        $stmt->execute();
    }

    private function delete($id)
    {
        $query = "DELETE FROM cart_product WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}
