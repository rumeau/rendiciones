<?php
namespace Registry\Form\Registry;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class ItemInputFilter extends InputFilter
{
    const DOCUMENT_BILL = 1;
    const DOCUMENT_INVOICE = 2;

    public function __construct()
    {
        $factory = new InputFactory();
        $this->add($factory->createInput(array(
            'name' => 'itemNumber',
            'required' => true,
        )));

        $this->add($factory->createInput(array(
            'name' => 'itemIdentifier',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Application\Validator\Rut'
                ),
            ),
        )));

        $this->add($factory->createInput(array(
            'name' => 'itemDate',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d'
                    ),
                ),
            ),
        )));

        $this->add($factory->createInput(array(
            'name' => 'itemGross',
            'allow_empty' => true,
            'filters' => array(
                array(
                    'name' => 'NumberFormat',
                    'options' => array(
                        'locale' => 'es_CL',
                        'type' => \NumberFormatter::TYPE_DOUBLE
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'Callback',
                    'options' => array(
                        'callback' => function ($value, $context) {
                            if ($context['document'] == self::DOCUMENT_INVOICE) {
                                if (empty($value)) {
                                    return false;
                                }
                            }

                            return true;
                        }
                    ),
                ),
            ),
        )));

        $this->add($factory->createInput(array(
            'name' => 'itemVat',
            'allow_empty' => true,
            'filters' => array(
                array(
                    'name' => 'NumberFormat',
                    'options' => array(
                        'locale' => 'es_CL',
                        'type' => \NumberFormatter::TYPE_DOUBLE
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'Callback',
                    'options' => array(
                        'callback' => function ($value, $context) {
                            if ($context['document'] == self::DOCUMENT_INVOICE) {
                                if (empty($value)) {
                                    return false;
                                }
                            }

                            return true;
                        }
                    ),
                ),
            ),
        )));

        $this->add($factory->createInput(array(
            'name' => 'itemTotal',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'NumberFormat',
                    'options' => array(
                        'locale' => 'es_CL',
                        'type' => \NumberFormatter::TYPE_DOUBLE
                    ),
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'GreaterThan',
                    'options' => array('min' => 0)
                ),
                array(
                    'name' => 'Callback',
                    'options' => array(
                        'callback' => function ($value, $context) {
                            if ($context['document'] == self::DOCUMENT_INVOICE) {
                                $total = $context['itemVat'] + $context['itemGross'];
                                if ($value != $total) {
                                    return false;
                                }
                            }

                            return true;
                        }
                    ),
                ),
            ),
        )));

        $this->add($factory->createInput(array(
            'name' => 'thefiles',
            'allow_empty' => true,
            'type' => 'Zend\InputFilter\FileInput',
            'filters' => array(
                array(
                    'name' => 'Zend\Filter\File\RenameUpload',
                    'options' => array(
                        'target' => realpath(__DIR__ . '/../../../../../../data/tmpuploads'),
                        'randomize' => true,
                    ),
                ),
            ),
        )));
    }
}
