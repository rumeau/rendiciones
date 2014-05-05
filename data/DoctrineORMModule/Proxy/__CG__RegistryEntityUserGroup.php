<?php

namespace DoctrineORMModule\Proxy\__CG__\Registry\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class UserGroup extends \Registry\Entity\UserGroup implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'name', 'description', 'status', 'isDefault', 'users', 'moderators');
        }

        return array('__isInitialized__', 'id', 'name', 'description', 'status', 'isDefault', 'users', 'moderators');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (UserGroup $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsDefault($isDefault)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsDefault', array($isDefault));

        return parent::setIsDefault($isDefault);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsDefault()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsDefault', array());

        return parent::getIsDefault();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsers', array());

        return parent::getUsers();
    }

    /**
     * {@inheritDoc}
     */
    public function addUsers(\Doctrine\Common\Collections\Collection $users)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addUsers', array($users));

        return parent::addUsers($users);
    }

    /**
     * {@inheritDoc}
     */
    public function addUser(\Registry\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addUser', array($user));

        return parent::addUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function removeUsers(\Doctrine\Common\Collections\Collection $users)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeUsers', array($users));

        return parent::removeUsers($users);
    }

    /**
     * {@inheritDoc}
     */
    public function removeUser(\Registry\Entity\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeUser', array($user));

        return parent::removeUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getModerators()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModerators', array());

        return parent::getModerators();
    }

    /**
     * {@inheritDoc}
     */
    public function addModerators(\Doctrine\Common\Collections\Collection $moderators)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addModerators', array($moderators));

        return parent::addModerators($moderators);
    }

    /**
     * {@inheritDoc}
     */
    public function addModerator(\Registry\Entity\User $moderator)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addModerator', array($moderator));

        return parent::addModerator($moderator);
    }

    /**
     * {@inheritDoc}
     */
    public function removeModerators(\Doctrine\Common\Collections\Collection $moderators)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeModerators', array($moderators));

        return parent::removeModerators($moderators);
    }

    /**
     * {@inheritDoc}
     */
    public function removeModerator(\Registry\Entity\User $moderator)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeModerator', array($moderator));

        return parent::removeModerator($moderator);
    }

}
