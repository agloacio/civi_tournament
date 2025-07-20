<?php
require_once("Elements/FormElement.php");

class CRM_CiviTournament_Form extends CRM_Core_Form
{
  public const LEGACY_DATE = FALSE;
  public const COUNTRY_SELECT = 'CountrySelect';
  public const STATE_PROVINCE_SELECT = 'StateProvinceSelect';

  protected $_entity;
  protected $_formElements;
  protected $_updateAction;

  public function __construct($state, $action, $method, $name)
  {
    parent::__construct($state, $action, $method, $name);

    $this->_formElements = array(
      new HiddenFormElement('id')
    );
  }

  public function __get($name)
  {
    if ($name === 'id')
      return $this->_id;
    if ($name === 'entity')
      return $this->_entity;
    if ($name === 'formElements')
      return $this->_formElements;
  }

  public function __set($name, $value)
  {
    if ($name === 'id')
      $this->_id = $value;
    if ($name === 'values')
      $this->_values = $value;
    if ($name === 'entityLabel')
      $this->_entityLabel = $value;
    if ($name === 'updateAction')
      $this->_updateAction = $value;
  }

  public function preProcess()
  {
    $submittedId = $this->getSubmitValue("id");
    $id = $submittedId 
      ?? CRM_Utils_Request::retrieve('id', 'Positive') 
      ?? CRM_Utils_Request::retrieve('cid', 'Positive');

    if (!$this->getAction()) $this->initializeAction();

    if ($submittedId === null) {
      switch ($this->getAction()) {
        case CRM_Core_Action::UPDATE:
          $this->_entity = $this->getPersistedEntity($id);

          // Check if record was found
          if (!$this->_entity) {
            $name = $this->getName();
            CRM_Core_Error::statusBounce(ts("Could not find $name with id = $this->_id"));
          }

          if (!CRM_Core_Permission::check('edit ' . $this->getDefaultEntity() . 's', $this->_id)) {
            CRM_Utils_System::permissionDenied();
            CRM_Utils_System::civiExit();
          }
          break;
        default:
          $this->initializeNewEntityCreation();
      }
    }

    $this->updateTitle();
  }

  public function buildQuickForm()
  {
    if ($this->_formElements) {
      foreach ($this->_formElements as $formElement) {
        $this->addFormElement($formElement->type, $formElement->name, $formElement->label, $formElement->attributes, $formElement->required, $formElement->extra);
      }
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

  public function setDefaultValues()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      return $this->getValuesForUpdate();
    } else {
      return $this->getSubmittedValues();
    }
  }

  public function postProcess()
  {
    $submittedValues = $this->getSubmitValues();
    $this->saveValues($submittedValues);

    $session = CRM_Core_Session::singleton();
    $session->setStatus($this->_entityLabel, "$this->_name Saved", 'success');

    $this->updateTitle();
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

  protected function getPersistedEntity(int $id)
  {
    $getAction = $this->initializeGetSingleRecordAction($id);
    foreach ($this->_formElements as $field) $getAction = $getAction->addSelect($field->name);
    return $getAction->execute();
  }

  protected function getValuesForUpdate() : array
  {
    return ["id" => $this->_entity->id];
  }

  protected function saveValues($submittedValues){
    foreach ($this->_formElements as $field) {
      if ($field->_type != 'Hidden') {
        $this->_updateAction->addValue($field->name, $submittedValues[self::toHtmlElementName($field->name)]);
      }
    }

    $this->_updateAction->execute();
  }

  protected function updateTitle()
  {
    $this->setTitle(ts('Edit %1', [1 => $this->entity->label]));
  }

  private function initializeNewEntityCreation()
  {
    // check for add permissions
    if (!CRM_Core_Permission::check('add ' . $this->getDefaultEntity() . 's')) {
      CRM_Utils_System::permissionDenied();
      CRM_Utils_System::civiExit();
    }

    $this->setTitle(ts('New %1', [1 => $this->_entityLabel ?? $this->getName()]));

    $session = CRM_Core_Session::singleton();
    $session->pushUserContext(CRM_Utils_System::url('civicrm/dashboard', 'reset=1'));
  }

  private function addFormElement($type, $name, $label = null, $attributes = [], $required = FALSE, $extra = null)
  {
    switch ($type) {
      case self::COUNTRY_SELECT: {
        $this->addCountrySelect($name, $label, $required);
        break;
      }
      case self::STATE_PROVINCE_SELECT: {
        $states_provinces = CRM_Core_PseudoConstant::stateProvince();
        $this->add('select', $name, $label ?? $name, $states_provinces, $required, array('empty_value' => ' '));
        break;
      }
      case "radio": {
        $values = array();
        $attributes = array();
        $separator = null;
        $this->addRadio($name, $label ?? $name, $values, $attributes, $separator, $required);
        break;
      }
      case "datepicker": {
        $this->add("datepicker", $name, $label ?? $name, array_merge($attributes, array('format' => 'mm/dd/yy')), $required, array('time' => false));
        break;
      }
      case "Select": {
        $this->add('select', $name, $label ?? $name, $attributes, $required, array('empty_value' => ' '));
        break;
      }
      case "Hidden": {
        $this->add('hidden', $name);
        break;
      }
      default: {
        $this->add('text', $name, $label ?? $name, $attributes, $required, $extra);
      }
    }
  }

  private function addCountrySelect($name, $label, $required) {
    $countries = CRM_Core_PseudoConstant::country();
    $this->add('select', $name, $label ?? $name, $countries, $required, array(
      'empty_value' => ' ',
      'onchange' => 'CRM_CiviTournament_Form.loadStates(this.value, \'address_primary_state_province_id\')'
    ));

    CRM_Core_Resources::singleton()->addScriptFile('civi_tournament', 'js/CRM_CiviTournament_Form.js');
  }

  private function initializeAction()
  {
    if (in_array('add', $this->urlPath)) {
      $defaultAction = 'add';
    } else
      $defaultAction = 'update';   
   
    $this->setAction(CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, $defaultAction));
  }

  private static function toHtmlElementNames($entity) : array {
    if ($entity) {
      return array_combine(
        array_map(function ($key) {
          return self::toHtmlElementName($key);
        }, array_keys($entity)),
        array_values($entity)
      );
    }
  }

  private static function toHtmlElementName($key) {
    return str_replace('.', '_', $key);
  }
}