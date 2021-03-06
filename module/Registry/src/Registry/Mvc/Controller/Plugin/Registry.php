<?php
namespace Registry\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Registry\Entity\Registry as RegistryEntity;

class Registry extends AbstractPlugin
{
    protected $registry;

    protected $identity;

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
        $isAdmin = $this->getController()->user()->isAdmin();
        if ($isAdmin) {
            if ($this->getRegistry()->getStatus() >= RegistryEntity::REGISTRY_STATUS_PENDING
                && $this->getRegistry()->getStatus() <= RegistryEntity::REGISTRY_STATUS_REJECTED
            ) {
                return true;
            }
        }

        $isModerator = $this->getController()->user()->isModerator();

        if (!$isModerator) {
            return false;
        }

        $identity = $this->getController()->zfcUserAuthentication()->getIdentity();
        $moderatedGroups = $identity->getModeratedGroups();
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
        $isAdmin = $this->getController()->user()->isAdmin();
        $isModerator = $this->getController()->user()->isModerator();
        if (($isModerator || $isAdmin) && $this->getRegistry()->getStatus() > RegistryEntity::REGISTRY_STATUS_DRAFT) {
            return true;
        } elseif ($this->getRegistry()->getUser() === $this->getIdentity()) {
            return true;
        }

        return false;
    }

    public function canClose()
    {
        $isModerator = $this->getController()->user()->isModerator();
        if ($isModerator && $this->getRegistry()->getStatus() === RegistryEntity::REGISTRY_STATUS_PENDING) {
            return true;
        }

        return false;
    }

    public function canReopen()
    {
        $isModerator = $this->getController()->user()->isModerator();
        if ($isModerator
            && $this->getRegistry()->getStatus() > RegistryEntity::REGISTRY_STATUS_PENDING
            && $this->getRegistry()->getStatus() <= RegistryEntity::REGISTRY_STATUS_REJECTED
        ) {
            return true;
        }

        return false;
    }

    /**
     *
     * @throws \Exception
     * @return RegistryEntity
     */
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
            $auth = $this->getController()->zfcUserAuthentication();
            if ($auth->hasIdentity()) {
                $this->identity = $auth->getIdentity();
            }
        }

        return $this->identity;
    }
}
