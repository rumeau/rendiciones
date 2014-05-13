<?php
namespace Registry\Form\Registry;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\CollectionInputFilter;
use Zend\InputFilter\Factory as InputFactory;

class RegistryInputFilter extends InputFilter
{
    public function __construct()
    {
        $factory = new InputFactory();
        $this->add($factory->createInput(array(
            'name' => 'task',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'InArray',
                    'options' => array('haystack' => array('save', 'draft'))
                ),
            ),
        )));

        $itemsFilter = new CollectionInputFilter();
        $itemsFilter->setInputFilter(new ItemInputFilter());
        $itemsFilter->setIsRequired(true);
        $this->add($itemsFilter, 'items');
    }
}
