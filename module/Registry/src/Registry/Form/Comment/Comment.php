<?php
namespace Registry\Form\Comment;

use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class Comment extends Fieldset implements ObjectManagerAwareInterface, InputFilterProviderInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\Comment());

        $this->add(array(
            'type' => 'Textarea',
            'name' => 'comment',
            'options' => array(
                'label' => _('Comentario'),
                'label_attributes' => array('class' => 'required'),
            ),
            'attributes' => array(
                'placeholder' => _('Comentario'),
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'comment' => array(
                'required' => true,
            ),
        );
    }
}
