<?php
namespace meetmeBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Entity\User;
use meetmeBundle\Modal\Login;

class logoutController extends Controller{
    
    public function logoutAction(Request $request){
        $sesion = $this->getRequest()->getSession();
        $sesion->clear();
        return $this->render('meetmeBundle:twig_html:login.html.twig');
    }
}

