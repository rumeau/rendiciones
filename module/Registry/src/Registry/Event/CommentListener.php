<?php
namespace Registry\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\Mail\AddressList;
use Zend\View\Model\ViewModel;

class CommentListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    protected $serviceLocator;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->getSharedManager()->attach(
            'Registry\Controller\CommentController',
            'create.comment',
            array($this, 'onCreate'),
            1
        );

        $this->listeners[] = $events->getSharedManager()->attach(
            'Registry\Controller\CommentController',
            'delete.comment',
            array($this, 'onDelete'),
            1
        );
    }

    public function onCreate(Event $event)
    {
        $controller = $event->getTarget();
        $this->serviceLocator = $controller->getServiceLocator();

        $message = new \SlmMail\Mail\Message\Mandrill();
        $message->setTemplate('rendiciones_create_comment_others');
        $message->setSubject('Sistema de Rendiciones - Nuevo comentario publicado');
        $message->setOptions(array('track_clicks' => true));

        $transport = $this->serviceLocator->get('SlmMail\Mail\Transport\MandrillTransport');
        
        $comment = $event->getParam('comment');
        $registry = $event->getParam('registry');

        $owner = $registry->getUser();
        $author = $comment->getAuthor();

        $message->setGlobalVariables(array(
            'AUTHORNAME' => $author->getDisplayName(),
            'REGISTRYNUMBER' => str_pad($registry->getNumber(), 10, '0', STR_PAD_LEFT),
            'COMMENTCONTENT' => $comment->getComment()
        ));

        if ($author === $owner) {
            $urlRoute = 'review/default';
            $url = $controller->url()->fromRoute(
                $urlRoute,
                array('action' => 'view'),
                array('query' => array('id' => $registry->getId()), 'force_canonical' => true)
            );
            $url .= '#comment-' . $comment->getId();
            $moderators = $comment->getAuthor()->getUserGroup()->getModerators();

            foreach ($moderators as $moderator) {
                if ($author === $moderator) {
                    continue;
                }
                $message->addTo($moderator->getEmail(), $moderator->getDisplayName());
                $message->setVariables($moderator->getEmail(), array(
                    'USERNAME' => $moderator->getDisplayName(),
                    'URL' => $url
                ));
            }
        } else {
            $urlRoute = 'registry/default';
            $url = $controller->url()->fromRoute(
                $urlRoute,
                array('action' => 'view'),
                array('query' => array('id' => $registry->getId()), 'force_canonical' => true)
            );
            $url .= '#comment-' . $comment->getId();

            $message->addTo($owner->getEmail(), $owner->getDisplayName());
            $message->setVariables($owner->getEmail(), array(
                'USERNAME' => $owner->getDisplayName(),
                'URL' => $url
            ));
        }

        //try {
            // This sends the email. Pretty simple.
            $transport->send($message);
        //} catch (\Exception $e) {
        //    $controller->fm(_('No se ha podido enviar la notificacion. ' . $e->getMessage()), 'error');
        //}
    }

    public function onDelete(Event $event)
    {

    }
}
