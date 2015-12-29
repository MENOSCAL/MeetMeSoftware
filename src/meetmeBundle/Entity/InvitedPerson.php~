<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvitedPerson
 *
 * @ORM\Table(name="invited_person")
 * @ORM\Entity
 */
class InvitedPerson
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="idinvited")
     * @ORM\JoinTable(name="invited_event",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idinvited", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idevent", referencedColumnName="id")
     *   }
     * )
     */
    private $idevent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idevent = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
