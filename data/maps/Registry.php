<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Registry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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
     * @ORM\OneToMany(targetEntity="Registry\Entity\Item", mappedBy="registry", orphanRemoval=true, cascade={"all"})
     * @ORM\OrderBy({"created_date"="ASC"})
     */
    private $items;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="registry", cascade={"all"})
     * @ORM\OrderBy({"createdDate"="ASC"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\File", mappedBy="registry")
     */
    private $files;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User", inversedBy="registries")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User")
     * @ORM\JoinColumn(name="modifiedBy", referencedColumnName="id")
     */
    private $modifiedBy;
}