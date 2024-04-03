<?php
class Order extends DB
{

    public function createOrder($tot_price, string $status, string $client_id, int $address_id, $user_id = null)
    {
        $sql = "INSERT INTO orders (tot_price, status, address_id, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('dsii', $tot_price, $status, $address_id, $user_id);
        $stmt->execute();
        $last_insert_id = $this->conn->insert_id;
        $this->deleteCart($client_id);
        return $last_insert_id;
    }

    public function orderProduct($order_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO order_product (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('iii', $order_id, $product_id, $quantity);
        $stmt->execute();
    }

    public function allOrders() {
        $result = $this->conn->query("SELECT * FROM orders");
        $orders = [];
        while ($row = $result->fetch_object()) {
            $orders[] = $row;
        }
        return $orders;
    }

    public function orders($id)
    {
        $result = $this->conn->query("SELECT * FROM orders WHERE user_id='$id'");
        $order = [];
        while ($row = $result->fetch_object()) {
            $order[] = $row;
        }
        return $order;
    }

    public function products($id) {
        $result = $this->conn->query("SELECT 
        products.name AS name,
        products.description AS description,
        products.price AS price,
        order_product.quantity AS quantity
    FROM 
        order_product 
    JOIN 
        products ON order_product.product_id = products.id
    WHERE 
        order_product.order_id = '$id';");
        $products = [];
        while ($row = $result->fetch_object()) {
            $products[] = $row;
        }
        return $products;
    }

    public function sendOrder($id) {
        $query = "UPDATE orders SET status='sended' WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);

        $stmt->execute();
    }

    public function address($id) {
        $query = "SELECT * FROM addresses WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_object();

        return $row;
    }

    private function deleteCart($id)
    {
        $sql = "DELETE FROM carts WHERE client_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
    }
}
