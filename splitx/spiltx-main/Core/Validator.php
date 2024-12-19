<?php

namespace Core;

class Validator
{
    /**
     * Validate that the given values is not empty
     * 
     * @param mixed $value
     * @return boole
     */
    public function notEmpty(mixed $value): bool
    {
        return !empty($value);
    }

    /**
     * Validate that the string length is between given
     * min and max length
     * 
     * @param string $value
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function stringLength(string $value, int $min = 1, int $max = 255)
    {
        $length = strlen($value);

        return $length >= $min && $length <= $max;
    }

    /**
     * Validate that the given value has a 
     * valid email format
     * 
     * @param string $value
     * @return bool
     */
    public function email(string $value): bool
    {
        return !filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
