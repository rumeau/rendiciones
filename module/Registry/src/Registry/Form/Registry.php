<?php

namespace Registry\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 *
 * @author Jean
 *
 */
class Registry extends Form implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\Registry());
        $this->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Registry\Form\Registry\Registry',
            'name' => 'registry',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));

        $this->add(array(
            'type' => 'Csrf',
            'name' => 'formcsrf',
        ));
    }
}
