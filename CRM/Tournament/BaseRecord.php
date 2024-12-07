<?php

class BaseRecord
{
  protected $_id;  

  public function __construct($id){
    $this->_id = $id;
  }
  
}