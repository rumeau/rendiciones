<?php
namespace Registry\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Registry\Entity\Registry as RegistryEntity;

class Registry extends AbstractHelper
{
    protected $registry;

    protected $identity;

    public function __construct()
    {
        return $this;
    }

    public function __invoke($registry = null)
    {
        if ($registry !== null) {
            $this->registry = $registry;
        }

        return $this;
    }

    /**
     * Verifica permiso de un moderador para cerrar una rendicion
     *
     * @throws \Exception
     * @return boolean
     */
    public function canModerate()
    {
        $user = $this->getView()->plugin('user');
        if ($user->isAdmin()) {
            if ($this->getRegistry()->getStatus() >= RegistryEntity::REGISTRY_STATUS_PENDING
                && $this->getRegistry()->getStatus() <= RegistryEntity::REGISTRY_STATUS_REJECTED
            ) {
                return true;
            }
        }

        if (!$user->isModerator()) {
            return false;
        }

        $identity = $this->getView()->plugin('zfcuseridentity');
        $moderatedGroups = $identity()->getModeratedGroups();
        $author = $this->getRegistry()->getUser();

        if (!$moderatedGroups->contains($author->getUserGroup())) {
            return false;
        }

        if ($this->getRegistry()->getStatus() >= RegistryEntity::REGISTRY_STATUS_PENDING
            && $this->getRegistry()->getStatus() <= RegistryEntity::REGISTRY_STATUS_REJECTED
        ) {
            return true;
        }

        return false;
    }

    /**
     * Valida permiso de un usuario para descartar su rendicion
     *
     * @throws \Exception
     * @return boolean
     */
    public function canDiscard()
    {
        if ($this->getRegistry()->getUser() === $this->getIdentity() && $this->getRegistry()->getStatus() === RegistryEntity::REGISTRY_STATUS_DRAFT) {
            return true;
        }

        return false;
    }

    /**
     * Valida permiso de un usuario para editar su rendicion (borrador)
     *
     * @throws \Exception
     * @return boolean
     */
    public function canEdit()
    {
        if ($this->getRegistry()->getUser() === $this->getIdentity() && $this->getRegistry()->getStatus() === RegistryEntity::REGISTRY_STATUS_DRAFT) {
            return true;
        }

        return false;
    }

    /**
     * Valida permiso de un moderador o usuario a ver su solicitud para revisar o confirmar respectivamente
     *
     * @throws \Exception
     * @return boolean
     */
    public function canView()
    {
        $isModerator = $this->getView()->plugin('user');
        if ($isModerator->isModerator() && $this->getRegistry()->getStatus() === RegistryEntity::REGISTRY_STATUS_PENDING) {
            return true;
        } elseif ($this->getRegistry()->getUser() === $this->getIdentity() && $this->getRegistry()->getStatus() !== RegistryEntity::REGISTRY_STATUS_DRAFT) {
            return true;
        }

        return false;
    }

    public function canClose()
    {
        $isModerator = $this->getView()->plugin('user');
        if ($isModerator->isModerator() && $this->getRegistry()->getStatus() === RegistryEntity::REGISTRY_STATUS_PENDING) {
            return true;
        }

        return false;
    }

    public function canReopen()
    {
        $isModerator = $this->getView()->plugin('user');
        if ($isModerator->isModerator()
            && $this->getRegistry()->getStatus() > RegistryEntity::REGISTRY_STATUS_PENDING
            && $this->getRegistry()->getStatus() <= RegistryEntity::REGISTRY_STATUS_REJECTED
        ) {
            return true;
        }

        return false;
    }

    protected function getRegistry()
    {
        if ($this->registry === null || !$this->registry instanceof RegistryEntity) {
            throw new \Exception('A valid registry must be provided');
        }

        return $this->registry;
    }

    protected function getIdentity()
    {
        if (!$this->identity) {
            $identity = $this->getView()->plugin('zfcUserIdentity');
            $this->identity = $identity();
        }

        return $this->identity;
    }
}
