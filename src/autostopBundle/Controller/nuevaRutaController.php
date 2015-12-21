<?php
namespace autostopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use autostopBundle\Entity\User;
use autostopBundle\Entity\Ruta;
use autostopBundle\Modal\Login;
use Symfony\Component\HttpFoundation\Request;

class nuevaRutaController extends Controller
{
    
    public function nuevarutaAction(Request $request)
    {
        if($request->getMethod()=='GET')
        {        
            $puntos = $request->query->get('puntos');            
            $formulario = $request->query->get('formulario');
            $sesion = $this->getRequest()->getSession();
            $em = $this->getDoctrine()->getManager();
            if($sesion->has('login')){
                $login = $sesion->get('login');
                $usuario = $login->getUsername();
            }else{
                return new Response("se perdio la referencia con la sesion del ususario...");
            }
            $puntosx = $puntosy = "";
            //$fecha = date('Y-m-d',strtotime($formulario["fecha"]));
            $fecha = new \DateTime(date('Y-m-d',strtotime($formulario["fecha"])));                     
            //$fecha->setTimestamp($formulario["fecha"]);
            $hora = new \DateTime(date('H:i',strtotime($formulario["hora"])));
            //$hora = date('H:i',strtotime($formulario["hora"]));
            $ruta = new Ruta("pendiente", intval($formulario["capacidad"]), $fecha, $hora, floatval($formulario["costo"]));
            for($i = 0 ; $i < sizeof($puntos["ruta"]) ; $i++){
                $puntosx .= $puntos["ruta"][$i]["latitud"] . ",";
                $puntosy .= $puntos["ruta"][$i]["longitud"] . ",";
            }
            $ruta->setPuntosx($puntosx);
            $ruta->setPuntosy($puntosy);
            $repositorioEstudiante = $em->getRepository('autostopBundle:User');
            $estudiante = $repositorioEstudiante->findOneBy(array('usuario'=>$usuario));
            $ruta->setIdestudiante($estudiante);            
            $em->persist($ruta);
            $em->flush();
            
            $idRuta = self::getIdRutaPorIdEstudiante($estudiante->getId(), $hora, $this->getDoctrine()->getManager());
            $response = $this->forward('autostopBundle:notificacion:enviarNotificaciones',array('idruta'=>$idRuta, 'idEstudiante'=>$estudiante->getId()));
            
            return $response;
            //return $this->render('autostopBundle:twig_html:ejemplo.html.twig');
            //return new Response('<html><body>'+var_dump($formulario)+'</body></html>');
        }else{ return new Response("no hay metodo post");}
    }
    
    public static function getIdRutaPorIdEstudiante($idEstudiante, $hora, $entityManager){
        //$em = $this->getDoctrine()->getManager();
        $rutaRepository = $entityManager->getRepository('autostopBundle:Ruta');
        $ruta = $rutaRepository->findOneBy(array('idestudiante'=>$idEstudiante, 'horainicio'=>$hora));
        if($ruta){
            return $ruta->getId();
        }else{
            return 0;//la ruta no se guardo con exito o existe un problema con la hora 
        }
    }
    
    public static function hasCar(){
        $em = $this->getDoctrine()->getManager();
        $estudianteRepository = $em->getRepository('autostopBundle:Estudiante');
        $login = $this->get('session')->get('login');
        $usuario = $estudianteRepository->findOneBy(array('usuario'=>$login->getUsername()));
        if($usuario){
            $id = $usuario->getId();
            $autoRepository = $em->getRepository('autostopBundle:Auto');
            $auto = $autoRepository->findOneBy(array('idEstudiante'=>$id));
            if($auto){return 1;}else{return 0;}
        }
        
    }
    
    public function puntosAction(){
        /*if($puntos){
            $puntos = null;*/
            //$request = $this->get('request');
            //$data = $request->request->get('Json');
            $data = $this->getRequest()->get('nombre');
            return new Response(json_encode(array('dataReceived' => $data)));
        /*$params = array();
            $content = $this->get("request")->getContent();
            if (!empty($content))
            {
                $params = json_decode($content, true); // 2nd param to get as array
            }*/
            //var_dump(json_decode($data));
            //var_dump(json_decode($data, true));
            //return new Response('<html><body>'+$params+'</body></html>');
        //}
    }
    
    public function buscarAction(){
        $em = $this->getDoctrine()->getManager();
        $data = $this->getRequest()->get('palabra');
        $html = "";
        $repositorio = $em->getRepository('autostopBundle:Estudiante');
        
        $query = $repositorio->createQueryBuilder('a')
               ->where('a.nombre LIKE :nombre')
               ->setParameter('nombre', $data.'%')
               ->getQuery();
        
        $clip = $query->getArrayResult();
        $length = count($clip);
        
        //return new Response(json_encode(array('entities' => $query->getParameters()[0])));
        //return new Response(json_encode(array($clip[0])));
        //return new Response('<a><div>'+'json_encode(array($clip[0]))'+'</div></a>');
        $uri = $_SERVER['REQUEST_URI'];
        
        for ($i = 0; $i < $length; $i++) {
            $nombre =($clip[$i]['nombre']);
            $apellido =($clip[$i]['apellido']);
            $usuario =($clip[$i]['usuario']);
            $url =($clip[$i]['foto'].'.jpg');
            
            $html .= "<a href=".$uri."perfil/".$usuario." style='text-decoration:none;' >
                    <div class='display_box' align='left'>
                        <div style='float:left; margin-right:6px;'>
                            <img src=".$url." width='60' height='60' />
                            <b>".$nombre." ".$apellido."</b></br>
                        </div>
                    </div>
                </a>";
        }
        
        return new Response($html);
        
    }   
    
}
