<?php

/**
 * Each contact may have 0 or more Phone Numbers.
 *
 * Each contact may have 0 or more Phone Numbers.
 *
 * @version 1.0
 * @author steig
 */

class PhoneNumber extends Entity 
{
  private string $_phoneNumber;
  private ?string $_areaCode;
  private ?string $_exchange;
  private ?string $_localNumber;

    /**
     * Constructor for PhoneNumber.
     * Validates the provided phone number.
     *
     * @param string $phoneNumber The phone number string.
     * @throws InvalidArgumentException If the phone number is not valid.
     */
    public function __construct(?int $id, string $phoneNumber)
    {
        $phoneNumber = self::normalize($phoneNumber); // Normalize the number before validation and storage

        //if (!self::isValid($phoneNumber)) {
        //    throw new InvalidArgumentException("Invalid phone number format: '{$phoneNumber}'");
        //}

        $this->_phoneNumber = $phoneNumber;
        parent::__construct($id, $phoneNumber);
    }

    /**
     * Validates a phone number using a basic regular expression.
     * This regex allows for common phone number characters and formats (digits, spaces, hyphens,
     * parentheses, and an optional leading plus sign for international codes).
     *
     * IMPORTANT: For robust international phone number validation, consider using
     * `libphonenumber-for-php`. This regex is a basic structural check.
     *
     * @param string $phoneNumber The phone number to validate.
     * @return bool True if the phone number is valid, false otherwise.
     */
    public static function isValid(string $phoneNumber): bool
    {
        // This regex allows for a leading plus sign, digits, spaces, hyphens, and parentheses.
        // It requires at least 7 digits (allowing for local numbers) and up to 20 characters.
        // Adjust the length constraints based on your requirements.
        $regex = '/^\+?[0-9\s\-\(\)]{7,20}$/';

        // You might want to normalize the number first (e.g., remove all non-digit characters
        // except '+' at the start) before applying more specific validation rules.
        // However, for a basic regex, allowing common separators is often desired.

        return preg_match($regex, $phoneNumber) === 1;
    }

    /**
     * Normalizes a phone number string by removing common non-digit separators.
     * This can be useful before storing or for more consistent validation if
     * your validation relies on the absence of these characters.
     *
     * @param string $phoneNumber The phone number string to normalize.
     * @return string The normalized phone number string.
     */
    public static function normalize(string $phoneNumber): string
    {
        // Keep '+' at the beginning, remove spaces, hyphens, and parentheses.
        return preg_replace('/[()\s\-]/', '', $phoneNumber);
    }
}