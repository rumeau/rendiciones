<?php
namespace Registry\Form\Registry;

use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 *
 * @author Jean
 *
 */
class Registry extends Fieldset implements ObjectManagerAwareInterface, InputFilterProviderInterface
{
    use ProvidesObjectManager;

    const DOCUMENT_BILL = 1;
    const DOCUMENT_INVOICE = 2;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\Registry());

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => _('Descripcion'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-4',
            ),
            'attributes' => array(
                'placeholder' => _('Descripcion'),
                'cols' => 5,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'items',
            'options' => array(
                'label' => _('Items'),
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'allow_remove' => false,
                'target_element' => array(
                    'type' => 'Registry\Form\Registry\Item'
                ),
            ),
        ));

        $this->add(array(
            'type' => 'Button',
            'name' => 'task'
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'task' => array(
                'required' => true
            ),
            'items' => array(
                'type' => 'Collection',
                'required' => true,
                'count' => 1,
                'input_filter' => array(
                'itemNumber' => array(
                    'required' => true,
                ),
                'itemIdentifier' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'Application\Validator\Rut'
                        ),
                    ),
                ),
                'itemDate' => array(
                    'required' => true,
                    'validators' => array(
                        array(
                            'name' => 'Date',
                            'options' => array(
                                'format' => 'Y-m-d'
                            ),
                        ),
                    ),
                ),
                'itemGross' => array(
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
                ),
                'itemVat' => array(
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
                ),
                'itemTotal' => array(
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
                ),
                'thefiles' => array(
                    'required' => true,
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
                ))
            ),
            
        );
    }
}
