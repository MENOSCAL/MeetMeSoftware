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
     * @var \DateTime
     *
     * @ORM\Column(name="invitation_date", type="datetime", nullable=true)
     */
    private $invitationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_invitation_date", type="datetime", nullable=true)
     */
    private $acceptedInvitationDate;

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
     * Set email
     *
     * @param string $email
     * @return InvitedPerson
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set invitationDate
     *
     * @param \DateTime $invitationDate
     * @return InvitedPerson
     */
    public function setInvitationDate($invitationDate)
    {
        $this->invitationDate = $invitationDate;

        return $this;
    }

    /**
     * Get invitationDate
     *
     * @return \DateTime 
     */
    public function getInvitationDate()
    {
        return $this->invitationDate;
    }

    /**
     * Set acceptedInvitationDate
     *
     * @param \DateTime $acceptedInvitationDate
     * @return InvitedPerson
     */
    public function setAcceptedInvitationDate($acceptedInvitationDate)
    {
        $this->acceptedInvitationDate = $acceptedInvitationDate;

        return $this;
    }

    /**
     * Get acceptedInvitationDate
     *
     * @return \DateTime 
     */
    public function getAcceptedInvitationDate()
    {
        return $this->acceptedInvitationDate;
    }

    /**
     * Add idevent
     *
     * @param \meetmeBundle\Entity\Event $idevent
     * @return InvitedPerson
     */
    public function addIdevent(\meetmeBundle\Entity\Event $idevent)
    {
        $this->idevent[] = $idevent;

        return $this;
    }

    /**
     * Remove idevent
     *
     * @param \meetmeBundle\Entity\Event $idevent
     */
    public function removeIdevent(\meetmeBundle\Entity\Event $idevent)
    {
        $this->idevent->removeElement($idevent);
    }

    /**
     * Get idevent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdevent()
    {
        return $this->idevent;
    }
}
