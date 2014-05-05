<?php
namespace Registry\Event;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;

class RegistryListener implements ListenerAggregateInterface
{
	use ListenerAggregateTrait;
	
	public function attach(EventManagerInterface $events)
	{
		$ids = array(
			'Registry\Controller\User',
			'Registry\Controller\Registry'
		);
		
		$this->listeners[] = $events->getSharedManager()->attach($ids, 'create.registry', array($this, 'onCreate'), 1);
		$this->listeners[] = $events->getSharedManager()->attach($ids, 'edit.registry',   array($this, 'onEdit'),   1);
		$this->listeners[] = $events->getSharedManager()->attach($ids, 'close.registry',  array($this, 'onClose'),  1);
		$this->listeners[] = $events->getSharedManager()->attach($ids, 'reopen.registry', array($this, 'onReopen'), 1);
	}
	
	public function onCreate()
	{
		
	}
	
	public function onEdit()
	{
		
	}
	
	public function onClose()
	{
		
	}
	
	public function onReopen()
	{
		
	}
}
