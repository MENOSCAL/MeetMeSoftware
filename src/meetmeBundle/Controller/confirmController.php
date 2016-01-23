<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class confirmController extends Controller{
    
    public function confirmAction($invitee)
    {
                    $posSpecialChar = strpos($invitee, "<");
                    $substremail = substr($invitee, $posSpecialChar);
                    $email=substr($substremail,1);
                    
                    $indexPosSpecialChar =  indexOf("<");
                    
                    $searchCode =  substr($invitee, $indexPosSpecialChar);
                    
                    $query = $em->createQueryBuilder()
                    ->select('e' )
                    ->from('meetmeBundle\Entity\Event', 'e')
                    ->where('e.searchCode = ?1')
                    ->setParameter(1 , $searchCode)
                    ->getQuery()->getResult();
                    
                    $events = $query->getResult();
                    
                    $query = $em->createQueryBuilder()
                    ->select('ip')
                    ->from('meetmeBundle\Entity\InvitedPerson', 'ip')
                    ->where('ip.email = ?1')
                    ->setParameter(1 ,$email)
                    ->getQuery();
                    
                    $invitedPersons = $query->getResult();
                    
                    foreach ($events as $event){
                        
                        $invitedEvent = $InvitedEvent();
                        
                        foreach ($invitedPersons as $invitedPerson){
                        
                        $em = $this->getDoctrine()->getManager();
                        $qb = $em->createQueryBuilder();
                        $q = $qb->update('meetmeBundle\Entity\InvitedEvent', 'ie')
                        ->set('ie.acceptedInvitDate', '?1')
                        ->where('ie.idinvited = ?2')
                        ->andWhere('ie.idevent = ?3')
                        ->setParameter(1, new \DateTime("now"))
                        ->setParameter(2, $invitedPerson->getId())
                        ->setParameter(2, $event->getId())
                        ->getQuery();
                        $p = $q->execute();
                            
                            
                        }
                        //$em->persist($invitedEvent);
                        //$em->flush();
                    }
                    
                    
                    
                    /*
                    $em = $this->getDoctrine()->getManager();
                    $qb = $em->createQueryBuilder();
                    $q = $qb->update('meetmeBundle\Entity\InvitedPerson', 'p')
                    ->set('p.acceptedInvitationDate', '?1')
                    ->where('p.email = ?2')
                    ->setParameter(1, new \DateTime("now"))
                    ->setParameter(2, $substremail)
                    ->getQuery();
                    $p = $q->execute();
                    */
                    
                
                    
                    
                    
                    
        return $this->render('meetmeBundle:twig_html:login.html.twig');
    }
}
