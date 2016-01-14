<?php

namespace meetmeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use meetmeBundle\Entity\InvitedPerson;
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
                $email = $request->get('email');
                
                $fullName = $request->get('firstname');
                $searchCode = $request->get('searchcode');
                $eventDate  = $request->get('eventdate');
                $hour = $request->get('hour');
                $place= $request->get('place');
                
                
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
                $limit=1; 
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQueryBuilder()
                ->select('e')
                ->from('meetmeBundle:Event', 'e')
                ->orderBy('e.eventDate', 'DESC')
                ->setMaxResults($limit)
                ->getQuery() 
                ;
                $events = $query->getResult();
                $invitedPerson = new InvitedPerson(); 
                $invitedPerson->setEmail($email);
                $invitedPerson->setInvitationDate(new \DateTime("now"));
                foreach($events as $event)
                {
                    //$id = $event->getId();
                    $event->addIdinvited($invitedPerson);
                    $invitedPerson->addIdevent($event);
                    $em->persist($event);
                    $em->persist($invitedPerson);
                    $em->flush();
                 }
                $message = \Swift_Message::newInstance()
                ->setSubject('Invitation from MeetMePlanner...')
                ->setFrom('meetmeplanner@gmail.com')
                ->setTo($email)
                ->setBody($messagetxt);
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

