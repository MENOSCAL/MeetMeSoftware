<?php

namespace autostopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_sender", columns={"idsender"}), @ORM\Index(name="fk_receiver", columns={"idreceiver"})})
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="messageId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageid;

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
     *   @ORM\JoinColumn(name="idreceiver", referencedColumnName="userId")
     * })
     */
    private $idreceiver;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsender", referencedColumnName="userId")
     * })
     */
    private $idsender;



    /**
     * Get messageid
     *
     * @return integer 
     */
    public function getMessageid()
    {
        return $this->messageid;
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
     * @param \autostopBundle\Entity\User $idreceiver
     * @return Message
     */
    public function setIdreceiver(\autostopBundle\Entity\User $idreceiver = null)
    {
        $this->idreceiver = $idreceiver;

        return $this;
    }

    /**
     * Get idreceiver
     *
     * @return \autostopBundle\Entity\User 
     */
    public function getIdreceiver()
    {
        return $this->idreceiver;
    }

    /**
     * Set idsender
     *
     * @param \autostopBundle\Entity\User $idsender
     * @return Message
     */
    public function setIdsender(\autostopBundle\Entity\User $idsender = null)
    {
        $this->idsender = $idsender;

        return $this;
    }

    /**
     * Get idsender
     *
     * @return \autostopBundle\Entity\User 
     */
    public function getIdsender()
    {
        return $this->idsender;
    }
}
