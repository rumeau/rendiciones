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
use Registry\Entity\File;
use Registry\File\FileInfo;

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
        $queryRegistry = $this->objectManager->createQueryBuilder();
        $queryRegistry->select('r as registry', 'SUM(i.itemTotal) as total')
            ->from('Registry\Entity\Registry', 'r')
            ->leftJoin('Registry\Entity\Item', 'i', 'WITH', 'i.registry = r')
            ->where('r.user = :USER')
            ->groupBy('r')
            ->setParameter('USER', $this->zfcUserAuthentication()->getIdentity());

        $status = $this->params()->fromQuery('filter', -1);
        if ($status >= 0) {
            $queryRegistry->andWhere('r.status = :STATUS')
                ->setParameter('STATUS', $status);
        }

        $orderMap = array(
            'number' => 'r.number',
            'date' => 'r.createdDate',
            'status' => 'r.status',
            'total' => 'total'
        );

        $sortParams = $this->sortParams($orderMap);
        $queryRegistry->orderBy($sortParams->by, $sortParams->sort);
        if ($sortParams->by == 'r.status') {
            $queryRegistry->orderBy('r.number', 'desc');
        }

        $registries = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($queryRegistry, false)));
        $registries->setCurrentPageNumber($this->params()->fromQuery('p', 1))
            ->setItemCountPerPage(20);

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
        $rid = $this->params()->fromQuery('id', 0);
        $registry = $this->objectManager->find('Registry\Entity\Registry', $rid);
        if (!is_object($registry) || !$this->registry($registry)->canView()) {
            $this->fm(_('La rendicion solicitada no pudo ser encontrada'), 'error');

            return $this->redirect()->toRoute('registry', array('action' => 'index'));
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Confirm', array('element' => $registry->getId()));

        if ($this->registry($registry)->canEdit()) {
            $prg = $this->prg(
                $this->url()->fromRoute(
                    'registry/default',
                    array('action' => 'view'),
                    array('query' => array('id' => $registry->getId()))
                ),
                true
            );

            if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
                return $prg;
            } elseif (is_array($prg)) {
                // Validar formulario de eliminacion
                $form->setData($prg);
                if (!$form->isValid()) {
                    $this->fm(_('La rendicion no pudo ser confirmada'), 'error');
                    return $this->redirect()->toRoute('registry');
                }

                // Confirmar una rendicion
                $modelManager = $this->getServiceLocator()->get('ModelManager');
                $model = $modelManager->get('Registry\Model\Registry');
                $model->doSave($registry, $form, $this, true);

                $this->fm(_('La rendicion ha sido confirmada, un moderador se encargara de revisarla'), 'success');

                return $this->redirect()->toRoute('registry');
            }
        }

        $commentsForm = $formManager->get('Registry\Form\Comment');
        $commentsForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'registry/comment',
                array('action' => 'comment'),
                array('query' => array('id' => $registry->getId()))
            )
        );

        return array(
            'form' => $form,
            'registry' => $registry,
            'commentform' => $commentsForm,
        );
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
            if ($form->isValid()) {
                // PROCESAR FORMULARIO
                // Obtener la rendicion creada con FORM
                $registry = $form->getObject();

                $this->uploadFiles($form);
                $modelManager = $this->getServiceLocator()->get('ModelManager');
                $model = $modelManager->get('Registry\Model\Registry');
                return $model->doSave($registry, $form, $this);
            }

            // Form not valid, but file uploads might be valid
            if (!isset($prg['registry']['items'])) {
                $error = _('Debe agregar al menos un item');
            }
            $tempFiles = $this->persistFiles($form);
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
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->forward()->dispatch('Registry\Controller\Index', array('action' => 'edit-ajax'));
        }

        $registry = $this->objectManager->find('Registry\Entity\Registry', $this->params()->fromQuery('id', 0));
        if (!is_object($registry) || $registry->getUser() !== $this->zfcUserAuthentication()->getIdentity()) {
            $this->fm(_('La rendicion seleccionada no ha sido encontrada'), 'error');
            return $this->redirect()->toRoute('registry', array('action' => 'index'));
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Registry');
        $form->bind($registry);

        $error = false;
        $tempFiles = null;

        $prg = $this->fileprg(
            $form,
            $this->url()->fromRoute(
                'registry/default',
                array('action' => 'edit'),
                array('query' => array('id' => $registry->getId()))
            ),
            true
        );

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif (is_array($prg)) {
            if ($form->isValid()) {
                // Obtener la rendicion creada con FORM
                $this->uploadFiles($form, $registry);
                $modelManager = $this->getServiceLocator()->get('ModelManager');
                $model = $modelManager->get('Registry\Model\Registry');
                return $model->doSave($registry, $form, $this);
            }

            // Form not valid, but file uploads might be valid
            if (!isset($prg['registry']['items'])) {
                $error = _('Debe agregar al menos un item');
            }
            $tempFiles = $this->persistFiles($form);
        }

        return array(
            'form' => $form,
            'id' => $registry->getId(),
            'error' => $error,
            'tempFiles' => $tempFiles,
        );
    }

    public function editAjaxAction()
    {
        $viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);

        if (!$this->getRequest()->isPost()) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('Llamada invalida')
            ));
        }

        $registry = $this->objectManager->find('Registry\Entity\Registry', $this->params()->fromPost('rid', 0));
        if (!is_object($registry) || !$this->registry($registry)->canEdit()) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('El registro no pudo ser encontrado')
            ));
        }

        $image = $this->objectManager->find('Registry\Entity\File', $this->params()->fromPost('fid', 0));
        if (!is_object($image) || $image->getRegistry() !== $registry) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('La imagen no pudo ser encontrada')
            ));
        }

        $this->objectManager->remove($image);
        $this->objectManager->flush();

        return $viewModel->setVariables(array(
            'result' => true,
            'msg' => _('La imagen ha sido eliminada')
        ));
    }

    public function deleteAction()
    {
        $registry = $this->objectManager->find('Registry\Entity\Registry', $this->params()->fromQuery('id', 0));
        $allowedToDelete = array(Registry::REGISTRY_STATUS_DRAFT);
        if (!is_object($registry)
            || $registry->getUser() !== $this->zfcUserAuthentication()->getIdentity()
            || !in_array($registry->getStatus(), $allowedToDelete)
        ) {
            $this->fm(_('La rendicion seleccionada no ha sido encontrada'), 'error');
            return $this->redirect()->toRoute('registry', array('action' => 'index'));
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\DeleteConfirm', array('element' => $registry->getId()));

        $prg = $this->prg(
            $this->url()->fromRoute(
                'registry/default',
                array('action' => 'delete'),
                array('query' => array('id' => $registry->getId()))
            ),
            true
        );

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

    protected function uploadFiles($form, Registry $registry = null)
    {
        if ($registry === null) {
            $registry = $form->getObject();
        }

        $uploadable = $this->getServiceLocator()->get('Gedmo\Uploadable');
        $items = $form->get('registry')->get('items');
        foreach ($items->getIterator() as $item) {
            $theFiles = $item->get('thefiles')->getValue();
            if (is_array($theFiles) && count($theFiles) > 0) {
                foreach ($theFiles as $fileInfo) {
                    $file = new File();
                    $file->setItem($item->getObject());
                    $file->setRegistry($form->getObject());

                    $uploadable->addEntityFileInfo($file, new FileInfo($fileInfo));
                    $this->objectManager->persist($file);
                }
            }
        }
    }

    protected function persistFiles($form)
    {
        $tempFiles = null;
        $items = $form->get('registry')->get('items');
        $count = 0;
        foreach ($items->getIterator() as $item) {
            $fileErrors = $item->get('thefiles')->getMessages();
            if (empty($fileErrors)) {
                $tempFiles[$count] = $item->get('thefiles')->getValue();
            }
            $count++;
        }

        return $tempFiles;
    }

    protected function validateItems($prg)
    {
        if (!isset($prg['registry']['items']) || !count($prg['registry']['items'])) {
            return _('Debe agregar al menos un item a su rendicion');
        }

        return false;
    }
}
