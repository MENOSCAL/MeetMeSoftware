<?php

namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of abController
 *
 * @author Carlos
 */
class buscarController extends Controller{
    //put your code here
    public function buscarAction()
    { 
        return $this->render('autostopBundle:twig_html:index.html.twig');
    }
}
