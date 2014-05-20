<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator as ZendPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Registry\Entity\Registry;
use Registry\Entity\Item;
use Zend\View\Model\ViewModel;

class ReviewController extends AbstractActionController
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
        $query = $this->objectManager->createQueryBuilder();
        $query->select('r as registry', 'SUM(i.itemTotal) as total', 'u.name as user')
            ->from('Registry\Entity\Registry', 'r')
            ->leftJoin('Registry\Entity\Item', 'i', 'WITH', 'i.registry = r')
            ->join('Registry\Entity\User', 'u', 'WITH', 'r.user = u')
            ->andWhere('r.status IN (:STATUSES)')
            ->groupBy('r')
            ->setParameter('STATUSES', array(
                Registry::REGISTRY_STATUS_PENDING,
                Registry::REGISTRY_STATUS_APPROVED,
                Registry::REGISTRY_STATUS_REJECTED
            ));

        if (!$this->user()->isAdmin()) {
            $query->join('Registry\Entity\User', 'm', 'WITH', 'm = :USER AND u.userGroup MEMBER OF m.moderatedGroups')
                ->setParameter('USER', $this->zfcUserAuthentication()->getIdentity());

        }

        $search = $this->params()->fromQuery('q', '');
        $search = preg_replace('/\.|\,|\-/', '', $search);
        if (!empty($search)) {
            $query->andWhere($query->expr()->orX('u.identity LIKE :SEARCH', 'u.name LIKE :SEARCH'))
                ->setParameter('SEARCH', "%$search%");
        }

        $status = $this->params()->fromQuery('filter', -1);
        if ($status >= 0) {
            $query->andWhere('r.status = :STATUS')
                ->setParameter('STATUS', $status);
        }

        $orderMap = array(
            'number' => 'r.number',
            'date' => 'r.createdDate',
            'status' => 'r.status',
            'total' => 'total',
            'user' => 'user',
        );

        $sortParams = $this->sortParams($orderMap);
        $query->orderBy($sortParams->by, $sortParams->sort);
        if ($sortParams->by == 'r.status') {
            $query->orderBy('r.number', 'desc');
        }

        $registries = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($query, false)));

        return array(
            'registries' => $registries,
            'filter' => (int) $status,
            'q' => $search
        );
    }

    /**
     * Visualizar una rendicion para revisarla o reabrirla
     *
     * @return \Zend\Http\Response|array
     */
    public function viewAction()
    {
        // Procesar cambio de estados
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->forward()->dispatch('Registry\Controller\Review', array('action' => 'view-ajax'));
        }

        $registry = $this->getRegistry();
        if (!$registry) {
            $this->fm(_('La rendicion solicitada no pudo ser encontrada'), 'error');
            return $this->redirect()->toRoute('review', array('action' => 'index'));
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Confirm', array('element' => $registry->getId()));

        $url = $this->url()->fromRoute('review/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
        $prg = $this->prg($url, true);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif (is_array($prg)) {
            // Validar formulario
            $form->setData($prg);
            if (!$form->isValid()) {
                $this->fm(_('No se ha podido cerrar la rendicion'), 'error');
                $helper = $this->getServiceLocator()->get('viewhelpermanager')->get('htmlList');
                $this->fm($helper($form->getMessages()), 'error');

                return $this->redirect()->toRoute('review');
            }

            if ($prg['task'] === 'reopen') {
                return $this->reopen($registry);
            } else {
                return $this->close($registry);
            }
        }

        $commentsForm = $formManager->get('Registry\Form\Comment');
        $commentsForm->setAttribute(
            'action',
            $this->url()->fromRoute(
                'review/comment',
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

    public function viewAjaxAction()
    {
        $viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
        $viewModel->setTerminal(true);

        if (!$this->getRequest()->isPost()) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('Llamada invalida')
            ));
        }

        $registry = $this->getRegistry();
        if (!$registry) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('La rendicion solicitada no pudo ser encontrada')
            ));
        }

        $itemId = $this->params()->fromPost('item', 0);
        $value  = $this->params()->fromPost('value', 0);
        $item   = $registry->getItems()->filter(function ($i) use ($itemId) {
            if ($i->getId() === (int) $itemId) {
                return true;
            }

            return false;
        })->current();

        if (!is_object($item) || !$item instanceof Item) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => -1,
                'msg' => _('El item solicitado no pudo ser encontrado')
            ));
        }

        $oldStatus = $item->getStatus();
        $item->setStatus((int) $value)
            ->setModifiedBy($this->zfcUserAuthentication()->getIdentity());

        $this->objectManager->persist($item);
        $this->objectManager->flush();

        return $viewModel->setVariables(array(
            'result' => true,
            'value' => $item->getStatus(),
            'oldValue' => $oldStatus,
            'msg' => _('El estado del item ha sido modificado')
        ));
    }

    public function close($registry)
    {
        if (!$this->registry($registry)->canClose()) {
            $this->fm(_('No se puede cerrar esta rendicion'), 'error');

            return $this->redirect()->toRoute('review/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
        }

        // Revisar una rendicion
        $rejected = false;
        $approvedPartial = false;
        $items = $registry->getItems();
        $itemsTotal = $items->count();
        $itemsApproved = $items->filter(function ($i) {
            if ($i->getStatus() === 1) {
                return true;
            }

            return false;
        });
        if ($itemsApproved->count() === 0) {
            $rejected = true;
        } elseif ($itemsTotal > $itemsApproved->count()) {
            $approvedPartial = true;
        }

        $registry->setStatus($rejected ? Registry::REGISTRY_STATUS_REJECTED : Registry::REGISTRY_STATUS_APPROVED);
        $registry->setModifiedBy($this->zfcUserAuthentication()->getIdentity());

        $this->getEventManager()->trigger('close.registry', $this, array('registry' => $registry));

        $this->objectManager->persist($registry);
        $this->objectManager->flush();

        $this->fm(_('La rendicion ha sido revisada y cerrada'), 'success');

        return $this->redirect()->toRoute('review');
    }

    public function reopen($registry)
    {
        if (!$this->registry($registry)->canReopen()) {
            $this->fm(_('No se puede abrir esta rendicion'), 'error');

            return $this->redirect()->toRoute('review/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
        }

        $registry->setStatus(Registry::REGISTRY_STATUS_PENDING);
        $registry->setModifiedBy($this->zfcUserAuthentication()->getIdentity());

        $this->getEventManager()->trigger('reopen.registry', $this, array('registry' => $registry));

        $this->objectManager->persist($registry);
        $this->objectManager->flush();

        $this->fm(_('Se ha vuelto a abrir la rendicion'), 'success');

        return $this->redirect()->toRoute('review/default', array('action' => 'view'), array('query' => array('id' => $registry->getId())));
    }

    protected function getRegistry()
    {
        $rid = $this->params()->fromQuery('id', 0);

        $registry = $this->objectManager->find('Registry\Entity\Registry', $rid);

        if (!is_object($registry) || !$this->registry($registry)->canModerate()) {
            return false;
        }

        return $registry;
    }
}
