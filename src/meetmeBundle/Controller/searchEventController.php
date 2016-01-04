<?php



namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class searchEventController extends Controller {
   
     public function searchEventAction()
    {
        return $this->render('meetmeBundle:twig_html:login.html.twig'); 
     }
}
