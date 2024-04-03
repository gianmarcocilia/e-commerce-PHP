<?php
class Product extends DB
{

    private $create_values;
    private $update_values;

    public function index()
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    public function show($id)
    {
        $query = "SELECT * FROM products WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_object();

        return $row;
    }

    public function create()
    {
        $query = "INSERT INTO products (name, description, price, category_id, img)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $name = $this->create_values['name'];
        $description = $this->create_values['description'];
        $price = $this->create_values['price'];
        $category_id = $this->create_values['category_id'];
        $image = $this->create_values['image'];

        $stmt->bind_param('ssdis', $name, $description, $price, $category_id, $image);

        $stmt->execute();
    }

    public function update($id)
    {
        $query = "UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('ssdii', $this->update_values['name'], $this->update_values['description'], $this->update_values['price'], $this->update_values['category_id'], $id);

        $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM products WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        return $result;
    }

    public function search($value) {
        $search_value = '%'. $value . '%';
        $sql = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_value);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    public function category($id) {
        $query = "SELECT * FROM categories WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_object();
        return $row;
    }

    public function setUpdateValue($updateValues) {
        $this->update_values = $updateValues;
    }

    public function setCreatedValue($createdValues) {
        $this->create_values = $createdValues;
    }
}
