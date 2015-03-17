<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;

use ACL\ACLBundle\Entity\Usuarios;
use Elearn\ElearnBundle\Form\PerfilUsuarioType;
use Elearn\ElearnBundle\Form\PasswordUsuarioType;

use ACL\ACLBundle\Entity\CursoUsuarios;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FrontController extends Controller
{

  public function modulosPublicar()
  {

  }

  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $curso = $em
    ->getRepository("ElearnBundle:Cursos")
    ->findOneById($id);

    if (!$curso) {
        throw $this->createNotFoundException(
        'Este curso no existe '.$id
      );
    }

    if ($this->get('security.context')->isGranted('ROLE_USER')) {
      // @fecha publicación curso
      $fpc = $curso->getFechaPublicacion();

      // @Usuario
      $usuario = $this->getUser()->getId();

      // @fecha registro del usuario
      $fru = $em->createQuery(
        "SELECT c, u
        FROM ElearnBundle:CursoUsuarios c
        JOIN c.curso u
        WHERE c.usuario = :usuario"
      )->setParameter('usuario',$usuario);

      $fru = $fru->getSingleResult();

      /*
       * Se la fecha mayor se usa para iniciar la publicación de los módulos
       */

      $dePublicacion = ($fpc < $fru->getFechaRegistro()) ? $fru->getFechaRegistro() : $fpc;

      /*
       * Se averigua por la fecha actual
       */
      //$hoy = date_format(new \DateTime('now'), 'Y-m-d');

      $hoy = new \DateTime('now');
      $intervalo = $dePublicacion->diff($hoy)->format('%a');

      $temporalidadCurso = $curso->getTemporalidad();

      $formaPublicacion = 0;

      switch($temporalidadCurso){
        case 1:
          $formaPublicacion = 1;
          break;
        case 2:
          $formaPublicacion = 7;
          break;
        case 3:
          $formaPublicacion = 14;
      };

      // echo "Días de intérvalo: ".$intervalo."<br />";
      // echo "Forma de publicacion: ".$formaPublicacion."<br />";
      // echo "Módulos a publicar: ".($intervalo / $formaPublicacion + 1) ."<br />";
      // exit();

      $modulosCurso = count($curso->getModulos());

      $modulosPublicar = ($intervalo / $formaPublicacion + 1);
      $modulosPublicar = ($modulosPublicar < $modulosCurso) ? $modulosPublicar: $modulosCurso;


      return $this->render('ElearnBundle:Front:curso.html.twig', array(
        "curso" => $curso,
        "modulosPublicar" => $modulosPublicar
      ));

    }else{

      return $this->render('ElearnBundle:Front:curso.html.twig', array(
        "curso" => $curso,
        "modulosPublicar" => null
      ));
    }


  }

  public function moduloAction($curso, $modulo, $seccion, Request $request)
  {

    $curso = $this->getDoctrine()
    ->getRepository("ElearnBundle:Cursos")
    ->find($curso);
    $modulo = $this->getDoctrine()
    ->getRepository("ElearnBundle:Modulos")
    ->find($modulo);
    $seccion = $this->getDoctrine()
    ->getRepository("ElearnBundle:Secciones")
    ->find($seccion);

    if(!$seccion){
      throw $this->createNotFoundException(
      'Este item no existe'
    );
  }

  $em = $this->getDoctrine()->getManager();
  // $comentarios = $em->getRepository("ElearnBundle:ComentariosItems")->findAll();

  $comentarios = $em->getRepository('ElearnBundle:ComentariosItems');

  $comentarios = $comentarios->createQueryBuilder('i')
    ->where('i.items = :item')
      ->andWhere('i.modulos = :modulo')
      ->andWhere('i.cursos = :curso')
    ->setParameter('item', $seccion)
      ->setParameter('modulo', $modulo)
      ->setParameter('curso', $curso)
    ->getQuery()
    ->getResult();

  $comentario = new ComentariosItems();
  $comentarioForm = $this->createForm(new ComentariosItemsType(), $comentario, array(
    'action' => "",
    'method' => 'POST',
  ));

  $comentarioForm->handleRequest($request);

  if($comentarioForm->isValid()){
    $em = $this->getDoctrine()->getManager();

    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository('ACLBundle:Usuarios')->findOneByUsername($usuario->getUsername());

    $curso = $em->getRepository('ElearnBundle:Cursos')->findOneById($curso);
    $modulo = $em->getRepository('ElearnBundle:Modulos')->findOneById($modulo);
    $items = $em->getRepository('ElearnBundle:Secciones')->findOneById($seccion);

    $comentario->setUsuarios($usuario);
    $comentario->setCursos($curso);
    $comentario->setModulos($modulo);
    $comentario->setItems($items);

    $em->persist($comentario);
    $em->flush();

    return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $seccion->getId())));
  }

    return $this->render('ElearnBundle:Front:modulo.html.twig', array(
      "curso" => $curso,
      "modulo" => $modulo,
      "seccion" => $seccion,
      "seccion_id" => $seccion->getId(),
      "comentarioForm" => $comentarioForm->createView(),
      "comentarios" => $comentarios
    ));
  }

  public function perfilAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository("ACLBundle:Usuarios")->findOneByUsername($usuario->getUsername());

    $formPerfil = $this->createForm(new PerfilUsuarioType(), $usuario);
    $formPassword = $this->createForm(new PasswordUsuarioType(), $usuario);

    $formPerfil->handleRequest($request);
    $formPassword->handleRequest($request);

    if($formPerfil->isValid()){
      $em->flush();
      return $this->redirect($this->generateUrl('front_perfil'));
    }

    if($formPassword->isValid()){
      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($usuario);
      $formData = $formPassword->getData();
      $usuario->setPassword($encoder->encodePassword($formData->getPassword(), $usuario->getSalt()));
      $em->flush();
      return $this->redirect($this->generateUrl('front_perfil'));
    }

    return $this->render('ElearnBundle:Front:perfil.html.twig', array(
      'formPerfil' => $formPerfil->createView(),
      'formPassword' => $formPassword->createView(),
      'usuario' => $usuario
    ));
  }
}
