<?php
namespace Registry\Form;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Comment extends Form implements ObjectManagerAwareInterface
{
	use ProvidesObjectManager;
	
	public function init()
	{
		$this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
		$this->setObject(new \Registry\Entity\Comment());
		
		$this->add(array(
			'type' => 'Textarea',
			'name' => 'comment',
			'options' => array(
				'label' => _('Comentario'),
				'label_attributes' => array('class' => 'required'),
			),
			'attributes' => array(
				'placeholder' => _('Comentario'),
			),
		));
	}
}