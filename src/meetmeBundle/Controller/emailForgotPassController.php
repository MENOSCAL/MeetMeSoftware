<?php
namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;

class emailForgotPassController extends Controller{
   
 public function emailForgotPassAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('meetmeBundle:User'); 
        if($request->getMethod() == 'POST'){
            
                $email = $request->get('email');
                $user = $repository->findOneBy(array('email'=>$email));
                if($user){
                   $firstName = $user->getname();
                   $lastName = $user->getLastName();
                   $username = $user->getUsername();
                   $newPassword = substr(md5(microtime()),rand(0,24),7);
                   
                   //Update this password in this user
                   $qb = $em->createQueryBuilder();
                   $q = $qb->update('meetmeBundle\Entity\User', 'u')
                    ->set('u.password', '?1')
                    ->where('u.id = ?2')
                    ->setParameter(1, sha1($newPassword))
                    ->setParameter(2, $user->getId())
                    ->getQuery();
                    $p = $q->execute();
                                      
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
                   $messagetxt = 'Dear '.$firstName. $lastName.":\n\nYour new credentials to login at MeetMe are: \n\nUsername: ".$username ."\nPassword: ".$newPassword;
                
                   $message = \Swift_Message::newInstance()
                   ->setSubject('Your credentials to login MeetMe')
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
