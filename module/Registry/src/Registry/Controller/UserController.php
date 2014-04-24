<?php

namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		// TODO Auto-generated UserController::indexAction() default action
		return new ViewModel ();
	}
}
