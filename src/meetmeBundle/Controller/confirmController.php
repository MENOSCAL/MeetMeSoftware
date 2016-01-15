<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class confirmController extends Controller{
    
    public function confirmAction($invitee)
    {
                    $em = $this->getDoctrine()->getManager();
                    $qb = $em->createQueryBuilder();
                    $q = $qb->update('meetmeBundle\Entity\InvitedPerson', 'p')
                    ->set('p.acceptedInvitationDate', '?1')
                    ->where('p.email = ?2')
                    ->setParameter(1, new \DateTime("now"))
                    ->setParameter(2, $invitee)
                    ->getQuery();
                    $p = $q->execute();
        return $this->render('meetmeBundle:twig_html:login.html.twig');
    }
}
