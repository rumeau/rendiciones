<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Item
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
     * @ORM\OneToMany(targetEntity="Registry\Entity\ItemValue", mappedBy="item")
     */
    private $values;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="item", cascade={"all"})
     * @ORM\OrderBy({"createdDate"="ASC"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\File", mappedBy="item")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="items")
     * @ORM\JoinColumn(name="registryId", referencedColumnName="id", nullable=false)
     */
    private $registry;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Document")
     * @ORM\JoinColumn(name="documentId", referencedColumnName="id", nullable=false)
     */
    private $document;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User")
     * @ORM\JoinColumn(name="modifiedBy", referencedColumnName="id")
     */
    private $modifiedBy;
}