<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class nologinController extends Controller{
    
    public function nologinAction()
    {
      return $this->render( 'meetmeBundle:twig_html:index0.html.twig');
    }
}
