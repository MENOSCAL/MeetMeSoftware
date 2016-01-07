<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExceptionController extends Controller{
     public function showAction()
    {
         return $this->render( 'TwigBundle:views:error404.html.twig', array('status_text' => "Pagina no encontrada", 'status_code' => "404" ) ); 
     }
}
