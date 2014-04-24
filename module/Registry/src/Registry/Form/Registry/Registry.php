<?php
namespace Registry\Form\Registry;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 *
 * @author Jean
 *        
 */
class Registry extends Fieldset implements ObjectManagerAwareInterface, InputFilterProviderInterface
{
	use ProvidesObjectManager;
	
	public function init()
	{
		$this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
		$this->setObject(new \Registry\Entity\Registry());
		
		$this->add(array(
			'type' => 'Zend\Form\Element\Textarea',
			'name' => 'description',
			'options' => array(
				'label' => _('Descripcion'),
				'label_attributes' => array('class' => 'col-lg-2'),
				'twb-layout' => 'horizontal',
				'column-size' => 'lg-4',
			),
			'attributes' => array(
				'placeholder' => _('Descripcion'),
				'cols' => 5,
			),
		));
		
		$this->add(array(
			'type' => 'Zend\Form\Element\Collection',
			'name' => 'items',
			'options' => array(
				'label' => _('Items'),
				'count' => 0,
				'should_create_template' => true,
				'allow_add' => true,
				'allow_remove' => true,
				'target_element' => array(
					'type' => 'Registry\Form\Registry\Item'
				),
			),
		));
	}
	
	public function getInputFilterSpecification()
	{
		return array(
		);
	}
}
