<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use meetmeBundle\Entity\User;
use meetmeBundle\Modal\Login;

class signupController extends Controller
{
    public function signupAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        if($request->getMethod() == 'POST'){
                $user = new User();  
                $user->setName($request->get('name'));
                $user->setLastName($request->get('lastname'));
                $username = $request->get('username');
                $user->setUsername($username);
                $user->setEmail($request->get('email'));
                $em = $this->getDoctrine()->getManager();  
                $selectedCountry = filter_input(INPUT_POST, 'namecbxcountry', FILTER_SANITIZE_NUMBER_INT);
                $selectedCountry2  = $em->getRepository('meetmeBundle:Country')->findOneById($selectedCountry);
                $user->setCountry($selectedCountry2);
                $password = $request->get('password');
                $user->setPassword(sha1($password));
                $user->setPhoto('bundles/meetme/img/female');
                $user->setStatus(1);
                $user->setType("N");
                $user->setRegisterDate(new \DateTime("now"));
                $em->persist($user);
                $em->flush();
                
                //25 dic 9.18
                $login = new Login();
                $login->setUsername($request->get('username'));
                $login->setName($user->getName());
                $login->setLastname($user->getLastname());
                $sesion->set('login', $login);
                return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname()) );
                //
                }else{
                //$sesion = $this->getRequest()->getSession();
                $em = $this->getDoctrine()->getManager();
                $repositorio = $em->getRepository('meetmeBundle:Country'); 
                $countries = $repositorio->findAll();
                return $this->render('meetmeBundle:twig_html:signup.html.twig', array(
                 'countries' => $countries));               
            }   
     }
        
    }
   