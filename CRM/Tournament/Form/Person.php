<?php

use CRM_Tournament_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Tournament_Form_Person extends CRM_Core_Form {
  private $person = null;
  public function preProcess()
  {
    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, 'update');

    parent::preProcess();

    $session = CRM_Core_Session::singleton();

    if ($this->_action == CRM_Core_Action::ADD) {
      // check for add contacts permissions
      if (!CRM_Core_Permission::check('add contacts')) {
        CRM_Utils_System::permissionDenied();
        CRM_Utils_System::civiExit();
      }

      $typeLabel = 'Person';

      $this->setTitle(ts('New %1', [1 => $typeLabel]));
      $session->pushUserContext(CRM_Utils_System::url('civicrm/dashboard', 'reset=1'));
    } else {
      $contactId = $this->getContactID();

      $people = \Civi\Api4\Individual::get(TRUE)
        ->addSelect('first_name', 'middle_name', 'last_name', 'birth_date', 'gender_id') //, 'prefix_id:label', 'suffix_id:label', 'gender_id:label')
        ->addWhere('id', '=', $contactId)
        ->setLimit(1)
        ->execute();

      $this->person = $people[0];

      // Check if person was found
      if (!$people) {
        CRM_Core_Error::statusBounce(ts("Could not find person with id = $contactId"));
      }

      if (empty($this->person['id'])) {
        CRM_Core_Error::statusBounce(ts('A person with that ID does not exist: %1', [1 => $contactId]));
      }

      if (!CRM_Core_Permission::check('Contact', $contactId, 'edit')) {
        CRM_Utils_System::permissionDenied();
        CRM_Utils_System::civiExit();
      }
      $this->_values = $this->person;

      $this->updateTitle();
    }
  }

  public function buildQuickForm() {
    $this->applyFilter('__ALL__', 'trim');

    $this->addField('last_name', ['placeholder' => ts('Last Name'), 'label' => ts('Last Name')], true);
    $this->addField('first_name', ['placeholder' => ts('First Name'), 'label' => ts('First Name')], true);
    $this->addField('middle_name', ['placeholder' => ts('Middle Name'), 'label' => ts('Middle Name')]);
    // $this->addField('birth_date', ['placeholder' => ts('Birth Date'), 'label' => ts('Birth Date')], false, false);
    // $this->addField('gender_id', ['placeholder' => ts('Gender'), 'label' => ts('Gender')]);


    $this->addField('gender_id', ['entity' => 'contact', 'type' => 'Radio', 'allowClear' => TRUE]);

    $this->addField('birth_date', ['entity' => 'contact'], FALSE, FALSE);

    $this->addField('prefix_id', ['entity' => 'contact', 'placeholder' => ts('Prefix'), 'label' => ts('Prefix')]);
    $this->addField('suffix_id', ['entity' => 'contact', 'placeholder' => ts('Suffix'), 'label' => ts('Suffix')]);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    //$this->assign('contactId', current);
    parent::buildQuickForm();
  }

  public function postProcess() {
    $this->person = $this->exportValues();

    $results = \Civi\Api4\Individual::update(FALSE)
      ->addValue('first_name', $this->person['first_name'])
      ->addValue('middle_name', $this->person['middle_name'])
      ->addValue('last_name', $this->person['last_name'])
      ->addValue('birth_date', $this->person['birth_date'])
      ->addValue('gender_id', $this->person['gender_id'])
      ->addValue('prefix_id', $this->person['prefix_id'])
      ->addValue('suffix_id', $this->person['suffix_id'])
      ->addWhere('id', '=', $this->getContactID())
      ->execute();

    $session = CRM_Core_Session::singleton();
    $session->setStatus($message, ts('Person Saved'), 'success');

    $this->updateTitle();

    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

  /**
   * Default form context used as part of addField()
   */
  public function getDefaultContext(): string
  {
    return 'update';
  }

  /**
   * Explicitly declare the entity api name.
   */
  public function getDefaultEntity()
  {
    return 'contact';
  }

  /**
   * Set default values for the form.
   *
   * Note that in edit/view mode the default values are retrieved from the database
   */
  public function setDefaultValues()
  {
    $defaults = $this->_values;
    return $defaults;
  }

  private function updateTitle(){     
    $displayName = $this->person['first_name'] . ' ' . $this->person['last_name'];
    $title = ts('Edit %1', [1 => $displayName]);
    $this->setTitle($title);
  }

}
