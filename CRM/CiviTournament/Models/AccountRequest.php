<?php

/**
 * AccountRequest short summary.
 *
 * AccountRequest description.
 *
 * @version 1.0
 * @author steig
 */
class AccountRequest extends TournamentObject
{
  private Person $_person;
  private Organization $_billingOrganization;
  private EmailAddress $_email;
  private PhoneNumber $_landLine;
  private PhoneNumber $_mobilePhone;
  private Address $_billingAddress;
  private Group $_registrationGroup;
}