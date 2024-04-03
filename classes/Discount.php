<?php
class Discount extends DB
{
    protected $discountValid = true;

    public function createDiscount($code, $discount)
    {
        $sql = "INSERT INTO discounts (code, discount) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $numero = $discount / 100;
        $discount_format = number_format($numero, 2);
        $stmt->bind_param('sd', $code, $discount_format);
        $stmt->execute();
    }

    public function discountValid($code, $discount)
    {
        if (strlen(trim($code)) === 0 || strlen(trim($code)) > 15) {
            $this->discountValid = false;
        }
        if ($discount > 60 || $discount < 5) {
            $this->discountValid = false;
        }
        if (!preg_match('/^\d+$/', $discount)) {
            return $this->discountValid = false;
        }
        return $this->discountValid;
    }

    public function selectDiscount($code)
    {
        $sql = "SELECT * FROM discounts WHERE code = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public function selectAllDiscount()
    {
        $sql = "SELECT * FROM discounts";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }
        return $data;
    }

    public function deleteDiscount($id)
    {
        $sql = "DELETE FROM discounts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}
