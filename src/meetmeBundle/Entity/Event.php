<?php

namespace meetmeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
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
     * @ORM\Column(name="type", type="string", length=1, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date", nullable=false)
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="date", nullable=true)
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="event_hour", type="string", length=5, nullable=false)
     */
    private $eventHour;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=100, nullable=false)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=200, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="search_code", type="string", length=10, nullable=false)
     */
    private $searchCode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="InvitedPerson", mappedBy="idevent")
     */
    private $idinvited;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idevent")
     */
    private $iduser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idinvited = new \Doctrine\Common\Collections\ArrayCollection();
        $this->iduser = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param string $type
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Event
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set eventHour
     *
     * @param string $eventHour
     * @return Event
     */
    public function setEventHour($eventHour)
    {
        $this->eventHour = $eventHour;

        return $this;
    }

    /**
     * Get eventHour
     *
     * @return string 
     */
    public function getEventHour()
    {
        return $this->eventHour;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Event
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set searchCode
     *
     * @param string $searchCode
     * @return Event
     */
    public function setSearchCode($searchCode)
    {
        $this->searchCode = $searchCode;

        return $this;
    }

    /**
     * Get searchCode
     *
     * @return string 
     */
    public function getSearchCode()
    {
        return $this->searchCode;
    }

    /**
     * Add idinvited
     *
     * @param \meetmeBundle\Entity\InvitedPerson $idinvited
     * @return Event
     */
    public function addIdinvited(\meetmeBundle\Entity\InvitedPerson $idinvited)
    {
        $this->idinvited[] = $idinvited;

        return $this;
    }

    /**
     * Remove idinvited
     *
     * @param \meetmeBundle\Entity\InvitedPerson $idinvited
     */
    public function removeIdinvited(\meetmeBundle\Entity\InvitedPerson $idinvited)
    {
        $this->idinvited->removeElement($idinvited);
    }

    /**
     * Get idinvited
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdinvited()
    {
        return $this->idinvited;
    }

    /**
     * Add iduser
     *
     * @param \meetmeBundle\Entity\User $iduser
     * @return Event
     */
    public function addIduser(\meetmeBundle\Entity\User $iduser)
    {
        $this->iduser[] = $iduser;

        return $this;
    }

    /**
     * Remove iduser
     *
     * @param \meetmeBundle\Entity\User $iduser
     */
    public function removeIduser(\meetmeBundle\Entity\User $iduser)
    {
        $this->iduser->removeElement($iduser);
    }

    /**
     * Get iduser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}
