<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use BjyAuthorize\Acl\HierarchicalRoleInterface;

/**
 * UserRole
 *
 * @ORM\Table(name="userrole", uniqueConstraints={@ORM\UniqueConstraint(name="unique_role", columns={"role_id"})}, indexes={@ORM\Index(name="idx_parent_id", columns={"parent_id"})})
 * @ORM\Entity
 */
class UserRole implements HierarchicalRoleInterface
{
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
     * @ORM\Column(name="role_id", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $roleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_default", type="integer", length=1, precision=0, scale=0, nullable=true, unique=false)
     */
    private $isDefault;

    /**
     * @var \Registry\Entity\UserRole
     *
     * @ORM\OneToOne(targetEntity="Registry\Entity\UserRole")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", unique=true, nullable=true)
     * })
     */
    private $parentId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Registry\Entity\User", mappedBy="userRoles")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set roleId
     *
     * @param  string   $roleId
     * @return UserRole
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set isDefault
     *
     * @param  integer  $isDefault
     * @return UserRole
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
     * Set parentId
     *
     * @param  \Registry\Entity\UserRole $parentId
     * @return UserRole
     */
    public function setParentId(\Registry\Entity\UserRole $parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return \Registry\Entity\UserRole
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Add user
     *
     * @param  \Registry\Entity\User $user
     * @return UserRole
     */
    public function addUser(\Registry\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Registry\Entity\User $user
     */
    public function removeUser(\Registry\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * INTERFACE METHODS
     */

    public function getParent()
    {
        return $this->parentId;
    }
}
