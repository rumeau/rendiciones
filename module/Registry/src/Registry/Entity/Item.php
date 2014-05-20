<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity
 * @Gedmo\Loggable
 */
class Item
{
    const ITEM_STATUS_PENDING = 0;
    const ITEM_STATUS_APPROVED = 1;
    const ITEM_STATUS_REJECTED = 2;

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
     * @ORM\Column(name="description", type="text", precision=0, scale=0, nullable=true, unique=false)
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
     */
    private $modifiedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="`status`", type="integer", length=1, precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\Versioned
     */
    private $status = self::ITEM_STATUS_PENDING;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_number", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="item_identifier", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_date", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemDate;

    /**
     * @var float
     *
     * @ORM\Column(name="item_gross", type="float", length=19, precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemGross;

    /**
     * @var float
     *
     * @ORM\Column(name="item_vat", type="float", length=19, precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemVat;

    /**
     * @var float
     *
     * @ORM\Column(name="item_total", type="float", length=19, precision=0, scale=0, nullable=true, unique=false)
     */
    private $itemTotal;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Registry\Entity\Comment", mappedBy="item", cascade={"all"})
     * @ORM\OrderBy({
     *     "createdDate"="ASC"
     * })
     */
    private $comments;

    /**
     * @var \Registry\Entity\Registry
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registry_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $registry;

    /**
     * @var \Registry\Entity\Document
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="document_id", referencedColumnName="id", nullable=false)
     * })
     * @Gedmo\Versioned
     */
    private $document;

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
     * @ORM\OneToMany(targetEntity="Registry\Entity\File", mappedBy="item", cascade={"all"}, orphanRemoval=true)
     */
    private $files;

    /**
     * @ORM\Version
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->values = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param  string $description
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * Set itemNumber
     *
     * @param  integer $itemNumber
     * @return Item
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;

        return $this;
    }

    /**
     * Get itemNumber
     *
     * @return integer
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * Set itemIdentifier
     *
     * @param  string $itemIdentifier
     * @return Item
     */
    public function setItemIdentifier($itemIdentifier)
    {
        $this->itemIdentifier = $itemIdentifier;

        return $this;
    }

    /**
     * Get itemIdentifier
     *
     * @return string
     */
    public function getItemIdentifier()
    {
        return $this->itemIdentifier;
    }

    /**
     * Set itemName
     *
     * @param  string $itemName
     * @return Item
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set itemDate
     *
     * @param  DateTime $itemDate
     * @return Item
     */
    public function setItemDate($itemDate)
    {
        $this->itemDate = $itemDate;

        return $this;
    }

    /**
     * Get itemDate
     *
     * @return DateTime
     */
    public function getItemDate()
    {
        return $this->itemDate;
    }

    /**
     * Set itemGross
     *
     * @param  float $itemGross
     * @return Item
     */
    public function setItemGross($itemGross)
    {
        $this->itemGross = $itemGross;

        return $this;
    }

    /**
     * Get itemGross
     *
     * @return float
     */
    public function getItemGross()
    {
        return $this->itemGross;
    }

    /**
     * Set itemVat
     *
     * @param  float $itemVat
     * @return Item
     */
    public function setItemVat($itemVat)
    {
        $this->itemVat = $itemVat;

        return $this;
    }

    /**
     * Get itemVat
     *
     * @return float
     */
    public function getItemVat()
    {
        return $this->itemVat;
    }

    /**
     * Set itemVat
     *
     * @param  float $itemTotal
     * @return Item
     */
    public function setItemTotal($itemTotal)
    {
        $this->itemTotal = $itemTotal;

        return $this;
    }

    /**
     * Get itemVat
     *
     * @return float
     */
    public function getItemTotal()
    {
        return $this->itemTotal;
    }

    /**
     * Add comments
     *
     * @param  \Registry\Entity\Comment $comments
     * @return Item
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
     * Set registry
     *
     * @param  \Registry\Entity\Registry $registry
     * @return Item
     */
    public function setRegistry(\Registry\Entity\Registry $registry)
    {
        $this->registry = $registry;

        return $this;
    }

    /**
     * Get registry
     *
     * @return \Registry\Entity\Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * Set document
     *
     * @param  \Registry\Entity\Document $document
     * @return Item
     */
    public function setDocument(\Registry\Entity\Document $document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \Registry\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set modifiedBy
     *
     * @param  \Registry\Entity\User $modifiedBy
     * @return Item
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
     * Add file
     *
     * @param  \Registry\Entity\File $file
     * @return Item
     */
    public function addFile(\Registry\Entity\File $file)
    {
        $file->setItem($this);
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
     * Remove file
     *
     * @param \Registry\Entity\File $file
     */
    public function removeFile(\Registry\Entity\File $file)
    {
        $this->files->removeElement($file);
        $file->setItem(null);
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

    /**
     * Set version
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     */
    public function getVersion()
    {
        return $this->version;
    }
}
