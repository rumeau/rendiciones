<?php
namespace Registry\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;

class UserListener implements ListenerAggregateInterface
{
	use ListenerAggregateTrait;
	
	public function attach(EventManagerInterface $events)
	{
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\User', 'create.user', array($this, 'onCreate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\User', 'edit.user',   array($this, 'onEdit'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\User', 'deactivate.user', array($this, 'onDeactivate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\User', 'activate.user', array($this, 'onActivate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach('Registry\Controller\User', 'delete.user', array($this, 'onDelete'), 1);
	}
	
	public function onCreate(MvcEvent $e)
	{
		
	}
	
	public function onEdit(MvcEvent $e)
	{
		
	}
	
	public function onDeactivate(MvcEvent $e)
	{
		
	}
	
	public function onActivate(MvcEvent $e)
	{
	
	}
	
	public function onDelete(MvcEvent $e)
	{
	
	}
}
