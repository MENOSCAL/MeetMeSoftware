<?php
namespace meetmeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class informalEventController extends Controller
{
    public function informalEventAction()
    {
       
        $sesion = $this->getRequest()->getSession();
        if($sesion->has('login')){
                    $login = $sesion->get('login');
                    $name = $login->getName();
                    $lastname = $login->getLastName();
                    $username = $login->getUsername();
                    return $this->render( 'meetmeBundle:twig_html:informalevent.html.twig', array('username' => $username, 'name'=>$name, 'lastname'=>$lastname) );
                    
                }else{
                    /*
                    $login = new Login();
                    $login->setUsername($username);
                    $login->setName($user->getName());
                    $this->get('session')->set('loginId', $user->getId());
                    $login->setLastname($user->getLastname());
                    $sesion->set('login', $login);
                    return $this->render( 'meetmeBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname()) );
                    */
                }                    
        //return $this->render('meetmeBundle:twig_html:informalevent.html.twig');
    }
}

