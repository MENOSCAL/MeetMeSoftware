<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEvent
 *
 * @ORM\Table(name="user_event", indexes={@ORM\Index(name="user_event_fk_2", columns={"idevent"}), @ORM\Index(name="user_event_fk_1", columns={"iduser"})})
 * @ORM\Entity
 */
class UserEvent
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
     * @ORM\Column(name="accepted_invitation_date", type="datetime", nullable=true)
     */
    private $acceptedInvitationDate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

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
     * @return UserEvent
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
     * Set acceptedInvitationDate
     *
     * @param \DateTime $acceptedInvitationDate
     * @return UserEvent
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
     * Set iduser
     *
     * @param \meetmeBundle\Entity\User $iduser
     * @return UserEvent
     */
    public function setIduser(\meetmeBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \meetmeBundle\Entity\User 
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idevent
     *
     * @param \meetmeBundle\Entity\Event $idevent
     * @return UserEvent
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
