<?php

namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator as ZendPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Registry\Entity\User;
use Zend\View\Model\ViewModel;
use Registry\Entity\Registry;
use Zend\Crypt\Password\Bcrypt;

class UserController extends AbstractActionController
{
	public function indexAction()
	{
		$q = $this->objectManager->createQueryBuilder();
		$q->select('u')
			->from('Registry\Entity\User', 'u');
		
		$status = $this->params()->fromQuery('filter', 1);
		$status = in_array($status, array(1,2)) ? $status : 1;
		$q->andWhere('u.status = :STATUS')
			->setParameter('STATUS', $status);
		
		$orderMap = array(
			'name' => 'u.name',
			'identity' => 'u.identity',
			'status' => 'u.status',
		);
		
		$sortParams = $this->sortParams($orderMap);
		$q->orderBy($sortParams->by, $sortParams->sort);
		
		$users = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($q, false)));
		$users->setItemCountPerPage(20);
		
		return array(
			'users' => $users,
			'filter' => (int) $status,
		);
	}
	
	public function createAction()
	{
		$formManager = $this->getServiceLocator()->get('FormElementManager');
		$form = $formManager->get('Registry\Form\User');
		 
		$url = $this->url()->fromRoute('users/default', array('action' => 'create'));
		$prg = $this->prg($url, true);
		if ($prg instanceof \Zend\Http\Response) {
			return $prg;
		} elseif (is_array($prg)) {
			// PROCESAR FORMULARIO
			$prg['user']['id'] = '';
			$prg['user']['userRoles'] = $this->fixPostUserRoles($prg);
            if (!in_array('3', $prg['user']['userRoles']) || (in_array('3', $prg['user']['userRoles']) && !isset($prg['user']['moderatedGroups']))) {
                $prg['user']['moderatedGroups'] = array();
            }
            
            $form->setValidationGroup(array('formcsrf', 'user' => array(
                'name', 'identity', 'password', 'password_c', 'email', 'userGroup',
                'workPhone', 'homePhone', 'mobilePhone', 'address', 'userRoles', 'moderatedGroups')));
            
			$form->setData($prg);
			if ($form->isValid()) {
				// Obtener la rendicion creada con FORM
				$user = $form->getObject();
				
				$service = $this->getServiceLocator()->get('zfcuser_user_service');
				
				// Encriptar y establecer credencial
				$bcrypt = new Bcrypt();
				$bcrypt->setCost($service->getOptions()->getPasswordCost());
				$user->setCredential($bcrypt->create($form->get('user')->getValue('password')));
				
				$this->objectManager->persist($user);
				$this->objectManager->flush();

				$this->getEventManager()->trigger('create.user', $this, array('user' => $user, 'form' => $form));
				
				$this->fm(_('Usuario guardado'));
				return $this->redirect()->toRoute('users', array('action' => 'index'));
			}
		}
		
		return array(
			'form'      => $form,
		);
	}
	
	public function editAction()
	{
		$id = $this->params()->fromQuery('id', 0);
		$user = $this->objectManager->find('Registry\Entity\User', $id);
		if (!is_object($user) || $user === $this->zfcUserAuthentication()->getIdentity()) {
			$this->fm(_('El usuario seleccionado no ha sido encontrado, o esta intentando editarse a si mismo'), 'error');
			return $this->redirect()->toRoute('users');
		}
		
		$formManager = $this->getServiceLocator()->get('FormElementManager');
		$form = $formManager->get('Registry\Form\User');
		$form->bind($user);

		$currentUserStatus = $user->getStatus();
		
		$url = $this->url()->fromRoute('users/default', array('action' => 'edit'), array('query' => array('id' => $user->getId())));
		$prg = $this->prg($url, true);
		if ($prg instanceof \Zend\Http\Response) {
			return $prg;
		} elseif (is_array($prg)) {
            $prg['user']['id'] = $user->getId();
			$prg['user']['userRoles'] = $this->fixPostUserRoles($prg);
			if (!in_array('3', $prg['user']['userRoles']) || (in_array('3', $prg['user']['userRoles']) && !isset($prg['user']['moderatedGroups']))) {
			    $prg['user']['moderatedGroups'] = array();
			}
			
			// PROCESAR FORMULARIO
			$validationGroup = array('formcsrf', 'user' => array(
			    'id', 'name', 'status', 'email', 'userGroup', 'workPhone',
			    'homePhone', 'mobilePhone', 'address', 'userRoles', 'moderatedGroups'));
			
			if (!empty($prg['user']['password'])) {
				$validationGroup = array_merge($validationGroup, array('user' => array('password_o', 'password', 'password_c')));
			}
			$form->setValidationGroup($validationGroup);
			$form->setData($prg);
			if ($form->isValid()) {
				// Obtener la rendicion creada con FORM
				$errorPassword = false;
				if ($form->get('user')->getValue('password') != '') {
					// Encriptar y establecer credencial
					$bcrypt = new Bcrypt();
					$oldPassword = $form->get('user')->getValue('password_o');
					$service = $this->getServiceLocator()->get('zfcuser_user_service');
					if (!$bcrypt->verify($oldPassword, $user->getCredential())) {
						$this->fm(_('La clave actual no es valida'), 'error');
						$errorPassword = true;
					} else {
						$bcrypt->setCost($service->getOptions()->getPasswordCost());
						$user->setCredential($bcrypt->create($form->get('user')->getValue('password')));
					}
				}
				
				$this->objectManager->persist($user);
				$this->objectManager->flush();

				$this->getEventManager()->trigger('edit.user', $this, array('user' => $user, 'form' => $form));
				if ($currentUserStatus != $user->getStatus()) {
					if ($user->getStatus() === 1) {
						$this->getEventManager()->trigger('activate.user', $this, array('user' => $user, 'form' => $form));
					} elseif ($user->getStatus() === 2) {
						$this->getEventManager()->trigger('deactivate.user', $this, array('user' => $user, 'form' => $form));
					}
				}
				
				$this->fm(_('Usuario guardado'));
				if ($errorPassword) {
					return $this->redirect()->toRoute('users/defaut', array('action' => 'edit'), array('query' => array('id' => $user->getId())));
				}
				return $this->redirect()->toRoute('users', array('action' => 'index'));
			}
		}
		
		
		return array(
			'form'      => $form,
		);
	}
	
	public function deleteAction()
	{
		$id = $this->params()->fromQuery('id', 0);
		$user = $this->objectManager->find('Registry\Entity\User', $id);
		if (!is_object($user) || $user->getStatus() !== \Registry\Entity\User::USER_STATUS_ACTIVE) {
			$this->fm(_('El usuario seleccionado no ha sido encontrado para eliminarlo'), 'error');
			return $this->redirect()->toRoute('users', array('action' => 'index'));
		} elseif ($user === $this->zfcUserAuthentication()->getIdentity()) {
			$this->fm(_('No puede eliminarse a si mismo, su cuenta debe ser eliminada por otro administrador'), 'error');
			return $this->redirect()->toRoute('users', array('action' => 'index'));
		}
		
		$q = $this->objectManager->createQuery('SELECT COUNT(r) FROM Registry\Entity\Registry r WHERE r.user = :USER AND r.status = :STATUS');
		$q->setParameters(array(
			'USER' => $user,
			'STATUS' => Registry::REGISTRY_STATUS_PENDING
		));
		$pending = $q->getSingleScalarResult();
		if ((int) $pending > 0) {
			$this->fm(_('El usuario tiene rendiciones pendientes de revision, por favor revise estas rendiciones antes de eliminarlo'), 'error');
			return $this->redirect()->toRoute('users', array('action' => 'index'));
		}
		
		$formManager = $this->getServiceLocator()->get('FormElementManager');
		$form = $formManager->get('Registry\Form\DeleteConfirm', array('element' => $user->getId()));
		 
		$url = $this->url()->fromRoute('users/default', array('action' => 'delete'), array('query' => array('id' => $user->getId())));
		$prg = $this->prg($url, true);
		if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
			return $prg;
		} elseif (is_array($prg)) {
			// Validar formulario de eliminacion
			$form->setData($prg);
			if (!$form->isValid()) {
				$this->fm(_('El usuario no pudo ser eliminado'), 'error');
				return $this->redirect()->toRoute('users');
			}
			
			// Trigger events
			$this->getEventManager()->trigger('delete.user', $this, array('user' => $user));

			$this->objectManager->remove($user);
			$this->objectManager->flush();
		
			$this->fm(_('El usuario ha sido eliminado'), 'success');
			
			return $this->redirect()->toRoute('users');
		}
		 
		return array(
			'form' => $form,
			'id' => $user->getId(),
			'user' => $user,
		);
	}
	
	protected function fixPostUserRoles($post)
	{
		$userRoles = array();
		if (isset($post['user']['userRoles'])) {
			$userRoles = $post['user']['userRoles'];
		}
		
		if (!in_array('1', $userRoles)) {
			$userRoles[0] = '1';
		}
		if (!in_array('2', $userRoles)) {
			$userRoles[1] = '2';
		}
		
		return $userRoles;
	}
}
