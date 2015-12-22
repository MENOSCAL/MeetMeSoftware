<?php
namespace autostopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use autostopBundle\Entity\User;
use autostopBundle\Modal\Login;

class loginController extends Controller
{
    public function loginAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('autostopBundle:User'); 
        
        if($request->getMethod() == 'POST'){
            $sesion->clear();
            $username = $request->get('username');
            $password = sha1($request->get('password'));
            //$recordar = $request->get('recordar');
            $user = $repositorio->findOneBy(array('username'=>$username,'password'=>$password));
             if($user){
                if($sesion->has('login')){
                    $login = $sesion->get('login');
                    $name = $login->getName();
                    $lastname = $login->getLastName();
                    $sex = $login->getSex();
                    return $this->render( 'autostopBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$name, 'lastname'=>$lastname, 'sex'=>$sex) );
                    
                }else{
                    $login = new Login();
                    $login->setUsername($username);
                    $login->setName($user->getName());
                    $this->get('session')->set('loginId', $user->getUserId());
                    $login->setLastname($user->getLastname());
                    $login->setSex($user->getSex());
                    $sesion->set('login', $login);
                    return $this->render( 'autostopBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$user->getName(), 'lastname'=>$user->getLastname(), 'sex'=>$user->getSex()) );
                    
                }                        
            }else{
                return $this->render('autostopBundle:twig_html:login.html.twig');
                //return new Response("no encontro el usuario");
            }     
            /*if($user){
                if($recordar == 'remember'){
                    $login = new Login();
                    $login->setUsername($usuario);
                    $login->setPassword($contrasena);
                    $sesion->set('login', $login);                
                }
                $query = $repositorio->createQueryBuilder('a')
                        ->where('a.usuario LIKE :usuario')
                        ->setParameter('usuario', $usuario)
                        ->getQuery();

                $clip = $query->getArrayResult();
                $id =($clip[0]['id']);
                $nombre =($clip[0]['nombre']);
                $apellido =($clip[0]['apellido']);
                $url =($clip[0]['foto'].'.jpg');
                //return $this->render('autostopBundle:twig_html:index.html.twig',array('nombre'=>$user->getNombre(), 'apellido'=>$user->getApellido()));//OJO aqui se actualiza la pagina 
                $this->get('session')->set('loginUserId', $usuario);
                $this->get('session')->set('loginId', $id);
                return $this->render('autostopBundle:twig_html:index.html.twig', array(
                'usuario'     => $usuario,
                'nombre'      => $nombre,
                'apellido'    => $apellido,
                'url'      => $url
                ));          
            }else{
                return $this->render('autostopBundle:twig_html:login.html.twig',array('mensaje'=>'no se encontro el usuario, registrese...'));
            }*/
        }else{
            if($sesion->has('login')){
                $login = $sesion->get('login');
                $username = $login->getUsername();
                $name = $login->getName();
                $lastname= $login->getLastname();
                $sex = $login->getSex();
                return $this->render( 'autostopBundle:twig_html:index.html.twig', array('username' => $username, 'name'=>$name, 'lastname'=>$lastname, 'sex'=>$sex) );
                
            }else{
                return $this->render('autostopBundle:twig_html:login.html.twig');            
            }
            /*if($sesion->has('login')){
                $login = $sesion->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();
                $user = $repositorio->findOneBy(array('usuario'=>$username,'contrasena'=>$password));
                if($user){
                    //return $this->render('autostopBundle:twig_html:index.html.twig', array('name' => $usuario->getNombre()));//OJO aqui se actualiza la pagina
                    return $this->render('autostopBundle:twig_html:index.html.twig', array(
                'usuario'   => $usuario
                ));
                }
            }*/
            return $this->render('autostopBundle:twig_html:login.html.twig');
        }        
    }
    public function reloadAction(){
        $sesion = $this->getRequest()->getSession();
        if($sesion->has('login')){
            $login = $sesion->get('login');
            $username = $login->getUsername();
            $name = $login->getName();
            $lastname = $login->getLastName();
            $sex = $login->getSex();
            return $this->render( 'autostopBundle:twig_html:index.html.twig', array('username'=> $username, 'name'=>$name, 'sex'=>$sex) );
        }
        return $this->render('autostopBundle:twig_html:index.html.twig');
        
        /*return $this->render('autostopBundle:twig_html:index.html.twig', array(
                'usuario'     => "ngngng"
                ));*/
    }
}

