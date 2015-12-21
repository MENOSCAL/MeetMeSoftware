<?php
namespace autostopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class informalEventController extends Controller
{
    public function informalEventAction()
    {
        return $this->render('autostopBundle:twig_html:informalevent.html.twig');
    }
}

