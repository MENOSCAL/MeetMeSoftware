<?php
namespace autostopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use autostopBundle\Entity\Auto;
use autostopBundle\Entity\User;
use autostopBundle\WebService\WebService;

class signupController extends Controller
{
    public function signupAction(Request $request)
    {
        if($request->getMethod() == 'POST'){
                $user = new User();  
                $user->setEmail($request->get('email'));
                $user->setName($request->get('name'));
                $user->setLastName($request->get('lastname'));
                $user->setUsername($request->get('username'));
                $password = $request->get('password');
                $user->setPassword(sha1($password));
                //$user->setCountry($request->get('country'));
                $user->setSex(1);
                $user->setPhoto('bundles/autostop/img/female');
                $em = $this->getDoctrine()->getManager();         
                $em->persist($user);
                $em->flush();
                return $this->render('autostopBundle:twig_html:login.html.twig');
            }else{
                return $this->render('autostopBundle:twig_html:signup.html.twig');
            }                   
               
     }
        
    }
   