<?php

/**
 * Group of people
 *
 * Example, for competition-type events, participants are usually registered as a group, especially for billing purposes.
 *
 * @version 1.0
 * @author msteigerwald
 */

class Group extends TournamentObject
{
  public function __construct($id, $name)
  {
    parent::__construct($id, $name);
  }
}