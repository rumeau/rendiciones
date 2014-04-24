<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={@ORM\Index(name="idx_parent_id", columns={"parent_id"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="unique_role", columns={"role_id"})}
 * )
 */
class UserRole
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, name="role_id")
     */
    private $roleId;

    /**
     * @ORM\Column(type="integer", length=1, nullable=false, name="is_default")
     */
    private $isDefault;

    /**
     * @ORM\OneToOne(targetEntity="Registry\Entity\UserRole")
     * @ORM\JoinColumn(name="parentId", referencedColumnName="id", nullable=false, unique=true)
     */
    private $parentId;

    /**
     * @ORM\ManyToMany(targetEntity="Registry\Entity\User", mappedBy="userRole")
     */
    private $user;
}