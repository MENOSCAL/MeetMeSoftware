<?php
namespace autostopBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use autostopBundle\Entity\Estudiante;
use autostopBundle\Modal\Login;

class loginController extends Controller
{
    public function loginAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('autostopBundle:Estudiante'); 
        
        if($request->getMethod() == 'POST'){
            $sesion->clear();
            $usuario = $request->get('usuario');
            $contrasena = sha1($request->get('contrasena'));
            $recordar = $request->get('recordar');
            $user = $repositorio->findOneBy(array('usuario'=>$usuario,'contrasena'=>$contrasena));
             if($user){
                if($sesion->has('login')){
                    $login = $sesion->get('login');
                    $nombre = $login->getNombre();
                    $apellido = $login->getApellido();
                    $sexo = $login->getSexo();
                    return $this->render( 'autostopBundle:paginas:index.html.twig', array('usuario' => $usuario, 'nombre'=>$nombre, 'apellido'=>$apellido, 'sexo'=>$sexo) );
                }else{
                    $login = new Login();
                    $login->setUsername($usuario);
                    $login->setNombre($user->getNombre());
                    $this->get('session')->set('loginId', $user->getId());
                    $login->setApellido($user->getApellido());
                    $login->setSexo($user->getSexo());
                    $sesion->set('login', $login);
                    return $this->render( 'autostopBundle:paginas:index.html.twig', array('usuario' => $usuario, 'nombre'=>$user->getNombre(), 'apellido'=>$user->getApellido(), 'sexo'=>$user->getSexo()) );
                }                        
            }else{
                return $this->render('autostopBundle:paginas:login.html.twig');
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
                //return $this->render('autostopBundle:paginas:index.html.twig',array('nombre'=>$user->getNombre(), 'apellido'=>$user->getApellido()));//OJO aqui se actualiza la pagina 
                $this->get('session')->set('loginUserId', $usuario);
                $this->get('session')->set('loginId', $id);
                return $this->render('autostopBundle:paginas:index.html.twig', array(
                'usuario'     => $usuario,
                'nombre'      => $nombre,
                'apellido'    => $apellido,
                'url'      => $url
                ));          
            }else{
                return $this->render('autostopBundle:paginas:login.html.twig',array('mensaje'=>'no se encontro el usuario, registrese...'));
            }*/
        }else{
            if($sesion->has('login')){
                $login = $sesion->get('login');
                $usuario = $login->getUsername();
                $nombre = $login->getNombre();
                $apellido = $login->getApellido();
                $sexo = $login->getSexo();
                return $this->render( 'autostopBundle:paginas:index.html.twig', array('usuario' => $usuario, 'nombre'=>$nombre, 'apellido'=>$apellido, 'sexo'=>$sexo) );
            }else{
                return $this->render('autostopBundle:paginas:login.html.twig');            
            }
            /*if($sesion->has('login')){
                $login = $sesion->get('login');
                $username = $login->getUsername();
                $password = $login->getPassword();
                $user = $repositorio->findOneBy(array('usuario'=>$username,'contrasena'=>$password));
                if($user){
                    //return $this->render('autostopBundle:paginas:index.html.twig', array('name' => $usuario->getNombre()));//OJO aqui se actualiza la pagina
                    return $this->render('autostopBundle:paginas:index.html.twig', array(
                'usuario'   => $usuario
                ));
                }
            }*/
            return $this->render('autostopBundle:paginas:login.html.twig');
        }        
    }
    public function recargarAction(){
        $sesion = $this->getRequest()->getSession();
        if($sesion->has('login')){
            $login = $sesion->get('login');
            $usuario = $login->getUsername();
            $nombre = $login->getNombre();
            $apellido = $login->getApellido();
            $sexo = $login->getSexo();
            return $this->render( 'autostopBundle:paginas:index.html.twig', array('usuario'=> $usuario, 'nombre'=>$nombre, 'apellido'=>$apellido, 'sexo'=>$sexo) );
        }
        return $this->render('autostopBundle:paginas:index.html.twig');
        
        /*return $this->render('autostopBundle:paginas:index.html.twig', array(
                'usuario'     => "ngngng"
                ));*/
    }
}

