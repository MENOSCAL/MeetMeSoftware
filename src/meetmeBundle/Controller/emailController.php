<?php

namespace meetmeBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use meetmeBundle\Entity\InvitedPerson;


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
                        $email = $request->get('email');
                        $messagetxt = $request->get('messagetxt');
                        
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
                        
                        foreach($events as $event)
                        {
                           //$id = $event->getId();
                           $event->addIdinvited($invitedPerson);
                           $em->persist($event);
                           $em->persist($invitedPerson);
                           $em->flush();
                        }
                        
               
        $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('rstacks9@gmail.com')
        ->setTo($email)
        ->setBody($messagetxt)
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
        ;
        $mailer = $this->get('mailer');
        $mailer->send($message);
        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->get('swiftmailer.transport.real');
        $spool->flushQueue($transport);

    //$this->get('mailer')->send($message);
    return $this->render('meetmeBundle:twig_html:registration.html.twig' ,
                array('name' => $email));
     }
   }
 }
 }

