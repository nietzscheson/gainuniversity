<?php

namespace Quiz\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioQuizOpciones
 */
class UsuarioQuizOpciones
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Elearn\ElearnBundle\Entity\Cursos
     */
    private $cursos;

    /**
     * @var \Elearn\ElearnBundle\Entity\Modulos
     */
    private $modulos;

    /**
     * @var \Elearn\ElearnBundle\Entity\Secciones
     */
    private $items;

    /**
     * @var \Quiz\QuizBundle\Entity\Quiz
     */
    private $quizes;

    /**
     * @var \Quiz\QuizBundle\Entity\Preguntas
     */
    private $preguntas;

    /**
     * @var \Quiz\QuizBundle\Entity\Opciones
     */
    private $opciones;


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
     * Set cursos
     *
     * @param \Elearn\ElearnBundle\Entity\Cursos $cursos
     * @return UsuarioQuizOpciones
     */
    public function setCursos(\Elearn\ElearnBundle\Entity\Cursos $cursos = null)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get cursos
     *
     * @return \Elearn\ElearnBundle\Entity\Cursos 
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set modulos
     *
     * @param \Elearn\ElearnBundle\Entity\Modulos $modulos
     * @return UsuarioQuizOpciones
     */
    public function setModulos(\Elearn\ElearnBundle\Entity\Modulos $modulos = null)
    {
        $this->modulos = $modulos;

        return $this;
    }

    /**
     * Get modulos
     *
     * @return \Elearn\ElearnBundle\Entity\Modulos 
     */
    public function getModulos()
    {
        return $this->modulos;
    }

    /**
     * Set items
     *
     * @param \Elearn\ElearnBundle\Entity\Secciones $items
     * @return UsuarioQuizOpciones
     */
    public function setItems(\Elearn\ElearnBundle\Entity\Secciones $items = null)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get items
     *
     * @return \Elearn\ElearnBundle\Entity\Secciones 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set quizes
     *
     * @param \Quiz\QuizBundle\Entity\Quiz $quizes
     * @return UsuarioQuizOpciones
     */
    public function setQuizes(\Quiz\QuizBundle\Entity\Quiz $quizes = null)
    {
        $this->quizes = $quizes;

        return $this;
    }

    /**
     * Get quizes
     *
     * @return \Quiz\QuizBundle\Entity\Quiz 
     */
    public function getQuizes()
    {
        return $this->quizes;
    }

    /**
     * Set preguntas
     *
     * @param \Quiz\QuizBundle\Entity\Preguntas $preguntas
     * @return UsuarioQuizOpciones
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
     * Set opciones
     *
     * @param \Quiz\QuizBundle\Entity\Opciones $opciones
     * @return UsuarioQuizOpciones
     */
    public function setOpciones(\Quiz\QuizBundle\Entity\Opciones $opciones = null)
    {
        $this->opciones = $opciones;

        return $this;
    }

    /**
     * Get opciones
     *
     * @return \Quiz\QuizBundle\Entity\Opciones 
     */
    public function getOpciones()
    {
        return $this->opciones;
    }
}
