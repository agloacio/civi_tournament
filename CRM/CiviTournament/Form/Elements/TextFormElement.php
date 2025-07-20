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
class TextFormElement extends FormElement
{
  public function __construct($name, $label = null, $required = FALSE, $helpText = null)
  {
    $attributes = ['label' => ts($label), 'placeholder' => ts($label), 'type' => $this->_type, 'help_text' => ts($helpText)];
    parent::__construct('Text', $name, $label, $required, $attributes);
  }

  public function GetEntityValue($entity)
  {
    $property = $this->name;
    $value = $entity->$property;
    return $value;
  }
}