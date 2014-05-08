<?php

namespace RegistryTest\Mapper;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class UserTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    protected $mapper;

    public function setUp()
    {
        $dir = __DIR__;
        $config = 'config/application.config.php';
        $this->setApplicationConfig(
            include $config
        );
        parent::setUp();

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $this->mapper = new \Registry\Mapper\User($objectManager, $serviceManager->get('zfcuser_module_options'));
    }

    public function testFindByEmail()
    {
        $res = $this->mapper->findByEmail('rumeau@gmail.com');
        $this->assertInstanceOf('Registry\Entity\User', $res);
    }

    public function testFindByUsername()
    {
        $res = $this->mapper->findByUsername('156480126');
        $this->assertInstanceOf('Registry\Entity\User', $res);
    }

    public function testFindById()
    {
        $res = $this->mapper->findById('1');
        $this->assertInstanceOf('Registry\Entity\User', $res);
    }

    public function testInsert()
    {
        $res = $this->mapper->findById('1');
        $name = $res->getName();
        $res->setName('Test');
        $newRes = $this->mapper->insert($res);

        $this->assertEquals('Test', $newRes->getName());
    }

    public function testUpdate()
    {
        $res = $this->mapper->findById('1');
        $res->setName('Jean Rumeau');
        $newRes = $this->mapper->update($res);

        $this->assertEquals('Jean Rumeau', $newRes->getName());
    }
}
