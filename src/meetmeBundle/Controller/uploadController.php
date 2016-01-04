<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Entity\Image;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class uploadController extends Controller{
    /**
     * @Template()
    */
    public function uploadAction(Request $request)
    {
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('meetmeBundle:User'); 
        $login = $sesion->get('login');
        $username = $login->getUsername();
        $password = $login->getPassword();
        $user = $repository->findOneBy(array('username'=>$username,'password'=>$password));
        $image = new Image();
        $form = $this->createFormBuilder($image)
        ->add('file')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        
        
        $qb = $em->createQueryBuilder();
        $q = $qb->update('meetmeBundle\Entity\Image', 'i')
        ->set('i.isActive', '?1')
        ->where('i.iduser = ?2')
        ->setParameter(1, 0)
        ->setParameter(2, $user->getId())
        ->getQuery();
        $p = $q->execute();
       
        
        $image->upload();
        $image->setIduser($user);
        $em->persist($image);
        $em->flush();
        
       
        

        //return $this->redirectToRoute('meetme_upload_success');
        return $this->redirectToRoute('meetme_login');
        
    }

    return $this->render('meetmeBundle:twig_html:upload.html.twig', array(
            'form' => $form->createView()));
    }
    
    public function uploadsuccessAction()
    {

        return $this->render('meetmeBundle:twig_html:responseuploadsuccessful.html.twig');
    }
    
}
