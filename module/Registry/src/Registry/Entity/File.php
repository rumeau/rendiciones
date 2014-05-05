<?php

namespace Registry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 * @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=false, appendNumber=true)
 */
class File
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="`name`", type="string", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var \Registry\Entity\Item
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Item", inversedBy="files")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="itemId", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * })
     */
    private $item;

    /**
     * @var \Registry\Entity\Registry
     *
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Registry", inversedBy="files")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="registryId", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     * })
     */
    private $registry;


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
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return File
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set item
     *
     * @param \Registry\Entity\Item $item
     * @return File
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
     * @param \Registry\Entity\Registry $registry
     * @return File
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
}
