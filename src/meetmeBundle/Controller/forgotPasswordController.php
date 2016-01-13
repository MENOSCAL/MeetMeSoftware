<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class forgotPasswordController extends Controller
{
    public function forgotPasswordAction()
    {
        return $this->render( 'meetmeBundle:twig_html:forgotpassword.html.twig'); 
    }
}
