<?php


namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class signupfailController extends Controller{
   public function signupfailAction()
    {
       return $this->render('meetmeBundle:twig_html:invalidpassword.html.twig');  
   }
}
