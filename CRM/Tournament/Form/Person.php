<?php
require_once "Form.php";
use CRM_Tournament_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Tournament_Form_Person extends Tournament_Core_Form {
  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $this->_fieldNames = array('first_name', 'middle_name', 'last_name', 'birth_date', 'gender_id', 'prefix_id', 'suffix_id');
  }

  public function preProcess()
  {
    parent::preProcess();

    if ($this->_action == CRM_Core_Action::ADD) {
      // check for add contacts permissions
      if (!CRM_Core_Permission::check('add contacts')) {
        CRM_Utils_System::permissionDenied();
        CRM_Utils_System::civiExit();
      }

      $this->setTitle(ts('New %1', [1 => $this->_name]));

      $session = CRM_Core_Session::singleton();
      $session->pushUserContext(CRM_Utils_System::url('civicrm/dashboard', 'reset=1'));
    } else if ($this->_action == CRM_Core_Action::UPDATE) {
      $this->update();
    }
  }

  protected function getGetSingleRecordAction(){
    $this->_id = $this->getContactID();
    return \Civi\Api4\Individual::get(TRUE)
      ->addWhere('id', '=', $this->_id)
      ->setLimit(1);
  }

  public function buildQuickForm() {
    $this->applyFilter('__ALL__', 'trim');
    $entity = $this->getDefaultEntity();

    $this->addField('last_name', ['placeholder' => ts('Last Name'), 'label' => ts('Last Name')], true);
    $this->addField('first_name', ['placeholder' => ts('First Name'), 'label' => ts('First Name')], true);
    $this->addField('middle_name', ['placeholder' => ts('Middle Name'), 'label' => ts('Middle Name')]);

    $this->addField('gender_id', ['entity' => $entity, 'type' => 'Radio', 'allowClear' => TRUE]);

    $this->addField('birth_date', ['entity' => $entity], FALSE, FALSE);

    $this->addField('prefix_id', ['entity' => $entity, 'placeholder' => ts('Prefix'), 'label' => ts('Prefix')]);
    $this->addField('suffix_id', ['entity' => $entity, 'placeholder' => ts('Suffix'), 'label' => ts('Suffix')]);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Save'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());

    //$this->assign('contactId', current);
    parent::buildQuickForm();
  }

  public function postProcess() {
    $this->_values = $this->exportValues();

    \Civi\Api4\Individual::update(FALSE)
      ->addValue('first_name', $this->_values['first_name'])
      ->addValue('middle_name', $this->_values['middle_name'])
      ->addValue('last_name', $this->_values['last_name'])
      ->addValue('birth_date', $this->_values['birth_date'])
      ->addValue('gender_id', $this->_values['gender_id'])
      ->addValue('prefix_id', $this->_values['prefix_id'])
      ->addValue('suffix_id', $this->_values['suffix_id'])
      ->addWhere('id', '=', $this->getContactID())
      ->execute();

    $session = CRM_Core_Session::singleton();
    $session->setStatus($this->displayName(), "$this->_name Saved", 'success');

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
    return 'create';
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

  protected function updateTitle(){     
    $displayName = 
    $title = ts('Edit %1', [1 => $this->displayName()]);
    $this->setTitle($title);
  }

  private function displayName(){
    return $this->_values['first_name'] . ' ' . $this->_values['last_name'];
  }

}
