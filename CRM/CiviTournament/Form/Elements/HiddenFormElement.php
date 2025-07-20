<?php
require_once("FormElement.php");

/**
 * TextFormElement short summary.
 *
 * TextFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class HiddenFormElement extends FormElement
{
  public function __construct($name)
  {
    parent::__construct('Hidden', $name, $name, self::REQUIRED);
  }
}