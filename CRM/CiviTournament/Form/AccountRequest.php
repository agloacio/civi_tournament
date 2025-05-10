<?php
use Civi\Api4\Address;
use Civi\Api4\Email;
use Civi\Api4\Phone;
require_once "CRM/CiviTournament/Models/Settings/Genders.php";
require_once "CRM/CiviTournament/Models/Settings/Salutations.php";
require_once "CRM/CiviTournament/Models/Settings/Generations.php";

/**
 * CRM_CiviTournament_Form_AccountRequest lets a new user apply for an account.
 *
 * An account combines an individual, an organization and a registration group. If approved the indivdial gets full access to the organizationa and all contacts in the registration group.
 *
 * @version 1.0
 * @author msteigerwald
 */

class CRM_CiviTournament_Form_AccountRequest extends CRM_CiviTournament_Form {
  private Person $_personForm;
  private Address $_addressForm;
  private Phone $_landlineForm;
  private Phone $_mobileForm;
  private Email $_emailForm;

  public function __construct(
    $state = NULL,
    $action = CRM_Core_Action::ADD,
    $method = 'post',
    $name = NULL
  )
  {
    parent::__construct($state, $action ?? CRM_Core_Action::ADD, $method, $name);
  }

  public function buildQuickForm() {
    $required = true;
    $optional = false;

    $this->add('text', 'email', ts('Email'), array('placeholder' => ts('Your Email')), $required);
    $this->add('text', 'organizationName', ts('Organization Name (e.g., School or School District)'), array('placeholder' => ts('School or District Name')), $required);
    $this->add(
      'select',
      'prefix_id',
      ts('Salutation'),
      array_merge([0 => '-- Select Salutation --'], Salutations::get())
    );
    $this->add('text', 'firstName', ts('First Name'), array('placeholder' => ts('First Name')), $required);
    $this->add('text', 'lastName', ts('Last Name'), array('placeholder' => ts('Last Name')), $required);
    $this->add(
      'select',
      'suffix_id',
      ts('Generation'),
      array_merge([0 => '-- Select Generation --'], Generations::get())
    );
    $this->add(
      'select',
      'gender_id',
      ts('Gender'),
      array_merge([0 => '-- Select Gender --'], Genders::get()),
      $optional,
      ['title' => ts('In case we need to assign roommates for housing.')]
    );
    $this->add('text', 'address', ts('Address'), array('placeholder' => ts('Address')), $required);
    $this->add('text', 'city', ts('City'), array('placeholder' => ts('City')), $required);
    $this->add('text', 'postalCode', ts('Zip'), array('placeholder' => ts('Zip')), $required);
    $this->add('text', 'phone', ts('Landline'), array('placeholder' => ts('Phone')), $required);
    $this->add('text','mobile_phone', ts('Mobile Phone'), array('title' => ts('How can we reach you at the tournament?')));

    parent::buildQuickForm();
  }

  public function postProcess() {
    parent::postProcess();
  }
}