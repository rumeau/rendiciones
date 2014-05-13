<?php
namespace Registry\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;

class RegistryListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $ids = array(
            'Registry\Controller\UserController',
            'Registry\Controller\RegistryController'
        );

        $this->listeners[] = $events->getSharedManager()->attach($ids, 'create.registry', array($this, 'onCreate'), 1);
        $this->listeners[] = $events->getSharedManager()->attach($ids, 'edit.registry',   array($this, 'onEdit'),   1);
        $this->listeners[] = $events->getSharedManager()->attach($ids, 'close.registry',  array($this, 'onClose'),  1);
        $this->listeners[] = $events->getSharedManager()->attach($ids, 'reopen.registry', array($this, 'onReopen'), 1);
    }

    public function onCreate(Event $e)
    {

    }

    public function onEdit(Event $e)
    {

    }

    public function onClose(Event $e)
    {

    }

    public function onReopen(Event $e)
    {

    }
}
