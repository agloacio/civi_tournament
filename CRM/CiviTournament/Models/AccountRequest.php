<?php

/**
 * Primary contact, organization, etc.
 *
 * Required properties for creating an account to access our system.
 *
 * @version 1.0
 * @author steig
 */
class AccountRequest extends TournamentObject
{
  private Person $_primaryContact;
  private Organization $_billingOrganization;
  private EmailAddress $_email;
  private PhoneNumber $_landLine;
  private PhoneNumber $_mobilePhone;
  private Address $_billingAddress;
  private Group $_registrationGroup;
}