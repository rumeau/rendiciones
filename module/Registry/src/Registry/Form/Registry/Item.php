<?php
namespace Registry\Form\Registry;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;

class Item extends Fieldset implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    const DOCUMENT_BILL = 1;
    const DOCUMENT_INVOICE = 2;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\Item());

        $this->add(array(
            'type' => 'Registry\Form\Element\DoctrineHidden',
            'name' => 'document',
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Registry\Entity\Document',
            ),
            'attributes' => array(
                'value' => 1,
                'class' => 'documentType',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => _('Descripcion'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-3',
            ),
            'attributes' => array(
                'placeholder' => _('Descripcion'),
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemNumber',
            'options' => array(
                'label' => _('Numero'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => 'N&deg;',
            ),
            'attributes' => array(
                'placeholder' => _('Numero'),
                'class' => 'numberField',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemIdentifier',
            'options' => array(
                'label' => _('RUT'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2'
            ),
            'attributes' => array(
                'placeholder' => _('RUT'),
                'data-formatter' => '99.999.999-*'
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemName',
            'options' => array(
                'label' => _('Nombre'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-3',
            ),
            'attributes' => array(
                'placeholder' => _('Nombre'),
            ),
        ));

        $this->add(array(
            'type' => 'Date',
            'name' => 'itemDate',
            'options' => array(
                'label' => _('Fecha'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-append' => '<span class="glyphicon glyphicon-calendar"></span>',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemGross',
            'options' => array(
                'label' => _('Total Neto'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => '$',
            ),
            'attributes' => array(
                'placeholder' => 'Total Neto',
                'value' => 0,
                'class' => 'totalGross',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemVat',
            'options' => array(
                'label' => _('IVA'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => '$',
            ),
            'attributes' => array(
                'placeholder' => _('IVA'),
                'value' => 0,
                'class' => 'totalVat',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'itemTotal',
            'options' => array(
                'label' => _('Total'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => '$',
            ),
            'attributes' => array(
                'placeholder' => _('Total'),
                'value' => 0,
            ),
        ));

        $this->add(array(
            'type' => 'File',
            'name' => 'thefiles',
            'options' => array(
                'label' => _('Imagenes'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-4',
            ),
            'attributes' => array(
                'multiple' => true,
            )
        ));
    }
}
