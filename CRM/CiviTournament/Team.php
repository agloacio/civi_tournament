<?php

/**
 * Team short summary.
 *
 * Team description.
 *
 * @version 1.0
 * @author msteigerwald
 */
class Team
{
  function getTeams(){
    $groups = \Civi\Api4\Group::get(TRUE)
      ->addSelect('id', 'name', 'title', 'description', 'source', 'visibility:label', 'is_active')
      ->addWhere('group_type', '=', 3)
      ->setLimit(25)
      ->execute();
    foreach ($groups as $group) {
      // do something
    }
  }
}