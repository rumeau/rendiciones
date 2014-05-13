<?php
namespace Registry\Form;

use Zend\Form\Form;

class Group extends Form
{
    public function init()
    {
        $this->add(array(
            'type' => 'Registry\Form\Group\Group',
            'name' => 'group',
            'options' => array(
                'use_as_base_fieldset' => true
            ),
        ));

        $this->add(array(
            'type' => 'Csrf',
            'name' => 'formcsrf'
        ));
    }
}
