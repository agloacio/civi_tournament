<?php

/**
 * Form Field
 *
 * Binds entity fields to form elements.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Field
{
  public $_entity;
  public $_name;
  public $_label;
  public $_placeholder;
  public $_props;
  public $_required;
  public $_type;
  public $_helpText;

  public function __construct($entity, $name, $label = null, $type = 'Text', $required = FALSE, $helpText = null)
  {
    $this->_entity = $entity;
    $this->_name = ts($name);
    $this->_label = ts($label ?? $this->defaultLabel());
    $this->_placeholder = $this->_label;
    $this->_type = $type;
    $this->_required = $required;
    $this->_helpText = $helpText;
    $this->_props = ['entity' => $this->_entity, 'label' => ts($this->_label), 'placeholder' => ts($this->_placeholder), 'type' => $this->_type, 'help_text' => ts($this->_helpText)];
  }

  private function defaultLabel()
  {
    $token = str_contains($this->_name, '_id') ? str_replace('_id', '', $this->_name) : $this->_name;
    return Field::capitalizeWords($token);
  }

  private static function capitalizeWords($string)
  {
    $words = explode('_', $string);
    $capitalizedWords = array_map('ucfirst', $words);
    return implode(' ', $capitalizedWords);
  }
}