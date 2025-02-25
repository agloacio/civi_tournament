<?php

/**
 * Creates and retrieves settings for CiviTournament Extension
 *
 * This class contains the common logic.  It's declared abstract because it shouldn't be instantiated directly.
 *
 * @version 1.0
 * @author msteigerwald
 */
abstract class CiviEntitySettings
{
  protected static $fields; // Static property

  abstract public static function addWhere($getAction);

  public static function get()
  {
    $getAction = static::getEntity()::get(TRUE)->setLimit(1); // Use late static binding
    $getAction = static::addWhere($getAction);

    foreach (static::getFields() as $key => $value) {
      $getAction = $getAction->addSelect($key);
    }

    $result = $getAction->execute();

    if (is_array($result[0]) && !empty($result[0])) {
      return $result[0];
    }

    return static::create();
  }

  // Abstract method to return the correct Entity class
  abstract protected static function getEntity();

  // Getter method for the fields
  protected static function getFields()
  {
    static::$fields = static::computeFields(); 
    return static::$fields;
  }

  // Abstract method to define the logic to compute the fields
  abstract protected static function computeFields();

  private static function create()
  {
    $createAction = static::getEntity()::create(TRUE); // Use late static binding

    foreach (static::getFields() as $key => $value) {
      $createAction = $createAction->addValue($key, $value);
    }

    $results = $createAction->execute();

    return $results[0];
  }
}