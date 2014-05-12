<?php
namespace Registry\Form\User;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Fieldset;
use DoctrineModule\Persistence\ProvidesObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class User extends Fieldset implements ObjectManagerAwareInterface, InputFilterProviderInterface
{
    use ProvidesObjectManager;

    public function init()
    {
        $this->setHydrator(new DoctrineHydrator($this->getObjectManager()));
        $this->setObject(new \Registry\Entity\User());

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'name',
            'options' => array(
                'label' => _('Nombre'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-4'
            ),
            'attributes' => array(
                'placeholder' => _('Nombre')
            ),
        ));

        $this->add(array(
            'type' => 'Checkbox',
            'name' => 'status',
            'options' => array(
                'unchecked_value' => 2,
                //'label' => _('Estado'),
                //'label_attributes' => array('class' => 'col-lg-2 control-label')
            ),
            'attributes' => array(
                'class' => 'switch-status',
                'value' => 1
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'identity',
            'options' => array(
                'label' => _('RUT'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'help-block' => _('El RUT se usara como nombre de usuario al inicar sesion'),
            ),
            'attributes' => array(
                'placeholder' => _('11111111-K'),
                'autocomplete' => 'off',
            )
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'password_o',
            'options' => array(
                'label' => _('Contraseña Actual'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
            ),
            'attributes' => array(
                'placeholder' => _('Contraseña'),
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'password_n',
            'options' => array(
                'label' => _('Contraseña'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
            ),
            'attributes' => array(
                'placeholder' => _('Contraseña'),
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'password_c',
            'options' => array(
                'label' => _('Confirmar Contraseña'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
            ),
            'attributes' => array(
                'placeholder' => _('Contraseña'),
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'userGroup',
            'options' => array(
                'label' => _('Grupo'),
                'label_attributes' => array('class' => 'col-lg-2 control-label'),
                'target_class' => 'Registry\Entity\UserGroup',
                'property' => 'name',
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-10',
            ),
            'attributes' => array(
                'class' => 'selectpicker show-menu-arrow',
                'data-size' => 10,
                'data-width' => '200px',
                'data-live-search' => true,
                'title' => _('Grupo'),
                'value' => 1,
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'email',
            'options' => array(
                'label' => _('E-Mail'),
                'label_attributes' => array('class' => 'col-lg-2 required'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2'
            ),
            'attributes' => array(
                'placeholder' => _('nombre@dominio.com'),
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'workPhone',
            'options' => array(
                'label' => _('Telefono Trabajo'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => array(
                    'text' => _('+56')
                ),
            ),
            'attributes' => array(
                'placeholder' => _('Cod Area + Numero')
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'homePhone',
            'options' => array(
                'label' => _('Telefono Casa'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => array(
                    'text' => _('+56')
                ),
            ),
            'attributes' => array(
                'placeholder' => _('Cod Area + Numero')
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'mobilePhone',
            'options' => array(
                'label' => _('Telefono Movil'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-2',
                'add-on-prepend' => array(
                    'text' => _('+56')
                ),
            ),
            'attributes' => array(
                'placeholder' => _('Numero')
            ),
        ));

        $this->add(array(
            'type' => 'Textarea',
            'name' => 'address',
            'options' => array(
                'label' => _('Direccion'),
                'label_attributes' => array('class' => 'col-lg-2'),
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-5'
            ),
            'attributes' => array(
                'placeholder' => _('Direccion'),
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'userRoles',
            'options' => array(
                'label_attributes' => array('class' => 'control'),
                'label_generator' => function ($entity) {
                    return _($entity->getRoleId());
                },
                'target_class' => 'Registry\Entity\UserRole',
                'property' => 'roleId',
                'inline' => false,
                'is_method' => true,
            ),
            'attributes' => array(
                'value' => array(1,2),
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'moderatedGroups',
            'options' => array(
                'label' => _('Grupos Moderados'),
                'label_attributes' => array('class' => 'col-lg-2 control-label'),
                'target_class' => 'Registry\Entity\UserGroup',
                'property' => 'name',
                'twb-layout' => 'horizontal',
                'column-size' => 'lg-10',
            ),
            'attributes' => array(
                'class' => 'selectpicker show-menu-arrow',
                'multiple' => true,
                'data-size' => 10,
                'data-width' => '300px',
                'data-live-search' => true,
                'title' => _('Asignar grupos'),
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
            'identity' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'Alnum', 'options' => array('allow_whitespace' => false))
                ),
                'validators' => array(
                    array('name' => 'Application\Validator\Rut'),
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'object_repository' => $this->getObjectManager()->getRepository('Registry\Entity\User'),
                            'fields' => 'identity',
                        ),
                    ),
                ),
            ),
            'password_o' => array(
                'required' => true,
                'validatos' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'callback' => function ($value, $context) {
                                if (!empty($context['password']) && empty($value)) {
                                    return false;
                                }

                                return true;
                            }
                        ),
                    ),
                ),
            ),
            'password_n' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array('min' => 5)
                    ),
                ),
            ),
            'password_c' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password_n',
                        ),
                    ),
                ),
            ),
            'email' => array(
                'required' => true,
                'validators' => array(
                    array('name' => 'EmailAddress'),
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_manager' => $this->getObjectManager(),
                            'object_repository' => $this->getObjectManager()->getRepository('Registry\Entity\User'),
                            'fields' => 'email',
                        ),
                    ),
                ),
            ),
            'workPhone' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'PhoneNumber',
                        'options' => array(
                            'country' => 'CL'
                        ),
                    ),
                ),
            ),
            'homePhone' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'PhoneNumber',
                        'options' => array(
                            'country' => 'CL'
                        ),
                    ),
                ),
            ),
            'mobilePhone' => array(
                'required' => false,
                'validators' => array(
                    array(
                        'name' => 'PhoneNumber',
                        'options' => array(
                            'country' => 'CL'
                        ),
                    ),
                ),
            ),
            'moderatedGroups' => array(
                'allow_empty' => true,
            ),
        );
    }
}
