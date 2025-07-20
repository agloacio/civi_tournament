<?php

/**
 * EmailFormElement short summary.
 *
 * EmailFormElement description.
 *
 * @version 1.0
 * @author steig
 */
class EmailFormElement extends TextFormElement {
  public function __construct($name, $label = null, $required = FALSE, $helpText = null)
  {
    parent::__construct($name, $label, $required, $helpText);
  }
}