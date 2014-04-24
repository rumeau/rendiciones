<?php

namespace Registry\Form;

use Zend\Form\Form;

/**
 *
 * @author Jean
 *        
 */
class Registry extends Form
{
	public function init()
	{
		$this->add(array(
			'type' => 'Registry\Form\Registry\Registry',
			'name' => 'registry',
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
