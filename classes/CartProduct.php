<?php
class CartProduct extends DB{

    public function index()
    {
        $sql = "SELECT * FROM cart_product";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    public function show($id)
    {
        $query = "SELECT * FROM cart_product WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_object();

        return $row;
    }

}