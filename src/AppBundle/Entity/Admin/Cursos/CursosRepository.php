<?php

namespace AppBundle\Entity\Admin\Cursos;

use Doctrine\ORM\EntityRepository;

/**
 * CursosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CursosRepository extends EntityRepository
{
  public function findCursosPublicados()
  {
    return $this->getEntityManager()
      ->createQuery(
        'SELECT c FROM AppBundle:Admin\Cursos\Cursos c where c.publicado = 1 ORDER BY c.id DESC '
      )
      ->getResult();
  }

  public function findCursoModuloItem($curso, $modulo, $item)
  {

    $em = $this->getEntityManager();

    $repositorio = $em->getRepository('AppBundle:Admin\Cursos\Cursos');

    $curso = $repositorio->createQueryBuilder('c')
      ->select('c','m','i','s')
      ->leftJoin('c.modulos','m')
      ->leftJoin('m.modulos', 'i')
      ->leftJoin('i.secciones','s')
      ->where('c.id = :curso')
      ->andWhere('m.modulos = :modulo')
      ->andWhere('s.secciones = :item')
      ->setParameter('curso', $curso)
      ->setParameter('modulo', $modulo)
      ->setParameter('item', $item)
      ->getQuery()
      ->getResult()
    ;

    return $curso;
  }
}
