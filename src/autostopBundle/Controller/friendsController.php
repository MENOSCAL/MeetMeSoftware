<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use autostopBundle\Entity\Solicitudamistad;
use autostopBundle\Entity\User;
use autostopBundle\Modal\Login;

/**
 * Description of amigosController
 *
 * @author Carlos
 */
class friendsController extends Controller{
    //put your code here
    public function addAction($usuariop){
        
        $em = $this->getDoctrine()->getManager();
        $login = $this->get('session')->get('login');
        //$seguidor = $this->get('session')->get('loginUserId');
        $seguidor = $login->getUsername();
        $id1 = $em->getRepository('autostopBundle:User')->findOneBy(array('usuario'=>$usuariop));
        $id2 = $em->getRepository('autostopBundle:User')->findOneBy(array('usuario'=>$seguidor));
        $date = date_create(date('Y-m-d H:i:s'));
        $usuario = new Solicitudamistad();
        $usuario->setEstado(0);
        $usuario->setFecha($date);
        $usuario->setIdestudiante($id1);
        $usuario->setIdseguidor($id2);
        
                 
                $em->persist($usuario);
                $em->flush();
        
        echo '<script language="javascript">';
        echo 'alert("usuario no encontrado")';
        echo '</script>';
        /*
        return $this->render('autostopBundle:twig_html:perfil.html.twig', array(
                'usuario'     => $seguidor,
                'nombre'      => $nombre,
                'apellido'    => $apellido,
                'url'      => $url,
                'usuariop'     => $usuariop,
                'nombrep'      => $nombrep,
                'apellidop'    => $apellidop,
                'urlp'      => $urlp,
                'blog_entries'      => $usuariosg,
                ));*/
       //echo '<script type="text/javascript">alert("solicitud enviada");</script>';
       return new Reponse();
    }
    
    public function deleteAction($usuariop){
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('autostopBundle:User');
        $usuario = $this->get('session')->get('loginUserId');
        
        $queryp = $repositorio->createQueryBuilder('a')
               ->where('a.usuario LIKE :usuariop')
               ->setParameter('usuariop', $usuariop)
               ->getQuery();
        $query = $repositorio->createQueryBuilder('a')
               ->where('a.usuario LIKE :usuariop')
               ->setParameter('usuariop', $usuario)
               ->getQuery();
        
        $clipid = $query->getArrayResult();
        $clipidp = $queryp->getArrayResult();
        
        $id = $clipid[0]['id'];
        $idp = $clipidp[0]['id'];
        
        $qb = $em->createQueryBuilder();
        $q = $qb->delete('autostopBundle:Solicitudamistad', 'u')
                ->where('IDENTITY(u.idseguidor) = ?3','IDENTITY(u.idestudiante) = ?4')
                ->setParameter(3, $id)
                ->setParameter(4, $idp)
                ->getQuery();
        $p = $q->execute();
        return new Reponse();
    }
}
