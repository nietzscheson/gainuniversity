<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuizOpciones
 *
 * @ORM\Table(name="Opciones")
 * @ORM\Entity(repositoryClass="Quiz\QuizBundle\Entity\OpcionesRepository")
 */
class Opciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="opcion", type="string", length=255)
     */
    private $opcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="boolean")
     */
    private $valor;

    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    /**
     * @ORM\ManyToOne(targetEntity="Preguntas", inversedBy="opciones")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     **/

    private $preguntas;


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
     * Set opcion
     *
     * @param string $opcion
     * @return QuizOpciones
     */
    public function setOpcion($opcion)
    {
        $this->opcion = $opcion;

        return $this;
    }

    /**
     * Get opcion
     *
     * @return string
     */
    public function getOpcion()
    {
        return $this->opcion;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return QuizOpciones
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set preguntas
     *
     * @param \Quiz\QuizBundle\Entity\Preguntas $preguntas
     * @return Opciones
     */
    public function setPreguntas(\Quiz\QuizBundle\Entity\Preguntas $preguntas = null)
    {
        $this->preguntas = $preguntas;

        return $this;
    }

    /**
     * Get preguntas
     *
     * @return \Quiz\QuizBundle\Entity\Preguntas
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     * @return Opciones
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }
}
