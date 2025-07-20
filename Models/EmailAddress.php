<?php

/**
 * Each contact may have 0 or more email addresses.
 *
 * Each contact may have 0 or more email addresses.
 *
 * @version 1.0
 * @author steig
 */
class EmailAddress extends Entity 
{
  private string $_email;
  private ?string $_domain;

  /**
   * Constructor for EmailAddress.
   * Validates the provided email address.
   *
   * @param string $email The email address to validate and store.
   * @throws InvalidArgumentException If the email address is not valid.
   */
  public function __construct(?int $id, string $email)
  {
    // Validate the email address using a regex before assigning
    if (!self::isValid($email)) {
      throw new InvalidArgumentException("Invalid email address format: '{$email}'");
    }

    $this->_email = $email;
    parent::__construct($id, $email);
  }

  public function __get($name)
  {
    if ($name === 'email') {
      return $this->_email;
    }
    if ($name === 'domain') {
      return $this->_domain;
    }
    return parent::__get($name);
  }

  /**
   * Validates an email address using a regular expression.
   * This regex is a common, fairly robust pattern for email validation.
   * While perfect email regex is complex and debated, this covers most cases.
   * For more stringent validation or if you encounter issues, consider `filter_var($email, FILTER_VALIDATE_EMAIL)`.
   *
   * @param string $email The email address to validate.
   * @return bool True if the email is valid, false otherwise.
   */
  public static function isValid(string $email): bool
  {
    // A common and generally robust regex for email validation
    // This allows for a wide range of valid email characters and structures.
    //$regex = '/^(?!(?:(?:\\x22?\\x5c[\\x00-\\x7e]\\x22?)|(?:\\x22?[^\\x5c\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5c[\\x00-\\x7e]\\x22?)|(?:\\x22?[^\\x5c\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2a\\x2b\\x2d\\x2f\\x30-\\x39\\x3d\\x3f\\x41-\\x5a\\x5f\\x61-\\x7a\\x7b-\\x7d]+)|(?:\\x22(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\x5c[\\x00-\\x7f])*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2a\\x2b\\x2d\\x2f\\x30-\\x39\\x3d\\x3f\\x41-\\x5a\\x5f\\x61-\\x7a\\x7b-\\x7d]+)|(?:\\x22(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\x5c[\\x00-\\x7f])*\\x22)))*@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)|(?:\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-zA-Z0-9-]*[a-zA-Z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\x5c[\\x00-\\x7f])+)\\]))$/';

    // A more readable and commonly used simpler regex for general purposes:
    // $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    // For most practical applications, PHP's built-in filter is often preferred
    // as it is maintained and handles edge cases that regex alone might miss.
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

    // If you specifically want to use the regex:
    // return preg_match($regex, $email);
  }
}