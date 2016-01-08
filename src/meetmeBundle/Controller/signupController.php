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
            //$remember = $request->get('remember');
            $userVal = $repositorio->findOneBy(array('username'=>$username,'password'=>$password));
            $emailVal = $repositorio->findOneBy(array('email'=>$email));
            
            if(is_null($userVal) && is_null($emailVal)){  
                $user = new User();  
                $user->setName($request->get('name'));
                $user->setLastName($request->get('lastname'));
                $username = $request->get('username');
                $email = strtolower($email);
                $selectedCountry = filter_input(INPUT_POST, 'namecbxcountry', FILTER_SANITIZE_NUMBER_INT);
                $selectedCountry2  = $em->getRepository('meetmeBundle:Country')->findOneById($selectedCountry);
                $password = $request->get('password');
                $passwordError = "";
                
                //Password validation
                if(strlen($password) < 7){
                $passwordError = "La clave debe tener al menos 7 caracteres";
                
                 }
                if(strlen($password) > 14){
                $passwordError = "La clave no puede tener más de 14 caracteres";
                
                }
                if (!preg_match('`[a-z]`',$password)){
                $passwordError = "La clave debe tener al menos una letra minúscula";
                
                }
                if (!preg_match('`[A-Z]`',$password)){
                $passwordError = "La clave debe tener al menos una letra mayúscula";
                
                }
                if (!preg_match('`[0-9]`',$password)){
                $passwordError = "La clave debe tener al menos un caracter numérico";
                
                }
   
                if($passwordError == ""){
                //sign up success
                $password = sha1($password); 
                $user->setPassword($password);
                $user->setUsername($username);
                $user->setCountry($selectedCountry2);
                $user->setEmail($email);
                $user->setStatus(1);
                $user->setType("A");
                $user->setRegisterDate(new \DateTime("now"));
                
                $em = $this->getDoctrine()->getManager();  
                $em->persist($user);
                $em->flush();
                
                $login = new Login();
                $login->setUsername($username);
                $login->setPassword($password);
                $login->setName($user->getName());
                $login->setLastname($user->getLastname());
                $this->get('session')->set('loginId', $user->getId());
                $sesion->set('login', $login);
                
                return $this->redirectToRoute('meetme_login');
                
                }else{
                    //signup failure. Invalid password.
                    return $this->redirectToRoute('meetme_signupfail');
                }
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
   