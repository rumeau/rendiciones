<?php
namespace Registry\Form;

use Zend\Form\Form;

/**
 *
 * @author Jean
 *        
 */
class User extends Form
{
	public function init()
	{
		$this->add(array(
			'type' => 'Registry\Form\User\User',
			'name' => 'user',
			'options' => array(
				'use_as_base_fieldset' => true,
			),
		));
		
		$this->add(array(
			'type' => 'Csrf',
			'name' => 'formcsrf',
		));
	}
}
