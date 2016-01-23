<?php

namespace meetmeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use meetmeBundle\Entity\Event;
use meetmeBundle\Entity\InvitedPerson;
use meetmeBundle\Entity\InvitedEvent;
use Symfony\Component\Validator\Constraints\Email;

class emailController extends Controller{
    
    public function emailAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        
        if($request->getMethod() == 'POST'){
            if($sesion->has('login')){
                $login = $sesion->get('login');
                $name = $login->getName();
                $lastname = $login->getLastName();
                $sesion->set('login', $login);
                
                $eventTitle= $request->get('eventtitle');
                ///$eventTitle= filter_input(INPUT_POST, 'eventtitle', FILTER_SANITIZE_STRING);
                $email = $request->get('email');
                
                $fullName = $request->get('firstname');
                $searchCode = $request->get('searchcode');
                $eventDate  = $request->get('eventdate');
                $hour = $request->get('hour');
                $place= $request->get('place');
                
                $code = $searchCode.htmlspecialchars("<").$email;
                                
                
                $emailConstraint = new Email();
                //We can set all restriction options in this manner.
                $emailConstraint->message = 'Invalid email address';
                // use the validator to validate the value.
                $errorList = $this->get('validator')->validateValue(
                $email,
                $emailConstraint
                );
                if (count($errorList) == 0) {
                // This is a valid email.
                
                $messagetxt1 =  "This is an invitation for you to participate in this Meetme Event: \n\n".$eventTitle."\n".$eventDate."\n".$hour."\n".$place."\n\n".$fullName."\n".$searchCode."\n\n";
                $messagetxt2 =  "Please click here to accept this invitation\n\n";
                $messagetxt3 = $request->get('messagetxt');
                $messagetxt = $messagetxt1.$messagetxt2.$messagetxt3;
                
                
                $sesion = $this->getRequest()->getSession();
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('meetmeBundle:InvitedPerson'); 
        
        
                $invitedPerson = new InvitedPerson();
                $invitedPerson = $repository->findOneBy(array('email'=>$email));
                
                if(!$invitedPerson){
                        $invitedPerson->setEmail($email);
                        $em->persist($invitedPerson);
                        $em->flush();
                }       
                
                
                 $query = $em->createQueryBuilder()
                ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->andWhere('e.searchCode = ?1')
                ->setParameter(1 , $searchCode)
                ->getQuery();
                 
                 $events = $query->getResult();
                
                /* funciona 100 %
                 $query = $em->createQueryBuilder()
                ->select('e')
                ->from('meetmeBundle\Entity\Event', 'e')
                ->where('e.createdBy = ?1')
                ->andWhere('e.place = ?2')
                ->setParameter(1 , 100)
                ->setParameter(2 , 'Guayaquil')
                ->getQuery();
                 
                 $events = $query->getResult();
                 */
                 
                
                ////$repository2 = $em->getRepository('meetmeBundle:Event'); 
                ///$event = new Event();
                /////$event = $repository2->findOneBy(array('title'=> $eventTitle, 'place' => $place ));
                
                
              foreach($events as $event){
                   
                $invitedPerson = $repository->findOneBy(array('email'=>$email));  
                $invitedEvent = new InvitedEvent();
                $invitedEvent->setIdevent($event);
                $invitedEvent->setIdinvited($invitedPerson);
                $invitedEvent->setSendingInvitationDate(new \DateTime("now"));
                
                $em->persist($invitedEvent);
                $em->flush();
                        
               
               }        
                        
                        
                        
                        
                        
                        
                        
                 //////}
                //$invitedPerson = new InvitedPerson(); 
                //$invitedPerson->setEmail($email);
                
                
               // $invitedPerson->setInvitationDate(new \DateTime("now"));
                
                
                
                //foreach($events as $event)
                //{
                    //$id = $event->getId();
                    //$event->addIdinvited($invitedPerson);
                    //$invitedPerson->addIdevent($event);
                    //$em->persist($event);
                    //$em->persist($invitedPerson);
                   // $em->flush();
                 //}
                  /*  
                  $limit=1; 
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQueryBuilder()
                ->select('e')
                ->from('meetmeBundle:Event', 'e')
                ->orderBy('e.creationDate', 'DESC')
                ->setMaxResults($limit)
                ->getQuery() 
                ;
                $events = $query->getResult();
                
                
                $limit=1; 
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQueryBuilder()
                ->select('p')
                ->from('meetmeBundle:InvitedPerson', 'p')
                ->orderBy('p.creationDate', 'DESC')
                ->setMaxResults($limit)
                ->getQuery() 
                ;
                $invitedPersons = $query->getResult();
                
                 foreach($events as $event)
                {
                   $idevent = $event->getId();
                }
                
                 foreach($invitedPersons as $invitedPerson)
                {
                   $idInvitedPerson = $invitedPerson->getId();
                }
                
                */
                
                
                
                
                
                
                
                
                
                
                
                
                $message = \Swift_Message::newInstance()
                ->setSubject('Invitation from MeetMePlanner...')
                ->setFrom('meetmeplanner@gmail.com')
                ->setTo($email)
                ->setBody($messagetxt."\n".$this->render('meetmeBundle:twig_html:invitation.html.twig', array('code'=> $code)));
                $mailer = $this->get('mailer');
                $mailer->send($message);
                $spool = $mailer->getTransport()->getSpool();
                $transport = $this->get('swiftmailer.transport.real');
                $spool->flushQueue($transport);
                //$this->get('mailer')->send($message);
                return $this->render('meetmeBundle:twig_html:registration.html.twig' ,
                array('name' => $email));
    
    } else {
        //This is not a valid email 
        $errorMessage = $errorList[0]->getMessage();
        // ... make something with the error.
    }
     }
   }
 }
 
 
 
 
 
 }

