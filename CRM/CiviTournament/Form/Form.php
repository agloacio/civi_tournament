<?php
use Civi\Api4\Action\GroupContact\Create;

class CRM_CiviTournament_Form extends CRM_Core_Form
{
  public const LEGACY_DATE = FALSE;
  public const COUNTRY_SELECT = 'CountrySelect';
  public const STATE_PROVINCE_SELECT = 'StateProvinceSelect';

  protected $_values;
  protected $_id;
  protected $_fields;
  protected $_recordName;
  protected $_updateAction;

  public function preProcess()
  {
    if (!$this->getAction()) {
      $this->initializeAction();
    }

    $submittedId = $this->getSubmitValue("id");
    if ($submittedId === null) {
      if ($this->isNewRecord()) {
        $this->startNewRecord();
      } else if ($this->needsUpdate()) {
        $this->reloadExistingRecord();
      }
    }
  }

  public function buildQuickForm()
  {
    foreach ($this->_fields as $field) {
      $this->addFieldElement($field->_name, $field->_type, $field->_props, $field->_required, $field->_label);
    }

    $this->applyFilter('__ALL__', 'trim');
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Save'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
  }

  public function postProcess()
  {
    $submittedValues = $this->getSubmitValues();
    foreach ($this->_fields as $field) {
      if ($field->_type != 'Hidden') {
        $this->_updateAction->addValue($field->_name, $submittedValues[self::toHtmlElement($field->_name)]);
      }
    }

    $this->_updateAction->execute();

    $session = CRM_Core_Session::singleton();
    $session->setStatus($this->_recordName, "$this->_name Saved", 'success');

    $this->updateTitle();
  }

  /**
   * Set default values for the form.
   *
   * Note that in edit/view mode the default values are retrieved from the database
   */
  public function setDefaultValues()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $defaults = $this->_values;
    } else {
      $defaults = $this->getSubmittedValues();//_submitValues;
    }
    return $defaults;
  }

  /**
   * Default form context used as part of addField()
   */
  public function getDefaultContext(): string
  {
    return 'create';
  }

  public function getRenderableElementNames()
  {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

  protected function getId()
  {
    $this->_id = $this->_id ?? $this->getSubmitValue("id") ?? CRM_Utils_Request::retrieve('id', 'Positive');
  }

  protected function reloadExistingRecord()
  {
    $getAction = $this->initializeGetSingleRecordAction();

    foreach ($this->_fields as &$field) {
      $getAction = $getAction->addSelect($field->_name);
    }

    $apiResults = $getAction->execute();

    // Check if record was found
    if (!$apiResults) {
      CRM_Core_Error::statusBounce(ts("Could not find $this->getName() with id = $this->_id"));
    }

    $this->_values = self::toHtmlElements($apiResults[0]);

    if (empty($this->_values['id'])) {
      CRM_Core_Error::statusBounce(ts("Could not find $this->getName() with id = $this->_id"));
    }

    if (!CRM_Core_Permission::check('edit ' . $this->getDefaultEntity() . 's', $this->_id)) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->setRecordName();
    $this->updateTitle();
  }

  protected function setRecordName()
  {
    $this->_recordName = $this->_values['id'];
  }

  protected function updateTitle()
  {
    $this->setTitle(ts('Edit %1', [1 => $this->_recordName]));
  }

  protected function startNewRecord()
  {
    // check for add permissions
    if (!CRM_Core_Permission::check('add ' . $this->getDefaultEntity() . 's')) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->setTitle(ts('New %1', [1 => $this->getName()]));

    $session = CRM_Core_Session::singleton();
    $session->pushUserContext(CRM_Utils_System::url('civicrm/dashboard', 'reset=1'));
  }

  private function addFieldElement($name, $type='Text', $props = [], $required = FALSE, $label = null)
  {
    $elementName = self::toHtmlElement($name);
    try {
      parent::addField($elementName, $props, $required, self::LEGACY_DATE);
    } catch (Exception $e) {
      switch ($type) {
        case self::COUNTRY_SELECT: {
          $countries = CRM_Core_PseudoConstant::country();
          $this->add('select', $elementName, $label ?? $elementName, $countries, $required, array(
            'empty_value' => ' ',
            'onchange' => 'CRM_CiviTournament_Form.loadStates(this.value, \'address_primary_state_province_id\')'
          ));

          CRM_Core_Resources::singleton()->addScriptFile('civi_tournament', 'js/CRM_CiviTournament_Form.js');

          break;
        }
        case self::STATE_PROVINCE_SELECT: {
          $states_provinces = CRM_Core_PseudoConstant::stateProvince();
          $this->add('select', $elementName, $label ?? $elementName, $states_provinces, $required, array('empty_value' => ' '));
          break;
        }
        default: {
          $this->add(strtolower($type), $elementName, $label ?? $elementName, $props, $required);
        }
      }
    }
  }

  private function initializeAction()
  {
    if (in_array('add', $this->urlPath)) {
      $defaultAction = 'add';
    } else
      $defaultAction = 'update';   
   
    $this->setAction(CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, $defaultAction));
  }

  private function isNewRecord() {
    return $this->getAction() == CRM_Core_Action::ADD;
  }

  private function needsUpdate()
  {
    return $this->getAction() == CRM_Core_Action::UPDATE;
  }

  private static function toHtmlElements($apiResult){
    if ($apiResult) {
      return array_combine(
        array_map(function ($key) {
          return self::toHtmlElement($key);
        }, array_keys($apiResult)),
        array_values($apiResult)
      );
    }
  }

  private static function toHtmlElement($key) {
    return str_replace('.', '_', $key);
  }
}