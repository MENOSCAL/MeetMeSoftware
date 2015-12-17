<?php
namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class eventoInformalController extends Controller
{
    public function eventoInformalAction()
    {
        return $this->render('autostopBundle:paginas:eventoinformal.html.twig');
    }
}

