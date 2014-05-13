<?php
namespace Registry\Form;

use Zend\Form\Form;

class Comment extends Form
{
    public function init()
    {
        $this->add(array(
            'type' => 'Registry\Form\Comment\Comment',
            'name' => 'comment',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));
    }
}
