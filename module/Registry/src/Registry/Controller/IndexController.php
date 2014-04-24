<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Registry for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator as ZendPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Registry\Entity\Registry;
use Registry\Entity\Item;
use Registry\Entity\File;
use Registry\File\FileInfo;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	const SAVE_REGISTRY_DRAF = 'draft';
	const SAVE_REGISTRY_PUBLISH = 'save';
	
	protected $acceptCriteria = array(
		'Zend\View\Model\JsonModel' => array(
			'application/json',
		),
	);
	
	
    public function indexAction()
    {
    	$q = $this->objectManager->createQueryBuilder();
        $q->select('r as registry', 'SUM(i.itemTotal) as total')
        	->from('Registry\Entity\Registry', 'r')
        	->leftJoin('Registry\Entity\Item', 'i', 'WITH', 'i.registry = r')
        	->where('r.user = :USER')
        	->groupBy('r')
        	->setParameter('USER', $this->zfcUserAuthentication()->getIdentity());
        
        $status = $this->params()->fromQuery('filter', -1);
        if ($status >= 0) {
        	$q->andWhere('r.status = :STATUS')
        		->setParameter('STATUS', $status);
        }
        
        $orderMap = array(
        	'number' => 'r.number',
        	'date' => 'r.createdDate',
        	'status' => 'r.status',
        	'total' => 'total'
        );
        
        $sortParams = $this->sortParams($orderMap);
        $q->orderBy($sortParams->by, $sortParams->sort);
        if ($sortParams->by == 'r.status') {
        	$q->orderBy('r.number', 'desc');
        }
        
        $registries = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($q, false)));
        
        return array(
        	'registries' => $registries,
        	'filter' => (int) $status,
        );
    }
    
    /**
     * Visualizar una rendicion para confirmarla o ver su resumen
     * 
     * @return \Zend\Http\Response|array
     */
    public function viewAction()
    {
    	$id = $this->params()->fromQuery('id', 0);
    	$registry = $this->objectManager->find('Registry\Entity\Registry', $id);
    	if (!is_object($registry) || !$this->registry($registry)->canView()) {
    		$this->fm(_('La rendicion solicitada no pudo ser encontrada'));
    		return $this->redirect()->toRoute('registry', array('action' => 'index'));
    	}
    	
    	$formManager = $this->getServiceLocator()->get('FormElementManager');
    	$form = $formManager->get('Registry\Form\Confirm', array('element' => $registry->getId()));
    	
    	if ($this->registry($registry)->canEdit()) {
	    	$url = $this->url()->fromRoute('registry/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
	    	$prg = $this->prg($url, true);
	    	if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
	    		return $prg;
	    	} elseif (is_array($prg)) {
	    		// Validar formulario de eliminacion
	    		$form->setData($prg);
	    		if (!$form->isValid()) {
	    			$this->fm(_('La rendicion no pudo ser confirmada'), 'error');
	    			$helper = $this->getServiceLocator()->get('viewhelpermanager')->get('htmlList');
	    			$this->fm($helper($form->getMessages()), 'error');
	    			return $this->redirect()->toRoute('registry');
	    		}
	    		
	    		// Confirmar una rendicion
	    		$this->doSave($registry, array(), true);
	    		
	    		$this->fm(_('La rendicion ha sido confirmada, un moderador se encargara de revisarla'), 'success');
	    		return $this->redirect()->toRoute('registry');
	    	}
    	}
    	
    	$commentsForm = $formManager->get('Registry\Form\Comment');
    	$commentsForm->setAttribute('action', $this->url()->fromRoute('registry/default', array('action' => 'comment'), array('query' => array('id' => $registry->getId()))));
    	
    	return array(
    		'form' => $form,
    		'registry' => $registry,
    		'commentform' => $commentsForm,
    	);
    }
    
    public function commentAction()
    {
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		return $this->forward()->dispatch('Registry\Controller\Index', array('action' => 'comment-ajax'));	
    	}
    	
    	$id = $this->params()->fromQuery('id', 0);
    	$registry = $this->objectManager->find('Registry\Entity\Registry', $id);
    	if (!is_object($registry) || !$this->registry($registry)->canView()) {
    		$this->fm(_('La rendicion solicitada no pudo ser encontrada'), 'error');
    		return $this->redirect()->toRoute('registry', array('action' => 'index'));
    	}
    	
    	
    	if ($this->registry($registry)->canModerate() || $this->registry($registry)->canEdit()) {
    		$formManager = $this->getServiceLocator()->get('FormElementManager');
    		$form = $formManager->get('Registry\Form\Comment');
    	
    		$url = $this->url()->fromRoute('registry/default', array('action' => 'comment'), array('query' => array('id' => $registry->getId())));
    		$form->setAttribute('action', $url);
    		
    		$prg = $this->prg($url, true);
    		if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
    			return $prg;
    		} elseif (is_array($prg)) {
    			// Validar formulario de eliminacion
    			$form->setData($prg);
    			if (!$form->isValid()) {
    				$this->fm(_('El comentario no pudo ser publicado'), 'error');
    				$helper = $this->getServiceLocator()->get('viewhelpermanager')->get('htmlList');
    				$this->fm($helper($form->getMessages()), 'error');
    				return $this->redirect()->toRoute('registry');
    			}
    			 
    			$comment = $form->getObject();
    			$comment->setAuthor($this->zfcUserAuthentication()->getIdentity());
    			$comment->setRegistry($registry);
    			
    			$this->objectManager->persist($comment);
    			$this->objectManager->flush();
    			
    			$this->fm(_('El comentario ha sido publicado'), 'success');
    			 
    			$url = $this->url()->fromRoute('registry/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
    			return $this->redirect()->toUrl($url . '#comment-' . $comment->getId());
    		}
    	}
    	
    	$this->fm(_('No tiene acceso a esta seccion'), 'error');
    	return $this->redirect()->toRoute('registry');
    }
    
    /**
     * Llamada ajax a comentarios
     * Actualmente solo para eliminar comentario
     * 
     * @return ViewModel
     */
    public function commentAjaxAction()
    {
    	$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
    	 
    	if (!$this->getRequest()->isPost()) {
    		return $viewModel->setVariables(array(
    			'result' => false,
    			'err' => 0,
    			'msg' => _('Llamada invalida')
    		));
    	}
    	
    	$id = $this->params()->fromPost('comment', 0);
    	$comment = $this->objectManager->find('Registry\Entity\Comment', $id);
    	if (!is_object($comment) || ($this->zfcUserAuthentication()->getIdentity() !== $comment->getAuthor() && !$this->registry($comment->getRegistry())->canModerate())) {
    		return $viewModel->setVariables(array(
    			'result' => false,
    			'err' => 0,
    			'msg' => _('El comentario solicitado no pudo ser encontrado')
    		));
    	}
    	 
    	$this->objectManager->remove($comment);
    	$this->objectManager->flush();
    	 
    	return $viewModel->setVariables(array(
    		'result' => true,
    		'msg' => _('El comentario ha sido eliminado')
    	));
    }
    
    /**
     * Crea una nueva rendicion
     * 
     * @return \Zend\Http\Response|array|\Zend\View\Model\ViewModel
     */
    public function createAction()
    {
    	$formManager = $this->getServiceLocator()->get('FormElementManager');
    	$form = $formManager->get('Registry\Form\Registry');
    	
    	$error = false;
    	$tempFiles = null;
    	
    	$url = $this->url()->fromRoute('registry/default', array('action' => 'create'));
    	$prg = $this->fileprg($form, $url, true);
    	if ($prg instanceof \Zend\Http\Response) {
    		return $prg;
    	} elseif (is_array($prg)) {
    		if (!isset($prg['registry']['items']) || !count($prg['registry']['items'])) {
	    		$error = _('Debe agregar al menos un item a su rendicion');
    		} else {
		    	// PROCESAR FORMULARIO
		    	if ($form->isValid()) {
		    		// Obtener la rendicion creada con FORM
		    		$registry = $form->getObject();
			    	
			    	$this->uploadFiles($form, $registry);
			    	$confirm = $this->doSave($registry, $prg);
			    	if ($confirm === true) {
			    		return $this->redirect()->toRoute('registry/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
			    	}
			    	
			    	$this->fm(_('Rendicion guardada'));
			    	return $this->redirect()->toRoute('registry', array('action' => 'index'));
		    	} else {
		    		// Form not valid, but file uploads might be valid
		    		$items = $form->get('registry')->get('items');
		    		$count = 0;
		    		foreach ($items->getIterator() as $item) {
		    			$fileErrors = $item->get('thefiles')->getMessages();
		    			if (empty($fileErrors)) {
		    				$tempFiles[$count] = $item->get('thefiles')->getValue();
		    			}
		    			$count++;
                	}
		    	}
    		}
    	}
    	
    	return array(
    		'form'      => $form,
    		//'id'        => $registry->getId(),
    		'error'     => $error,
    		'tempFiles' => $tempFiles
    	);
    }
    
    /**
     * Edita un borrador de rendicion
     *
     * @return \Zend\Http\Response|array|\Zend\View\Model\ViewModel
     */
    public function editAction()
    {
    	$id = $this->params()->fromQuery('id', 0);
    	$registry = $this->objectManager->find('Registry\Entity\Registry', (int) $id);
    	if ($registry->getUser() !== $this->zfcUserAuthentication()->getIdentity() || !is_object($registry)) {
    		$this->fm(_('La rendicion seleccionada no ha sido encontrada'), 'error');
    		return $this->redirect()->toRoute('registry', array('action' => 'index'));
    	}
    	
    	$formManager = $this->getServiceLocator()->get('FormElementManager');
    	$form = $formManager->get('Registry\Form\Registry');
    	$form->bind($registry);
    	
    	$error = false;
    	$tempFiles = null;
    	
    	$url = $this->url()->fromRoute('registry/default', array('action' => 'edit'), array('query' => array('id' => $registry->getId())));
    	$prg = $this->fileprg($form, $url, true);
    	if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
    		return $prg;
    	} elseif (is_array($prg)) {
    		if (!count($prg['registry']['items'])) {
	    		$error = _('Debe agregar al menos un item a su rendicion');
    		} else {
		    	// PROCESAR FORMULARIO
		    	if ($form->isValid()) {
		    		// Obtener la rendicion creada con FORM
		    		$registry = $form->getObject();
			    	
			    	$this->uploadFiles($form, $registry);
		    		$confirm = $this->doSave($registry, $prg);
			    	if ($confirm === true) {
			    		return $this->redirect()->toRoute('registry/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
			    	}
			    	
			    	$this->fm(_('Rendicion guardada'));
			    	return $this->redirect()->toRoute('registry', array('action' => 'index'));
		    	} else {
		    		// Form not valid, but file uploads might be valid
		    		$items = $form->get('registry')->get('items');
		    		$count = 0;
		    		foreach ($items->getIterator() as $item) {
		    			$fileErrors = $item->get('thefiles')->getMessages();
		    			if (empty($fileErrors)) {
		    				$tempFiles[$count] = $item->get('thefiles')->getValue();
		    			}
		    			$count++;
                	}
		    	}
    		}
    	}
    	
    	return array(
    		'form' => $form,
    		'id' => $registry->getId(),
    		'error' => $error,
    		'tempFiles' => $tempFiles
    	);
    }
    
    public function deleteAction()
    {
    	$id = $this->params()->fromQuery('id', 0);
    	$registry = $this->objectManager->find('Registry\Entity\Registry', $id);
    	$allowedStatusToDelete = array(Registry::REGISTRY_STATUS_DRAFT);
    	if (!is_object($registry) || $registry->getUser() !== $this->zfcUserAuthentication()->getIdentity() || !in_array($registry->getStatus(), $allowedStatusToDelete)) {
    		$this->fm(_('La rendicion seleccionada no ha sido encontrada'), 'error');
    		return $this->redirect()->toRoute('registry', array('action' => 'index'));
    	}
    	
    	$formManager = $this->getServiceLocator()->get('FormElementManager');
    	$form = $formManager->get('Registry\Form\DeleteConfirm', array('element' => $registry->getId()));
    	
    	$url = $this->url()->fromRoute('registry/default', array('action' => 'delete'), array('query' => array('id' => $registry->getId())));
    	$prg = $this->prg($url, true);
    	if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
    		return $prg;
    	} elseif (is_array($prg)) {
    		// Validar formulario de eliminacion
    		$form->setData($prg);
    		if (!$form->isValid()) {
    			$this->fm(_('La rendicion no pudo ser eliminada'), 'error');
    			$this->fm($form->getMessages(), 'error');
    			return $this->redirect()->toRoute('registry');
    		}
    		
    		// Trigger events
    		$this->getEventManager()->trigger('delete.registry', $this, array('registry' => $registry));
    		
    		$this->objectManager->remove($registry);
    		$this->objectManager->flush();
    		
    		$this->fm(_('La rendicion ha sido eliminada'), 'success');
    		
    		return $this->redirect()->toRoute('registry');
    	}
    	
    	return array(
    		'form' => $form,
    		'id' => $registry->getId(),
    	);
    }
    
    protected function uploadFiles($form, $registry)
    {
    	$uploadable = $this->getServiceLocator()->get('Gedmo\Uploadable');
    	$items = $form->get('registry')->get('items');
    	foreach ($items->getIterator() as $item) {
    		foreach ($item->get('thefiles')->getValue() as $fileInfo) {
    			$file = new File();
    			$file->setItem($item->getObject());
    			$file->setRegistry($registry);
    			
    			$uploadable->addEntityFileInfo($file, new FileInfo($fileInfo));
    			$this->objectManager->persist($file);
    		}
    	}
    }
    
    protected function updateNumber($registry)
    {
    	$query = $this->objectManager->createQueryBuilder();
    	$query->select('MAX(r.number) + 1')
    		->from('Registry\Entity\Registry', 'r')
    		->where('r.user = :USER')
    		->andWhere('r.status != 0')
    		->setParameter('USER', $registry->getUser());
    	
    	$nextVal = $query->getQuery()->getSingleScalarResult();
    	$registry->setNumber($nextVal !== null ? $nextVal : 1);
    }
    
    protected function doSave($registry, $prg = array(), $confirm = false)
    {
    	// Establecer el estado de la rendicion
    	$status = isset($prg['task']) ? $prg['task'] : 'draft';
    	$status = in_array($status, array( 'draft', 'save' )) ? $status : 'draft';
    	
    	// establecer Usuario
    	$registry->setUser($this->zfcUserAuthentication()->getIdentity());
    	$registry->setStatus(Registry::REGISTRY_STATUS_DRAFT);
    	    	
    	// Disparar eventos
    	if (!$confirm) {
    		$this->getEventManager()->trigger('create.registry', $this, array('registry' => $registry));
    	} else {
    		$this->getEventManager()->trigger('confirm.registry', $this, array('registry' => $registry));
    	}
    	
    	$toConfirm = null;
    	if ($status == 'save') {
    		$toConfirm = true;
    	}
    	if ($confirm === true) {
    		$toConfirm = false;
    		$this->updateNumber($registry);
    		$registry->setCreatedDate(new \DateTime('NOW'));
    		$registry->setStatus(Registry::REGISTRY_STATUS_PENDING);
    	}
    	
    	// Guardar datos
    	$this->objectManager->persist($registry);
    	$this->objectManager->flush();
    	
    	return $toConfirm;
    }
}
