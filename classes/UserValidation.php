<?php
class UserValidation extends DB
{
    protected bool $form_valid = true;
    protected array $errors = [
        'name' => [],
        'email' => [],
        'password' => [],
        'confirm_password' => []
    ];

    public function validate($values, bool $register = false)
    {
        $this->require('name', $values['name']);
        $this->min('name', $values['name'], 2);
        $this->require('email', $values['email']);
        $this->email('email', $values['email']);
        if($register){
            $this->alreadyExist($values['email']);
        }
        $this->require('password', $values['password']);
        $this->password('password', $values['password']);
        $this->checkSamePassword($values['password'], $values['confirm_password']);
        return $this->form_valid;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function setError(string $input_field, string $error)
    {
        $this->form_valid = false;
        $this->errors[$input_field][] = $error;
    }

    protected function alreadyExist($email)
    {
        $query = "SELECT * FROM users WHERE `email` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 0) {
            $this->setError('email', 'Questa Email è già associata ad un utente!');
        }
    }

    protected function require(string $input_field, string $input_value)
    {
        if (strlen(trim($input_value)) === 0) {
            $this->setError($input_field, 'The field is required!');
        }
    }

    protected function min(string $input_field, string $input_value, int $min)
    {
        if (strlen(trim($input_value)) < $min) {
            $this->setError($input_field, 'The Min length for this field is ' . $min . ' characters!');
        }
    }

    protected function email(string $input_field, string $input_value)
    {
        if (!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
            $this->setError($input_field, 'This Email is not valid!');
        }
    }

    protected function password(string $input_field, string $input_value) {
        if(mb_strlen(trim($input_value)) < 8) {
           $this->setError($input_field, "The Min length for this field is 8 characters!");
       }
       if (!preg_match("/[A-Z]/", $input_value)) {
           $this->setError($input_field, "The password must contain at least one capital letter.");
       }
       if (!preg_match("/[a-z]/", $input_value)) {
           $this->setError($input_field, "The password must contain at least one lowercase letter.");
       }
       if (!preg_match("/\W/", $input_value)) {
           $this->setError($input_field, "The password must contain at least one special character.");
       }
       if (preg_match("/\s/", $input_value)) {
           $this->setError($input_field, "The password cannot contain spaces.");
       }
     }
  
     protected function checkSamePassword(string $password, string $repeat_password) {
        if(trim($password) !== trim($repeat_password)) {
           $this->setError('confirm_password', "Password doesn't match!");
        }
     }
}
