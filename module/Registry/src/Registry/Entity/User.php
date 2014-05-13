<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use BjyAuthorize\Provider\Role\ProviderInterface;
use ZfcUser\Entity\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class User implements UserInterface, ProviderInterface
{
    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_INACTIVE = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=20, precision=0, scale=0, nullable=false, unique=true)
     */
    private $identity;

    /**
     * @var string
     *
     * @ORM\Column(name="credential", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     * @Gedmo\Versioned
     */
    private $credential;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     * @Gedmo\Versioned
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_phone", type="string", length=15, precision=0, scale=0, nullable=true, unique=false)
     */
    private $mobilePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="home_phone", type="string", length=15, precision=0, scale=0, nullable=true, unique=false)
     */
    private $homePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="work_phone", type="string", length=15, precision=0, scale=0, nullable=true, unique=false)
     */
    private $workPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=60, precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var array
     *
     * @ORM\Column(name="options", type="array", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Versioned
     */
    private $options;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Timestampable(on="update")
     * @Gedmo\Versioned
     */
    private $modifiedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="`status`", type="integer", length=1, precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Versioned
     */
    private $status = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $hash;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\Registry", mappedBy="user")
     */
    private $registries;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Registry\Entity\UserRole", inversedBy="user")
     * @ORM\JoinTable(name="userrolelinker",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    private $userRoles;

    /**
     * @var \Registry\Entity\UserGroup
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\UserGroup", inversedBy="users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $userGroup;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Registry\Entity\UserGroup", inversedBy="moderators")
     * @ORM\JoinTable(name="moderatorgrouplinker",
     *   joinColumns={
     *     @ORM\JoinColumn(name="moderator_id", referencedColumnName="id", nullable=false)
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     *   }
     * )
     */
    private $moderatedGroups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->moderatedGroups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param  integer $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set name
     *
     * @param  string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set identity
     *
     * @param  string $identity
     * @return User
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Get identity
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set credential
     *
     * @param  string $credential
     * @return User
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;

        return $this;
    }

    /**
     * Get credential
     *
     * @return string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * Set email
     *
     * @param  string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mobilePhone
     *
     * @param  string $mobilePhone
     * @return User
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set homePhone
     *
     * @param  string $homePhone
     * @return User
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set workPhone
     *
     * @param  string $workPhone
     * @return User
     */
    public function setWorkPhone($workPhone)
    {
        $this->workPhone = $workPhone;

        return $this;
    }

    /**
     * Get workPhone
     *
     * @return string
     */
    public function getWorkPhone()
    {
        return $this->workPhone;
    }

    /**
     * Set address
     *
     * @param  string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set options
     *
     * @param  array $options
     * @return User
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set createdDate
     *
     * @param  \DateTime $createdDate
     * @return User
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param  \DateTime $modifiedDate
     * @return User
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set status
     *
     * @param  integer $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Set hash
     *
     * @param  string $hash
     * @return User
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Add registries
     *
     * @param  \Registry\Entity\Registry $registries
     * @return User
     */
    public function addRegistry(\Registry\Entity\Registry $registries)
    {
        $this->registries[] = $registries;

        return $this;
    }

    /**
     * Remove registries
     *
     * @param \Registry\Entity\Registry $registries
     */
    public function removeRegistry(\Registry\Entity\Registry $registries)
    {
        $this->registries->removeElement($registries);
    }

    /**
     * Get registries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegistries()
    {
        return $this->registries;
    }

    /**
     * Add comments
     *
     * @param  \Registry\Entity\Comment $comments
     * @return User
     */
    public function addComment(\Registry\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Registry\Entity\Comment $comments
     */
    public function removeComment(\Registry\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add userRole
     *
     * @param  \Registry\Entity\UserRole $userRole
     * @return User
     */
    public function addUserRole(\Registry\Entity\UserRole $userRole)
    {
        $this->userRoles[] = $userRole;

        return $this;
    }

    public function addUserRoles(\Doctrine\Common\Collections\Collection $userRoles)
    {
        foreach ($userRoles as $userRole) {
            $this->addUserRole($userRole);
        }

        return $this;
    }

    /**
     * Remove userRole
     *
     * @param \Registry\Entity\UserRole $userRole
     */
    public function removeUserRole(\Registry\Entity\UserRole $userRole)
    {
        $this->userRoles->removeElement($userRole);
    }

    public function removeUserRoles(\Doctrine\Common\Collections\Collection $userRoles)
    {
        foreach ($userRoles as $userRole) {
            $this->removeUserRole($userRole);
        }
    }

    /**
     * Get userRole
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * Set userGroup
     *
     * @param  \Registry\Entity\UserGroup $userGroup
     * @return User
     */
    public function setUserGroup(\Registry\Entity\UserGroup $userGroup)
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * Add moderatedGroup
     *
     * @param  \Registry\Entity\UserGroup $moderatedGroup
     * @return User
     */
    public function addModeratedGroup(\Registry\Entity\UserGroup $moderatedGroup)
    {
        $moderatedGroup->addModerator($this);
        $this->moderatedGroups[] = $moderatedGroup;

        return $this;
    }

    public function addModeratedGroups(\Doctrine\Common\Collections\Collection $moderatedGroups)
    {
        foreach ($moderatedGroups as $moderatedGroup) {
            $this->addModeratedGroup($moderatedGroup);
        }

        return $this;
    }

    /**
     * Remove moderatedGroup
     *
     * @param \Registry\Entity\UserGroup $moderatedGroup
     */
    public function removeModeratedGroup(\Registry\Entity\UserGroup $moderatedGroup)
    {
        $this->moderatedGroups->removeElement($moderatedGroup);
    }

    public function removeModeratedGroups(\Doctrine\Common\Collections\Collection $moderatedGroups)
    {
        foreach ($moderatedGroups as $moderatedGroup) {
            $this->removeModeratedGroup($moderatedGroup);
        }
    }

    /**
     * Get userGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModeratedGroups()
    {
        return $this->moderatedGroups;
    }

    /**
     * INTERFACE METHODS
     */

    public function getUsername()
    {
        return $this->getIdentity();
    }

    public function setUsername($username)
    {
        $this->setIdentity($username);
    }

    public function getDisplayName()
    {
        return $this->getName();
    }

    public function setDisplayName($displayName)
    {
        $this->setName($displayName);
    }

    public function getPassword()
    {
        return $this->getCredential();
    }

    public function setPassword($password)
    {
        $this->setCredential($password);
    }

    public function getState()
    {
        return $this->getStatus();
    }

    public function setState($state)
    {
        $this->setStatus($state);
    }

    public function getRoles()
    {
        return $this->getUserRoles();
    }
}
