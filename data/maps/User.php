<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true, length=20, nullable=false)
     */
    private $identity;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $credential;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15, nullable=true, name="mobile_phone")
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=15, nullable=true, name="home_phone")
     */
    private $homePhone;

    /**
     * @ORM\Column(type="string", length=15, nullable=true, name="work_phone")
     */
    private $workPhone;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $options;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="created_date")
     */
    private $createdDate;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="modified_date")
     */
    private $modifiedDate;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $hash;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\Registry", mappedBy="user")
     */
    private $registries;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="Registry\Entity\UserRole", inversedBy="user")
     * @ORM\JoinTable(
     *     name="UserRoleLinker",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $userRole;
}