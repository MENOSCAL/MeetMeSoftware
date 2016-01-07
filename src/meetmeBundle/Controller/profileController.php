<?php

namespace meetmeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Entity\Solicitudamistad;
use meetmeBundleundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use meetmeBundle\Modal\Login;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

class profileController extends Controller{
    //put your code here
    public function profileAction($usuariop){         
         
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('meetmeBundle:User');
        $repositorio2 = $em->getRepository('meetmeBundle:Solicitudamistad');
        $login = $this->get('session')->get('login');
        $usuario = $login->getUsername();
        //$sexo = $login->getSexo();
        //$usuario = $this->get('session')->get('loginUserId');
        $ids = $this->get('session')->get('loginId');
        
        $queryid = $repositorio->createQueryBuilder('a')
               ->where('a.usuario LIKE :usuariop')
               ->setParameter('usuariop', $usuariop)
               ->getQuery();
        
        $clipid = $queryid->getArrayResult();
        $id = $clipid[0]['id'];
        
        $querysgres = $repositorio2->createQueryBuilder('a')
               ->select('IDENTITY(a.idseguidor), a.estado, a.id')
               ->where('IDENTITY(a.idestudiante) LIKE :idestudiante')
               ->setParameter('idestudiante', $id)
               ->getQuery();
        
       $estudianteseguido = $repositorio2->createQueryBuilder('a')
               ->select('IDENTITY(a.idseguidor), a.estado, a.id')
               ->where('IDENTITY(a.idestudiante) LIKE :idestudiante','IDENTITY(a.idseguidor) LIKE :idseguidor')
               ->setParameter('idestudiante', $id)
               ->setParameter('idseguidor', $ids)
               ->getQuery();
        if($estudianteseguido){
            $esseguido=1;
        }
        else{
            $esseguido=0;
        }
        
        
        $query = $repositorio->createQueryBuilder('a')
               ->where('a.usuario LIKE :usuario')
               ->setParameter('usuario', $usuario)
               ->getQuery();
       
        $queryp = $repositorio->createQueryBuilder('a')
               ->where('a.usuario LIKE :usuariop')
               ->setParameter('usuariop', $usuariop)
               ->getQuery();
        
        $clip = $query->getArrayResult();
        $clipp = $queryp->getArrayResult();
        
        $qb = $em->createQueryBuilder();
        $q = $qb->update('meetmeBundle:User','u')
                ->set('u.visitas','?1')
                ->where('u.id = ?3')
                ->setParameter(1, $clipp[0]['visitas']+1)
                ->setParameter(3, $id)
                ->getQuery();
        $p = $q->execute();
        
        //$clips = $querys->getArrayResult();
        $lengthq = count($querysgres->getArrayResult());
        //echo '<script type="text/javascript">alert("' . $lengthq . '")</script>';
        if($lengthq > 0){
            $clipsgres = $querysgres->getArrayResult();
            
            $querynombres = $repositorio->createQueryBuilder('a')
               ->where('a.id LIKE :id')
               ->setParameter('id', $clipsgres[0]['1'])
               ->getQuery();
            $clipnombres = $querynombres->getArrayResult();
            $stackSeguidores = array(array($clipnombres[0]['nombre'], $clipnombres[0]['apellido'], $clipnombres[0]['foto'].'.jpg', $clipnombres[0]['usuario'])); 
            
            $length = count($clipsgres);
            
            for ($i = 1; $i < $length; $i++) {
             $querynombres = $repositorio->createQueryBuilder('a')
               ->where('a.id LIKE :id')
               ->setParameter('id', $clipsgres[$i]['1'])
               ->getQuery();
              
            $clipnombres = $querynombres->getArrayResult();
            
                array_push($stackSeguidores, array($clipnombres[0]['nombre'], $clipnombres[0]['apellido'], $clipnombres[0]['foto'].'.jpg', $clipnombres[0]['usuario']));
           }
        }else{
            $stackSeguidores = array(array("", "", "")); 
            $clipsgres = "";
            $length = 0;
        }
        
         $querysgdos = $repositorio2->createQueryBuilder('a')
               ->select('IDENTITY(a.idestudiante), a.estado, a.id')
               ->where('IDENTITY(a.idseguidor) LIKE :idseguidor')
               ->setParameter('idseguidor', $id)
               ->getQuery();
        //echo '<script type="text/javascript">alert("' . $id . '")</script>';
        
        $length2q = count($querysgdos->getArrayResult());
        //echo '<script type="text/javascript">alert("' . $length2q . '")</script>';
        if($length2q > 0){
            
            $clipsgdos = $querysgdos->getArrayResult();
            
            
            
            $querynombres2 = $repositorio->createQueryBuilder('a')
               ->where('a.id LIKE :id')
               ->setParameter('id', $clipsgdos[0]['1'])
               ->getQuery();
            
            
            
            $clipnombres2 = $querynombres2->getArrayResult();
            $stackSeguidos = array(array($clipnombres2[0]['nombre'], $clipnombres2[0]['apellido'], $clipnombres2[0]['foto'].'.jpg', $clipnombres2[0]['usuario'])); 
        
            $length2 = count($clipsgdos);
            
            for ($i = 1; $i < $length2; $i++) {
             $querynombres2 = $repositorio->createQueryBuilder('a')
               ->where('a.id LIKE :id')
               ->setParameter('id', $clipsgdos[$i]['1'])
               ->getQuery();
              
            $clipnombres2 = $querynombres2->getArrayResult();
            
                array_push($stackSeguidos, array($clipnombres2[0]['nombre'], $clipnombres2[0]['apellido'], $clipnombres2[0]['foto'].'.jpg', $clipnombres2[0]['usuario']));
            }
        }else{
            $stackSeguidos = array(array("", "", "")); 
            $clipsgdos = "";
            $length2 = 0;
        }
        
        
        $nombre =($clip[0]['nombre']);
        $apellido =($clip[0]['apellido']);
        $url =($clip[0]['foto'].'.jpg');
        
        $nombrep =($clipp[0]['nombre']);
        $apellidop =($clipp[0]['apellido']);
        $urlp =($clipp[0]['foto'].'.jpg');
        $visitasp =($clipp[0]['visitas']);
        
        if ($queryp) {
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("usuario no encontrado")';
            echo '</script>';
        }
        
        return $this->render('meetmeBundle:twig_html:perfil.html.twig', array(
                'usuario'     => $usuario,
                'nombre'      => $nombre,
                'apellido'    => $apellido,
                'url'         => $url,
                'sexo'        => $sexo,
                'usuariop'     => $usuariop,
                'nombrep'      => $nombrep,
                'esseguido'      => $esseguido,
                'apellidop'    => $apellidop,
                'urlp'      => $urlp,
                'visitasp'      => $visitasp,
                'blog_entries' => $clipsgres,
                'blog_nombres' => $stackSeguidores,
                'blog_entries2' => $clipsgdos,
                'blog_nombres2' => $stackSeguidos,
                'numSeguidores' => $length,
                'numSeguidos' => $length2
                ));
    }
       
}
