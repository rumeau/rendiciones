<?php
namespace Registry\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;

class CountPendingRegistries extends AbstractHelper Implements ObjectManagerAwareInterface
{
	use ProvidesObjectManager;
	
	public function __invoke()
	{
		$q = $this->objectManager->createQueryBuilder();
		$q->select('COUNT(r) as registries')
			->from('Registry\Entity\Registry', 'r')
			->where('r.status = :PENDING_STATUS')
			->setParameter('PENDING_STATUS', \Registry\Entity\Registry::REGISTRY_STATUS_PENDING);
		
		$count = $q->getQuery()->getSingleScalarResult();
		
		return $count;
	}
}
