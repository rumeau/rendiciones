<?php
namespace Registry\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class RegistryInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new Registry\RegistryInputFilter(), 'registry');
    }
}
