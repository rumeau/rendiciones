<?php
namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Group
 *
 * @ORM\Table(name="usergroup")
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class UserGroup
{

    /**
     *
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var string
     * 
     * @ORM\Column(name="`name`", type="string", length=40, nullable=false)
     */
    private $name;

    /**
     *
     * @var string
     * 
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="`status`", type="integer", length=1)
     */
    private $status = 1;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="is_default", type="integer", length=1)
     */
    private $isDefault = 0;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Registry\Entity\User", mappedBy="userGroup", cascade={"ALL"})
     */
    private $users;
    
    /**
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Registry\Entity\User", mappedBy="moderatedGroups")
     */
    private $moderators;

    private $defaultGroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moderators = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setDefaultGroup(UserGroup $defaultGroup)
    {
        $this->defaultGroup = $defaultGroup;

        return $this;
    }

    public function getDefaultGroup()
    {
        if (!$this->defaultGroup) {
            throw new \InvalidArgumentException('No default group have been set');
        }

        return $this->defaultGroup;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     * 
     * @param string
     * @return Group
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get description
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     * 
     * @param string
     * @return Group
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }

    /**
     * Get status
     * 
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     * 
     * @param integer
     * @return Group            
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }
    
    /**
     * Set isDefault
     * 
     * @param integer
     * @return Group
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        
        return $this;
    }
    
    /**
     * Get isDefault
     * 
     * @return integer
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add users
     * 
     * @param \Doctrine\Common\Collections\Collection
     * @return Group
     */
    public function addUsers(\Doctrine\Common\Collections\Collection $users)
    {
        foreach ($users as $user) {
            $this->addUser($user);
        }
        
        return $this;
    }
    
    public function addUser(User $user)
    {
        $user->setUserGroup($this);
        $this->users[] = $user;
        
        return $this;
    }
    
    public function removeUsers(\Doctrine\Common\Collections\Collection $users)
    {
        foreach ($users as $user) {
            $this->removeUser($user);
        }
        
        return $this;
    }
    
    public function removeUser(User $user)
    {
        $user->setUserGroup($this->getDefaultGroup());
        $this->users->removeElement($user);
    }
    
    /**
     * Get moderators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModerators()
    {
    	return $this->moderators;
    }
    
    /**
     * Add moderators
     *
     * @param \Doctrine\Common\Collections\Collection
     * @return UserGroup
     */
    public function addModerators(\Doctrine\Common\Collections\Collection $moderators)
    {
    	foreach ($moderators as $moderator) {
    		$this->addModerator($moderator);
    	}
    
    	return $this;
    }
    
    public function addModerator(User $moderator)
    {
    	$this->moderators[] = $moderator;
    
    	return $this;
    }
    
    public function removeModerators(\Doctrine\Common\Collections\Collection $moderators)
    {
    	foreach ($moderators as $moderator) {
    		$this->removeModerator($moderator);
    	}
    
    	return $this;
    }
    
    public function removeModerator(User $moderator)
    {
    	$moderator->removeModeratedGroup($this);
    	$this->moderators->removeElement($moderator);
    }
}
