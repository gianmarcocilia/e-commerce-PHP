<?php
class User extends DB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($query);
        $md5_password = md5($password);
        $stmt->bind_param('ss', $email, $md5_password);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        if ($row) {
            $this->setUser($row, 'user');
            return true;
        } else {
            return false;
        }
    }

    public function register($name, $email, $password)
    {
        $user = $this->createUser($name, $email, $password, 2);
        return $user;
    }

    public function modifyData($name, $email, $password, $id)
    {
        $sql = "UPDATE users SET name=?, email=?, password=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $md5_password = md5($password);
        $stmt->bind_param('sssi', $name, $email, $md5_password, $id);
        if ($stmt->execute()) {
            $new_user = (object) [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'role_id' => 2
            ];
            $this->setUser($new_user);
        }
    }

    private function setUser($result)
    {
        $user = $result;
        $user = (object) [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->role_id == 1
        ];

        $_SESSION['user'] = $user;
    }

    private function createUser($name, $email, $password, $role_id)
    {
        $query = "INSERT INTO users (name, email, password, role_id)
        VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $md5_password = md5($password);
        $stmt->bind_param('sssi', $name, $email, $md5_password, $role_id);
        $stmt->execute();
    }
}
