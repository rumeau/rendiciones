<?php
namespace Registry\Model;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;

class Model implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;
}
