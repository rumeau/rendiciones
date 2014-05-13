<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Registry\Entity\Comment;

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
            return $this->forward()->dispatch('Registry\Controller\Index', array('action' => 'comment-ajax'));
        }

        $registry = $this->objectManager->find('Registry\Entity\Registry', $this->params()->fromQuery('id', 0));
        if (!is_object($registry) || !$this->registry($registry)->canView()) {
            $this->fm(_('La rendicion solicitada no pudo ser encontrada'), 'error');
            return $this->redirect()->toRoute('registry', array('action' => 'index'));
        }

        $source = $this->params()->fromQuery('source', 'registry');
        if (!$this->registry($registry)->canModerate() && !$this->registry($registry)->canEdit()) {
            $this->fm(_('No tiene acceso a esta seccion'), 'error');
            return $this->redirect()->toRoute($source);
        }

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Registry\Form\Comment');

        $url = $this->url()->fromRoute(
            $source . '/default',
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
                    $source . '/default',
                    array('action' => 'view'),
                    array('query' => array('id' => $registry->getId()))
                );
            }

            $comment = $form->getObject();
            $comment->setAuthor($this->zfcUserAuthentication()->getIdentity())
                ->setRegistry($registry);

            $this->objectManager->persist($comment);
            $this->objectManager->flush();

            $this->fm(_('El comentario ha sido publicado'), 'success');

            return $this->redirect()->toUrl(
                $this->url()->fromRoute(
                    $source . '/default',
                    array('action' => 'view'),
                    array('query' => array('id' => $registry->getId()))
                ) . '#comment-' . $comment->getId()
            );
        }
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

        $comment = $this->objectManager->find('Registry\Entity\Comment', $this->params()->fromPost('comment', 0));
        if (!is_object($comment)
            || ($this->zfcUserAuthentication()->getIdentity() !== $comment->getAuthor()
                && !$this->registry($comment->getRegistry())->canModerate())
        ) {
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
}
