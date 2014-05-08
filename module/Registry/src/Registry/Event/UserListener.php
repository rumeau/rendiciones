<?php
namespace Registry\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;

class UserListener implements ListenerAggregateInterface
{
	use ListenerAggregateTrait;
	
	public function attach(EventManagerInterface $events)
	{
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\UserController', 'create.user', array($this, 'onCreate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\UserController', 'edit.user',   array($this, 'onEdit'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\UserController', 'deactivate.user', array($this, 'onDeactivate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\UserController', 'activate.user', array($this, 'onActivate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\UserController', 'delete.user', array($this, 'onDelete'), 1);
	}
	
	public function onCreate(Event $e)
	{
		// TODO Hacer algo
	}
	
	public function onEdit(Event $e)
	{
		// TODO Hacer algo
	}
	
	public function onDeactivate(Event $e)
	{
		// TODO Notificar al usuario acerca de su desactivacion
	}
	
	public function onActivate(Event $e)
	{
		// TODO Notificar al usuario acerca de su reactivacion
	}
	
	public function onDelete(Event $e)
	{
		// TODO Hacer algo?
	}
}
