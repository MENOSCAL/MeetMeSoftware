<?php
namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of eventoFormalController
 *
 * @author Raul
 */
class eventoFormalController extends Controller{
    public function eventoFormalAction()
    {
        return $this->render('autostopBundle:paginas:eventoformal.html.twig');
    }
}
