<?php

namespace autostopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Puntos
 *
 * @ORM\Table(name="puntos", indexes={@ORM\Index(name="IDX_2F16D1B9B053AE12", columns={"idRuta"})})
 * @ORM\Entity
 */
class Puntos
{
    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitud;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \autostopBundle\Entity\Ruta
     *
     * @ORM\ManyToOne(targetEntity="autostopBundle\Entity\Ruta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRuta", referencedColumnName="id")
     * })
     */
    private $idruta;


}
