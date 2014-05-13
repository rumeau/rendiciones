<?php

namespace Registry\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 *
 * @author Jean
 *
 */
class Registry extends Form
{
    public function __construct()
    {
        parent::__construct('registry');
    }

    public function init()
    {
        $this->setAttribute('method', 'post')
            ->setInputFilter(new RegistryInputFilter());

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
