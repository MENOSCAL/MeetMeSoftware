<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use meetmeBundle\Entity\User;
use meetmeBundle\Entity\Event;
use meetmeBundle\Entity\InvitedPerson;

class createdEventController extends Controller
{
    public function createdEventAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repositorio = $em->getRepository('meetmeBundle:User');
        if($request->getMethod() == 'POST'){
            //$sesion->clear();
             if($sesion->has('login')){
                    $login = $sesion->get('login');
                    $username = $login->getUsername();
                    $password = $login->getPassword();
                    $user = $repositorio->findOneBy(array('username'=>$username,'password'=>$password));
                    $name = $user->getName();
                    $lastName = $user->getLastname();
                    $title = $request->get('title');
                    $eventDate = $request->get('date');
                    $eventHour = $request->get('hour');
                    $description = $request->get('description');
                    $place = $request->get('place');
                    $event = new Event();  
                    $event->setType("I");
                    $type = $event->getType();
                    $event->setTitle($title);
                    $title = $event->getTitle();
                    $event->setEventDate(new \DateTime($eventDate));
                    $eventDate = $event->getEventDate();
                    $eventDateStr = date_format($eventDate, 'Y-m-d');
                    $event->setEventHour($eventHour);
                    //$eventHour = $event->getEventHour();
                    $event->setDescription($description);
                    $event->setPlace($place);
                    $event->setCreationDate(new \DateTime("now"));
                    $creationDate = $event->getCreationDate();
                    //$email = $request->get('email');
                    
                    //$invitedPerson = new InvitedPerson(); 
                    //$invitedPerson->setEmail($email);
                    
                    $event->addIduser($user);
                    //$event->addIdinvited($invitedPerson);
                    
                    $em->persist($event);
                    $em->persist($user);
                    //$em->persist($invitedPerson);
                    $em->flush();
                    
                    $repositorio = $em->getRepository('meetmeBundle:InvitedPerson'); 
                    $invitedPersons = $repositorio->findAll();
                    /*
                     return new Response(
                     'Created user id: '.$user->getId()
                    .' and event id: '.$event->getId()
                     );
                    */
                   
                    return $this->render('meetmeBundle:twig_html:createdevent.html.twig', array('title' => $title, 'name'=>$name, 'lastname' => $lastName, 'eventdate' => $eventDateStr, 'hour' => $eventHour, 'place' => $place, 'invitedPersons' => $invitedPersons)); 
             }
                return $this->render('meetmeBundle:twig_html:login.html.twig'); 
                }
                else
                {
                 return $this->render('meetmeBundle:twig_html:login.html.twig');  
                }   
     }
}
   