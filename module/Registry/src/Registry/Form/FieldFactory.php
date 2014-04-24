<?php
namespace Registry\Form;

use Registry\Entity\DocumentField;
use Zend\Form\Element;

class FieldFactory
{
	public function __construct($field = null)
	{
		if ($field instanceof DocumentField) {
			$type = $field->getType();
			$method = 'create' . ucfirst(strtolower($type));
			if (method_exists($this, $method)) {
				return $this->$method($field);
			}
		}
		
		return $this;
	}
	
	public function create(DocumentField $field)
	{
		$type = $field->getType();
		$type = ucfirst(strtolower($type));
		
		$method = 'create' . $type;
		
		if (!method_exists($this, $method)) {
			throw new Exception\BadMethodCallException('The field type "' . $type . '" does not exists');
		}
		
		return $this->$method($field);
	}
	
	/**
	 * Crea un campo decimal
	 * 
	 * @param DocumentField $field
	 * @return \Zend\Form\Element\Text
	 */
	protected function createDecimal(DocumentField $field)
	{
		$element = new Element\Text();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2',
				'add-on-prepend' => '$',
			))
			->setAttribute('placeholder', _('Monto'));
		
		return $element;
	}
	
	/**
	 * Crea un campo de fecha
	 * 
	 * @param DocumentField $field
	 * @return \Zend\Form\Element\Date
	 */
	protected function createDate(DocumentField $field)
	{
		$element = new Element\Date();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2',
				'add-on-append' => '<span class="glyphicon glyphicon-calendar"></span>',
			))
			->setAttribute('placeholder', _('Fecha'));
	
		return $element;
	}
	
	
	protected function createTime(DocumentField $field)
	{
		$element = new Element\Time();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2'
			))
			->setAttribute('placeholder', _('Hora'));
	
		return $element;
	}
	
	protected function createDatetime(DocumentField $field)
	{
		$element = new Element\DateTime();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2'
			))
			->setAttribute('placeholder', _('Fecha & Hora'));
	
		return $element;
	}
	
	protected function createNum(DocumentField $field)
	{
		$element = new Element\Text();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2'
			))
			->setAttribute('placeholder', _('Numero'));
	
		return $element;
	}
	
	protected function createAlnum(DocumentField $field)
	{
		$element = new Element\Text();
		$element->setName($field->getId())
			->setLabel($field->getName())
			->setLabelAttributes(array('class' => 'col-lg-2'))
			->setOptions(array(
				'colum-size' => 'lg-2'
			))
			->setAttribute('placeholder', _('Texto'));
	
		return $element;
	}
}
