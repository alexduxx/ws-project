<?php

class Validate
{
    private $_passed = false;
    private $_errors = array();
    private $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }


    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                // echo "{$item} {$rule} must be {$rule_value} <br>";         REALLY fucking nice feature

                $value = $source[$item];
                // echo $value;
                $item = escape($item);

                if ($rule === 'required' && empty($value)) { // check the rules for the inputs
                    $this->addError("{$item} is required");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters");
                            }
                            break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item} ");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                            break;
                        case 'special-pass-requirements':
                            if (!preg_match_all('$\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $value)) {
                                $this->addError("{$item} does not meet the requirements.");
                            }
                            break;
                        case 'upper-lower-case':
                            if (preg_match_all('/[^a-z\s-]/i', $value)) {
                                $this->addError("{$item} can contain only letters.");
                            }
                            break;
                        case 'lower-case':
                            if (preg_match_all('/[^a-z\s-]/', $value)) {
                                $this->addError("{$item} can contain only letters.");
                            }
                            break;
                        case 'email-validation':
                            $email = filter_var($value, FILTER_SANITIZE_EMAIL);
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("Invalid {$item}.");
                            }
                            break;

                        default:
                            # code ...
                            break;
                    }
                }
            }
        }
        if (empty($this->errors())) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
