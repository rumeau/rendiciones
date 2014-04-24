<?php
namespace Registry\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Confirm extends Form implements InputFilterProviderInterface
{

    protected $element;

    public function __construct($name = null, $options = array())
    {
        if (! isset($options['element'])) {
            throw new \Zend\Form\Exception\InvalidArgumentException('An element option is required to confirm it');
        }
        
        $this->element = $options['element'];
        unset($options['element']);
        
        parent::__construct('confirm', $options);
    }

    public function init()
    {
        $this->add(
            array(
                'type' => 'Hidden',
                'name' => 'element',
                'attributes' => array(
                    'value' => $this->element
                )
            )
        );
        
        $this->add(array(
            'type' => 'Csrf',
            'name' => 'csrf'
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'element' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Int'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => $this->element
                        )
                    )
                )
            )
        );
    }
}
