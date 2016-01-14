<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class showEventController extends Controller{
    
    public function showEventAction($varid)
    {
        return $this->render('meetmeBundle:twig_html:login.html.twig'); 
    }
}
