<?php

namespace autostopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solicitudamistad
 *
 * @ORM\Table(name="solicitudamistad", indexes={@ORM\Index(name="IDX_8FCF235FB9CB2147", columns={"idEstudiante"}), @ORM\Index(name="IDX_8FCF235FBC8DEC53", columns={"idSeguidor"})})
 * @ORM\Entity
 */
class Solicitudamistad
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \autostopBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="autostopBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSeguidor", referencedColumnName="id")
     * })
     */
    private $idseguidor;

    /**
     * @var \autostopBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="autostopBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstudiante", referencedColumnName="id")
     * })
     */
    private $idestudiante;

      /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Solicitudamistad
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Solicitudamistad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
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
     * Set idseguidor
     *
     * @param \autostopBundle\Entity\User $idseguidor
     * @return Solicitudamistad
     */
    public function setIdseguidor(User $idseguidor = null)
    {
        $this->idseguidor = $idseguidor;

        return $this;
    }

    /**
     * Get idseguidor
     *
     * @return \autostopBundle\Entity\User 
     */
    public function getIdseguidor()
    {
        return $this->idseguidor;
    }

    /**
     * Set idestudiante
     *
     * @param \autostopBundle\Entity\User $idestudiante
     * @return Solicitudamistad
     */
    public function setIdestudiante(User $idestudiante = null)
    {
        $this->idestudiante = $idestudiante;

        return $this;
    }

    /**
     * Get idestudiante
     *
     * @return \autostopBundle\Entity\User 
     */
    public function getIdestudiante()
    {
        return $this->idestudiante;
    }
}
