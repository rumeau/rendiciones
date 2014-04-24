<?php
namespace Registry\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class ItemValue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true, name="value_num")
     */
    private $valueNum;

    /**
     * @ORM\Column(type="string", nullable=true, name="value_alnum")
     */
    private $valueAlnum;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="value_datetime")
     */
    private $valueDatetime;

    /**
     * @ORM\Column(type="date", nullable=true, name="value_date")
     */
    private $valueDate;

    /**
     * @ORM\Column(type="time", nullable=true, name="value_time")
     */
    private $valueTime;

    /**
     * @ORM\Column(type="float", length=19, nullable=true, name="value_decimal")
     */
    private $valueDecimal;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $valuetype;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\Item", inversedBy="values")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\DocumentField", inversedBy="values")
     * @ORM\JoinColumn(name="document_field_id", referencedColumnName="id", nullable=false)
     */
    private $field;

    /**
     * @ORM\ManyToOne(targetEntity="Registry\Entity\User")
     * @ORM\JoinColumn(name="modifiedBy", referencedColumnName="id")
     */
    private $modifiedBy;
}