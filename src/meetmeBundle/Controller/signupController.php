<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use meetmeBundle\Entity\User;
use meetmeBundle\Modal\Login;

class signupController extends Controller
{
    public function signupAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('meetmeBundle:User'); 
        
        if($request->getMethod() == 'POST'){
            $sesion->clear();
            $username = $request->get('username');
            $password = sha1($request->get('password'));
            $email = $request->get('email');
            //$recordar = $request->get('recordar');
            $userVal = $repositorio->findOneBy(array('username'=>$username,'password'=>$password));
            $emailVal = $repositorio->findOneBy(array('email'=>$email));
            if(is_null($userVal) && is_null($emailVal)){  
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
                $user->setPhoto('bundles/meetme/img/unisex');
                $user->setStatus(1);
                $user->setType("N");
                $user->setRegisterDate(new \DateTime("now"));
                $em->persist($user);
                $em->flush();
                $login = new Login();
                $login->setUsername($request->get('username'));
                $login->setName($user->getName());
                $login->setLastname($user->getLastname());
                
                
                
                //$this->get('session')->getFlashBag()->set(
                //'success',
                //array(
                //'title' => 'Congratulatios. ',
                //'message' => 'Your sign up has been successful. Welcome to the best place to plan your schedules.'
                //)
                //);
                //$sesion->set('login', $login);
                //return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname()) );
                return $this->render( 'meetmeBundle:twig_html:responsesignupsuccess.html.twig', array('username' => $username) );
                
                
                
                
                 }else{
                     
                     $username = $request->get('username');
                     $email = $request->get('email');
                     return $this->render('meetmeBundle:twig_html:responsesignupfail.html.twig', array('username' => $username, 'email' => $email));
                     $repositorio = $em->getRepository('meetmeBundle:Country'); 
                     $countries = $repositorio->findAll();
                     return $this->render('meetmeBundle:twig_html:signup.html.twig', array(
                                           'countries' => $countries));  
                 }
                
                }else{
                $repositorio = $em->getRepository('meetmeBundle:Country'); 
                $countries = $repositorio->findAll();
                 return $this->render('meetmeBundle:twig_html:signup.html.twig', array(
                 'countries' => $countries));  
            }   
     }
     
     
    

}
   