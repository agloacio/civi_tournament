<?php


use \Civi\Api4\Individual as Api;

class PersistenceLayer
{
  static function initializeGetSingleRecordAction($id)
  {
    return Api::get(TRUE)
      ->addWhere('id', '=', $id)
      ->setLimit(1);
  }
}