<?php
require_once("ContactProfile.php");

/**
 * Profile (inc. email, phone, address) for, e.g., School, District, Company, etc.
 *
 * Non-person Contact.
 *
 * @version 1.0
 * @author steig
 */
class OrganizationProfile extends ContactProfile
{
  private Organization $_organization;

  public function __construct(Organization $organization, EmailAddress $email, Address $address, PhoneNumber $mainPhone, ?PhoneNumber $mobilePhone = null)
  {
    $this->_organization = $organization;
    parent::__construct($organization->id, $organization->name, $organization->label, $email, $address, $mainPhone, $mobilePhone);
  }

  public function __get($name)
  {
    if ($name === 'organization') {
      return $this->_organization;
    }
    return parent::__get($name);
  }
}