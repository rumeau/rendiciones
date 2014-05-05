<?php
namespace Registry\Form\Group;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class Group extends Fieldset implements ObjectManagerAwareInterface, InputFilterProviderInterface
{
    use ProvidesObjectManager;
    
    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\UserGroup());
        
        $this->add(array(
        	'type' => 'Text',
        	'name' => 'name',
        	'options' => array(
        		'label' => _('Nombre del Grupo'),
        		'label_attributes' => array('class' => 'col-lg-2 required'),
        		'twb-layout' => 'horizontal',
        		'column-size' => 'lg-4',
        	),
        	'atttributes' => array(
        		'placeholder' => _('Nombre'),
        	),
        ));
        
        $this->add(array(
        	'type' => 'Textarea',
        	'name' => 'description',
        	'options' => array(
        		'label' => _('Descripcion'),
        		'label_attributes' => array('class' => 'col-lg-2'),
        		'twb-layout' => 'horizontal',
        		'column-size' => 'lg-5',
        	),
        ));
        
        $this->add(array(
        	'type' => 'DoctrineModule\Form\Element\ObjectSelect',
        	'name' => 'users',
        	'options' => array(
        		'label' => _('Usuarios'),
        		'label_attributes' => array('class' => 'col-lg-2 control-label'),
        	    'target_class' => 'Registry\Entity\User',
        	    'label_generator' => function($e) {
                    $label = $e->getDisplayName();
                    if (is_object($e->getUserGroup()) && $e->getUserGroup()->getId() !== 1) {
                        $label .= ' *';
                    }
                    return $label;
        	    },
        	    'property' => 'name',
        	    'twb-layout' => 'horizontal',
        	    'column-size' => 'lg-10',
            ),
            'attributes' => array(
        		'class' => 'selectpicker show-menu-arrow',
                'multiple' => true,
                'data-size' => 10,
                'data-width' => '300px',
                'data-live-search' => true,
                'title' => _('Asignar Usuarios'),
                'data-actions-box' => true,
        	),
        ));
    }
    
    public function getInputFilterSpecification()
    {
        return array(
        	'name' => array(
        	   'required' => true,
            ),
            'users' => array(
        		'allow_empty' => true,
        	),
        );
    }
}
