<?php
namespace Registry\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;

class User extends AbstractHelper implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    protected $allowedModeratorIds = array();

    protected $allowedModeratorRoles = false;

    protected $allowedAdminIds = array();

    protected $allowedAdminRoles = false;

    protected $userRoles;

    public function __invoke()
    {
        return $this;
    }

    public function isModerator()
    {
        return $this->is(1);
    }

    public function isAdmin()
    {
        return $this->is(2);
    }

    public function is($type = 1)
    {
        if ($type === 1) {
            $allowedRoles = $this->getAllowedModeratorRoles();
        } elseif ($type === 2) {
            $allowedRoles = $this->getAllowedAdminRoles();
        } else {
            return false;
        }

        $userRoles = $this->getUserRoles();

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

    public function getAllowedModeratorRoles()
    {
        if (!$this->allowedModeratorRoles) {
            $q = $this->getObjectManager()->createQueryBuilder();
            $q->select('ur')
                ->from('Registry\Entity\UserRole', 'ur')
                ->where('ur.roleId IN (:USER_ROLES)')
                ->setParameter('USER_ROLES', $this->allowedModeratorIds);

            $this->allowedModeratorRoles = $q->getQuery()->getResult();
        }

        return $this->allowedModeratorRoles;
    }

    public function setAllowedAdminIds($ids = array())
    {
        $this->allowedAdminIds = $ids;

        return $this;
    }

    public function getAllowedAdminRoles()
    {
        if (!$this->allowedAdminRoles) {
            $q = $this->getObjectManager()->createQueryBuilder();
            $q->select('ur')
                ->from('Registry\Entity\UserRole', 'ur')
                ->where('ur.roleId IN (:USER_ROLES)')
                ->setParameter('USER_ROLES', $this->allowedAdminIds);

            $this->allowedAdminRoles = $q->getQuery()->getResult();
        }

        return $this->allowedAdminRoles;
    }

    public function getUserRoles()
    {
        if (!$this->userRoles) {
            $identity = $this->getView()->plugin('zfcUserIdentity');
            $this->userRoles = $identity()->getRoles();
        }

        return $this->userRoles;
    }
}
