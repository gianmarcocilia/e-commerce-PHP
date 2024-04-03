<?php
class Address extends DB
{

    public function saveAddress($values)
    {
        $sql = "INSERT INTO addresses (user_id, name, surname, email, street, city, cap) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $user_id = isset($values['user_id']) ? $values['user_id'] : null;
        $name = $values['name'];
        $surname = $values['surname'];
        $email = $values['email'];
        $street = $values['street'];
        $city = $values['city'];
        $cap = $values['cap'];
        $stmt->bind_param('issssss', $user_id, $name, $surname, $email, $street, $city, $cap);
        $stmt->execute();

        $last_insert_id = $this->conn->insert_id;

        return $last_insert_id;
    }

    public function selectAddress($user_id)
    {
        $sql = "SELECT * FROM addresses WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public function modifyAddress($values, $id) {
        $sql = "UPDATE addresses SET name=?, surname=?, email=?, street=?, city=?, cap=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $name = $values['name'];
        $surname = $values['surname'];
        $email = $values['email'];
        $street = $values['street'];
        $city = $values['city'];
        $cap = $values['cap'];
        $stmt->bind_param('ssssssi', $name, $surname, $email, $street, $city, $cap, $id);
        $stmt->execute();
    }
}
