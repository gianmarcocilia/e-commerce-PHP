<?php
class ProductValidation
{
    protected bool $form_valid = true;
    protected array $errors = [
        'name' => [],
        'description' => [],
        'price' => [],
        'category_id' => [],
        'image' => []
    ];

    public function validate($values)
    {
        $this->require('name', $values['name']);
        $this->min('name', $values['name'], 3);
        $this->require('description', $values['description']);
        $this->require('price', $values['price']);
        $this->checkPrice('price', $values['price'], 0.50);
        $this->require('image', $values['image']);
        $this->min('image', $values['image'], 12);
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

    protected function checkPrice(string $input_field, $input_value, $min) {
        if (!is_numeric($input_value)) {
            $this->setError($input_field, 'Please insert only number!');
        }
        if($input_value < $min) {
            $this->setError($input_field, 'The min price for product is '. $min . ' €!');
        }
    }

}
