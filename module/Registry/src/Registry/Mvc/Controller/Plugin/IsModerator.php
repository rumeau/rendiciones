<?php
namespace Registry\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;

class IsModerator extends AbstractPlugin implements ObjectManagerAwareInterface
{
	use ProvidesObjectManager;
	
	protected $allowedModeratorIds = array();
	
	public function __invoke()
	{
		$auth = $this->getController()->zfcUserAuthentication();
		if (!$auth->hasIdentity()) {
			return false;
		}
		
		$identity = $auth->getIdentity();
		
		$q = $this->getObjectManager()->createQueryBuilder();
		$q->select('ur')
			->from('Registry\Entity\UserRole', 'ur')
			->where('ur.roleId IN (:USER_ROLES)')
			->setParameter('USER_ROLES', $this->allowedModeratorIds);
		
		$userRoles = $identity->getRoles();
		$allowedRoles = $q->getQuery()->getResult();
		
		$result = false;
		foreach ($allowedRoles as $aR) {
			if (!$userRoles->contains($aR)) {
				continue;
			}
			
			$result = true;
			break;
		}
		
		return $result;
	}
	
	public function setAllowedModeratorIds($ids = array())
	{
		$this->allowedModeratorIds = $ids;
	
		return $this;
	}
}
