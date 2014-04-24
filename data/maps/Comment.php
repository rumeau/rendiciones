<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Comment
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
    private $comment;

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
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="comments")
     * @ORM\JoinColumn(name="registryId", referencedColumnName="id")
     */
    private $registry;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Item", inversedBy="comments")
     * @ORM\JoinColumn(name="itemId", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $author;
}