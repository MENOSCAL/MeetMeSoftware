<?php
namespace meetmeBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Modal\Login;
use meetmeBundle\Entity\User;

class loginController extends Controller
{
    public function loginAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('meetmeBundle:User'); 
        $imgRepository = $em->getRepository('meetmeBundle:Image'); 
        
        
        if($request->getMethod() == 'POST'){
            $sesion->clear();
            $username = $request->get('username');
            $password = sha1($request->get('password'));
            $status = 1;
            $user = new User();
            $user = $repository->findOneBy(array('username'=>$username,'password'=>$password));
            if($user){
                if($sesion->has('login')){
                    
                        $login = $sesion->get('login');
                        $name = $login->getName();
                        $lastname = $login->getLastName();
                        $this->get('session')->getFlashBag()->set(
                       'success',
                        array(
                        'title' => 'Welcome. ',
                        'message' => 'Your log in has been successful. '
                        )
                        );
                        $sesion->set('login', $login);
                        $img = $imgRepository->findOneBy(array('iduser'=>$user->getId(), 'isActive'=>1 ));
                        
                        $email  = trim($user->getEmail());
                        $domain = strstr($email, '@');
                        $useremail = strstr($email, '@', true); // Desde PHP 5.3.0
                        if (strnatcasecmp ( $domain , "@gmail.com" ) == 0 ) {
                          $emailcode = "g";
                        }            
                        
                        if($img){
                          return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode) );
                        }else{
                         $nameImg = 'unisex.png';
                         return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode) ); 
                        }
                    
                }else{
                      $login = new Login();
                      $login->setUsername($username);
                      $login->setPassword($password);
                      $login->setName($user->getName());
                      $this->get('session')->set('loginId', $user->getId());
                      $login->setLastname($user->getLastname());
                      $this->get('session')->getFlashBag()->set(
                      'success',
                      array(
                      'title' => 'Welcome. ',
                      'message' => 'Your log in has been successful. '
                      )
                      );
                      $sesion->set('login', $login);
                      $email  = trim($user->getEmail());
                      $domain = strstr($email, '@');
                      $useremail = strstr($email, '@', true); // Desde PHP 5.3.0
                      if (strnatcasecmp ( $domain , "@gmail.com" ) == 0 ) {
                          $emailcode = "g";
                      }                      
                      $img = $imgRepository->findOneBy(array('iduser'=>$user->getId(), 'isActive'=>1 ));
                      if($img){
                        return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode) );
                      }else{
                        $nameImg = 'unisex.png';
                        return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode) ); 
                      }
                }     
            }else{
                
                
                //
                $this->get('session')->getFlashBag()->set(
                      'Error',
                      array(
                      'title' => 'Sign In Error. ',
                      'message' => 'The user or the password doesn\'t match. '
                      )
                      );
                //
                
                return $this->render('meetmeBundle:twig_html:login.html.twig'); 
                
           } 
        }else{
    
                if($sesion->has('login')){
                    $login = $sesion->get('login');
                    $username = $login->getUsername();
                    $password = $login->getPassword();
                    $user = $repository->findOneBy(array('username'=>$username,'password'=>$password));
                    $img = $imgRepository->findOneBy(array('iduser'=>$user->getId(), 'isActive'=>1 ));
                
                    if($user){
                     $this->get('session')->getFlashBag()->set(
                      'success',
                      array(
                      'title' => 'Welcome. ',
                      'message' => 'Your log in has been successful. '
                      )
                      );
                     $sesion->set('login', $login);
                     
                     $email  = trim($user->getEmail());
                     $domain = strstr($email, '@');
                     $useremail = strstr($email, '@', true); // Desde PHP 5.3.0
                     if (strnatcasecmp ( $domain , "@gmail.com" ) == 0 ) {
                         $emailcode = "g";
                     }               
                        if($img){
                           return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode) );
                        }else{
                           $nameImg = 'unisex.png';
                           return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode) ); 
                        }
                }
                }else{
                    
                     return $this->render('meetmeBundle:twig_html:login.html.twig');
                    
                }
            }
    }   
    
    public function reloadAction(){
        $sesion = $this->getRequest()->getSession();
        if($sesion->has('login')){
            $login = $sesion->get('login');
            $username = $login->getUsername();
            $name = $login->getName();
            $lastname = $login->getLastName();
            return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username'=> $username, 'name'=>$name, 'lastname'=>$lastname) );
        }
        return $this->render('meetmeBundle:twig_html:index.html.twig');
    }
    
   
}