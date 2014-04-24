<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class DocumentField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Registry\Entity\ItemValue", mappedBy="field")
     */
    private $values;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Document", inversedBy="documentFields")
     * @ORM\JoinColumn(name="documentId", referencedColumnName="id", nullable=false)
     */
    private $document;
}