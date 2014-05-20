<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Registry\Entity\Comment;
use Registry\Entity\Registry;

class CommentController extends AbstractActionController
{
    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
    );

    public function commentAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->forward()->dispatch('Registry\Controller\Comment', array('action' => 'comment-ajax'));
        }

        $route = $this->getParentRoute();

        $registry = $this->getRegistry();
        if (!$registry instanceof Registry) {
            return $this->redirect()->toRoute($route);
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Comment');

        $url = $this->url()->fromRoute(
            "$route/default",
            array('action' => 'comment'),
            array('query' => array('id' => $registry->getId()))
        );
        $form->setAttribute('action', $url);
        $prg = $this->prg($url, true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif (is_array($prg)) {
            // Validar formulario de eliminacion
            $form->setData($prg);
            if (!$form->isValid()) {
                $this->fm(_('El comentario no pudo ser publicado'), 'error');

                return $this->redirect()->toRoute(
                    "$route/default",
                    array('action' => 'view'),
                    array('query' => array('id' => $registry->getId()))
                );
            }

            $comment = $form->getObject();
            $this->saveComment($comment, $registry);

            $this->fm(_('El comentario ha sido publicado'), 'success');

            return $this->redirect()->toUrl(
                $this->url()->fromRoute(
                    "$route/default",
                    array('action' => 'view'),
                    array('query' => array('id' => $registry->getId()))
                ) . '#comment-' . $comment->getId()
            );
        }

        return $this->redirect()->toRoute($route);
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

        $comment = $this->getComment();
        if (!$comment instanceof Comment) {
            return $viewModel->setVariables(array(
                'result' => false,
                'err' => 0,
                'msg' => _('El comentario solicitado no pudo ser encontrado')
            ));
        }

        $this->objectManager->remove($comment);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(
            'delete.comment',
            $this,
            array(
                'comment' => $comment,
                'user' => $this->zfcUserAuthentication()->getIdentity()
            )
        );

        return $viewModel->setVariables(array(
            'result' => true,
            'msg' => _('El comentario ha sido eliminado')
        ));
    }

    public function saveComment(Comment $comment, Registry $registry)
    {
        $identity = $this->zfcUserAuthentication()->getIdentity();
        $comment->setAuthor($identity)
                ->setRegistry($registry);

            $this->objectManager->persist($comment);
            $this->objectManager->flush();

            $this->getEventManager()->trigger(
                'create.comment',
                $this,
                array(
                    'registry' => $registry,
                    'comment' => $comment,
                )
            );
    }

    protected function getRegistry()
    {
        $registry = $this->objectManager->find('Registry\Entity\Registry', $this->params()->fromQuery('id', 0));
        if (!is_object($registry) || !$this->registry($registry)->canView()) {
            $this->fm(_('La rendicion solicitada no pudo ser encontrada'), 'error');
            return false;
        }

        if (!$this->registry($registry)->canModerate() && !$this->registry($registry)->canEdit()) {
            $this->fm(_('No tiene acceso a esta seccion'), 'error');
            return false;
        }

        return $registry;
    }

    protected function getComment()
    {
        $comment = $this->objectManager->find('Registry\Entity\Comment', $this->params()->fromPost('comment', 0));
        if (!is_object($comment)
            || ($this->zfcUserAuthentication()->getIdentity() !== $comment->getAuthor()
                && !$this->registry($comment->getRegistry())->canModerate())
        ) {
            return false;
        }

        return $comment;
    }

    protected function getParentRoute()
    {
        $matchedRoute = $this->getEvent()->getRouteMatch()->getMatchedRouteName();
        $route = strpos($matchedRoute, '/comment') ? $matchedRoute : 'home/dummy';
        $route = explode('/', $route);
        $route = $route[0];

        return $route;
    }
}
