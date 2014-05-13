<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Zend\Db\Sql\Ddl\Column\Integer;

/**
 * Registry
 *
 * @ORM\Table(name="registry")
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class Registry
{
    const REGISTRY_STATUS_DRAFT = 0;
    const REGISTRY_STATUS_PENDING = 1;
    const REGISTRY_STATUS_APPROVED = 2;
    const REGISTRY_STATUS_REJECTED = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Integer
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     * @Gedmo\Versioned
     */
    private $number = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Versioned
     */
    private $description;

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
     * @ORM\Column(name="status", type="integer", length=1, precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Versioned
     */
    private $status = 0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\Item", mappedBy="registry", cascade={"all"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="registry", cascade={"all"})
     * @ORM\OrderBy({
     *     "createdDate"="ASC"
     * })
     */
    private $comments;

    /**
     * @var \Registry\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User", inversedBy="registries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    /**
     * @var \Registry\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modified_by", referencedColumnName="id", nullable=true)
     * })
     * @Gedmo\Versioned
     */
    private $modifiedBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\File", mappedBy="registry", cascade={"ALL"})
     */
    private $files;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set number
     *
     * @param integer
     * @return Registry
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set description
     *
     * @param  string   $description
     * @return Registry
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Set createdDate
     *
     * @param  \DateTime $createdDate
     * @return Registry
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
     * @return Registry
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
     * @param  integer  $status
     * @return Registry
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
     * Add items
     *
     * @param  \Registry\Entity\Item $items
     * @return Registry
     */
    public function addItem(\Registry\Entity\Item $item)
    {
        $item->setRegistry($this);
        $this->items[] = $item;

        return $this;
    }

    public function addItems(Collection $items)
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Registry\Entity\Item $items
     */
    public function removeItem(\Registry\Entity\Item $item)
    {
        $item->setRegistry(null);
        $this->items->removeElement($item);
    }

    public function removeItems(Collection $items)
    {
        foreach ($items as $item) {
            $this->removeItem($item);
        }

        return $this;
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add comments
     *
     * @param  \Registry\Entity\Comment $comments
     * @return Registry
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
     * Set user
     *
     * @param  \Registry\Entity\User $user
     * @return Registry
     */
    public function setUser(\Registry\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Registry\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set modifiedBy
     *
     * @param  \Registry\Entity\User $modifiedBy
     * @return Registry
     */
    public function setModifiedBy(\Registry\Entity\User $modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return \Registry\Entity\User
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Add files
     *
     * @param  \Registry\Entity\File $files
     * @return Registry
     */
    public function addFile(\Registry\Entity\File $file)
    {
        $file->setRegistry($this);
        $this->files[] = $file;

        return $this;
    }

    public function addFiles(\Doctrine\Common\Collections\Collection $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }

        return $this;
    }

    /**
     * Remove files
     *
     * @param \Registry\Entity\File $files
     */
    public function removeFile(\Registry\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    public function removeFiles(\Doctrine\Common\Collections\Collection $files)
    {
        foreach ($files as $file) {
            $this->removeFile($file);
        }
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }
}
