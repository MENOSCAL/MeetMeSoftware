<?php

namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use autostopBundle\Entity\Ruta;
use autostopBundle\Entity\Solicitudamistad;
use autostopBundle\Entity\Estudiante;

class notificacionController extends Controller{
    
    public function enviarNotificacionesAction($idruta, $idEstudiante){
        //con el idEstudiante busco en la tabla solicitudAmistad, todos sus seguidores y este se encarga de crear las notificaciones
        $solicitudRepository = $this->getDoctrine()->getManager()->getRepository('autostopBundle:Solicitudamistad');
        $query = $solicitudRepository->createQueryBuilder('sa')  
                           ->where('sa.idestudiante = :id')
                           ->setParameter('id', $idEstudiante)
                           ->getQuery();
        $arraySeguidores = $query->getResult();
        //$result = $arraySeguidores[0]['idseguidor']['id'];
        return new Response(var_dump($arraySeguidores[0]->getIdseguidor()->getId()));//aqui me quede todo bien por ahora
        //return new Response("<html><body>"+$result+"</body></html>");
    }
}

