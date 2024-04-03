<?php
class Category extends DB
{

    public function categories()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    public function products($id)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }
}
