<?php
declare(strict_types=1);

class Validator
{
    private array $errors = [];

    /**
     * Ensure a field exists and is not empty.
     */
    public function required(array $data, string $field, string $internalMessage = null): void
    {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            $this->errors[$field] = $internalMessage ?? "$field must not be empty.";
        }
    }

    /**
     * Ensure a field length is within [min, max].
     */
    public function length(array $data, string $field, int $min, int $max, string $internalMessage = null): void
    {
        if (!isset($data[$field])) {
            // If it's missing, 'required' might already have flagged it.
            return;
        }

        $len = mb_strlen(trim($data[$field]));
        if ($len < $min || $len > $max) {
            $this->errors[$field] = $internalMessage
                ?? "$field must be between $min and $max characters.";
        }
    }

    /**
     * Ensure a field is a valid email format.
     */
    public function email(array $data, string $field, string $internalMessage = null): void
    {
        if (!isset($data[$field])) {
            return;
        }

        $value = trim($data[$field]);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $internalMessage
                ?? "$field is not a valid email address.";
        }
    }

    /**
     * Check if there are any validation errors.
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get the array of validation errors (for internal logging).
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
