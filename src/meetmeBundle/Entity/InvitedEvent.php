<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvitedEvent
 *
 * @ORM\Table(name="invited_event", indexes={@ORM\Index(name="invited_event_fk_2", columns={"idevent"}), @ORM\Index(name="invited_event_fk_1", columns={"idinvited"})})
 * @ORM\Entity
 */
class InvitedEvent
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
     * @var \DateTime
     *
     * @ORM\Column(name="sending_invitation_date", type="datetime", nullable=true)
     */
    private $sendingInvitationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_invit_date", type="datetime", nullable=true)
     */
    private $acceptedInvitDate;

    /**
     * @var \InvitedPerson
     *
     * @ORM\ManyToOne(targetEntity="InvitedPerson")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idinvited", referencedColumnName="id")
     * })
     */
    private $idinvited;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevent", referencedColumnName="id")
     * })
     */
    private $idevent;



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
     * Set sendingInvitationDate
     *
     * @param \DateTime $sendingInvitationDate
     * @return InvitedEvent
     */
    public function setSendingInvitationDate($sendingInvitationDate)
    {
        $this->sendingInvitationDate = $sendingInvitationDate;

        return $this;
    }

    /**
     * Get sendingInvitationDate
     *
     * @return \DateTime 
     */
    public function getSendingInvitationDate()
    {
        return $this->sendingInvitationDate;
    }

    /**
     * Set acceptedInvitDate
     *
     * @param \DateTime $acceptedInvitDate
     * @return InvitedEvent
     */
    public function setAcceptedInvitDate($acceptedInvitDate)
    {
        $this->acceptedInvitDate = $acceptedInvitDate;

        return $this;
    }

    /**
     * Get acceptedInvitDate
     *
     * @return \DateTime 
     */
    public function getAcceptedInvitDate()
    {
        return $this->acceptedInvitDate;
    }

    /**
     * Set idinvited
     *
     * @param \meetmeBundle\Entity\InvitedPerson $idinvited
     * @return InvitedEvent
     */
    public function setIdinvited(\meetmeBundle\Entity\InvitedPerson $idinvited = null)
    {
        $this->idinvited = $idinvited;

        return $this;
    }

    /**
     * Get idinvited
     *
     * @return \meetmeBundle\Entity\InvitedPerson 
     */
    public function getIdinvited()
    {
        return $this->idinvited;
    }

    /**
     * Set idevent
     *
     * @param \meetmeBundle\Entity\Event $idevent
     * @return InvitedEvent
     */
    public function setIdevent(\meetmeBundle\Entity\Event $idevent = null)
    {
        $this->idevent = $idevent;

        return $this;
    }

    /**
     * Get idevent
     *
     * @return \meetmeBundle\Entity\Event 
     */
    public function getIdevent()
    {
        return $this->idevent;
    }
}
