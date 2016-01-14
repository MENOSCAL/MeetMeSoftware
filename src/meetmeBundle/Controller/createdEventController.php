<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
                    $searchCode = substr(md5(microtime()),rand(0,21),10);
                    $event->setSearchCode($searchCode);
                    
                    //$email = $request->get('email');
                    
                    //$invitedPerson = new InvitedPerson(); 
                    //$invitedPerson->setEmail($email);
                    
                    $event->addIduser($user);
                    $user->addIdevent($event);
                    //$event->addIdinvited($invitedPerson);
                    
                    $em->persist($event);
                    $em->persist($user);
                    //$em->persist($invitedPerson);
                    $em->flush();
                    
                    //
                    $query = $em->createQueryBuilder()
                    ->select('p')
                    ->from('meetmeBundle\Entity\InvitedPerson', 'p')
                    ->innerJoin('p.idevent','e')
                    ->where('e.id = ?1')
                    ->setParameter(1 , $event->getId())
                    ->orderBy('p.invitationDate', 'DESC')
                    ->getQuery();
                    //
                    //$repositorio = $em->getRepository('meetmeBundle:InvitedPerson'); 
                    //$invitedPersons = $repositorio->findAll();
                    $invitedPersons = $query->getResult();
                    /*
                     return new Response(
                     'Created user id: '.$user->getId()
                    .' and event id: '.$event->getId()
                     );
                    */
                   
                    return $this->render('meetmeBundle:twig_html:createdevent.html.twig', array('title' => $title, 'name'=>$name, 'lastname' => $lastName, 'eventdate' => $eventDateStr, 'hour' => $eventHour, 'place' => $place, 'invitedPersons' => $invitedPersons, 'searchCode' =>$searchCode)); 
             }
                return $this->render('meetmeBundle:twig_html:login.html.twig'); 
                }
                else
                {
                 return $this->render('meetmeBundle:twig_html:login.html.twig');  
                }   
     }
}
   