<?php
class AddressValidation
{
    protected bool $form_valid = true;
    protected array $errors = [
        'name' => [],
        'surname' => [],
        'email' => [],
        'street' => [],
        'city' => [],
        'cap' => []
    ];

    public function validate($values)
    {
        $this->require('name', $values['name']);
        $this->min('name', $values['name'], 2);
        $this->require('surname', $values['surname']);
        $this->min('surname', $values['surname'], 2);
        $this->require('email', $values['email']);
        $this->email('email', $values['email']);
        $this->require('street', $values['street']);
        $this->require('city', $values['city']);
        $this->require('cap', $values['cap']);
        $this->cap('cap', $values['cap']);
        return $this->form_valid;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function setError(string $input_field, string $error)
    {
        $this->form_valid = false;
        array_push($this->errors["$input_field"], $error);
    }

    protected function require(string $input_field, string $input_value)
    {
        if (strlen(trim($input_value)) === 0) {
            $this->setError($input_field, 'Questo campo è richiesto!');
        }
    }

    protected function min(string $input_field, string $input_value, int $min)
    {
        if (strlen(trim($input_value)) < $min) {
            $this->setError($input_field, 'La lunghezza minima per questo campo è di ' . $min . ' caratteri!');
        }
    }

    protected function email(string $input_field, string $input_value)
    {
        if (!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
            $this->setError($input_field, 'L\'email inserita non è valida!');
        }
    }

    protected function cap(string $input_field, string $input_value) {
        if (!((strlen(trim($input_value)) === 5) && (ctype_digit($input_value)))) {
            $this->setError($input_field, 'Il CAP inserito non è valido!');
        }
    }

}
