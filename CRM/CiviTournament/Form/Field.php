<?php

/**
 * Field short summary.
 *
 * Field description.
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

  public function __construct($entity, $name, $label = null, $type = 'Text', $required = FALSE)
  {
    $this->_entity = $entity;
    $this->_name = $name;
    $this->_label = $label ?? $this->defaultLabel();
    $this->_placeholder = $this->_label;
    $this->_type = $type;
    $this->_required = $required;
    $this->_props = ['entity' => $this->_entity, 'label' => ts($this->_label), 'placeholder' => ts($this->_placeholder), 'type' => $this->_type];
  }

  private function defaultLabel()
  {
    $token = str_contains($this->_name, '_id') ? str_replace('_id', '', $this->_name) : $this->_name;
    return $this->capitalizeWords($token);
  }

  private function capitalizeWords($string)
  {
    $words = explode('_', $string);
    $capitalizedWords = array_map('ucfirst', $words);
    return implode(' ', $capitalizedWords);
  }
}