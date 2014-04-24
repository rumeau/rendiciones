<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Item", inversedBy="file")
     * @ORM\JoinColumn(name="itemId", referencedColumnName="id")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="files")
     * @ORM\JoinColumn(name="registryId", referencedColumnName="id")
     */
    private $registry;
}