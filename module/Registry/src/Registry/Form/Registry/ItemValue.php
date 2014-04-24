<?php
namespace Registry\Form\Registry;

use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Registry\Entity\DocumentField;
use Registry\Form\FieldFactory;

class ItemValue extends Fieldset implements ObjectManagerAwareInterface
{
	use ProvidesObjectManager;
	
	public $document;
	
	public function __construct($name = 'item', $options = array())
	{
		if (isset($options['document'])) {
			$this->document = $options['document'];
			unset($options['document']);
		}
	
		parent::__construct($name, $options);
	}
	
	public function init()
	{
		$om = $this->getObjectManager();
		if ($this->document) {
			$fields = $this->document->getDocumentFields();
			foreach ($fields as $field) {
				$this->add($this->createField($field));
			}
		}
	}
	
	public function createField(DocumentField $field)
	{
		$element = new FieldFactory();
		return $element->create($field);
	}
}
