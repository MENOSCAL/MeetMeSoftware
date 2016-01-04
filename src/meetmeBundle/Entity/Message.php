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


}
