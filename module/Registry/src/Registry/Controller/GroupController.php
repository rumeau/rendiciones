<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator as ZendPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Registry\Entity\Group;

class GroupController extends AbstractActionController
{
    public function indexAction()
    {
        $q = $this->objectManager->createQueryBuilder();
        $q->select('g', 'COUNT(u) as users')
            ->from('Registry\Entity\UserGroup', 'g')
            ->leftJoin('Registry\Entity\User', 'u', 'WITH', 'g = u.userGroup AND u.status = 1')
            ->where('g.isDefault != 1')
            ->groupBy('g');
        
        $orderMap = array(
            'name' => 'g.name',
            'users' => 'users',
        );
        
        $sortParams = $this->sortParams($orderMap);
        $q->orderBy($sortParams->by, $sortParams->sort);
        
        $groups = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($q, false)));
        
        return array(
            'groups' => $groups,
        );
    }
    
    public function createAction()
    {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Group');
        
        $url = $this->url()->fromRoute('groups/default', array('action' => 'create'));
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\Response) {
        	return $prg;
        } elseif (is_array($prg)) {
            if (!isset($prg['group']['users'])) {
            	$prg['group']['users'] = array();
            }
            
        	// PROCESAR FORMULARIO
        	$form->setData($prg);
        	if ($form->isValid()) {
        		// Obtener la rendicion creada con FORM
        		$this->objectManager->persist($form->getObject());
        		$this->objectManager->flush();
                
        		$this->fm(_('Grupo guardado'));
        		return $this->redirect()->toRoute('groups', array('action' => 'index'));
        	}
        }
        
        return array(
            'form' => $form,
        );
    }
    
    public function editAction()
    {
        $id = $this->params()->fromQuery('id', 0);
        $group = $this->objectManager->getRepository('Registry\Entity\UserGroup')->findOneBy(array( 'id' => $id, 'isDefault' => 0 ));
        if (!is_object($group)) {
            $this->fm(_('El grupo seleccionado no ha sido encontrado'));
            return $this->redirect()->toRoute('groups');
        }
        
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Group');
        $group->setDefaultGroup($this->objectManager->getReference('Registry\Entity\UserGroup', 1));
        $form->bind($group);
        
        $url = $this->url()->fromRoute('groups/default', array('action' => 'edit'), array('query' => array('id' => $group->getId())));
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\Response) {
        	return $prg;
        } elseif (is_array($prg)) {
            if (!isset($prg['group']['users'])) {
                $prg['group']['users'] = array();
            }
            
        	// PROCESAR FORMULARIO
        	$form->setData($prg);
        	if ($form->isValid()) {
        		// Obtener la rendicion creada con FORM
        		$this->objectManager->persist($group);
        		$this->objectManager->flush();

                // Trigger events
                // TODO Actualizar groups
                $this->getEventManager()->trigger('edit.group', $this, array('group' => $group));
        
        		$this->fm(_('Grupo guardado'));
        		return $this->redirect()->toRoute('groups', array('action' => 'index'));
        	}
        }
        
        return array(
        	'form' => $form,
            'group' => $group,
        );
    }
    
    public function deleteAction()
    {
        $id = $this->params()->fromQuery('id', 0);
        $group = $this->objectManager->getRepository('Registry\Entity\UserGroup')->findOneBy(array( 'id' => $id, 'isDefault' => 0 ));
        if (!is_object($group)) {
        	$this->fm(_('El grupo seleccionado no ha sido encontrado'));
        	return $this->redirect()->toRoute('groups');
        }
        
        if ($group->getUsers()->count()) {
            $this->fm(_('No puede eliminar este grupo por que no esta vacio'), 'error');
            return $this->redirect()->toRoute('groups');
        }
        
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\DeleteConfirm', array('element' => $group->getId()));
         
        $url = $this->url()->fromRoute('groups/default', array('action' => 'delete'), array('query' => array('id' => $group->getId())));
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
        	return $prg;
        } elseif (is_array($prg)) {
        	// Validar formulario de eliminacion
        	$form->setData($prg);
        	if (!$form->isValid()) {
        		$this->fm(_('El grupo no pudo ser eliminado'), 'error');
        		$this->fm($form->getMessages(), 'error');
        		return $this->redirect()->toRoute('groups');
        	}
            
        	$this->objectManager->remove($group);
        	$this->objectManager->flush();
            
        	$this->fm(_('El grupo ha sido eliminado'), 'success');
        
        	return $this->redirect()->toRoute('groups');
        }
        
        return array(
            'form' => $form,
            'group' => $group,
        );
    }
}
