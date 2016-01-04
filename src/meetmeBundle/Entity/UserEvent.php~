<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEvent
 *
 * @ORM\Table(name="user_event", indexes={@ORM\Index(name="fk_user", columns={"iduser"}), @ORM\Index(name="fk_event", columns={"idevent"})})
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
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevent", referencedColumnName="id")
     * })
     */
    private $idevent;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
}
