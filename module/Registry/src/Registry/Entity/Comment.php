<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
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
     * @ORM\Column(name="comment", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $comment;

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
     */
    private $status = 1;

    /**
     * @var \Registry\Entity\Item
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Item", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $item;

    /**
     * @var \Registry\Entity\Registry
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registry_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $registry;

    /**
     * @var \Registry\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $author;

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
     * Set comment
     *
     * @param  string  $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdDate
     *
     * @param  \DateTime $createdDate
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * Set item
     *
     * @param  \Registry\Entity\Item $item
     * @return Comment
     */
    public function setItem(\Registry\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Registry\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set registry
     *
     * @param  \Registry\Entity\Registry $registry
     * @return Comment
     */
    public function setRegistry(\Registry\Entity\Registry $registry = null)
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
     * Set author
     *
     * @param  \Registry\Entity\User $author
     * @return Comment
     */
    public function setAuthor(\Registry\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Registry\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
