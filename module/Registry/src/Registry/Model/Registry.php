<?php
namespace Registry\Model;

use Registry\Entity\Registry as RegistryEntity;

class Registry extends Model
{
    public function updateNumber($registry)
    {
        $query = $this->getObjectManager()->createQueryBuilder();
        $query->select('MAX(r.number) + 1')
            ->from('Registry\Entity\Registry', 'r')
            ->where('r.user = :USER')
            ->andWhere('r.status != 0')
            ->setParameter('USER', $registry->getUser());

        $nextVal = $query->getQuery()->getSingleScalarResult();
        $registry->setNumber($nextVal !== null ? $nextVal : 1);
    }

    public function doSave($registry, $form, $controller, $confirm = false)
    {
        // establecer Usuario y Estado
        $registry->setUser($controller->zfcUserAuthentication()->getIdentity());
        $registry->setStatus(RegistryEntity::REGISTRY_STATUS_DRAFT);

        // Disparar eventos
        $event = $confirm ? 'confirm' : 'create';
        $controller->getEventManager()->trigger($event . '.registry', $controller, array('registry' => $registry));

        if ($confirm === true) {
            $toConfirm = false;
            $this->updateNumber($registry);
            $registry->setCreatedDate(new \DateTime('NOW'));
            $registry->setStatus(RegistryEntity::REGISTRY_STATUS_PENDING);
        } else {
            $task = $form->get('registry')->get('task')->getValue();
            $toConfirm = $task == 'save' ? true : null;
        }

        // Guardar datos
        $this->getObjectManager()->persist($registry);
        $this->getObjectManager()->flush();

        if ($toConfirm === true) {
            return $controller->redirect()->toRoute(
                'registry/default',
                array('action' => 'view'),
                array('query' => array('id' => $registry->getId()))
            );
        }

        $controller->fm(_('Rendicion guardada'));
        return $controller->redirect()->toRoute('registry', array('action' => 'index'));
    }
}
