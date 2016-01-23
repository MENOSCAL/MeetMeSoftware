<?php
namespace meetmeBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Modal\Login;
use meetmeBundle\Entity\User;
use Doctrine\ORM\Query\AST\Join;

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
                        /*
                         $maxItemPerPage = 5;
                 $query = $em->createQueryBuilder()
                 ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->innerJoin('e.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                        
                         */
                        /*
                         $maxItemPerPage = 5;
                         
                  $query = $em->createQueryBuilder()
                ->select('e.id AS eid', 'e.type', 'e.title', 'e.description', 'e.eventDate', 'e.eventHour', 'e.place' )
                ->from('meetmeBundle\Entity\UserEvent', 'ue')
                ->innerJoin('ue.idevent','e')
                 ->innerJoin('ue.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                  */
                 
                  $maxItemPerPage = 5;
                  $query = $em->createQueryBuilder()
                ->select('e.id as eid', 'e.title', 'e.description' )
                ->from('meetmeBundle\Entity\Event', 'e')
                ->where('e.createdBy = ?1')
                ->orderBy('e.creationDate', 'DESC')
                ->setParameter(1 , $user->getId())
                ->getQuery()->getResult();
                  
                  
                 
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                $query,
                $this->get('request')->query->get('page', 1)/*page number*/,
                $maxItemPerPage /*limit per page*/
                );


                        if($img){
                          return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) );
                        }else{
                         $nameImg = 'bundles/meetme/images/unisex.png';
                         return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) ); 
                        }
                    
                }else{//user doesn't have login
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
                      
                      //$page_title = Util::getFormattedPageTitle("Events");

                      
                 $maxItemPerPage = 5;
                 /*
                 $query = $em->createQueryBuilder()
                 ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->innerJoin('e.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                       
                       */
                 /*
                        $query = $em->createQueryBuilder()
               ->select('e.id AS eid', 'e.type', 'e.title', 'e.description', 'e.eventDate', 'e.eventHour', 'e.place' )
                ->from('meetmeBundle\Entity\UserEvent', 'ue')
                ->innerJoin('ue.idevent','e')
                 ->innerJoin('ue.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                  
                  */
                       
              $maxItemPerPage = 5;
                  $query = $em->createQueryBuilder()
                ->select('e.id as eid', 'e.title', 'e.description' )
                ->from('meetmeBundle\Entity\Event', 'e')
                ->where('e.createdBy = ?1')
                ->orderBy('e.creationDate', 'DESC')
                ->setParameter(1 , $user->getId())
                ->getQuery()->getResult();
                  
              
               /*todos los eventos creados por todos los users
                $query = $em->createQueryBuilder()
                ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
              */
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                $query,
                $this->get('request')->query->get('page', 1)/*page number*/,
                $maxItemPerPage /*limit per page*/
                );


    // parameters to template
                /*
    return $this->render('CustomersBundle:Default:index.html.twig', array(
        'page_title' => $page_title,
        'pagination' => $pagination,
        'image_path' => CustomersConstants::$customers_image_thumb_path
    ));
                 */
                 
    
    
                      $img = $imgRepository->findOneBy(array('iduser'=>$user->getId(), 'isActive'=>1 ));
                      if($img){
                        return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) );
                      }else{
                        $nameImg = 'bundles/meetme/images/unisex.png';
                        return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) ); 
                      }
                }     
            }else{
              
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
                     
                     $maxItemPerPage = 5;
                     
                     /*
                 $query = $em->createQueryBuilder()
                 ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->innerJoin('e.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                 */
                     /*
                     $query = $em->createQueryBuilder()
                ->select('e.id AS eid', 'e.type', 'e.title', 'e.description', 'e.eventDate', 'e.eventHour', 'e.place' )
                ->from('meetmeBundle\Entity\UserEvent', 'ue')
                ->innerJoin('ue.idevent','e')
                 ->innerJoin('ue.iduser','u')
                ->where('u.id = ?1')
                ->setParameter(1 , $user->getId())
                ->orderBy('e.eventDate', 'DESC')
                ->getQuery()->getResult();
                    */
                     $maxItemPerPage = 5;
                  $query = $em->createQueryBuilder()
                ->select('e.id as eid', 'e.title', 'e.description' )
                ->from('meetmeBundle\Entity\Event', 'e')
                ->where('e.createdBy = ?1')
                ->orderBy('e.creationDate', 'DESC')
                ->setParameter(1 , $user->getId())
                ->getQuery()->getResult();
                  
                  
                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                $query,
                $this->get('request')->query->get('page', 1)/*page number*/,
                $maxItemPerPage /*limit per page*/
                );
                
                
                        if($img){
                           return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $img->getPath(),   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) );
                        }else{
                           $nameImg = 'bundles/meetme/images/unisex.png';
                           return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'nameImg' => $nameImg,   'useremail' => $useremail, 'emailcode' => $emailcode, 'pagination' => $pagination) ); 
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