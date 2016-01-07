<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class nologinController extends Controller{
    
    public function nologinAction()
    {
      return $this->render( 'meetmeBundle:twig_html:index0.html.twig');
    }
}
