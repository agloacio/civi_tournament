<?php

class Person extends BaseRecord
{
  public $_last_name;
  public $_first_name;
  public $_middle_name;
  public $_gender;
  public $_birth_date;
  public $_prefix;
  public $_suffix;

  public function __construct($id){
    parent::__construct($id);
  }
}