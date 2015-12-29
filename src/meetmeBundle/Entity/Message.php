<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_sender", columns={"idsender"}), @ORM\Index(name="fk_receiver", columns={"idreceiver"}), @ORM\Index(name="fk_invitedperson", columns={"idinvitedperson"})})
 * @ORM\Entity
 */
class Message
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
     * @ORM\Column(name="subject", type="string", length=50, nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=400, nullable=true)
     */
    private $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="idinvitedperson", type="integer", nullable=true)
     */
    private $idinvitedperson;

    /**
     * @var string
     *
     * @ORM\Column(name="date_sent", type="string", length=20, nullable=true)
     */
    private $dateSent;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idreceiver", referencedColumnName="id")
     * })
     */
    private $idreceiver;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsender", referencedColumnName="id")
     * })
     */
    private $idsender;



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
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set idinvitedperson
     *
     * @param integer $idinvitedperson
     * @return Message
     */
    public function setIdinvitedperson($idinvitedperson)
    {
        $this->idinvitedperson = $idinvitedperson;

        return $this;
    }

    /**
     * Get idinvitedperson
     *
     * @return integer 
     */
    public function getIdinvitedperson()
    {
        return $this->idinvitedperson;
    }

    /**
     * Set dateSent
     *
     * @param string $dateSent
     * @return Message
     */
    public function setDateSent($dateSent)
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    /**
     * Get dateSent
     *
     * @return string 
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * Set idreceiver
     *
     * @param \meetmeBundle\Entity\User $idreceiver
     * @return Message
     */
    public function setIdreceiver(\meetmeBundle\Entity\User $idreceiver = null)
    {
        $this->idreceiver = $idreceiver;

        return $this;
    }

    /**
     * Get idreceiver
     *
     * @return \meetmeBundle\Entity\User 
     */
    public function getIdreceiver()
    {
        return $this->idreceiver;
    }

    /**
     * Set idsender
     *
     * @param \meetmeBundle\Entity\User $idsender
     * @return Message
     */
    public function setIdsender(\meetmeBundle\Entity\User $idsender = null)
    {
        $this->idsender = $idsender;

        return $this;
    }

    /**
     * Get idsender
     *
     * @return \meetmeBundle\Entity\User 
     */
    public function getIdsender()
    {
        return $this->idsender;
    }
}
