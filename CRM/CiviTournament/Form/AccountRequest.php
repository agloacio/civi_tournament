<?php
use const Civi\WorkflowMessage\Traits\ADDRESS_EXPORT_FMT;
require_once "Person.php";
require_once "BillingOrganization.php";

/**
 * CRM_CiviTournament_Form_AccountRequest lets a new user apply for an account.
 *
 * An account combines an individual, an organization and a registration group. If approved the indivdial gets full access to the organizationa and all contacts in the registration group.
 *
 * @version 1.0
 * @author msteigerwald
 */

class CRM_CiviTournament_Form_AccountRequest extends CRM_Core_Form {
  public function __construct(
    $state = NULL,
    $action = CRM_Core_Action::ADD,
    $method = 'post',
    $name = NULL
  )
  {
    $this->_method = $method;
    parent::__construct($state, $action ?? CRM_Core_Action::ADD, $method, $name);
  }

  public function buildQuickForm() {
    // Instantiate subforms
    $this->_personSubForm = new CRM_CiviTournament_Form_Person($this->getState(), $this->getAction(), $this->_method, $this->getName());
    $this->_billingOrgSubForm = new CRM_CiviTournament_Form_BillingOrganization($this->getState(), $this->getAction(), $this->_method, $this->getName());

    //build the subforms.
    $this->_personSubForm->buildQuickForm();
    $this->_billingOrgSubForm->buildQuickForm();

    // Assign subforms to the template
    $this->assign('personSubForm', $this->_personSubForm);
    $this->assign('billingOrgSubForm', $this->_billingOrgSubForm);

    // Add other elements specific to AccountRequest
    $this->add('text', 'account_name', ts('Account Name'));

    parent::buildQuickForm();
  }

  //public function setDefaults() {
  //  $defaults = parent::getDefaults();

  //  // Set defaults for the Person subform if needed
  //  $defaults['person'] = [
  //      'first_name' => 'John', // Example default
  //      'last_name' => 'Doe',
  //  ];

  //  // Set defaults for the Billing Organization subform if needed
  //  $defaults['billing_organization'] = [
  //      'organization_name' => 'Example Corp', // Example default
  //  ];

  //  $this->setDefaults($defaults);
  //}

  public function postProcess() {
    $values = $this->controller->exportValues($this->getName());

    // Access data from subforms
    $personValues = $values['person'];
    $billingOrgValues = $values['billing_organization'];
    $accountName = $values['account_name'];

    // Process the data (e.g., save to the database)
    // ...

    parent::postProcess();
  }

  private $_method = 'post';
  private $_personSubForm;
  private $_billingOrgSubForm;
}