<?php
namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of eventoFormalController
 *
 * @author Raul
 */
class formalEventController extends Controller{
    public function formalEventAction()
    {
        return $this->render('autostopBundle:twig_html:formalevent.html.twig');
    }
}
